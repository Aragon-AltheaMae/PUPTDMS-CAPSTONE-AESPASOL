<?php

namespace App\Mail;

use App\Models\DocumentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentRequestApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public DocumentRequest $documentRequest
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Document Request Approved - PUP Taguig Dental Clinic',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.document-requests.approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}