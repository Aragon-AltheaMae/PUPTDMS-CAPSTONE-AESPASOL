<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Helpers\AuditLogger;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
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
        $coreRoles = ['admin', 'dentist', 'patient'];

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
            'admin' => [
                'access_super_admin_dashboard',
                'access_patient_dashboard',
                'receive_notifications',
                'manage_user_accounts',
                'manage_user_roles',
                'manage_dentist_accounts',
                'manage_super_admin_accounts',
                'manage_system_settings',
                'manage_audit_trail',
                'manage_document_templates',
                'manage_reports',
                'manage_patient_profiles',
                'manage_appointments',
                'manage_dental_records',
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
        $admin = Role::where('slug', 'admin')->firstOrFail();
        $dentist    = Role::where('slug', 'dentist')->firstOrFail();
        $patient    = Role::where('slug', 'patient')->firstOrFail();

        $superAdminPermissions = Permission::whereIn('slug', [
            'access_super_admin_dashboard',
            'access_dentist_dashboard',
            'access_patient_dashboard',
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

        $admin->permissions()->sync($superAdminPermissions);
        $dentist->permissions()->sync($dentistPermissions);
        $patient->permissions()->sync($patientPermissions);

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
        $role = Role::findOrFail($id);

        if (
            in_array(strtolower($role->slug), ['super_admin', 'super-admin', 'superadmin']) ||
            str_contains(strtolower($role->name), 'super')
        ) {
            return redirect()->route('admin.role_permissions')
                ->with('error', 'Cannot delete the Super Admin role.');
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
