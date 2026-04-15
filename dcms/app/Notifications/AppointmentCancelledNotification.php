<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentCancelledNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly Appointment $appointment,
        private readonly string $cancelledBy = 'Dentist',
        private readonly ?string $reason = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $message = sprintf(
            'Your appointment on %s at %s was cancelled by %s.',
            optional($this->appointment->appointment_date)->format('M d, Y') ?? (string) $this->appointment->appointment_date,
            $this->formatTime($this->appointment->appointment_time),
            $this->cancelledBy
        );

        if (!empty($this->reason)) {
            $message .= ' Reason: ' . $this->reason;
        }

        return [
            'title' => 'Appointment Cancelled',
            'message' => $message,
            'url' => route('patient.appointment.index'),
            'icon' => 'fa-calendar-xmark',
            'appointment_id' => $this->appointment->id,
            'patient_id' => $this->appointment->patient_id,
            'event' => 'appointment.cancelled',
        ];
    }

    private function formatTime(?string $time): string
    {
        if (empty($time)) {
            return 'N/A';
        }

        try {
            return \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('g:i A');
        } catch (\Throwable) {
            return $time;
        }
    }
}
