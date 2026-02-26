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
        'other_services',
        'appointment_date',
        'appointment_time',
        'status',
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
