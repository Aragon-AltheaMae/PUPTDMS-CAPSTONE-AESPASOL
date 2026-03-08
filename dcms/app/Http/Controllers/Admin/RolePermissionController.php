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
    $roles = Role::with('permissions')->get();
    $permissions = Permission::orderBy('module')->orderBy('name')->get();
    $groupedPermissions = $permissions->groupBy('module');

    return view('admin.role-permissions', compact('roles', 'groupedPermissions'));
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
}