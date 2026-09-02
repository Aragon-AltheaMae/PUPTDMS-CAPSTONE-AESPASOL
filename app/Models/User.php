<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    private const PERMISSION_ALIASES = [
        'view_patient_profiles' => ['manage_patient_profiles'],
        'view_dental_records' => ['manage_dental_records'],
        'view_appointments' => ['manage_appointments'],
        'reschedule_appointments' => ['manage_appointments'],
        'cancel_appointments' => ['manage_appointments'],
        'create_follow_up_appointments' => ['manage_appointments'],
        'create_procedure_records' => ['manage_appointments', 'manage_walk_in_patients', 'manage_existing_records'],
        'create_dental_records' => ['manage_appointments', 'manage_walk_in_patients', 'manage_existing_records', 'manage_dental_records'],
        'create_medical_records' => ['manage_appointments', 'manage_walk_in_patients', 'manage_existing_records', 'manage_dental_records'],
        'create_odontograms' => ['manage_appointments', 'manage_walk_in_patients', 'manage_existing_records', 'manage_dental_records'],
        'update_odontograms' => ['manage_appointments', 'manage_walk_in_patients', 'manage_existing_records', 'manage_dental_records'],
        'view_reports' => ['manage_reports', 'create_report_files', 'create_ai_generative_reports'],
        'view_roles_permissions' => [
            'manage_user_roles',
            'create_custom_roles',
            'update_role_permissions',
            'delete_custom_roles',
        ],
        'create_custom_roles' => ['manage_user_roles'],
        'update_role_permissions' => ['manage_user_roles'],
        'delete_custom_roles' => ['manage_user_roles'],
        'view_system_logs' => [
            'export_system_logs',
            'archive_system_logs',
        ],
        'manage_audit_trail' => [
            'view_system_logs',
            'export_system_logs',
            'archive_system_logs',
        ],
        'export_system_logs' => [],
        'archive_system_logs' => [],
        'view_account_details' => ['manage_user_accounts', 'manage_user_roles', 'manage_dentist_accounts'],
        'create_users' => ['create_disable_users', 'manage_user_accounts', 'manage_user_roles', 'manage_dentist_accounts'],
        'disable_users' => ['create_disable_users', 'manage_user_accounts', 'manage_user_roles', 'manage_dentist_accounts'],
        'update_user_role' => ['update_role_password', 'manage_user_accounts', 'manage_user_roles', 'manage_dentist_accounts'],
        'update_user_password' => ['update_role_password', 'manage_user_accounts', 'manage_user_roles', 'manage_dentist_accounts'],
        'view_service_type' => [
            'view_service_types',
            'create_service_type',
            'delete_service_type',
            'update_default_service_type',
        ],
        'create_service_type' => ['create_delete_custom_service_types'],
        'delete_service_type' => ['create_delete_custom_service_types'],
        'update_default_service_type' => ['update_service_types'],
        'view_clinic_schedule' => ['manage_clinic_schedule', 'create_delete_clinic_schedule'],
        'update_clinic_schedule' => ['manage_clinic_schedule', 'create_delete_clinic_schedule'],
        'create_clinic_schedule' => ['manage_clinic_schedule', 'create_delete_clinic_schedule'],
        'delete_clinic_schedule' => ['manage_clinic_schedule', 'create_delete_clinic_schedule'],
        'view_academic_periods' => ['set_academic_year'],
        'update_academic_period' => ['set_academic_year'],
        'create_academic_period' => ['create_delete_academic_period', 'set_academic_year'],
        'delete_academic_period' => ['create_delete_academic_period', 'set_academic_year'],
        'view_inventory' => ['manage_inventory'],
        'add_inventory' => ['manage_inventory', 'manage_inventory_items'],
        'update_inventory' => ['manage_inventory', 'manage_inventory_items'],
        'delete_inventory' => ['manage_inventory', 'manage_inventory_items'],
        'view_cms_integration' => ['manage_dentist_accounts', 'manage_cms_users'],
        'create_cms_integration' => ['manage_dentist_accounts', 'manage_cms_users'],
        'update_cms_integration' => ['manage_dentist_accounts', 'manage_cms_users'],
        'view_faculty_integration' => ['manage_dentist_accounts'],
        'create_faculty_integration' => ['manage_dentist_accounts'],
        'update_faculty_integration' => ['manage_dentist_accounts'],
    ];

    public const ADMIN_AREA_PERMISSION_SLUGS = [
        'access_super_admin_dashboard',
        'manage_system_settings',
        'set_notification_rules',
        'view_system_logs',
        'export_system_logs',
        'archive_system_logs',
        'manage_audit_trail',
        'view_account_details',
        'create_users',
        'disable_users',
        'update_user_role',
        'update_user_password',
        'view_roles_permissions',
        'create_custom_roles',
        'update_role_permissions',
        'delete_custom_roles',
        'view_patient_profiles',
        'view_dental_records',
        'view_appointments',
        'view_clinic_schedule',
        'update_clinic_schedule',
        'create_clinic_schedule',
        'delete_clinic_schedule',
        'create_delete_clinic_schedule',
        'view_document_requests',
        'approve_document_requests',
        'reject_document_requests',
        'manage_document_templates',
        'view_reports',
        'create_report_files',
        'create_ai_generative_reports',
        'view_inventory',
        'add_inventory',
        'update_inventory',
        'delete_inventory',
        'view_service_type',
        'create_service_type',
        'delete_service_type',
        'update_default_service_type',
        'view_academic_periods',
        'update_academic_period',
        'create_academic_period',
        'delete_academic_period',
        'view_cms_integration',
        'create_cms_integration',
        'update_cms_integration',
        'view_faculty_integration',
        'create_faculty_integration',
        'update_faculty_integration',
        'view_dentist_transitions',
        'create_dentist_transitions',
        'update_dentist_transitions',
        'assign_dentist_successors',
        'finalize_dentist_transitions',
        'cancel_dentist_transitions',
        'extend_dentist_access',
        'set_academic_year',
        'receive_notifications',
        'access_dentist_dashboard',
        'access_patient_dashboard',
    ];

    public const CLINICAL_PERMISSION_SLUGS = [
        'access_dentist_dashboard',
        'manage_appointments',
        'view_appointments',
        'reschedule_appointments',
        'cancel_appointments',
        'create_follow_up_appointments',
        'manage_walk_in_patients',
        'manage_existing_records',
        'create_procedure_records',
        'create_dental_records',
        'create_medical_records',
        'create_odontograms',
        'update_odontograms',
        'manage_clinic_schedule',
        'view_clinic_schedule',
        'update_clinic_schedule',
        'create_clinic_schedule',
        'delete_clinic_schedule',
        'manage_patient_profiles',
        'view_patient_profiles',
        'view_dental_records',
        'view_document_requests',
        'approve_document_requests',
        'reject_document_requests',
        'manage_inventory',
        'view_inventory',
        'add_inventory',
        'update_inventory',
        'delete_inventory',
        'create_report_files',
        'manage_dental_records',
        'view_dentist_transitions',
        'create_dentist_transitions',
        'update_dentist_transitions',
        'assign_dentist_successors',
        'finalize_dentist_transitions',
        'cancel_dentist_transitions',
        'extend_dentist_access',
    ];

    public const PATIENT_AREA_PERMISSION_SLUGS = [
        'access_patient_dashboard',
        'book_appointments',
        'view_own_appointments',
        'view_own_profile',
        'view_own_records',
        'request_documents',
        'receive_notifications',
    ];

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

        $candidateSlugs = array_values(array_unique([
            $permissionSlug,
            ...self::PERMISSION_ALIASES[$permissionSlug] ?? [],
        ]));

        $actualRoleSlug = optional($this->role)->slug;
        $activeRoleSlug = session('impersonated_role')
            ?: session('role')
            ?: $actualRoleSlug;

        if ($activeRoleSlug && $activeRoleSlug !== $actualRoleSlug) {
            $activeRole = Role::with('permissions')
                ->where('slug', $activeRoleSlug)
                ->first();

            if ($activeRole) {
                return $activeRole->permissions
                    ->whereIn('slug', $candidateSlugs)
                    ->isNotEmpty();
            }
        }

        return $this->role->permissions()
            ->whereIn('slug', $candidateSlugs)
            ->exists();
    }

    public function hasAnyPermission(array $permissionSlugs): bool
    {
        if (!$this->role) {
            return false;
        }

        foreach ($permissionSlugs as $permissionSlug) {
            if ($this->hasPermission((string) $permissionSlug)) {
                return true;
            }
        }

        return false;
    }

    public function isExemptFromIdleTimeout(?string $activeRoleSlug = null): bool
    {
        $normalizedRole = $this->activeRoleSlug($activeRoleSlug);

        $exemptRoles = array_map(
            static fn (mixed $role): string => strtolower(trim((string) $role)),
            (array) config('session.idle_timeout_exempt_roles', [])
        );

        return in_array($normalizedRole, $exemptRoles, true);
    }

    public function idleTimeoutSeconds(?string $activeRoleSlug = null): int
    {
        if ($this->isExemptFromIdleTimeout($activeRoleSlug)) {
            return 0;
        }

        $roleSlug = $this->activeRoleSlug($activeRoleSlug);
        $coreRoles = array_map(
            static fn (mixed $role): string => strtolower(trim((string) $role)),
            (array) config('session.core_role_slugs', [])
        );

        if (!in_array($roleSlug, $coreRoles, true)) {
            return max(0, (int) config('session.custom_role_idle_timeout_seconds', 3600));
        }

        return max(0, (int) config('session.idle_timeout_seconds', 600));
    }

    private function activeRoleSlug(?string $activeRoleSlug = null): string
    {
        return strtolower(trim((string) (
            $activeRoleSlug
            ?: session('impersonated_role')
            ?: session('role')
            ?: optional($this->role)->slug
        )));
    }

    public function canAccessAdminArea(?string $activeRoleSlug = null): bool
    {
        $normalizedRole = strtolower(trim((string) $activeRoleSlug));

        if ($normalizedRole === 'super_admin') {
            return true;
        }

        return $this->hasAnyPermission(self::ADMIN_AREA_PERMISSION_SLUGS);
    }

    public function hasAnyClinicalPermission(): bool
    {
        return $this->hasAnyPermission(self::CLINICAL_PERMISSION_SLUGS);
    }

    public function canAccessClinicalArea(?string $activeRoleSlug = null): bool
    {
        $normalizedRole = strtolower(trim((string) $activeRoleSlug));

        if ($normalizedRole === 'patient') {
            return false;
        }

        if ($normalizedRole === 'super_admin') {
            return true;
        }

        return $this->hasAnyClinicalPermission();
    }

    public function canAccessPatientArea(?string $activeRoleSlug = null): bool
    {
        $normalizedRole = strtolower(trim((string) $activeRoleSlug));

        if ($normalizedRole === 'patient') {
            return true;
        }

        return $this->hasAnyPermission(self::PATIENT_AREA_PERMISSION_SLUGS);
    }

    public function currentRoleNotifications()
    {
        $currentRole = optional($this->role)->slug;

        return $this->notifications()->where(function ($query) use ($currentRole) {
            $query->where('data->recipient_role', $currentRole)
                ->orWhere('data->recipient_role', 'like', '%,' . $currentRole . ',%')
                ->orWhere('data->recipient_role', 'like', $currentRole . ',%')
                ->orWhere('data->recipient_role', 'like', '%,' . $currentRole);
        });
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

    public function getFullNameAttribute()
    {
        return trim(
            $this->first_name . ' ' .
                ($this->middle_name ?? '') . ' ' .
                $this->last_name . ' ' .
                ($this->suffix_name ?? '')
        );
    }

    public function resolveRoleDisplayName(?string $fallbackRoleSlug = null): string
    {
        if ($this->role) {
            return $this->role->display_name;
        }

        return Role::displayNameFor($fallbackRoleSlug);
    }

    public function getDisplayRoleNameAttribute(): string
    {
        return $this->resolveRoleDisplayName();
    }
}
