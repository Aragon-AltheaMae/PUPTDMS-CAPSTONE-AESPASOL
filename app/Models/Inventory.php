<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory_items'; 

    protected $fillable = [
        'category',
        'date_received',
        'stock_no',
        'name',
        'unit',
        'qty',
        'used'
    ];

    protected $appends = ['balance', 'formatted_date'];

    public function getBalanceAttribute()
    {
        return $this->qty - $this->used;
    }

    public function getFormattedDateAttribute()
    {
        return $this->date_received->format('m/d/y');
    }

    protected $casts = [
        'date_received' => 'date',
    ];
}
