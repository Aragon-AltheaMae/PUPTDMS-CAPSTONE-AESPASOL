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
            'receive_notifications',
            'manage_system_settings',
            'manage_audit_trail',
            'view_system_logs',
            'export_system_logs',
            'archive_system_logs',
            'view_account_details',
            'create_users',
            'disable_users',
            'update_user_role',
            'update_user_password',
            'view_roles_permissions',
            'create_custom_roles',
            'update_role_permissions',
            'delete_custom_roles',
            'view_dentist_transitions',
            'create_dentist_transitions',
            'update_dentist_transitions',
            'assign_dentist_successors',
            'finalize_dentist_transitions',
            'cancel_dentist_transitions',
            'extend_dentist_access',
            'view_dentist_transition_audit_logs',
            'manage_document_templates',
            'view_service_type',
            'create_service_type',
            'delete_service_type',
            'update_default_service_type',
            'view_reports',
            'create_report_files',
            'view_ai_reports',
            'create_ai_generative_reports',
            'view_inventory',
            'add_inventory',
            'update_inventory',
            'delete_inventory',
            'view_patient_profiles',
            'view_dental_records',
            'view_appointments',
            'reschedule_appointments',
            'cancel_appointments',
            'create_follow_up_appointments',
            'create_procedure_records',
            'create_dental_records',
            'create_medical_records',
            'create_odontograms',
            'update_odontograms',
            'view_clinic_schedule',
            'update_clinic_schedule',
            'create_clinic_schedule',
            'delete_clinic_schedule',
            'view_document_requests',
            'approve_document_requests',
            'reject_document_requests',
            'view_academic_periods',
            'update_academic_period',
            'create_academic_period',
            'delete_academic_period',
            'view_faculty_integration',
            'create_faculty_integration',
            'update_faculty_integration',
            'view_cms_integration',
            'create_cms_integration',
            'update_cms_integration',
            'set_appointment_limit',
            'set_notification_rules',
        ];

        $dentistPermissions = [
            'access_dentist_dashboard',
            'view_patient_profiles',
            'view_dental_records',
            'view_appointments',
            'reschedule_appointments',
            'cancel_appointments',
            'manage_walk_in_patients',
            'manage_existing_records',
            'view_document_requests',
            'approve_document_requests',
            'reject_document_requests',
            'request_documents',
            'create_follow_up_appointments',
            'create_procedure_records',
            'create_dental_records',
            'create_medical_records',
            'create_odontograms',
            'update_odontograms',
            'view_clinic_schedule',
            'update_clinic_schedule',
            'create_clinic_schedule',
            'delete_clinic_schedule',
            'view_inventory',
            'add_inventory',
            'update_inventory',
            'delete_inventory',
            'view_reports',
            'create_report_files',
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
