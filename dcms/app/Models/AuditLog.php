<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'actor_role',
        'actor_identifier',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent'
    ];
}