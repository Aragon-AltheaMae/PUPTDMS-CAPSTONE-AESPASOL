<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryAnswer extends Model
{
    protected $fillable = [
        'patient_id',
        'medical_history_id',
        'question_id',
        'answer_bool',
        'answer_text',
        'answer_date',
    ];

    protected $casts = [
        'answer_bool' => 'boolean',
        'answer_date' => 'date',
    ];

     public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class);
    }

    public function question()
    {
        return $this->belongsTo(MedicalHistoryQuestion::class, 'question_id');
    }
}