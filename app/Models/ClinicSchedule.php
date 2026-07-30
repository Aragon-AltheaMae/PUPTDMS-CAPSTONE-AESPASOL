<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClinicSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'days_label', 'days', 'status',
        'open_time', 'close_time', 'break_time',
        'max_slots', 'notes', 'is_active',
    ];

    protected $casts = [
        'days'      => 'array',
        'is_active' => 'boolean',
    ];

    // ── Scopes ───

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ── Helpers ───
    public function getHoursRangeAttribute(): string
    {
        if ($this->status === 'closed') return 'Closed';
        if (! $this->open_time || ! $this->close_time) return '—';
        return date('g:i A', strtotime($this->open_time))
             . ' – '
             . date('g:i A', strtotime($this->close_time));
    }

    public function getDaysLabelAttribute(): string
    {
        $map = [
            'Mon' => 'M',
            'Tue' => 'T',
            'Wed' => 'W',
            'Thu' => 'TH',
            'Fri' => 'F',
            'Sat' => 'SAT',
            'Sun' => 'SUN',
        ];

        $order = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        return collect($this->days ?? [])
            ->sortBy(fn($day) => array_search($day, $order))
            ->map(fn($day) => $map[$day] ?? $day)
            ->implode(', ');
    }

    /**
     * Returns available time-slot strings for a specific ISO date.
     * Each element: ['time' => '9:00 AM', 'available' => true]
     *
     * @param  array  $bookedSlotCounts  ['9:00 AM' => 1, '10:00 AM' => 0, …]
     */
    
    public function availableSlots(string $isoDate, array $bookedSlotCounts = []): array
        {
            if ($this->status === 'closed') {
                return [];
            }

            $openH  = (int) date('H', strtotime($this->open_time ?? '09:00'));
            $closeH = (int) date('H', strtotime($this->close_time ?? '17:00'));

            $breakStart = $breakEnd = null;
            if ($this->break_time && $this->break_time !== 'none') {
                [$bs, $be] = explode('-', $this->break_time);
                $breakStart = (int) substr(trim($bs), 0, 2);
                $breakEnd   = (int) substr(trim($be), 0, 2);
            }

            $slots = [];

            for ($h = $openH; $h < $closeH; $h++) {
                if ($breakStart !== null && $h >= $breakStart && $h < $breakEnd) {
                    continue;
                }

                $mysqlTime = sprintf('%02d:00:00', $h);
                $label     = date('g:i A', strtotime($mysqlTime));
                $booked    = $bookedSlotCounts[$mysqlTime] ?? 0;

                $slots[] = [
                    'time'       => $label,
                    'mysql_time' => $mysqlTime,
                    'available'  => $booked < 1,
                ];
            }
        return $slots;
    }
}