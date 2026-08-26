<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\AuditLogger;

class RolePermissionController extends Controller
{
    private const CORE_ROLE_SLUGS = ['admin', 'dentist', 'patient'];

    private const REQUIRED_PERMISSIONS = [
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
        ['name' => 'View Dentist Transitions', 'slug' => 'view_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Create Dentist Transitions', 'slug' => 'create_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Update Dentist Transitions', 'slug' => 'update_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Assign Dentist Successors', 'slug' => 'assign_dentist_successors', 'module' => 'Dentist Continuity'],
        ['name' => 'Finalize Dentist Transitions', 'slug' => 'finalize_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Cancel Dentist Transitions', 'slug' => 'cancel_dentist_transitions', 'module' => 'Dentist Continuity'],
        ['name' => 'Extend Dentist Access', 'slug' => 'extend_dentist_access', 'module' => 'Dentist Continuity'],
        ['name' => 'View Dentist Transition Audit Logs', 'slug' => 'view_dentist_transition_audit_logs', 'module' => 'Dentist Continuity'],
        ['name' => 'Manage Document Templates', 'slug' => 'manage_document_templates', 'module' => 'Document Templates'],
        ['name' => 'Manage Reports', 'slug' => 'manage_reports', 'module' => 'Reports'],
        ['name' => 'Manage Inventory', 'slug' => 'manage_inventory', 'module' => 'Inventory'],
        ['name' => 'Set Academic Year', 'slug' => 'set_academic_year', 'module' => 'System Settings'],
        ['name' => 'Set Archive Records', 'slug' => 'set_archive_records', 'module' => 'System Settings'],
        ['name' => 'Set Report Periods', 'slug' => 'set_report_periods', 'module' => 'System Settings'],
        ['name' => 'Set Required Fields', 'slug' => 'set_required_fields', 'module' => 'System Settings'],
        ['name' => 'Set Appointment Limit', 'slug' => 'set_appointment_limit', 'module' => 'System Settings'],
        ['name' => 'Set Notification Rules', 'slug' => 'set_notification_rules', 'module' => 'System Settings'],
        ['name' => 'Set Export File Type', 'slug' => 'set_export_file_type', 'module' => 'System Settings'],
        ['name' => 'Manage Dental Records', 'slug' => 'manage_dental_records', 'module' => 'Dental Records'],
        ['name' => 'Manage Appointments', 'slug' => 'manage_appointments', 'module' => 'Appointments'],
        ['name' => 'Manage Walk-in Patients', 'slug' => 'manage_walk_in_patients', 'module' => 'Appointments'],
        ['name' => 'Add Existing Record', 'slug' => 'manage_existing_records', 'module' => 'Appointments'],
        ['name' => 'Manage Clinic Schedule', 'slug' => 'manage_clinic_schedule', 'module' => 'Appointments'],
        ['name' => 'Manage Patient Profiles', 'slug' => 'manage_patient_profiles', 'module' => 'Patients'],
        ['name' => 'Manage Document Requests', 'slug' => 'manage_document_requests', 'module' => 'Document Requests'],
        ['name' => 'Book Appointments', 'slug' => 'book_appointments', 'module' => 'Appointments'],
        ['name' => 'View Own Appointments', 'slug' => 'view_own_appointments', 'module' => 'Appointments'],
        ['name' => 'View Own Profile', 'slug' => 'view_own_profile', 'module' => 'Patients'],
        ['name' => 'View Own Records', 'slug' => 'view_own_records', 'module' => 'Dental Records'],
        ['name' => 'Request Documents', 'slug' => 'request_documents', 'module' => 'Document Requests'],
    ];

