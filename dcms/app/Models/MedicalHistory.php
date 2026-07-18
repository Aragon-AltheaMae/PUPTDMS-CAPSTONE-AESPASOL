<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    protected $fillable = [
        'patient_id',
        'emergency_person',
        'emergency_number',
        'emergency_relation',
        'patient_signature',
        'signature_review_status',
        'signature_review_notes',
        'signature_ai_provider',
        'signature_ai_confidence',
    ];

    protected $casts = [
        'signature_ai_confidence' => 'float',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function answers()
    {
        return $this->hasMany(MedicalHistoryAnswer::class);
    }

    public function diseaseAnswers()
    {
        return $this->hasMany(MedicalHistoryDiseaseAnswer::class);
    }
}
