<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalHistory extends Model
{
    protected $fillable = [
        'appointment_id',
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
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
