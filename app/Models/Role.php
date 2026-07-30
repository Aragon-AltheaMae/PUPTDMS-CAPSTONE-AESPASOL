<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getDisplayNameAttribute(): string
    {
        return match ($this->slug) {
            'super_admin' => 'Admin',
            'dentist' => 'Dentist',
            'patient' => 'Patient',
            default => $this->name,
        };
    }
}