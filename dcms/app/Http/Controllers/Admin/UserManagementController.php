<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
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

    $query = User::with(['role', 'patient']);

    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    if ($roleFilter !== '') {
        $query->whereHas('role', function ($q) use ($roleFilter) {
            $q->where('slug', $roleFilter)
              ->orWhere('name', $roleFilter);
        });
    }

    if ($statusFilter !== '') {
        $query->where('status', $statusFilter);
    }

    $users = $query->latest()->paginate(10)->withQueryString();

    $notifications = collect([]);

    return view('admin.user-management', compact('users', 'roles', 'notifications'));
}

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email|unique:patients,email',
        'password' => 'required|min:8|confirmed',
        'role_id' => 'nullable|exists:roles,id',
        'status' => 'required|in:active,inactive',
        'phone' => 'nullable|string|max:20',
        'birthdate' => 'nullable|date',
        'gender' => 'nullable|in:Male,Female',
    ]);

    DB::transaction(function () use ($request) {
        $role = $request->role_id ? Role::find($request->role_id) : null;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'status' => $request->status,
        ]);

        if ($role && $role->slug === 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone ?? '',
                'birthdate' => $request->birthdate ?? now()->toDateString(),
                'gender' => $request->gender ?? 'Male',
                'password' => $user->password,
            ]);
        }
    });

    return redirect()->route('admin.user_management')
        ->with('success', 'User created successfully.');
}
public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('users')->ignore($user->id),
        ],
        'role_id' => 'nullable|exists:roles,id',
        'status' => 'required|in:active,inactive',
        'phone' => 'nullable|string|max:20',
        'birthdate' => 'nullable|date',
        'gender' => 'nullable|in:Male,Female',
    ]);

    DB::transaction(function () use ($request, $user) {
        $role = $request->role_id ? Role::find($request->role_id) : null;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'status' => $request->status,
        ]);

        if ($role && $role->slug === 'patient') {
            $patient = Patient::firstOrNew(['user_id' => $user->id]);

            if ($patient->exists && $patient->id) {
                $request->validate([
                    'email' => 'required|email|unique:patients,email,' . $patient->id,
                ]);
            }

            $patient->fill([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone ?? ($patient->phone ?? ''),
                'birthdate' => $request->birthdate ?? ($patient->birthdate ?? now()->toDateString()),
                'gender' => $request->gender ?? ($patient->gender ?? 'Male'),
                'password' => $user->password,
            ]);

            $patient->user_id = $user->id;
            $patient->save();
        } else {
            Patient::where('user_id', $user->id)->delete();
        }
    });

    return redirect()->route('admin.user_management')
        ->with('success', 'User updated successfully.');
}

    public function resetPassword(Request $request, User $user)
{
    $request->validate([
        'password' => 'required|min:8|confirmed',
    ]);

    DB::transaction(function () use ($request, $user) {
        $hashedPassword = Hash::make($request->password);

        $user->update([
            'password' => $hashedPassword,
        ]);

        $role = $user->role;
        if ($role && $role->slug === 'patient') {
            Patient::where('user_id', $user->id)->update([
                'password' => $hashedPassword,
            ]);
        }
    });

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