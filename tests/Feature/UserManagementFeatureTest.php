<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_user_with_auto_generated_password(): void
    {
        $admin = $this->createAdminUser();
        $patientRole = $this->createRole('Patient', 'patient');

        $response = $this->actingAs($admin)
            ->withSession($this->adminSession($admin))
            ->post(route('admin.user_management.store'), [
                'name' => 'Juan Dela Cruz',
                'email' => 'juan@example.com',
                'role_id' => $patientRole->id,
                'status' => 'active',
                'phone' => '09123456789',
                'birthdate' => '2000-01-01',
                'gender' => 'Male',
            ]);

        $response->assertRedirect(route('admin.user_management'));
        $response->assertSessionHas('success', 'User created successfully.');
        $response->assertSessionHas('generated_user_password');

        /** @var array{name:string,email:string,password:string} $generated */
        $generated = session('generated_user_password');

        $this->assertSame('Juan Dela Cruz', $generated['name']);
        $this->assertSame('juan@example.com', $generated['email']);
        $this->assertSame(12, strlen($generated['password']));
        $this->assertMatchesRegularExpression('/[a-z]/', $generated['password']);
        $this->assertMatchesRegularExpression('/[A-Z]/', $generated['password']);
        $this->assertMatchesRegularExpression('/\d/', $generated['password']);
        $this->assertMatchesRegularExpression('/[@#$%*!\?]/', $generated['password']);

        $user = User::where('email', 'juan@example.com')->firstOrFail();

        $this->assertTrue(Hash::check($generated['password'], (string) $user->password));
        $this->assertDatabaseHas('patients', [
            'user_id' => $user->id,
            'email' => 'juan@example.com',
            'phone' => '09123456789',
            'gender' => 'Male',
        ]);
    }

    public function test_ajax_user_management_index_returns_rich_user_details_payload(): void
    {
        $admin = $this->createAdminUser();
        $patientRole = $this->createRole('Patient', 'patient');

        $user = User::create([
            'name' => 'Detail Target',
            'email' => 'detail-target@example.com',
            'password' => bcrypt('Password123!'),
            'role_id' => $patientRole->id,
            'status' => 'active',
            'last_login_at' => '2026-07-18 09:30:00',
        ]);

        Patient::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '09998887777',
            'birthdate' => '2001-02-03',
            'gender' => 'Female',
            'password' => $user->password,
        ]);

        $response = $this->actingAs($admin)
            ->withSession($this->adminSession($admin))
            ->get(route('admin.user_management', ['search' => 'detail-target@example.com']), [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ]);

        $response->assertOk();
        $response->assertJsonPath('users.0.email', 'detail-target@example.com');
        $response->assertJsonPath('users.0.role_name', 'Patient');
        $response->assertJsonPath('users.0.details.id', $user->id);
        $response->assertJsonPath('users.0.details.phone', '09998887777');
        $response->assertJsonPath('users.0.details.gender', 'Female');
        $response->assertJsonPath('users.0.details.patient_profile', 'Linked');
        $response->assertJsonPath('users.0.details.status', 'Active');
        $response->assertJsonPath('users.0.details.role', 'Patient');
        $response->assertJsonPath('users.0.details.last_login_at', 'Jul 18, 2026 09:30 AM');
    }

    public function test_deleting_admin_like_custom_role_reassigns_users_to_admin_role(): void
    {
        $admin = $this->createAdminUser();
        $adminRole = Role::where('slug', 'admin')->firstOrFail();
        $customRole = $this->createRole('Clinic Staff', 'clinic_staff');

        $affectedUser = User::create([
            'name' => 'Clinic Staff User',
            'email' => 'clinic-staff@example.com',
            'password' => bcrypt('Password123!'),
            'role_id' => $customRole->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)
            ->withSession($this->adminSession($admin))
            ->delete(route('admin.role_permissions.destroy_role', $customRole->id), [], [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('affected_users', 1);
        $response->assertJsonPath('fallback_role.slug', 'admin');

        $this->assertDatabaseMissing('roles', [
            'id' => $customRole->id,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $affectedUser->id,
            'role_id' => $adminRole->id,
        ]);
    }

    public function test_deleting_dentist_like_custom_role_reassigns_users_to_dentist_role(): void
    {
        $admin = $this->createAdminUser();
        $dentistRole = $this->createRole('Dentist', 'dentist');
        $customRole = $this->createRole('Senior Dentist', 'senior_dentist');

        $affectedUser = User::create([
            'name' => 'Senior Dentist User',
            'email' => 'senior-dentist@example.com',
            'password' => bcrypt('Password123!'),
            'role_id' => $customRole->id,
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)
            ->withSession($this->adminSession($admin))
            ->delete(route('admin.role_permissions.destroy_role', $customRole->id), [], [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ]);

        $response->assertOk();
        $response->assertJsonPath('fallback_role.slug', 'dentist');

        $this->assertDatabaseHas('users', [
            'id' => $affectedUser->id,
            'role_id' => $dentistRole->id,
        ]);
    }

    public function test_built_in_roles_cannot_be_deleted(): void
    {
        $admin = $this->createAdminUser();
        $adminRole = Role::where('slug', 'admin')->firstOrFail();

        $response = $this->actingAs($admin)
            ->withSession($this->adminSession($admin))
            ->delete(route('admin.role_permissions.destroy_role', $adminRole->id));

        $response->assertRedirect(route('admin.role_permissions'));
        $response->assertSessionHas('error', 'Cannot delete the Super Admin role.');

        $this->assertDatabaseHas('roles', [
            'id' => $adminRole->id,
            'slug' => 'admin',
        ]);
    }

    private function createAdminUser(): User
    {
        $this->createRole('Dentist', 'dentist');
        $this->createRole('Patient', 'patient');

        $adminRole = $this->createRole('Admin', 'admin');

        return User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Password123!'),
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);
    }

    private function createRole(string $name, string $slug): Role
    {
        return Role::firstOrCreate(
            ['slug' => $slug],
            ['name' => $name]
        );
    }

    private function adminSession(User $admin): array
    {
        return [
            'role' => 'admin',
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
        ];
    }
}
