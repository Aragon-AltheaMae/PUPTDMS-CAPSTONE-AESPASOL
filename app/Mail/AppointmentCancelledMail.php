<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Appointment $appointment,
        public ?string $cancelledBy = null,
        public ?string $reason = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Cancelled - PUP Taguig Dental Clinic',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointments.cancellation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
