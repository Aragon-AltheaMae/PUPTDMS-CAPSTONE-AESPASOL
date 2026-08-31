<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const ADMIN_PERMISSIONS = [
        ['name' => 'Access Super Admin Dashboard', 'slug' => 'access_super_admin_dashboard', 'module' => 'General Access'],
        ['name' => 'Receive Notifications', 'slug' => 'receive_notifications', 'module' => 'General Access'],
        ['name' => 'Manage System Settings', 'slug' => 'manage_system_settings', 'module' => 'System Settings'],
        ['name' => 'Set Notification Rules', 'slug' => 'set_notification_rules', 'module' => 'System Settings'],
        ['name' => 'View System Logs', 'slug' => 'view_system_logs', 'module' => 'System Logs'],
        ['name' => 'Export System Logs', 'slug' => 'export_system_logs', 'module' => 'System Logs'],
        ['name' => 'Archive System Logs', 'slug' => 'archive_system_logs', 'module' => 'System Logs'],
        ['name' => 'View Account Details', 'slug' => 'view_account_details', 'module' => 'User Management'],
        ['name' => 'Create Users', 'slug' => 'create_users', 'module' => 'User Management'],
        ['name' => 'Disable Users', 'slug' => 'disable_users', 'module' => 'User Management'],
        ['name' => 'Update User Role', 'slug' => 'update_user_role', 'module' => 'User Management'],
        ['name' => 'Update User Password', 'slug' => 'update_user_password', 'module' => 'User Management'],
        ['name' => 'View Roles & Permissions', 'slug' => 'view_roles_permissions', 'module' => 'Role Permissions'],
        ['name' => 'Create Custom Roles', 'slug' => 'create_custom_roles', 'module' => 'Role Permissions'],
        ['name' => 'Update Role Permissions', 'slug' => 'update_role_permissions', 'module' => 'Role Permissions'],
        ['name' => 'Delete Custom Roles', 'slug' => 'delete_custom_roles', 'module' => 'Role Permissions'],
        ['name' => 'View Faculty Integration', 'slug' => 'view_faculty_integration', 'module' => 'Faculty Integration'],
        ['name' => 'Create Faculty Integration', 'slug' => 'create_faculty_integration', 'module' => 'Faculty Integration'],
        ['name' => 'Update Faculty Integration', 'slug' => 'update_faculty_integration', 'module' => 'Faculty Integration'],
        ['name' => 'View CMS Integration', 'slug' => 'view_cms_integration', 'module' => 'CMS Integration'],
        ['name' => 'Create CMS Integration', 'slug' => 'create_cms_integration', 'module' => 'CMS Integration'],
        ['name' => 'Update CMS Integration', 'slug' => 'update_cms_integration', 'module' => 'CMS Integration'],
        ['name' => 'View Dentist Transitions', 'slug' => 'view_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Create Dentist Transitions', 'slug' => 'create_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Update Dentist Transitions', 'slug' => 'update_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Assign Dentist Successors', 'slug' => 'assign_dentist_successors', 'module' => 'Dentist Continuity'],
        ['name' => 'Finalize Dentist Transitions', 'slug' => 'finalize_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Cancel Dentist Transitions', 'slug' => 'cancel_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Extend Dentist Access', 'slug' => 'extend_dentist_access', 'module' => 'Dentist Continuity'],
        ['name' => 'Manage Document Templates', 'slug' => 'manage_document_templates', 'module' => 'Document Templates'],
        ['name' => 'View Service Type', 'slug' => 'view_service_type', 'module' => 'Service Types'],
        ['name' => 'Create Service Type', 'slug' => 'create_service_type', 'module' => 'Service Types'],
        ['name' => 'Delete Service Type', 'slug' => 'delete_service_type', 'module' => 'Service Types'],
        ['name' => 'Update Default Service Type', 'slug' => 'update_default_service_type', 'module' => 'Service Types'],
        ['name' => 'View Reports', 'slug' => 'view_reports', 'module' => 'Reports'],
        ['name' => 'Create Report Files', 'slug' => 'create_report_files', 'module' => 'Reports'],
        ['name' => 'Create AI Generative Reports', 'slug' => 'create_ai_generative_reports', 'module' => 'Reports'],
        ['name' => 'View Inventory', 'slug' => 'view_inventory', 'module' => 'Inventory'],
        ['name' => 'Add Inventory', 'slug' => 'add_inventory', 'module' => 'Inventory'],
        ['name' => 'Update Inventory', 'slug' => 'update_inventory', 'module' => 'Inventory'],
        ['name' => 'Delete Inventory', 'slug' => 'delete_inventory', 'module' => 'Inventory'],
        ['name' => 'View Academic Periods/PUP Calendar/Time', 'slug' => 'view_academic_periods', 'module' => 'Academic Period'],
        ['name' => 'Update Academic Period', 'slug' => 'update_academic_period', 'module' => 'Academic Period'],
        ['name' => 'Create Academic Period', 'slug' => 'create_academic_period', 'module' => 'Academic Period'],
        ['name' => 'Delete Academic Period', 'slug' => 'delete_academic_period', 'module' => 'Academic Period'],
        ['name' => 'View Dental Records', 'slug' => 'view_dental_records', 'module' => 'Dental Records'],
        ['name' => 'View Appointments', 'slug' => 'view_appointments', 'module' => 'Appointments'],
        ['name' => 'View Schedule and Dates', 'slug' => 'view_clinic_schedule', 'module' => 'Clinic Schedule'],
        ['name' => 'Update Clinic Hours', 'slug' => 'update_clinic_schedule', 'module' => 'Clinic Schedule'],
        ['name' => 'Create Clinic Hours', 'slug' => 'create_clinic_schedule', 'module' => 'Clinic Schedule'],
        ['name' => 'Delete Clinic Hours', 'slug' => 'delete_clinic_schedule', 'module' => 'Clinic Schedule'],
        ['name' => 'View Patient Profiles', 'slug' => 'view_patient_profiles', 'module' => 'Patients'],
        ['name' => 'View Document Requests', 'slug' => 'view_document_requests', 'module' => 'Document Requests'],
        ['name' => 'Approve Document Requests', 'slug' => 'approve_document_requests', 'module' => 'Document Requests'],
        ['name' => 'Reject Document Requests', 'slug' => 'reject_document_requests', 'module' => 'Document Requests'],
    ];

    public function up(): void
    {
        $adminRole = Role::query()->where('slug', 'admin')->first();

        if (! $adminRole) {
            return;
        }

        foreach (self::ADMIN_PERMISSIONS as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        $permissionIds = Permission::query()
            ->whereIn('slug', array_column(self::ADMIN_PERMISSIONS, 'slug'))
            ->pluck('id');

        $adminRole->permissions()->sync($permissionIds);
    }

    public function down(): void
    {
        // Intentionally left as a no-op because this migration codifies
        // the current Admin default permission matrix.
    }
};