    private const DEFAULT_ROLE_PERMISSIONS = [
        'admin' => [
            'access_super_admin_dashboard',
            'receive_notifications',
            'manage_system_settings',
            'manage_audit_trail',
            'manage_user_accounts',
            'manage_user_roles',
            'manage_dentist_accounts',
            'manage_super_admin_accounts',
            'view_dentist_transitions',
            'create_dentist_transitions',
            'update_dentist_transitions',
            'assign_dentist_successors',
            'finalize_dentist_transitions',
            'cancel_dentist_transitions',
            'extend_dentist_access',
            'view_dentist_transition_audit_logs',
            'manage_document_templates',
            'manage_reports',
            'manage_inventory',
            'manage_patient_profiles',
            'manage_dental_records',
            'manage_appointments',
            'manage_clinic_schedule',
            'manage_document_requests',
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
            'manage_patient_profiles',
            'manage_appointments',
            'manage_walk_in_patients',
            'manage_existing_records',
            'manage_clinic_schedule',
            'manage_document_requests',
            'manage_inventory',
            'manage_reports',
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

    public function index(Request $request)
    {
        $this->ensureRequiredPermissionsExist();
        $this->seedDefaultsIfEmpty();

        $roles = Role::with('permissions')->get();
        $permissions = Permission::where('slug', '!=', 'manage_backup')
            ->orderBy('module')
            ->orderBy('name')
            ->get();
        $groupedPermissions = $permissions->groupBy('module');

        $highlightRoleId = session('new_role_id') ?? $request->query('highlight_role');

        AuditLogger::log(
            'view',
            'roles_permissions',
            'Admin viewed roles and permissions'
        );

        return view('admin.role-permissions', compact('roles', 'groupedPermissions', 'highlightRoleId'));
    }

    private function seedDefaultsIfEmpty(): void
    {
        foreach (self::CORE_ROLE_SLUGS as $slug) {
            $role = Role::where('slug', $slug)->first();
            if ($role && $role->permissions()->count() === 0) {
                $this->applyDefaults($role, $slug);
            }
        }
    }

    private function ensureRequiredPermissionsExist(): void
    {
        foreach (self::REQUIRED_PERMISSIONS as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }

    private function applyDefaults(Role $role, string $slug): void
    {
        if (!isset(self::DEFAULT_ROLE_PERMISSIONS[$slug])) return;

        $ids = Permission::whereIn('slug', self::DEFAULT_ROLE_PERMISSIONS[$slug])->pluck('id');
        $role->permissions()->sync($ids);
    }

    public function update(Request $request)
    {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $role = Role::findOrFail($request->role_id);

        if ($request->expectsJson()) {
            $permissionIds = array_map('intval', $request->input('permissions', []));
        } else {
            $permissionIds = array_map('intval', $request->input("permissions.{$role->id}", []));
        }

        $role->permissions()->sync($permissionIds);

        AuditLogger::log(
            'update',
            'roles_permissions',
            "Admin updated permissions for role ID {$role->id} ({$role->name})"
        );

        if ($request->expectsJson()) {
            $savedPermissions = Permission::whereIn('id', $permissionIds)
                ->get(['id', 'name', 'slug', 'module'])
                ->map(fn($p) => [
                    'id'     => $p->id,
                    'name'   => $p->name,
                    'slug'   => $p->slug,
                    'module' => $p->module,
                ])
                ->values()
                ->toArray();

            return response()->json([
                'success'     => true,
                'message'     => "Permissions for \"{$role->name}\" updated successfully.",
                'role_id'     => $role->id,
                'role_name'   => $role->name,
                'permissions' => $savedPermissions,
            ]);
        }

        $savedPermissions = Permission::whereIn('id', $permissionIds)
            ->get(['id', 'name', 'slug', 'module'])
            ->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'slug' => $p->slug, 'module' => $p->module])
            ->values()
            ->toArray();

        return redirect()
            ->route('admin.role_permissions')
            ->with('success', 'Role permissions updated successfully.')
            ->with('saved_view_as', [
                'role_id'     => $role->id,
                'role_name'   => $role->name,
                'permissions' => $savedPermissions,
            ]);
    }

    public function reset()
    {
        foreach (self::DEFAULT_ROLE_PERMISSIONS as $slug => $permissionSlugs) {
            $role = Role::where('slug', $slug)->firstOrFail();
            $permissionIds = Permission::whereIn('slug', $permissionSlugs)->pluck('id');

            $role->permissions()->sync($permissionIds);
        }

        Role::query()
            ->whereNotIn('slug', self::CORE_ROLE_SLUGS)
            ->each(function (Role $role): void {
                $role->permissions()->sync([]);
            });

        AuditLogger::log
            ('update', 
            'roles_permissions', 
            'Admin reset all permissions to defaults');

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Default permissions restored.',
            ]);
        }

        return back()->with('success', 'Default permissions restored.');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:roles,slug',
                'regex:/^[a-z0-9]+(?:[-_][a-z0-9]+)*$/'
            ],
        ], [
            'name.unique' => 'A role with this name already exists.',
            'slug.unique' => 'A role with this slug already exists.',
            'slug.regex'  => 'Slug may only contain lowercase letters, numbers, hyphens, and underscores.',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        $role->permissions()->sync([]);

        $message = "Role \"{$role->name}\" created successfully. You can now assign permissions and use it in User Management.";

        AuditLogger::log(
            'create',
            'roles_permissions',
            "Admin created role ID {$role->id} ({$role->name})"
        );

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'role' => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'slug' => $role->slug,
                ],
                'user_management_url' => route('admin.user_management'),
            ], 201);
        }

        return redirect()
            ->route('admin.role_permissions', ['highlight_role' => $role->id])
            ->with('success', $message)
            ->with('new_role_id', $role->id);
    }

    public function destroyRole($id)
    {
        try {
            $role = Role::findOrFail($id);

            if (
                in_array(strtolower($role->slug), ['super_admin', 'super-admin', 'superadmin']) ||
                str_contains(strtolower($role->name), 'super')
            ) {
                $message = 'Cannot delete the Super Admin role.';

                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                    ], 422);
                }

                return redirect()->route('admin.role_permissions')
                    ->with('error', $message);
            }

            $fallbackRole = $this->resolveFallbackRole($role);
            $affectedUsers = 0;

            DB::transaction(function () use ($role, $fallbackRole, &$affectedUsers) {
                $affectedUsers = User::where('role_id', $role->id)->count();

                if ($affectedUsers > 0) {
                    User::where('role_id', $role->id)->update([
                        'role_id' => $fallbackRole->id,
                    ]);
                }

                $role->permissions()->detach();
                $role->delete();
            });

            AuditLogger::log(
                'delete',
                'roles_permissions',
                "Deleted role ID {$role->id} ({$role->name}) and reassigned {$affectedUsers} user(s) to {$fallbackRole->display_name}"
            );

            $message = $affectedUsers > 0
                ? "Role '{$role->name}' has been deleted. {$affectedUsers} user(s) were reassigned to {$fallbackRole->display_name}."
                : "Role '{$role->name}' has been deleted.";

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'fallback_role' => [
                        'id' => $fallbackRole->id,
                        'name' => $fallbackRole->display_name,
                        'slug' => $fallbackRole->slug,
                    ],
                    'affected_users' => $affectedUsers,
                ]);
            }

            return redirect()->route('admin.role_permissions')
                ->with('success', $message);
        } catch (\Throwable $e) {
            $message = app()->hasDebugModeEnabled() && config('app.debug')
                ? $e->getMessage()
                : 'Could not delete role.';

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 500);
            }

            return redirect()->route('admin.role_permissions')
                ->with('error', $message);
        }
    }

    private function resolveFallbackRole(Role $deletedRole): Role
    {
        $name = strtolower((string) $deletedRole->name);
        $slug = strtolower((string) $deletedRole->slug);

        if (str_contains($slug, 'dentist') || str_contains($name, 'dentist')) {
            return Role::where('slug', 'dentist')->firstOrFail();
        }

        if (
            str_contains($slug, 'admin') ||
            str_contains($name, 'admin') ||
            str_contains($slug, 'staff') ||
            str_contains($name, 'staff') ||
            str_contains($slug, 'clinic') ||
            str_contains($name, 'clinic')
        ) {
            return Role::where('slug', 'admin')->firstOrFail();
        }

        return Role::where('slug', 'patient')->firstOrFail();
    }
}
