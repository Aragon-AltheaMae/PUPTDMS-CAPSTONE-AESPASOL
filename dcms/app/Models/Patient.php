<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

    public function medicalHistory()
    {
        return $this->hasOne(\App\Models\MedicalHistory::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function documentRequests()
    {
        return $this->hasMany(DocumentRequest::class);
    }
}