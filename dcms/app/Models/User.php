<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'sso_user_id',
        'last_login_at',
        'access_token',
        'refresh_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'access_token',
        'refresh_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $slug): bool
    {
        return optional($this->role)->slug === $slug;
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function hasAnyRole(array $slugs): bool
    {
        return in_array(optional($this->role)->slug, $slugs, true);
    }

    public function hasPermission(string $permissionSlug): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->permissions()->where('slug', $permissionSlug)->exists();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}