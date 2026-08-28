<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class DentistSessionTimeoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'session.idle_timeout_seconds' => 60,
            'session.idle_timeout_exempt_roles' => ['dentist'],
        ]);
    }

    public function test_dentist_session_remains_active_after_idle_timeout(): void
    {
        $dentist = $this->makeUser('dentist@example.com', 'dentist');

        $this->actingAs($dentist)
            ->withSession([
                'role' => 'dentist',
                'last_activity_at' => now()->subMinutes(10)->timestamp,
                'session_idle_locked' => true,
            ])
            ->postJson(route('session.activity'))
            ->assertOk()
            ->assertJson(['active' => true]);

        $this->assertAuthenticatedAs($dentist);
        $this->assertFalse((bool) session('session_idle_locked', false));
    }

    public function test_dentist_cannot_be_logged_out_by_a_stale_idle_expiry_request(): void
    {
        $dentist = $this->makeUser('stale-timer-dentist@example.com', 'dentist');

        $this->actingAs($dentist)
            ->withSession([
                'role' => 'dentist',
                'last_activity_at' => now()->subMinutes(10)->timestamp,
                'session_idle_locked' => true,
            ])
            ->postJson(route('session.expire'))
            ->assertOk()
            ->assertJson([
                'expired' => false,
                'active' => true,
            ]);

        $this->assertAuthenticatedAs($dentist);
    }

    public function test_dentist_view_uses_keepalive_without_rendering_timeout_modal(): void
    {
        $dentist = $this->makeUser('dentist-view@example.com', 'dentist');

        Route::middleware('web')->get('/_test/dentist-session-ui', function () {
            return view('partials.global-toast', [
                'layoutRole' => 'dentist',
            ]);
        });

        $this->actingAs($dentist)
            ->withSession(['role' => 'dentist'])
            ->get('/_test/dentist-session-ui')
            ->assertOk()
            ->assertDontSee('data-session-timeout-modal', false)
            ->assertSee("fetch(activityUrl", false);
    }

    public function test_patient_session_still_expires_after_idle_timeout(): void
    {
        $patient = $this->makeUser('patient@example.com', 'patient');

        $this->actingAs($patient)
            ->withSession([
                'role' => 'patient',
                'last_activity_at' => now()->subMinutes(10)->timestamp,
            ])
            ->postJson(route('session.activity'))
            ->assertUnauthorized()
            ->assertJson(['expired' => true]);
    }

    private function makeUser(string $email, string $roleSlug): User
    {
        $role = Role::create([
            'name' => ucfirst($roleSlug),
            'slug' => $roleSlug,
        ]);

        return User::create([
            'name' => ucfirst($roleSlug) . ' User',
            'email' => $email,
            'password' => bcrypt('password'),
            'role_id' => $role->id,
            'status' => 'active',
        ]);
    }
}
