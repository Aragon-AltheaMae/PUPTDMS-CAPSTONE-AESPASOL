<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'hypertension',
        'diabetes',
        'heart_condition',
        'allergy',
        'pregnant',
        'nursing',
        'birth_control',
        'emergency_person',
        'emergency_number',
        'emergency_relation',
        'patient_signature',
    ];

    protected $casts = [
        'hypertension' => 'boolean',
        'diabetes' => 'boolean',
        'heart_condition' => 'boolean',
        'allergy' => 'boolean',
        'pregnant' => 'boolean',
        'nursing' => 'boolean',
        'birth_control' => 'boolean',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
