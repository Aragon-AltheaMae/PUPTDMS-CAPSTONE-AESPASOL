<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTreatmentRecord extends Model
{

    protected $fillable = [
        'treatment_date',
        'patient_name',
        'patient_email',
        'patient_phone',
        'office_type',
        'program_code',
        'gender',
        'treatment_done',
        'minutes_processed',
        'has_signature',
        'signature_path',
    ];

    protected $casts = [
        'treatment_date' => 'date',
        'has_signature' => 'boolean',
    ];
}
