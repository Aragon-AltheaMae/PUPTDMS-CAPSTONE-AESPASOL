<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['patient', 'datetime', 'service'];

    public function dentalHistory()
    {
         return $this->belongsTo(Appointment::class);
    }

    public function medicalHistory()
    {
        return $this->belongsTo(Appointment::class);
    }
}

