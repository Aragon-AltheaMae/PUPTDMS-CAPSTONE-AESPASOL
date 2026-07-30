<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryDiseaseAnswer extends Model
{
    protected $fillable = [
        'patient_id',
        'medical_history_id',
        'disease_id',
        'has_disease',
    ];

    protected $casts = [
        'has_disease' => 'boolean',
    ];

     public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class);
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
}