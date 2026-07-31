<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\ConcurrentSessionService;
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
                'patient' => 3,
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

    public function test_patient_login_policy_keeps_three_sessions_and_removes_only_the_oldest_excess_session(): void
    {
        $patient = $this->makeUser('patient@example.com', 'patient');

        $this->insertSession('patient-session-1', $patient->id, now()->subMinutes(30)->timestamp);
        $this->insertSession('patient-session-2', $patient->id, now()->subMinutes(20)->timestamp);
        $this->insertSession('patient-session-3', $patient->id, now()->subMinutes(10)->timestamp);

        $result = app(ConcurrentSessionService::class)
            ->enforceLimitForCurrentSession($patient, 'new-patient-session');

        $this->assertSame(1, $result['terminated_sessions']);
        $this->assertDatabaseMissing('sessions', ['id' => 'patient-session-1']);
        $this->assertDatabaseHas('sessions', ['id' => 'patient-session-2']);
        $this->assertDatabaseHas('sessions', ['id' => 'patient-session-3']);
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

    private function insertSession(string $id, int $userId, int $lastActivity): void
    {
        DB::table('sessions')->insert([
            'id' => $id,
            'user_id' => $userId,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
            'payload' => base64_encode('payload'),
            'last_activity' => $lastActivity,
        ]);
    }
}
