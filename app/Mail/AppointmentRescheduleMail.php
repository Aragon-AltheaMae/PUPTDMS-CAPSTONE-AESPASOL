<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentRescheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Appointment $appointment,
        public ?string $oldAppointmentDate = null,
        public ?string $oldAppointmentTime = null,
        public ?string $rescheduledBy = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Rescheduled - PUP Taguig Dental Clinic',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.reschedule',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
