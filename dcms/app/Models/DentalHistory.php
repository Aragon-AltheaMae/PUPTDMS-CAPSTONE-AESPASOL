<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
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
        'headaches',
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
        'additional_concerns',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
