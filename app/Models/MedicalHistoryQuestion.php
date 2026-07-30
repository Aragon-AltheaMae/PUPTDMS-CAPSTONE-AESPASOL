<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHistoryQuestion extends Model
{
    protected $fillable = ['code', 'type', 'sort_order'];

    public function answers()
    {
        return $this->hasMany(MedicalHistoryAnswer::class, 'question_id');
    }
}