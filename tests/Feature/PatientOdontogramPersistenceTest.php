<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PatientOdontogram;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientOdontogramPersistenceTest extends TestCase
{
    use RefreshDatabase;

    private int $appointmentSequence = 0;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_future_appointments_update_one_persistent_patient_odontogram(): void
    {
        $dentistRole = Role::create(['name' => 'Dentist', 'slug' => 'dentist']);
        $permission = Permission::create([
            'name' => 'Manage Appointments',
            'slug' => 'manage_appointments',
            'module' => 'Appointments',
        ]);
        $dentistRole->permissions()->attach($permission);

        $dentist = User::create([
            'name' => 'Test Dentist',
            'email' => 'dentist@example.com',
            'password' => bcrypt('password'),
            'role_id' => $dentistRole->id,
            'status' => 'active',
        ]);

        $patient = Patient::create([
            'name' => 'Test Patient',
            'email' => 'patient@example.com',
            'phone' => '09123456789',
            'birthdate' => '2000-01-01',
            'gender' => 'Male',
            'password' => bcrypt('password'),
        ]);

        $firstAppointment = $this->makeAppointment($patient, $dentist);

        $this->actingAs($dentist)
            ->withSession(['role' => 'dentist'])
            ->postJson(route('dentist.odontogram.save', $firstAppointment), [
                'odontogram_data' => [
                    $this->toothEntry(11, 'D', ['top' => 'F']),
                ],
                'oral_examination' => 'Initial examination',
                'diagnosis' => 'Initial diagnosis',
                'procedure_duration_hms' => '00:30:00',
                'completion_action' => 'finished',
                'has_applied_treatment' => true,
            ])
            ->assertSuccessful();

        $secondAppointment = $this->makeAppointment($patient, $dentist);

        $this->actingAs($dentist)
            ->withSession(['role' => 'dentist'])
            ->postJson(route('dentist.odontogram.save', $secondAppointment), [
                'odontogram_data' => [
                    $this->toothEntry(11, 'F', ['top' => 'F']),
                    $this->toothEntry(12, 'D'),
                ],
                'oral_examination' => 'Follow-up examination',
                'diagnosis' => 'Updated diagnosis',
                'procedure_duration_hms' => '00:30:00',
                'completion_action' => 'finished',
                'has_applied_treatment' => true,
            ])
            ->assertSuccessful();

        $this->assertDatabaseCount('patient_odontograms', 1);
        $this->assertDatabaseCount('appointment_procedures', 2);

        $odontogram = PatientOdontogram::where('patient_id', $patient->id)->firstOrFail();
        $teeth = collect($odontogram->odontogram_data)->keyBy('tooth');

        $this->assertSame([11, 12], $teeth->keys()->sort()->values()->all());
        $this->assertSame('F', data_get($teeth->get(11), 'status.code'));
        $this->assertSame('F', data_get($teeth->get(11), 'surfaces.top.code'));
        $this->assertSame('D', data_get($teeth->get(12), 'status.code'));
        $this->assertSame($secondAppointment->id, $odontogram->last_appointment_id);
        $this->assertSame($dentist->id, $odontogram->last_updated_by);
    }

    private function makeAppointment(Patient $patient, User $dentist): Appointment
    {
        $appointmentTime = now()->startOfHour()->addMinutes($this->appointmentSequence * 30);
        $this->appointmentSequence++;

        return Appointment::create([
            'patient_id' => $patient->id,
            'dentist_id' => $dentist->id,
            'service_type' => 'Oral Checkup',
            'appointment_date' => now()->toDateString(),
            'appointment_time' => $appointmentTime->format('H:i:s'),
            'status' => 'upcoming',
        ]);
    }

    private function toothEntry(int $tooth, string $statusCode, array $surfaces = []): array
    {
        $surfaceData = [];

        foreach ($surfaces as $surface => $code) {
            $surfaceData[$surface] = [
                'code' => $code,
                'label' => $code,
                'colorHex' => '#2563eb',
            ];
        }

        return [
            'tooth' => $tooth,
            'status' => [
                'code' => $statusCode,
                'label' => $statusCode,
                'colorHex' => '#ef4444',
            ],
            'surfaces' => $surfaceData,
        ];
    }
}
