<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\SystemSetting;
use App\Models\User;
use App\Notifications\AppointmentCancelledNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CancelAppointmentsDuringClinicOut extends Command
{
    protected $signature = 'appointments:cancel-during-clinic-out';

    protected $description = 'Cancel due appointments while the clinic is marked OUT';

    public function handle(): int
    {
        $clinicStatus = strtolower(
            trim(
                (string) SystemSetting::getSetting(
                    'clinic_status',
                    'in'
                )
            )
        );

        if ($clinicStatus !== 'out') {
            $this->info('Clinic is IN. No appointments cancelled.');

            return self::SUCCESS;
        }

        $now = Carbon::now();

        $this->info(
            'Clinic is OUT. Checking appointments as of '
                . $now->format('Y-m-d h:i A')
        );

        $appointments = Appointment::with('patient.user')
            ->whereDate(
                'appointment_date',
                $now->toDateString()
            )
            ->whereIn('status', [
                'upcoming',
                'rescheduled',
                'pending',
                'confirmed',
            ])
            ->orderBy('appointment_time')
            ->get();

        $cancelledCount = 0;

        foreach ($appointments as $appointment) {
            if (empty($appointment->appointment_time)) {
                continue;
            }

            try {
                $appointmentDate = Carbon::parse(
                    $appointment->appointment_date
                )->format('Y-m-d');

                $appointmentDateTime = Carbon::parse(
                    $appointmentDate . ' ' . $appointment->appointment_time
                );
            } catch (\Throwable $e) {
                Log::warning(
                    'Unable to parse appointment schedule.',
                    [
                        'appointment_id' => $appointment->id,
                        'date' => $appointment->appointment_date,
                        'time' => $appointment->appointment_time,
                        'error' => $e->getMessage(),
                    ]
                );

                continue;
            }

            $this->line(
                "Appointment #{$appointment->id}: "
                    . $appointmentDateTime->format('Y-m-d h:i A')
                    . " | Status: {$appointment->status}"
            );

            /*
         * Appointment time has not arrived yet.
         * Leave it active.
         */
            if ($appointmentDateTime->isFuture()) {
                $this->line('  -> Not due yet. Skipped.');

                continue;
            }

            /*
         * Clinic is currently OUT and appointment
         * time has already arrived.
         */
            $appointment->update([
                'status' => 'cancelled',
            ]);

            $patientUser = $this->resolvePatientUser(
                $appointment->patient
            );

            if ($patientUser) {
                try {
                    $patientUser->notify(
                        new AppointmentCancelledNotification(
                            $appointment,
                            'the dentist',
                            'Dentist is unavailable and the clinic is currently closed.'
                        )
                    );
                } catch (\Throwable $e) {
                    Log::error(
                        'Failed sending automatic cancellation notification.',
                        [
                            'appointment_id' => $appointment->id,
                            'user_id' => $patientUser->id,
                            'error' => $e->getMessage(),
                        ]
                    );
                }
            }

            $cancelledCount++;

            $this->info(
                "  -> CANCELLED appointment #{$appointment->id}"
            );
        }

        $this->info(
            "Finished. {$cancelledCount} appointment(s) cancelled."
        );

        return self::SUCCESS;
    }

    private function resolvePatientUser($patient): ?User
    {
        if (!$patient) {
            return null;
        }

        if (
            isset($patient->user)
            && $patient->user instanceof User
        ) {
            return $patient->user;
        }

        if (!empty($patient->user_id)) {
            return User::find($patient->user_id);
        }

        if (!empty($patient->email)) {
            return User::where(
                'email',
                $patient->email
            )->first();
        }

        return User::where(
            'patient_id',
            $patient->id
        )->first();
    }
}
