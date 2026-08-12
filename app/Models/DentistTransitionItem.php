<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentistTransitionItem extends Model
{
    use HasFactory;

    public const TYPES = [
        'appointment',
        'document_request',
    ];

    public const TRANSFER_STATUSES = [
        'pending',
        'ready',
        'transferred',
        'excluded',
        'manually_resolved',
        'failed',
    ];

    protected $fillable = [
        'dentist_transition_id',
        'item_type',
        'record_id',
        'patient_id',
        'original_dentist_id',
        'successor_dentist_id',
        'transfer_status',
        'is_critical',
        'resolution_type',
        'remarks',
        'transferred_by',
        'transferred_at',
    ];

    protected $casts = [
        'is_critical' => 'boolean',
        'transferred_at' => 'datetime',
    ];

    public function transition()
    {
        return $this->belongsTo(DentistTransition::class, 'dentist_transition_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function originalDentist()
    {
        return $this->belongsTo(User::class, 'original_dentist_id');
    }

    public function successorDentist()
    {
        return $this->belongsTo(User::class, 'successor_dentist_id');
    }

    public function transferredBy()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }

    public function documentRequest()
    {
        return $this->belongsTo(DocumentRequest::class, 'record_id');
    }

    public function getReferenceLabelAttribute(): string
    {
        return match ($this->item_type) {
            'appointment' => 'APT-' . str_pad((string) $this->record_id, 6, '0', STR_PAD_LEFT),
            'document_request' => $this->documentRequest?->reference_number
                ? 'DOC-' . $this->documentRequest->reference_number
                : 'DOC-' . str_pad((string) $this->record_id, 6, '0', STR_PAD_LEFT),
            default => strtoupper($this->item_type) . '-' . $this->record_id,
        };
    }
}
