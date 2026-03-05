<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Authenticatable
{
    use HasFactory;

        protected $fillable = [
            'name',
            'email',
            'phone',
            'birthdate',
            'gender',
            'password',
        ];



    protected $hidden = [
        'password',
    ];

    public function dentalHistory()
    {
        return $this->hasOne(\App\Models\DentalHistory::class);
    }

    public function dentalHistoryDates()
    {
        return $this->hasOne(\App\Models\DentalHistoryConditionDate::class);
    }

    public function dentalHistoryConcerns()
    {
        return $this->hasOne(\App\Models\DentalHistoryConcern::class);
    }

    public function dentalHistoryAnswers()
    {
        return $this->hasMany(\App\Models\DentalHistoryAnswer::class);
    }
}
