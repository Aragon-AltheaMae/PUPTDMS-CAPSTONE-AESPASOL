<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientOdontogram extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'odontogram_data',
        'last_appointment_id',
        'last_updated_by',
    ];

    protected $casts = [
        'odontogram_data' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function lastAppointment()
    {
        return $this->belongsTo(Appointment::class, 'last_appointment_id');
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }
}
