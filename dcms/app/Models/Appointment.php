<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'appointment_date',
        'appointment_time',
        'status',
    ];

    public function service()
    {
        return $this->hasOne(AppointmentService::class);
    }

    public function dentalHistory()
    {
        return $this->hasOne(DentalHistory::class);
    }

    public function medicalHistory()
    {
        return $this->hasOne(MedicalHistory::class);
    }
}
