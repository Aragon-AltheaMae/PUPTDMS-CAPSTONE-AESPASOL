<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalHistoryCondition extends Model
{
    protected $fillable = ['code', 'question', 'sort_order'];

    public function answers()
    {
        return $this->hasMany(DentalHistoryAnswer::class, 'condition_id');
    }
}