<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentProcedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'odontogram_data',
        'oral_examination',
        'diagnosis',
        'prescriptions',
        'completion_action',
        'procedure_started_at',
        'procedure_completed_at',
        'procedure_duration_seconds',
    ];

    protected $casts = [
        'odontogram_data' => 'array',
        'procedure_started_at' => 'datetime',
        'procedure_completed_at' => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
