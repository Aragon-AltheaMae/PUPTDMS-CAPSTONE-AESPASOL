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
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'code',
        'email',
        'phone',
        'birthdate',
        'gender',
        'password',
        'role_id',
        'status',
        'employment_status',
        'account_status',
        'last_working_date',
        'access_ends_at',
        'deactivated_at',
        'deactivated_by',
        'deactivation_reason',
        'sso_user_id',
        'last_login_at',
        'last_failed_login_at',
        'failed_login_attempts',
        'locked_until',
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
        'last_failed_login_at' => 'datetime',
        'locked_until' => 'datetime',
        'birthdate' => 'date',
        'last_working_date' => 'date',
        'access_ends_at' => 'datetime',
        'deactivated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function faculty()
    {
        return $this->hasOne(Faculty::class);
    }

    public function dentistTransitions()
    {
        return $this->hasMany(DentistTransition::class, 'dentist_id');
    }

    public function initiatedDentistTransitions()
    {
        return $this->hasMany(DentistTransition::class, 'initiated_by');
    }

    public function successorDentistTransitions()
    {
        return $this->hasMany(DentistTransition::class, 'default_successor_dentist_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Role & Permission Helpers
    |--------------------------------------------------------------------------
    */

    public function hasRole(string $slug): bool
    {
        return optional($this->role)->slug === $slug;
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

    /*
    |--------------------------------------------------------------------------
    | JWT
    |--------------------------------------------------------------------------
    */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    // 🔥 Full name (automatic)
    public function getFullNameAttribute()
    {
        return trim(
            $this->first_name . ' ' .
            ($this->middle_name ?? '') . ' ' .
            $this->last_name . ' ' .
            ($this->suffix_name ?? '')
        );
    }
}
