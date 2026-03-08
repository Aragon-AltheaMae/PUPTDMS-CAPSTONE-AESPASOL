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
            ['name' => 'Manage Super Admin Accounts', 'slug' => 'manage_super_admin_accounts', 'module' => 'User Management'],
            ['name' => 'Manage Document Templates', 'slug' => 'manage_document_templates', 'module' => 'Document Templates'],
            ['name' => 'Manage Reports', 'slug' => 'manage_reports', 'module' => 'Reports'],
            ['name' => 'Manage Inventory', 'slug' => 'manage_inventory', 'module' => 'Inventory'],
            ['name' => 'Manage Backup', 'slug' => 'manage_backup', 'module' => 'System Settings'],
            ['name' => 'Set Academic Year', 'slug' => 'set_academic_year', 'module' => 'System Settings'],
            ['name' => 'Set Archive Records', 'slug' => 'set_archive_records', 'module' => 'System Settings'],
            ['name' => 'Set Report Periods', 'slug' => 'set_report_periods', 'module' => 'System Settings'],
            ['name' => 'Set Required Fields', 'slug' => 'set_required_fields', 'module' => 'System Settings'],
            ['name' => 'Set Appointment Limit', 'slug' => 'set_appointment_limit', 'module' => 'System Settings'],
            ['name' => 'Set Notification Rules', 'slug' => 'set_notification_rules', 'module' => 'System Settings'],
            ['name' => 'Set Export File Type', 'slug' => 'set_export_file_type', 'module' => 'System Settings'],

            ['name' => 'Manage Dental Records', 'slug' => 'manage_dental_records', 'module' => 'Dental Records'],
            ['name' => 'Manage Appointments', 'slug' => 'manage_appointments', 'module' => 'Appointments'],
            ['name' => 'Manage Patient Profiles', 'slug' => 'manage_patient_profiles', 'module' => 'Patients'],
            ['name' => 'Manage Document Requests', 'slug' => 'manage_document_requests', 'module' => 'Document Requests'],

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