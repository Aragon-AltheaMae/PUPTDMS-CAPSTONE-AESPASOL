<?php

namespace App\Services;

use App\Helpers\AuditLogger;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ConcurrentSessionService
{
    public function isEnabled(): bool
    {
        if (!config('concurrent-sessions.enabled', true)) {
            return false;
        }

        return config('session.driver') === 'database'
            && Schema::hasTable($this->sessionTable());
    }

    public function getSessionLimitForUser(User $user): int
    {
        $roleSlug = (string) optional($user->role)->slug;
        $limits = config('concurrent-sessions.role_limits', []);
        $defaultLimit = (int) config('concurrent-sessions.default_limit', 1);

        $limit = $limits[$roleSlug] ?? $defaultLimit;

        return max(1, (int) $limit);
    }

    public function enforceLimitForCurrentSession(User $user, ?string $currentSessionId = null): array
    {
        if (!$this->isEnabled()) {
            return $this->result(0, $this->getSessionLimitForUser($user), false);
        }

        $sessionTable = $this->sessionTable();
        $currentSessionId ??= session()->getId();
        $limit = $this->getSessionLimitForUser($user);

        if ($limit <= 1) {
            $terminatedSessions = $this->revokeOtherSessions(
                $user,
                $currentSessionId,
                'new_login_single_session_policy'
            );

            return $this->result($terminatedSessions, $limit, true);
        }

        return DB::transaction(function () use ($user, $currentSessionId, $limit, $sessionTable) {
            $lockedUser = User::query()
                ->with('role')
                ->lockForUpdate()
                ->findOrFail($user->id);

            $this->pruneExpiredSessionsForUser($lockedUser);

            $activeSessions = $this->activeSessionsQuery($lockedUser->id)
                ->orderBy('last_activity')
                ->get();

            $currentSessionExists = $activeSessions->contains('id', $currentSessionId);
            $projectedCount = $activeSessions->count() + ($currentSessionExists ? 0 : 1);
            $excessCount = max(0, $projectedCount - $limit);

            if ($excessCount === 0) {
                return $this->result(0, $limit, true);
            }

            $sessionsToRevoke = $activeSessions
                ->filter(fn (object $session) => $session->id !== $currentSessionId)
                ->take($excessCount)
                ->pluck('id')
                ->values();

            if ($sessionsToRevoke->isEmpty()) {
                return $this->result(0, $limit, true);
            }

            DB::table($sessionTable)
                ->where('user_id', $lockedUser->id)
                ->whereIn('id', $sessionsToRevoke->all())
                ->delete();

            AuditLogger::log(
                'session_limit_enforced',
                'authentication',
                sprintf(
                    'Concurrent session policy enforced for user #%d. %d older session(s) were revoked.',
                    $lockedUser->id,
                    $sessionsToRevoke->count()
                )
            );

            return $this->result($sessionsToRevoke->count(), $limit, true);
        });
    }

    public function revokeAllSessions(User $user, ?string $exceptSessionId = null, string $reason = 'security_event'): int
    {
        if (!$this->isEnabled()) {
            return 0;
        }

        $query = DB::table($this->sessionTable())->where('user_id', $user->id);

        if ($exceptSessionId) {
            $query->where('id', '!=', $exceptSessionId);
        }

        $deleted = $query->delete();

        if ($deleted > 0) {
            AuditLogger::log(
                'sessions_revoked',
                'authentication',
                sprintf(
                    'Revoked %d active session(s) for user #%d due to %s.',
                    $deleted,
                    $user->id,
                    $reason
                )
            );
        }

        return $deleted;
    }

    public function revokeOtherSessions(User $user, string $currentSessionId, string $reason = 'security_event'): int
    {
        return $this->revokeAllSessions($user, $currentSessionId, $reason);
    }

    public function pruneExpiredSessionsForUser(User $user): int
    {
        if (!$this->isEnabled()) {
            return 0;
        }

        return DB::table($this->sessionTable())
            ->where('user_id', $user->id)
            ->where('last_activity', '<', $this->activeCutoffTimestamp())
            ->delete();
    }

    public function activeSessionsForUser(User $user): Collection
    {
        if (!$this->isEnabled()) {
            return collect();
        }

        return $this->activeSessionsQuery($user->id)
            ->orderByDesc('last_activity')
            ->get();
    }

    public function sessionsForDisplay(User $user, string $currentSessionId): Collection
    {
        return $this->activeSessionsForUser($user)
            ->map(function (object $session) use ($currentSessionId) {
                return [
                    'reference' => $this->makePublicReference($session->id),
                    'is_current' => hash_equals((string) $session->id, $currentSessionId),
                    'ip_address' => $session->ip_address ?: 'Unknown',
                    'user_agent' => $session->user_agent ?: 'Unknown device',
                    'device_label' => $this->formatDeviceLabel($session->user_agent),
                    'browser_label' => $this->detectBrowser($session->user_agent),
                    'last_activity_at' => now()->setTimestamp((int) $session->last_activity),
                    'last_activity_label' => now()->setTimestamp((int) $session->last_activity)->diffForHumans(),
                ];
            })
            ->sortByDesc(fn (array $session) => $session['last_activity_at']->getTimestamp())
            ->values();
    }

    public function recentSessionHistoryForUser(User $user, int $limit = 8): Collection
    {
        $limit = max(1, min($limit, 20));
        $roleSlug = (string) optional($user->role)->slug;
        $identifiers = array_values(array_unique(array_filter([
            $user->id,
            $roleSlug === 'patient' ? $user->patient?->id : null,
            $roleSlug === 'admin' || $roleSlug === 'super_admin' ? session('admin_id') : null,
            $roleSlug === 'dentist' ? session('dentist_id') : null,
            $roleSlug === 'patient' ? session('patient_id') : null,
        ])));

        return AuditLog::query()
            ->where(function ($query) use ($user, $identifiers, $roleSlug) {
                $query->where(function ($strictQuery) use ($user, $roleSlug) {
                    $strictQuery->where('actor_id', $user->id);

                    if ($roleSlug !== '') {
                        $strictQuery->where('actor_role', $roleSlug);
                    }
                });

                if (!empty($identifiers)) {
                    $query->orWhere(function ($legacyQuery) use ($identifiers, $roleSlug) {
                        $legacyQuery->whereNull('actor_id')
                            ->whereIn('actor_identifier', $identifiers);

                        if ($roleSlug !== '') {
                            $legacyQuery->where('actor_role', $roleSlug);
                        }
                    });
                }
            })
            ->whereIn('action', [
                'login',
                'logout',
                'session_limit_enforced',
                'sessions_revoked',
                'session_revoked',
            ])
            ->whereIn('module', ['authentication', 'patient_auth'])
            ->latest()
            ->take($limit)
            ->get()
            ->map(function (AuditLog $entry) {
                $userAgent = (string) ($entry->user_agent ?: 'Unknown device');
                $action = (string) $entry->action;

                return [
                    'action' => $action,
                    'action_label' => $this->formatHistoryAction($action),
                    'action_tone' => $this->historyTone($action),
                    'device_label' => $this->formatDeviceLabel($userAgent),
                    'browser_label' => $this->detectBrowser($userAgent),
                    'ip_address' => $entry->ip_address ?: 'Unknown',
                    'user_agent' => $userAgent,
                    'description' => $entry->description ?: 'Session activity recorded.',
                    'occurred_at' => $entry->created_at,
                    'occurred_at_label' => optional($entry->created_at)?->diffForHumans(),
                ];
            });
    }

    public function revokeSessionByReference(User $user, string $reference, ?string $currentSessionId = null): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        $session = $this->findOwnedSessionByReference($user, $reference);

        if (!$session) {
            return false;
        }

        if ($currentSessionId && hash_equals((string) $session->id, $currentSessionId)) {
            return false;
        }

        $deleted = DB::table($this->sessionTable())
            ->where('user_id', $user->id)
            ->where('id', $session->id)
            ->delete();

        if ($deleted > 0) {
            AuditLogger::log(
                'session_revoked',
                'authentication',
                sprintf('User #%d revoked one of their active sessions.', $user->id)
            );
        }

        return $deleted > 0;
    }

    public function paginateActiveSessionsForAdmin(
        int $perPage = 15,
        array $filters = [],
        ?string $currentSessionId = null
    ): LengthAwarePaginator {
        $perPage = in_array($perPage, [10, 15, 20, 50, 100], true) ? $perPage : 15;
        $currentSessionId ??= session()->getId();

        $query = DB::table($this->sessionTable() . ' as sessions')
            ->leftJoin('users', 'users.id', '=', 'sessions.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->select([
                'sessions.id',
                'sessions.user_id',
                'sessions.ip_address',
                'sessions.user_agent',
                'sessions.last_activity',
                'users.name as user_name',
                'users.email as user_email',
                'users.status as user_status',
                'roles.slug as role_slug',
            ])
            ->whereNotNull('sessions.user_id')
            ->where('sessions.last_activity', '>=', $this->activeCutoffTimestamp());

        $role = trim((string) ($filters['role'] ?? ''));
        $search = trim((string) ($filters['search'] ?? ''));

        if ($role !== '' && $role !== 'all') {
            $query->where('roles.slug', $role);
        }

        if ($search !== '') {
            $query->where(function (Builder $builder) use ($search) {
                $builder->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%")
                    ->orWhere('sessions.ip_address', 'like', "%{$search}%")
                    ->orWhere('sessions.user_agent', 'like', "%{$search}%");
            });
        }

        $paginator = $query
            ->orderByDesc('sessions.last_activity')
            ->paginate($perPage)
            ->withQueryString();

        $items = collect($paginator->items())
            ->map(function (object $session) use ($currentSessionId) {
                $role = (string) ($session->role_slug ?: 'unknown');

                return (object) [
                    'reference' => $this->makePublicReference((string) $session->id),
                    'user_id' => $session->user_id,
                    'user_name' => $session->user_name ?: 'Unknown User',
                    'user_email' => $session->user_email ?: 'No email',
                    'user_status' => $session->user_status ?: 'unknown',
                    'role_slug' => $role,
                    'role_label' => $this->formatRoleLabel($role),
                    'ip_address' => $session->ip_address ?: 'Unknown',
                    'user_agent' => $session->user_agent ?: 'Unknown device',
                    'device_label' => $this->formatDeviceLabel($session->user_agent),
                    'browser_label' => $this->detectBrowser($session->user_agent),
                    'last_activity_at' => now()->setTimestamp((int) $session->last_activity),
                    'last_activity_label' => now()->setTimestamp((int) $session->last_activity)->diffForHumans(),
                    'is_current' => hash_equals((string) $session->id, $currentSessionId),
                ];
            })
            ->all();

        $paginator->setCollection(collect($items));

        return $paginator;
    }

    public function getAdminSessionStats(): array
    {
        $baseQuery = DB::table($this->sessionTable() . ' as sessions')
            ->leftJoin('users', 'users.id', '=', 'sessions.user_id')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->whereNotNull('sessions.user_id')
            ->where('sessions.last_activity', '>=', $this->activeCutoffTimestamp());

        return [
            'total_sessions' => (clone $baseQuery)->count(),
            'active_users' => (clone $baseQuery)->distinct('sessions.user_id')->count('sessions.user_id'),
            'admin_sessions' => (clone $baseQuery)->whereIn('roles.slug', ['admin', 'super_admin'])->count(),
            'dentist_sessions' => (clone $baseQuery)->where('roles.slug', 'dentist')->count(),
            'patient_sessions' => (clone $baseQuery)->where('roles.slug', 'patient')->count(),
        ];
    }

    public function revokeSessionByReferenceAsAdmin(User $actor, string $reference, ?string $currentSessionId = null): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        $session = $this->findSessionByReference($reference);

        if (!$session) {
            return false;
        }

        if ($currentSessionId && hash_equals((string) $session->id, $currentSessionId)) {
            return false;
        }

        $deleted = DB::table($this->sessionTable())
            ->where('id', $session->id)
            ->delete();

        if ($deleted > 0) {
            AuditLogger::log(
                'admin_session_revoked',
                'authentication',
                sprintf('Admin #%d revoked an active session for user #%d.', $actor->id, (int) $session->user_id)
            );
        }

        return $deleted > 0;
    }

    public function revokeAllSessionsForUserAsAdmin(User $actor, User $targetUser, ?string $exceptSessionId = null): int
    {
        if (!$this->isEnabled()) {
            return 0;
        }

        $query = DB::table($this->sessionTable())->where('user_id', $targetUser->id);

        if ($exceptSessionId) {
            $query->where('id', '!=', $exceptSessionId);
        }

        $deleted = $query->delete();

        if ($deleted > 0) {
            AuditLogger::log(
                'admin_user_sessions_revoked',
                'authentication',
                sprintf(
                    'Admin #%d revoked %d active session(s) for user #%d.',
                    $actor->id,
                    $deleted,
                    $targetUser->id
                )
            );
        }

        return $deleted;
    }

    protected function activeSessionsQuery(int $userId)
    {
        return DB::table($this->sessionTable())
            ->where('user_id', $userId)
            ->where('last_activity', '>=', $this->activeCutoffTimestamp());
    }

    protected function activeSessionsBaseQuery(User $user): Builder
    {
        return DB::table($this->sessionTable())
            ->where('user_id', $user->id)
            ->where('last_activity', '>=', $this->activeCutoffTimestamp());
    }

    protected function activeCutoffTimestamp(): int
    {
        $sessionLifetimeSeconds = max(60, (int) config('session.lifetime', 120) * 60);
        $idleTimeoutSeconds = (int) env('SESSION_IDLE_TIMEOUT_SECONDS', 0);

        if ($idleTimeoutSeconds > 0) {
            $sessionLifetimeSeconds = min($sessionLifetimeSeconds, $idleTimeoutSeconds);
        }

        return now()->subSeconds($sessionLifetimeSeconds)->getTimestamp();
    }

    protected function sessionTable(): string
    {
        return (string) config('session.table', 'sessions');
    }

    protected function makePublicReference(string $sessionId): string
    {
        return hash_hmac('sha256', $sessionId, (string) config('app.key'));
    }

    protected function findOwnedSessionByReference(User $user, string $reference): ?object
    {
        return $this->activeSessionsBaseQuery($user)
            ->get()
            ->first(function (object $session) use ($reference) {
                return hash_equals($this->makePublicReference((string) $session->id), $reference);
            });
    }

    protected function findSessionByReference(string $reference): ?object
    {
        return DB::table($this->sessionTable())
            ->where('last_activity', '>=', $this->activeCutoffTimestamp())
            ->get()
            ->first(function (object $session) use ($reference) {
                return hash_equals($this->makePublicReference((string) $session->id), $reference);
            });
    }

    protected function formatDeviceLabel(?string $userAgent): string
    {
        if (blank($userAgent)) {
            return 'Unknown device';
        }

        $platform = match (true) {
            Str::contains($userAgent, 'Windows', true) => 'Windows',
            Str::contains($userAgent, 'Macintosh', true) => 'macOS',
            Str::contains($userAgent, 'Android', true) => 'Android',
            Str::contains($userAgent, ['iPhone', 'iPad', 'iOS'], true) => 'iOS',
            Str::contains($userAgent, 'Linux', true) => 'Linux',
            default => 'Device',
        };

        $browser = $this->detectBrowser($userAgent);

        return trim($platform . ' - ' . $browser);
    }

    protected function detectBrowser(?string $userAgent): string
    {
        if (blank($userAgent)) {
            return 'Browser';
        }

        return match (true) {
            Str::contains($userAgent, 'Edg/', true) => 'Edge',
            Str::contains($userAgent, 'OPR/', true) => 'Opera',
            Str::contains($userAgent, 'Firefox/', true) => 'Firefox',
            Str::contains($userAgent, 'Chrome/', true) => 'Chrome',
            Str::contains($userAgent, 'Safari/', true) => 'Safari',
            default => 'Browser',
        };
    }

    protected function formatRoleLabel(string $role): string
    {
        return match ($role) {
            'super_admin', 'admin' => 'Admin',
            'dentist' => 'Dentist',
            'patient' => 'Patient',
            default => Str::headline($role !== '' ? $role : 'Unknown'),
        };
    }

    protected function formatHistoryAction(string $action): string
    {
        return match ($action) {
            'login' => 'Signed In',
            'logout' => 'Signed Out',
            'session_limit_enforced' => 'Older Session Replaced',
            'sessions_revoked', 'session_revoked' => 'Session Revoked',
            default => Str::headline(str_replace('_', ' ', $action)),
        };
    }

    protected function historyTone(string $action): string
    {
        return match ($action) {
            'login' => 'success',
            'logout' => 'neutral',
            'session_limit_enforced', 'sessions_revoked', 'session_revoked' => 'warning',
            default => 'neutral',
        };
    }

    protected function result(int $terminatedSessions, int $limit, bool $supported): array
    {
        return [
            'supported' => $supported,
            'terminated_sessions' => $terminatedSessions,
            'limit' => $limit,
        ];
    }
}
