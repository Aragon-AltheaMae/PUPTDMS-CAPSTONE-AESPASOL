<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    protected $fillable = ['code', 'label', 'sort_order'];

    public function medicalHistoryDiseaseAnswers()
    {
        return $this->hasMany(MedicalHistoryDiseaseAnswer::class);
    }
}