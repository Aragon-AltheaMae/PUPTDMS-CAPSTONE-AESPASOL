<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalHistory extends Model
{
    protected $fillable = [
        'patient_id',
        'last_dental_visit',
        'previous_dentist',
    ];

    protected $casts = [
        'last_dental_visit' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}