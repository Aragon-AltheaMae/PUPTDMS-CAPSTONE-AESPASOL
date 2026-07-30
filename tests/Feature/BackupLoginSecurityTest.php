<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackupLoginSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'security.login.max_attempts' => 3,
            'security.login.decay_seconds' => 60,
            'security.login.lockout_seconds' => 300,
        ]);
    }

    public function test_backup_login_locks_admin_account_after_repeated_failed_attempts(): void
    {
        $admin = $this->makeAdmin();

        for ($attempt = 1; $attempt <= 3; $attempt++) {
            $response = $this->from('/backup-login')->post('/login', [
                'email' => $admin->email,
                'password' => 'wrong-password',
            ]);

            $response->assertRedirect('/backup-login');
        }

        $admin->refresh();

        $this->assertSame(3, $admin->failed_login_attempts);
        $this->assertNotNull($admin->locked_until);
        $this->assertTrue($admin->locked_until->isFuture());
    }

    public function test_locked_admin_account_cannot_use_correct_password_until_lock_expires(): void
    {
        $admin = $this->makeAdmin();

        $admin->forceFill([
            'failed_login_attempts' => 3,
            'locked_until' => now()->addMinutes(5),
        ])->save();

        $response = $this->from('/backup-login')->post('/login', [
            'email' => $admin->email,
            'password' => 'password123!',
        ]);

        $response->assertRedirect('/backup-login');
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    private function makeAdmin(): User
    {
        $role = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin']
        );

        return User::create([
            'name' => 'Security Admin',
            'email' => 'security-admin@example.com',
            'password' => bcrypt('password123!'),
            'role_id' => $role->id,
            'status' => 'active',
        ]);
    }
}
