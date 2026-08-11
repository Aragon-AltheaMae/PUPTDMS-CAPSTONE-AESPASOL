<?php

namespace Tests\Feature;

use App\Support\BrowserDetection;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\ConcurrentSessionService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ConcurrentSessionFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'session.driver' => 'database',
            'session.table' => 'sessions',
            'session.lifetime' => 120,
            'concurrent-sessions.enabled' => true,
            'concurrent-sessions.default_limit' => 1,
            'concurrent-sessions.role_limits' => [
                'admin' => 1,
                'dentist' => 1,
                'patient' => 1,
            ],
        ]);
    }

    public function test_admin_login_policy_revokes_existing_older_sessions(): void
    {
        $admin = $this->makeUser('admin@example.com', 'admin');

        $this->insertSession('old-admin-session-1', $admin->id, now()->subMinutes(15)->timestamp);
        $this->insertSession('old-admin-session-2', $admin->id, now()->subMinutes(5)->timestamp);

        $result = app(ConcurrentSessionService::class)
            ->enforceLimitForCurrentSession($admin, 'new-admin-session');

        $this->assertSame(2, $result['terminated_sessions']);
        $this->assertDatabaseMissing('sessions', ['id' => 'old-admin-session-1']);
        $this->assertDatabaseMissing('sessions', ['id' => 'old-admin-session-2']);
    }

    public function test_patient_login_policy_revokes_existing_older_sessions_like_admin_and_dentist(): void
    {
        $patient = $this->makeUser('patient@example.com', 'patient');

        $this->insertSession('patient-session-1', $patient->id, now()->subMinutes(20)->timestamp);
        $this->insertSession('patient-session-2', $patient->id, now()->subMinutes(5)->timestamp);

        $result = app(ConcurrentSessionService::class)
            ->enforceLimitForCurrentSession($patient, 'new-patient-session');

        $this->assertSame(2, $result['terminated_sessions']);
        $this->assertDatabaseMissing('sessions', ['id' => 'patient-session-1']);
        $this->assertDatabaseMissing('sessions', ['id' => 'patient-session-2']);
    }

    public function test_deactivating_a_user_revokes_their_existing_sessions(): void
    {
        $admin = $this->makeUser('owner-admin@example.com', 'admin');
        $targetUser = $this->makeUser('revoked-user@example.com', 'dentist');

        $permission = Permission::create([
            'name' => 'Manage Users',
            'slug' => 'manage_users',
            'module' => 'Users',
        ]);

        $admin->role->permissions()->syncWithoutDetaching([$permission->id]);

        $this->insertSession('dentist-session-1', $targetUser->id, now()->subMinutes(8)->timestamp);
        $this->insertSession('dentist-session-2', $targetUser->id, now()->subMinutes(2)->timestamp);

        $this->actingAs($admin)
            ->withSession([
                'role' => 'admin',
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
            ])
            ->post(route('admin.user_management.toggle_status', $targetUser))
            ->assertRedirect();

        $targetUser->refresh();

        $this->assertSame('inactive', $targetUser->status);
        $this->assertDatabaseMissing('sessions', ['id' => 'dentist-session-1']);
        $this->assertDatabaseMissing('sessions', ['id' => 'dentist-session-2']);
    }

    public function test_session_display_prefers_stored_browser_name_when_available(): void
    {
        $patient = $this->makeUser('brave-user@example.com', 'patient');

        $this->insertSession(
            'brave-session',
            $patient->id,
            now()->subMinute()->timestamp,
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36',
            'Brave'
        );

        $session = app(ConcurrentSessionService::class)
            ->sessionsForDisplay($patient, 'brave-session')
            ->first();

        $this->assertSame('Brave', $session['browser_label']);
    }

    public function test_browser_detection_prefers_explicit_browser_hint(): void
    {
        $request = Request::create('/auth/oidc/redirect', 'GET', [
            'browser_name' => 'Brave',
        ], [], [], [
            'HTTP_USER_AGENT' => 'Mozilla/5.0 Chrome/138.0.0.0 Safari/537.36',
        ]);

        $request->setLaravelSession(new class {
            public function get($key, $default = null)
            {
                return $default;
            }
        });

        $this->assertSame('Brave', BrowserDetection::detectFromRequest($request));
    }

    public function test_browser_detection_identifies_brave_from_client_hints(): void
    {
        $this->assertSame(
            'Brave',
            BrowserDetection::detectFromClientHints('"Brave";v="138", "Chromium";v="138", "Not=A?Brand";v="99"')
        );
    }

    private function makeUser(string $email, string $roleSlug): User
    {
        $role = Role::firstOrCreate(
            ['slug' => $roleSlug],
            ['name' => ucfirst(str_replace('_', ' ', $roleSlug))]
        );

        return User::create([
            'name' => ucfirst($roleSlug) . ' User',
            'email' => $email,
            'password' => bcrypt('password'),
            'role_id' => $role->id,
            'status' => 'active',
        ]);
    }

    private function insertSession(
        string $id,
        int $userId,
        int $lastActivity,
        string $userAgent = 'PHPUnit',
        ?string $browserName = null
    ): void
    {
        DB::table('sessions')->insert([
            'id' => $id,
            'user_id' => $userId,
            'ip_address' => '127.0.0.1',
            'user_agent' => $userAgent,
            'browser_name' => $browserName,
            'payload' => base64_encode('payload'),
            'last_activity' => $lastActivity,
        ]);
    }
}
