<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalHistory extends Model
{
    protected $fillable = [
        'patient_id',
        'source_appointment_id',
        'last_dental_visit',
        'previous_dentist',

        'bleeding_gums',
        'sensitive_temp',
        'sensitive_taste',
        'tooth_pain',
        'sores',
        'injuries',

        'clicking',
        'joint_pain',
        'difficulty_moving',
        'difficulty_chewing',
        'jaw_headaches',
        'clench_grind',
        'biting',
        'teeth_loosening',
        'food_teeth',
        'med_reaction',

        'periodontal',
        'difficult_extraction',
        'prolonged_bleeding',
        'dentures',
        'ortho_treatment',

        'extraction_date',
        'dentures_date',
        'ortho_date',

        'additional_concerns',
    ];

    protected $casts = [
        'last_dental_visit' => 'date',
        'extraction_date'   => 'date',
        'dentures_date'     => 'date',
        'ortho_date'        => 'date',

        // booleans
        'bleeding_gums' => 'boolean',
        'sensitive_temp' => 'boolean',
        'sensitive_taste' => 'boolean',
        'tooth_pain' => 'boolean',
        'sores' => 'boolean',
        'injuries' => 'boolean',
        'clicking' => 'boolean',
        'joint_pain' => 'boolean',
        'difficulty_moving' => 'boolean',
        'difficulty_chewing' => 'boolean',
        'jaw_headaches' => 'boolean',
        'clench_grind' => 'boolean',
        'biting' => 'boolean',
        'teeth_loosening' => 'boolean',
        'food_teeth' => 'boolean',
        'med_reaction' => 'boolean',
        'periodontal' => 'boolean',
        'difficult_extraction' => 'boolean',
        'prolonged_bleeding' => 'boolean',
        'dentures' => 'boolean',
        'ortho_treatment' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function sourceAppointment()
    {
        return $this->belongsTo(Appointment::class, 'source_appointment_id');
    }
}