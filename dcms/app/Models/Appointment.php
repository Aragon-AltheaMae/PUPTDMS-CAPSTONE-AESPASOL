<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'service_type',
        'appointment_date',
        'appointment_time',
        'status',
        'patient_signature',
        'service_type',
    ];

    public function dentalHistory()
    {
        return $this->hasOne(DentalHistory::class);
    }

    public function medicalHistory()
    {
        return $this->hasOne(MedicalHistory::class);
    }
}
