<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::where('slug', 'admin')->firstOrFail();
        $dentist = Role::where('slug', 'dentist')->firstOrFail();
        $patient = Role::where('slug', 'patient')->firstOrFail();

        $adminPermissions = [
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
        ];

        $dentistPermissions = [
            'access_dentist_dashboard',
            'receive_notifications',
            'manage_dental_records',
            'manage_appointments',
            'manage_patient_profiles',
            'manage_inventory',
            'manage_reports',
            'manage_document_requests',
        ];

        $patientPermissions = [
            'access_patient_dashboard',
            'receive_notifications',
            'book_appointments',
            'view_own_appointments',
            'view_own_profile',
            'view_own_records',
            'request_documents',
        ];

        $admin->permissions()->sync(
            Permission::whereIn('slug', $adminPermissions)->pluck('id')
        );

        $dentist->permissions()->sync(
            Permission::whereIn('slug', $dentistPermissions)->pluck('id')
        );

        $patient->permissions()->sync(
            Permission::whereIn('slug', $patientPermissions)->pluck('id')
        );
    }
}