<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalHistoryAnswer extends Model
{
    protected $fillable = [
        'patient_id',
        'condition_id',
        'answer',
    ];

    protected $casts = [
        'answer' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function condition()
    {
        return $this->belongsTo(DentalHistoryCondition::class, 'condition_id');
    }
}