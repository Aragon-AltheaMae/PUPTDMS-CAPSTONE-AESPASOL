<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class DocumentRequestRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(public $documentRequest)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
{
    return [
        'title' => 'Document Request Rejected',
        'message' => 'Your document request has been rejected.',
        'reason' => $this->documentRequest->rejection_reason,
        'url' => route('patient.dashboard'),
        'icon' => 'fa-file-circle-xmark',
    ];
}

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}