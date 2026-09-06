<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeactivation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deactivated_by',
        'employment_status',
        'account_status',
        'last_working_date',
        'access_ends_at',
        'deactivated_at',
        'reason',
    ];

    protected $casts = [
        'last_working_date' => 'date',
        'access_ends_at' => 'datetime',
        'deactivated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deactivatedBy()
    {
        return $this->belongsTo(User::class, 'deactivated_by');
    }
}
