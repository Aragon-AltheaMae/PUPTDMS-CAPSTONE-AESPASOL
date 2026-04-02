<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AuditLog extends Model
{
    protected $fillable = [
        'actor_id',
        'actor_name',
        'actor_role',
        'actor_identifier',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}