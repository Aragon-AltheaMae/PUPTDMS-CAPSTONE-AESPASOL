<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ServiceType;

class Appointment extends Model
{
    use HasFactory;

    public const ACTIVE_DUTY_END_STATUSES = [
        'pending',
        'confirmed',
        'upcoming',
        'rescheduled',
    ];

    public const FINALIZED_STATUSES = [
        'completed',
        'cancelled',
        'rejected',
        'no_show',
        'no-show',
    ];

    protected $fillable = [
        'patient_id',
        'service_type_id',
        'reserved_booking_period_id',
        'reserved_booking_period_slot_id',
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

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function dentalHistory()
    {
        return $this->hasOne(DentalHistory::class);
    }

    public function scopeForDentist(Builder $query, int $dentistId): Builder
    {
        return $query->where('dentist_id', $dentistId);
    }

    public function scopeScheduledOnDate(Builder $query, string $date): Builder
    {
        return $query->whereDate('appointment_date', $date);
    }

    public function scopeActiveForDutyEnd(Builder $query): Builder
    {
        return $query->whereIn('status', self::ACTIVE_DUTY_END_STATUSES);
    }

    public function medicalHistory()
    {
        return $this->hasOne(MedicalHistory::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function reservedBookingPeriod()
    {
        return $this->belongsTo(ReservedBookingPeriod::class)->withTrashed();
    }

    public function reservedBookingPeriodSlot()
    {
        return $this->belongsTo(ReservedBookingPeriodSlot::class);
    }

    public function reservedProcedureWindowIsOpen(?Carbon $now = null): bool
    {
        if (! $this->reservedBookingPeriod) {
            return Carbon::parse($this->appointment_date)->isToday();
        }

        $now ??= now();
        $date = Carbon::parse($this->reservedBookingPeriod->reserved_date)->toDateString();
        $start = Carbon::parse($date . ' ' . $this->reservedBookingPeriod->start_time);
        $end = Carbon::parse($date . ' ' . $this->reservedBookingPeriod->end_time);

        return $now->betweenIncluded($start, $end);
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

    public function getServiceTypeNameAttribute(): ?string
    {
        return $this->serviceType?->name ?? $this->service_type;
    }
}
