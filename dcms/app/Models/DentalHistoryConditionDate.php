<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalHistoryConditionDate extends Model
{
    protected $fillable = [
        'patient_id',
        'extraction_date',
        'dentures_date',
        'ortho_date',
    ];

    protected $casts = [
        'extraction_date' => 'date',
        'dentures_date'   => 'date',
        'ortho_date'      => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}