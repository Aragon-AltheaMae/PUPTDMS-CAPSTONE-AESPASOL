<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        // Auto-seed defaults if any core role has no permissions yet
        $this->seedDefaultsIfEmpty();

        $roles = Role::with('permissions')->get();
        $permissions = Permission::orderBy('module')->orderBy('name')->get();
        $groupedPermissions = $permissions->groupBy('module');

        return view('admin.role-permissions', compact('roles', 'groupedPermissions'));
    }

    private function seedDefaultsIfEmpty(): void
    {
        $coreRoles = ['super_admin', 'dentist', 'patient'];

        foreach ($coreRoles as $slug) {
            $role = Role::where('slug', $slug)->first();
            if ($role && $role->permissions()->count() === 0) {
                $this->applyDefaults($role, $slug);
            }
        }
    }

    private function applyDefaults(Role $role, string $slug): void
    {
        $map = [
            'super_admin' => [
                'access_super_admin_dashboard',
                'receive_notifications',
                'manage_user_accounts',
                'manage_user_roles',
                'manage_dentist_accounts',
                'manage_super_admin_accounts',
                'manage_system_settings',
                'manage_audit_trail',
                'manage_backup',
                'manage_document_templates',
                'manage_reports',
                'manage_patient_profiles',
                'manage_appointments',
                'set_academic_year',
                'set_archive_records',
                'set_report_periods',
                'set_required_fields',
                'set_appointment_limit',
                'set_notification_rules',
                'set_export_file_type',
            ],
            'dentist' => [
                'access_dentist_dashboard',
                'receive_notifications',
                'manage_dental_records',
                'manage_appointments',
                'manage_patient_profiles',
                'manage_inventory',
                'manage_reports',
                'manage_document_requests',
            ],
            'patient' => [
                'access_patient_dashboard',
                'receive_notifications',
                'book_appointments',
                'view_own_appointments',
                'view_own_profile',
                'view_own_records',
                'request_documents',
            ],
        ];

        if (!isset($map[$slug])) return;

        $ids = Permission::whereIn('slug', $map[$slug])->pluck('id');
        $role->permissions()->sync($ids);
    }

    public function update(Request $request)
    {
        $roles = Role::all();

        foreach ($roles as $role) {
            $permissionIds = $request->input("permissions.{$role->id}", []);
            $role->permissions()->sync($permissionIds);
        }

        return back()->with('success', 'Role permissions updated successfully.');
    }

    public function reset()
    {
        $superAdmin = Role::where('slug', 'super_admin')->firstOrFail();
        $dentist = Role::where('slug', 'dentist')->firstOrFail();
        $patient = Role::where('slug', 'patient')->firstOrFail();

        $superAdminPermissions = Permission::whereIn('slug', [
            'access_super_admin_dashboard',
            'access_dentist_dashboard',
            'receive_notifications',
            'manage_system_settings',
            'manage_audit_trail',
            'manage_user_accounts',
            'manage_user_roles',
            'manage_dentist_accounts',
            'manage_super_admin_accounts',
            'manage_document_templates',
            'manage_reports',
            'manage_patient_profiles',
            'manage_appointments',
            'manage_inventory',
            'manage_backup',
            'set_academic_year',
            'set_archive_records',
            'set_report_periods',
            'set_required_fields',
            'set_appointment_limit',
            'set_notification_rules',
            'set_export_file_type',
        ])->pluck('id');

        $dentistPermissions = Permission::whereIn('slug', [
            'access_dentist_dashboard',
            'receive_notifications',
            'manage_dental_records',
            'manage_appointments',
            'manage_patient_profiles',
            'manage_appointments',
            'manage_inventory',
            'manage_reports',
            'manage_document_requests',
        ])->pluck('id');

        $patientPermissions = Permission::whereIn('slug', [
            'access_patient_dashboard',
            'receive_notifications',
            'book_appointments',
            'view_own_appointments',
            'view_own_profile',
            'view_own_records',
            'request_documents',
        ])->pluck('id');

        $superAdmin->permissions()->sync($superAdminPermissions);
        $dentist->permissions()->sync($dentistPermissions);
        $patient->permissions()->sync($patientPermissions);

        return back()->with('success', 'Default permissions restored.');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'slug' => ['required', 'string', 'max:255', 'unique:roles,slug',
                       'regex:/^[a-z0-9]+(?:_[a-z0-9]+)*$/'],
        ], [
            'name.unique' => 'A role with this name already exists.',
            'slug.unique' => 'A role with this slug already exists.',
            'slug.regex'  => 'Slug may only contain lowercase letters, numbers, and underscores.',
        ]);

        Role::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()
            ->route('admin.role_permissions')
            ->with('success', "Role \"{$request->name}\" created successfully. You can now assign permissions.");
    }
}