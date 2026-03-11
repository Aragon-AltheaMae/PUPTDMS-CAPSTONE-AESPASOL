<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::orderBy('name')->get();

        $search = trim((string) $request->get('search'));
        $roleFilter = trim((string) $request->get('role'));
        $statusFilter = trim((string) $request->get('status', 'active'));

        $adminUsers = User::with('role')->get()->map(function ($user) {
            return (object) [
                'id' => 'user_' . $user->id,
                'real_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_name' => optional($user->role)->name ?? 'No Role',
                'role_key' => optional($user->role)->slug ?? optional($user->role)->name ?? '',
                'status' => $user->status ?? 'active',
                'created_at' => $user->created_at,
                'source' => 'users',
                'can_edit' => true,
                'can_toggle' => true,
                'can_reset_password' => true,
            ];
        });

        $patients = Patient::query()->get()->map(function ($patient) {
            return (object) [
                'id' => 'patient_' . $patient->id,
                'real_id' => $patient->id,
                'name' => $patient->name,
                'email' => $patient->email,
                'role_name' => 'Patient',
                'role_key' => 'patient',
                'role_id' => null,
                'status' => 'active',
                'created_at' => $patient->created_at,
                'source' => 'patients',
                'can_edit' => true,
                'can_toggle' => false,
                'can_reset_password' => true,
            ];
        });

        $dentist = collect([
            (object) [
                'id' => 'dentist_1',
                'real_id' => 1,
                'name' => 'University Dentist',
                'email' => 'dentist',
                'role_name' => 'Dentist',
                'role_key' => 'dentist',
                'role_id' => null,
                'status' => 'active',
                'created_at' => now(),
                'source' => 'manual',
                'can_edit' => false,
                'can_toggle' => false,
                'can_reset_password' => false,
            ]
        ]);

        $allAccounts = $adminUsers
            ->concat($patients)
            ->concat($dentist);

        if ($search !== '') {
            $allAccounts = $allAccounts->filter(function ($account) use ($search) {
                return str_contains(strtolower($account->name), strtolower($search)) ||
                       str_contains(strtolower($account->email), strtolower($search));
            });
        }

        if ($roleFilter !== '') {
            $allAccounts = $allAccounts->filter(function ($account) use ($roleFilter) {
                return strtolower($account->role_key) == strtolower($roleFilter)
                    || strtolower($account->role_name) == strtolower($roleFilter);
            });
        }

        if ($statusFilter !== '') {
            $allAccounts = $allAccounts->filter(function ($account) use ($statusFilter) {
                return strtolower($account->status) === strtolower($statusFilter);
            });
        }

        $allAccounts = $allAccounts
            ->sortByDesc('created_at')
            ->values();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allAccounts->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $users = new LengthAwarePaginator(
            $currentItems,
            $allAccounts->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        $notifications = collect([]);

        return view('admin.user-management', compact('users', 'roles', 'notifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.user_management')
            ->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'nullable|exists:roles,id',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.user_management')
            ->with('success', 'User updated successfully.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user_management')
            ->with('success', 'Password reset successfully.');
    }

    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return redirect()->route('admin.user_management')
            ->with('success', 'User status updated.');
    }

    public function updatePatient(Request $request, Patient $patient)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
        ]);

        $patient->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.user_management')
            ->with('success', 'Patient updated successfully.');
    }

    public function resetPatientPassword(Request $request, Patient $patient)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $patient->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user_management')
            ->with('success', 'Patient password reset successfully.');
    }
}