<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentDraft extends Model
{
    protected $fillable = [
        'patient_id',
        'payload',
        'current_step',
        'last_saved_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'current_step' => 'integer',
        'last_saved_at' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(
            Patient::class
        );
    }
}