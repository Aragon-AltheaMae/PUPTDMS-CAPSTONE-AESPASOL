<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Permission;
use App\Models\Role;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class DentistAppointmentAutoCancelTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_overdue_appointment_stays_active_while_clinic_is_still_in(): void
    {
        Carbon::setTestNow('2026-09-04 16:00:00');

        $dentist = $this->makeDentist();
        $patient = $this->makePatient();
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'dentist_id' => $dentist->id,
            'service_type' => 'Oral Check-up',
            'appointment_date' => '2026-09-04',
            'appointment_time' => '07:00:00',
            'status' => 'upcoming',
        ]);

        SystemSetting::setSetting('clinic_status', 'in', 'clinic');

        $this->actingAs($dentist)
            ->withSession(['role' => 'dentist'])
            ->get(route('dentist.dentist.patient.profile', $patient))
            ->assertOk();

        $this->assertSame('upcoming', $appointment->fresh()->status);
        $this->assertNull($appointment->fresh()->cancellation_reason);
    }

    public function test_overdue_appointment_is_cancelled_after_clinic_is_marked_out(): void
    {
        Carbon::setTestNow('2026-09-04 16:30:00');

        $dentist = $this->makeDentist();
        $patient = $this->makePatient();
        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'dentist_id' => $dentist->id,
            'service_type' => 'Oral Check-up',
            'appointment_date' => '2026-09-04',
            'appointment_time' => '07:00:00',
            'status' => 'upcoming',
        ]);

        SystemSetting::setSetting('clinic_status', 'out', 'clinic');
        SystemSetting::setSetting('clinic_status_out_at', '2026-09-04 16:00:00', 'clinic');

        $this->actingAs($dentist)
            ->withSession(['role' => 'dentist'])
            ->get(route('dentist.dentist.patient.profile', $patient))
            ->assertOk();

        $updatedAppointment = $appointment->fresh();

        $this->assertSame('cancelled', $updatedAppointment->status);
        $this->assertSame(
            'Appointment was not started before the dentist checked out.',
            $updatedAppointment->cancellation_reason
        );
    }

    private function makeDentist(): User
    {
        $role = Role::create([
            'name' => 'Dentist',
            'slug' => 'dentist',
        ]);

        $permission = Permission::firstOrCreate(
            ['slug' => 'manage_patient_profiles'],
            [
                'name' => 'Manage Patient Profiles',
                'module' => 'Patients',
            ]
        );

        $role->permissions()->attach($permission);

        return User::create([
            'name' => 'Dentist User',
            'email' => 'dentist-auto-cancel@example.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id,
            'status' => 'active',
        ]);
    }

    private function makePatient(): Patient
    {
        return Patient::create([
            'name' => 'Appointment Patient',
            'email' => 'appointment-patient@example.com',
            'phone' => '09171234567',
            'birthdate' => '2004-01-01',
            'gender' => 'Female',
            'password' => bcrypt('password'),
        ]);
    }
}
