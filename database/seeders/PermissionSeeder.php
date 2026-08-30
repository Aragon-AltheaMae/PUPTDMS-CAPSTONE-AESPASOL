<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Access Super Admin Dashboard', 'slug' => 'access_super_admin_dashboard', 'module' => 'General Access'],
            ['name' => 'Access Dentist Dashboard', 'slug' => 'access_dentist_dashboard', 'module' => 'General Access'],
            ['name' => 'Access Patient Dashboard', 'slug' => 'access_patient_dashboard', 'module' => 'General Access'],
            ['name' => 'Receive Notifications', 'slug' => 'receive_notifications', 'module' => 'General Access'],

            ['name' => 'Manage System Settings', 'slug' => 'manage_system_settings', 'module' => 'System Settings'],
            ['name' => 'Manage Audit Trail', 'slug' => 'manage_audit_trail', 'module' => 'System Settings'],
            ['name' => 'Manage User Accounts', 'slug' => 'manage_user_accounts', 'module' => 'User Management'],
            ['name' => 'Manage User Roles', 'slug' => 'manage_user_roles', 'module' => 'User Management'],
            ['name' => 'Manage Dentist Accounts', 'slug' => 'manage_dentist_accounts', 'module' => 'User Management'],
            ['name' => 'Create/Disable Users', 'slug' => 'create_disable_users', 'module' => 'User Management'],
            ['name' => 'Update Role, Password', 'slug' => 'update_role_password', 'module' => 'User Management'],
            ['name' => 'View Dentist Transitions', 'slug' => 'view_dentist_transitions', 'module' => 'Dentist Continuity'],
            ['name' => 'Create Dentist Transitions', 'slug' => 'create_dentist_transitions', 'module' => 'Dentist Continuity'],
            ['name' => 'Update Dentist Transitions', 'slug' => 'update_dentist_transitions', 'module' => 'Dentist Continuity'],
            ['name' => 'Assign Dentist Successors', 'slug' => 'assign_dentist_successors', 'module' => 'Dentist Continuity'],
            ['name' => 'Finalize Dentist Transitions', 'slug' => 'finalize_dentist_transitions', 'module' => 'Dentist Continuity'],
            ['name' => 'Cancel Dentist Transitions', 'slug' => 'cancel_dentist_transitions', 'module' => 'Dentist Continuity'],
            ['name' => 'Extend Dentist Access', 'slug' => 'extend_dentist_access', 'module' => 'Dentist Continuity'],
            ['name' => 'View Dentist Transition Audit Logs', 'slug' => 'view_dentist_transition_audit_logs', 'module' => 'Dentist Continuity'],
            ['name' => 'Manage Super Admin Accounts', 'slug' => 'manage_super_admin_accounts', 'module' => 'User Management'],
            ['name' => 'Manage Document Templates', 'slug' => 'manage_document_templates', 'module' => 'Document Templates'],
            ['name' => 'Manage Reports', 'slug' => 'manage_reports', 'module' => 'Reports'],
            ['name' => 'Manage Inventory', 'slug' => 'manage_inventory', 'module' => 'Inventory'],
            ['name' => 'Set Academic Year', 'slug' => 'set_academic_year', 'module' => 'System Settings'],
            ['name' => 'Create/Delete Academic Period', 'slug' => 'create_delete_academic_period', 'module' => 'Academic Period'],
            ['name' => 'Set Archive Records', 'slug' => 'set_archive_records', 'module' => 'System Settings'],
            ['name' => 'Set Report Periods', 'slug' => 'set_report_periods', 'module' => 'System Settings'],
            ['name' => 'Set Required Fields', 'slug' => 'set_required_fields', 'module' => 'System Settings'],
            ['name' => 'Set Appointment Limit', 'slug' => 'set_appointment_limit', 'module' => 'System Settings'],
            ['name' => 'Set Notification Rules', 'slug' => 'set_notification_rules', 'module' => 'System Settings'],
            ['name' => 'Set Export File Type', 'slug' => 'set_export_file_type', 'module' => 'System Settings'],

            ['name' => 'Manage Dental Records', 'slug' => 'manage_dental_records', 'module' => 'Dental Records'],
            ['name' => 'View Dental Records', 'slug' => 'view_dental_records', 'module' => 'Dental Records'],
            ['name' => 'Manage Appointments', 'slug' => 'manage_appointments', 'module' => 'Appointments'],
            ['name' => 'View Appointments', 'slug' => 'view_appointments', 'module' => 'Appointments'],
            ['name' => 'Reschedule Appointments', 'slug' => 'reschedule_appointments', 'module' => 'Appointments'],
            ['name' => 'Cancel Appointments', 'slug' => 'cancel_appointments', 'module' => 'Appointments'],
            ['name' => 'Create Follow-up Appointments', 'slug' => 'create_follow_up_appointments', 'module' => 'Appointments'],
            ['name' => 'Manage Walk-in Patients', 'slug' => 'manage_walk_in_patients', 'module' => 'Appointments'],
            ['name' => 'Manage Clinic Schedule', 'slug' => 'manage_clinic_schedule', 'module' => 'Appointments'],
            ['name' => 'View Schedule and Dates', 'slug' => 'view_clinic_schedule', 'module' => 'Clinic Schedule'],
            ['name' => 'Update Clinic Hours', 'slug' => 'update_clinic_schedule', 'module' => 'Clinic Schedule'],
            ['name' => 'Create Clinic Hours', 'slug' => 'create_clinic_schedule', 'module' => 'Clinic Schedule'],
            ['name' => 'Delete Clinic Hours', 'slug' => 'delete_clinic_schedule', 'module' => 'Clinic Schedule'],
            ['name' => 'Create Procedure Records', 'slug' => 'create_procedure_records', 'module' => 'Clinical Records'],
            ['name' => 'Create Dental Records', 'slug' => 'create_dental_records', 'module' => 'Clinical Records'],
            ['name' => 'Create Medical Records', 'slug' => 'create_medical_records', 'module' => 'Clinical Records'],
            ['name' => 'Create Odontograms', 'slug' => 'create_odontograms', 'module' => 'Clinical Records'],
            ['name' => 'Update Odontograms', 'slug' => 'update_odontograms', 'module' => 'Clinical Records'],
            ['name' => 'View Academic Periods/PUP Calendar/Time', 'slug' => 'view_academic_periods', 'module' => 'Academic Period'],
            ['name' => 'Update Academic Period', 'slug' => 'update_academic_period', 'module' => 'Academic Period'],
            ['name' => 'Create Academic Period', 'slug' => 'create_academic_period', 'module' => 'Academic Period'],
            ['name' => 'Delete Academic Period', 'slug' => 'delete_academic_period', 'module' => 'Academic Period'],
            ['name' => 'View Inventory', 'slug' => 'view_inventory', 'module' => 'Inventory'],
            ['name' => 'Add Inventory', 'slug' => 'add_inventory', 'module' => 'Inventory'],
            ['name' => 'Update Inventory', 'slug' => 'update_inventory', 'module' => 'Inventory'],
            ['name' => 'Delete Inventory', 'slug' => 'delete_inventory', 'module' => 'Inventory'],
            ['name' => 'View Account Details', 'slug' => 'view_account_details', 'module' => 'User Management'],
            ['name' => 'Create Users', 'slug' => 'create_users', 'module' => 'User Management'],
            ['name' => 'Disable Users', 'slug' => 'disable_users', 'module' => 'User Management'],
            ['name' => 'Update User Role', 'slug' => 'update_user_role', 'module' => 'User Management'],
            ['name' => 'Update User Password', 'slug' => 'update_user_password', 'module' => 'User Management'],
            ['name' => 'View Service Type', 'slug' => 'view_service_type', 'module' => 'Service Types'],
            ['name' => 'Create Service Type', 'slug' => 'create_service_type', 'module' => 'Service Types'],
            ['name' => 'Delete Service Type', 'slug' => 'delete_service_type', 'module' => 'Service Types'],
            ['name' => 'Update Default Service Type', 'slug' => 'update_default_service_type', 'module' => 'Service Types'],
            ['name' => 'View Reports', 'slug' => 'view_reports', 'module' => 'Reports'],
            ['name' => 'Manage Patient Profiles', 'slug' => 'manage_patient_profiles', 'module' => 'Patients'],
            ['name' => 'View Patient Profiles', 'slug' => 'view_patient_profiles', 'module' => 'Patients'],
            ['name' => 'Manage Document Requests', 'slug' => 'manage_document_requests', 'module' => 'Document Requests'],
            ['name' => 'View Document Requests', 'slug' => 'view_document_requests', 'module' => 'Document Requests'],
            ['name' => 'Approve Document Requests', 'slug' => 'approve_document_requests', 'module' => 'Document Requests'],
            ['name' => 'Reject Document Requests', 'slug' => 'reject_document_requests', 'module' => 'Document Requests'],

            ['name' => 'Book Appointments', 'slug' => 'book_appointments', 'module' => 'Appointments'],
            ['name' => 'View Own Appointments', 'slug' => 'view_own_appointments', 'module' => 'Appointments'],
            ['name' => 'View Own Profile', 'slug' => 'view_own_profile', 'module' => 'Patients'],
            ['name' => 'View Own Records', 'slug' => 'view_own_records', 'module' => 'Dental Records'],
            ['name' => 'Request Documents', 'slug' => 'request_documents', 'module' => 'Document Requests'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
