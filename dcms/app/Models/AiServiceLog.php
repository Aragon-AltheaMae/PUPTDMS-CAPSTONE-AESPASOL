<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiServiceLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'feature',
        'provider',
        'status',
        'mode',
        'message',
        'context',
        'happened_at',
    ];

    protected $casts = [
        'context' => 'array',
        'happened_at' => 'datetime',
    ];
}
