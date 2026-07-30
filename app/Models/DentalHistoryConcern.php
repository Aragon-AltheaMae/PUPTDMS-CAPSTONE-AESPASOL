<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalHistoryConcern extends Model
{
    protected $fillable = [
        'patient_id',
        'additional_concerns',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}