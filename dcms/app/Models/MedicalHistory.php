<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $fillable = [
        'appointment_id',

        'good_health',
        'good_health_details',
        'medical_exam_date',

        'under_treatment',
        'treatment_details',

        'hospitalized',
        'hospital_details',

        'allergy_medicine',
        'allergy_food',
        'allergy_others',

        'medication',
        'medication_details',

        'pregnant',
        'nursing',
        'birth_control',

        'tobacco_use',
        'tobacco_per_day',
        'tobacco_per_week',

        'headaches',
        'earaches',
        'neck_aches',

        'emergency_person',
        'emergency_number',
        'emergency_relation',

        'patient_signature',
    ];

    protected $casts = [
        'medical_exam_date' => 'date',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function conditions()
    {
        return $this->hasOne(MedicalHistoryCondition::class);
    }
}
