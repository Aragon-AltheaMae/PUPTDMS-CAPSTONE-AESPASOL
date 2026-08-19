<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'dentist_id',
        'original_dentist_id',
        'service_type',
        'appointment_date',
        'appointment_time',
        'status',
        'cancellation_reason',
        'transferred_by',
        'transferred_at',
        'transfer_reason',
        'is_follow_up',
        'follow_up_for_appointment_id',
        'follow_up_reason',
        'follow_up_reminder_sent_at',
        'follow_up_today_reminder_sent_at',
        'follow_up_one_day_reminder_sent_at',
        'is_walk_in',
    ];

    protected $casts = [
        'is_follow_up' => 'boolean',
        'follow_up_reminder_sent_at' => 'datetime',
        'follow_up_today_reminder_sent_at' => 'datetime',
        'follow_up_one_day_reminder_sent_at' => 'datetime',
        'is_walk_in' => 'boolean',
        'transferred_at' => 'datetime',
    ];

    public function dentalHistory()
    {
        return $this->hasOne(DentalHistory::class);
    }

    public function medicalHistory()
    {
        return $this->hasOne(MedicalHistory::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function dentist()
    {
        return $this->belongsTo(User::class, 'dentist_id');
    }

    public function originalDentist()
    {
        return $this->belongsTo(User::class, 'original_dentist_id');
    }

    public function transferActor()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }

    public function originalAppointment()
    {
        return $this->belongsTo(Appointment::class, 'follow_up_for_appointment_id');
    }

    public function followUpAppointments()
    {
        return $this->hasMany(Appointment::class, 'follow_up_for_appointment_id');
    }

    public function procedure()
    {
        return $this->hasOne(AppointmentProcedure::class);
    }
}
