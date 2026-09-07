<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservedBookingPeriod extends Model
{
    use HasFactory, SoftDeletes;

    public const MAX_CAPACITY = 30;

    public const BOOKING_MODES = [
        'timeslot',
        'date_only',
    ];

    public const PATIENT_TYPES = [
        'student',
        'faculty',
        'administrative',
        'guest',
    ];

    protected $fillable = [
        'title',
        'reserved_date',
        'active_reserved_date',
        'start_time',
        'end_time',
        'booking_mode',
        'timeslot_duration_minutes',
        'target_patient_type',
        'allowed_services',
        'program_code',
        'year_level',
        'section',
        'max_capacity',
        'notes',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'reserved_date' => 'date:Y-m-d',
        'active_reserved_date' => 'date:Y-m-d',
        'year_level' => 'integer',
        'max_capacity' => 'integer',
        'timeslot_duration_minutes' => 'integer',
        'allowed_services' => 'array',
        'is_active' => 'boolean',
    ];

    protected $appends = [
        'target_label',
    ];

    protected static function booted(): void
    {
        static::saving(function (ReservedBookingPeriod $period) {
            $period->active_reserved_date = $period->is_active
                ? optional($period->reserved_date)->format('Y-m-d')
                : null;
        });

        static::deleting(function (ReservedBookingPeriod $period) {
            if (! $period->isForceDeleting()) {
                $period->forceFill([
                    'is_active' => false,
                    'active_reserved_date' => null,
                ])->saveQuietly();
            }
        });

        static::restoring(function (ReservedBookingPeriod $period) {
            $period->forceFill([
                'is_active' => true,
                'active_reserved_date' => optional($period->reserved_date)->format('Y-m-d'),
            ]);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function slots()
    {
        return $this->hasMany(ReservedBookingPeriodSlot::class)
            ->orderBy('slot_time');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function activeAppointments()
    {
        return $this->appointments()->whereIn('status', ['upcoming', 'rescheduled']);
    }

    public function isEligiblePatient(Patient $patient): bool
    {
        $classification = strtolower(trim((string) $patient->classification));

        $matchesType = $this->target_patient_type === 'guest'
            ? in_array($classification, ['guest', 'dependent_alumni'], true)
            : $classification === $this->target_patient_type;

        if (! $matchesType) {
            return false;
        }

        if ($this->target_patient_type !== 'student') {
            return true;
        }

        return strtoupper(trim((string) $patient->course_code)) === strtoupper(trim((string) $this->program_code))
            && (int) $patient->year_level === (int) $this->year_level
            && strtoupper(trim((string) $patient->section)) === strtoupper(trim((string) $this->section));
    }

    public function allowsService(?string $service): bool
    {
        if ($this->allowed_services === null) {
            return true;
        }

        return collect($this->allowed_services)->contains(
            fn ($allowedService) => strcasecmp(trim((string) $allowedService), trim((string) $service)) === 0
        );
    }

    public function getTargetLabelAttribute(): string
    {
        $type = match ($this->target_patient_type) {
            'student' => 'Student',
            'faculty' => 'Faculty',
            'administrative' => 'Administrative',
            default => 'Guest',
        };

        if ($this->target_patient_type !== 'student') {
            return $type;
        }

        return implode(' · ', array_filter([
            $type,
            $this->program_code,
            $this->year_level ? 'Year '.$this->year_level : null,
            $this->section ? 'Section '.$this->section : null,
        ]));
    }
}
