<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory_items'; 

    protected $fillable = [
        'category',
        'date_received',
        'expiration_date',
        'stock_no',
        'name',
        'unit',
        'qty',
        'used'
    ];

    protected $appends = [
        'balance',
        'formatted_date',
        'formatted_expiration_date',
        'expiration_days_remaining',
        'expiration_status',
        'expiration_label',
    ];

    public function getBalanceAttribute()
    {
        return $this->qty - $this->used;
    }

    public function getFormattedDateAttribute()
    {
        return $this->date_received->format('m/d/y');
    }

    public function getFormattedExpirationDateAttribute(): ?string
    {
        return $this->expiration_date?->format('m/d/y');
    }

    public function getExpirationDaysRemainingAttribute(): ?int
    {
        return $this->expiration_date
            ? today()->diffInDays($this->expiration_date, false)
            : null;
    }

    public function getExpirationStatusAttribute(): string
    {
        if (! $this->expiration_date) {
            return 'none';
        }

        $today = today();
        $expirationDate = $this->expiration_date->copy()->startOfDay();

        if ($expirationDate->lt($today)) {
            return 'expired';
        }

        if ($expirationDate->equalTo($today)) {
            return 'today';
        }

        return $expirationDate->lte($today->copy()->addDays(30))
            ? 'near'
            : 'normal';
    }

    public function getExpirationLabelAttribute(): ?string
    {
        if (! $this->expiration_date) {
            return null;
        }

        return match ($this->expiration_status) {
            'expired' => 'Expired ' . today()->diffInDays($this->expiration_date) . ' day(s) ago',
            'today' => 'Expires Today',
            'near' => 'Expiring Soon (' . today()->diffInDays($this->expiration_date) . ' day(s))',
            default => 'Expires ' . $this->expiration_date->format('M d, Y'),
        };
    }

    protected $casts = [
        'date_received' => 'date',
        'expiration_date' => 'date',
    ];
}
