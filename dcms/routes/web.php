<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Patient;
use App\Helpers\AuditLogger;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Dentist\InventoryController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Dentist\DentistPatientController;
use App\Http\Controllers\Dentist\DentistAppointmentController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Helpers\PhilippineHolidays;
use App\Http\Controllers\Admin\SystemLogController;
use App\Http\Controllers\Admin\UserManagementController;


/*
|--------------------------------------------------------------------------
| PUBLIC AUTH PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect('/login'));

// Patient Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Patient Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Dentist Login
Route::get('/dentist/login', function () {
    return view('auth.dentist-login');
})->name('dentist.login');

// Admin Login
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');


/*
|--------------------------------------------------------------------------
| PUBLIC AUTH ACTIONS
|--------------------------------------------------------------------------
*/

// Patient Registration
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:patients,email',
        'phone' => 'nullable|string|max:20',
        'birthdate' => 'nullable|date',
        'gender' => 'nullable|string|max:10',
        'password' => 'required|string|min:6|confirmed',
    ]);

    

    Patient::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'birthdate' => $request->birthdate,
        'gender' => $request->gender,
        'password' => Hash::make($request->password),
    ]);

    return redirect('/login')->with('success', 'Account created successfully!');
});

// Patient Login POST
Route::post('/login', function (Request $request) {
    $patient = Patient::where('email', $request->email)->first();

    if ($patient && Hash::check($request->password, $patient->password)) {
        session([
            'role' => 'patient',
            'patient_id' => $patient->id,
            'email' => $patient->email,
        ]);

        AuditLogger::log(
            'login',
            'authentication',
            'Patient logged into the system'
        );

        return redirect()->route('homepage');
    }

    return back()->with('error', 'Invalid credentials');
});

// Dentist Login POST (hard-coded for now)
Route::post('/dentist/login', function (Request $request) {
    if ($request->email === 'dentist' && $request->password === 'dentist123') {
        session([
            'role' => 'dentist',
            'dentist_email' => 'dentist',
        ]);

        AuditLogger::log(
            'login',
            'authentication',
            'Dentist logged into the system'
        );

        return redirect()->route('dentist.dentist.dashboard');
    }

    return back()->with('error', 'Invalid dentist credentials');
})->name('dentist.login.submit');

// Admin Login POST
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Logout (all roles)
Route::post('/logout', function () {
    AuditLogger::log(
        'logout',
        'authentication',
        'User logged out of the system'
    );

    session()->flush();
    Auth::logout();

    return redirect('/login');
})->name('logout');

// Admin Logout
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| ADMIN / SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        if (!session('admin_logged_in') && session('role') !== 'super_admin') {
            return redirect('/admin/login');
        }

        return view('admin.admin-dashboard');
    })->name('admin.admin.dashboard');

    Route::get('/role-permissions', [RolePermissionController::class, 'index'])
        ->name('admin.role_permissions');

    Route::post('/role-permissions/update', [RolePermissionController::class, 'update'])
        ->name('admin.role_permissions.update');

    Route::post('/role-permissions/reset', [RolePermissionController::class, 'reset'])
        ->name('admin.role_permissions.reset');
    
    Route::post('/role-permissions/store-role', [RolePermissionController::class, 'storeRole'])
        ->name('admin.role_permissions.store_role');

    Route::get('/system-logs', [SystemLogController::class, 'index'])
    ->name('admin.system_logs');
});

// User Management
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user_management');
    Route::post('/user-management', [UserManagementController::class, 'store'])->name('user_management.store');

    Route::put('/user-management/{user}', [UserManagementController::class, 'update'])->name('user_management.update');
    Route::put('/user-management/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('user_management.reset_password');
    Route::patch('/user-management/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('user_management.toggle_status');

    Route::put('/user-management/patient/{patient}', [UserManagementController::class, 'updatePatient'])->name('user_management.patient.update');
    Route::put('/user-management/patient/{patient}/reset-password', [UserManagementController::class, 'resetPatientPassword'])->name('user_management.patient.reset_password');
});

// START IMPERSONATION
    Route::post('/impersonate', function (Request $request) {
        if (!session('admin_logged_in') || session('role') !== 'super_admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'role' => 'required|string'
        ]);

        $targetRole = strtolower(trim($request->role));

        // Save original admin identity once
        if (!session()->has('impersonator_role')) {
            session([
                'impersonator_role' => session('role'),
                'impersonator_admin_logged_in' => session('admin_logged_in'),
                'impersonator_admin_id' => session('admin_id'),
                'impersonator_admin_email' => session('admin_email'),
            ]);
        }

        if ($targetRole === 'dentist') {
            session([
                'impersonated_role' => 'dentist',
            ]);

            session()->forget(['impersonated_patient_id']);

            \App\Helpers\AuditLogger::log(
                'impersonation_started',
                'authentication',
                'Super Admin started impersonating Dentist dashboard'
            );

            return response()->json([
                'redirect' => route('dentist.dentist.dashboard')
            ]);
        }

        if ($targetRole === 'patient') {
            $patient = \App\Models\Patient::first();

            if (!$patient) {
                return response()->json([
                    'message' => 'No patient found to impersonate.'
                ], 422);
            }

            session([
                'impersonated_role' => 'patient',
                'impersonated_patient_id' => $patient->id,
            ]);

            \App\Helpers\AuditLogger::log(
                'impersonation_started',
                'authentication',
                'Super Admin started impersonating Patient dashboard'
            );

            return response()->json([
                'redirect' => route('patient.dashboard')
            ]);
        }

        return response()->json([
            'message' => 'Unsupported role.'
        ], 422);
    })->name('admin.impersonate');

    // STOP IMPERSONATION
    Route::post('/stop-impersonation', function () {
        if (session()->has('impersonator_role')) {
            \App\Helpers\AuditLogger::log(
                'impersonation_stopped',
                'authentication',
                'Super Admin stopped impersonation'
            );
        }

        session()->forget([
            'impersonated_role',
            'impersonated_patient_id',
            'impersonator_role',
            'impersonator_admin_logged_in',
            'impersonator_admin_id',
            'impersonator_admin_email',
        ]);

        session([
            'role' => 'super_admin',
            'admin_logged_in' => true,
        ]);

        return redirect()->route('admin.admin.dashboard');
    })->name('admin.stop_impersonation');


/*
|--------------------------------------------------------------------------
| PATIENT-PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['role:patient'])->group(function () {

    Route::get('/homepage', [HomepageController::class, 'index'])
        ->middleware('permission:access_patient_dashboard')
        ->name('homepage');

    Route::get('/book-appointment', [AppointmentController::class, 'create'])
        ->middleware('permission:book_appointments')
        ->name('patient.book.appointment');

    Route::get('/available-slots', [AppointmentController::class, 'availableSlots'])
        ->middleware('permission:book_appointments')
        ->name('patient.appointments.available-slots');

    Route::post('/document-requests', [DocumentRequestController::class, 'store'])
        ->middleware('permission:request_documents')
        ->name('patient.document.requests.store');

    Route::get('/document-requests', [DocumentRequestController::class, 'index'])
        ->middleware('permission:request_documents')
        ->name('patient.document.requests.index');

    Route::post('/document-requests/{id}/status', [DocumentRequestController::class, 'updateStatus'])
        ->middleware('permission:request_documents')
        ->name('patient.document.requests.updateStatus');

    Route::get('/record', [RecordController::class, 'index'])
        ->middleware('permission:view_own_records')
        ->name('patient.record');

    Route::get('/about-us', fn() => view('patient.about-us'))
        ->name('patient.about.us');
});


/*
|--------------------------------------------------------------------------
| PATIENT ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('patient')->middleware(['role:patient'])->group(function () {

    Route::get('/dashboard', function () {
        $patient = Patient::find(session('patient_id'));
        return view('patient-dashboard', compact('patient'));
    })->middleware('permission:access_patient_dashboard')->name('patient.dashboard');

    Route::get('/appointment', [AppointmentController::class, 'index'])
        ->middleware('permission:view_own_appointments')
        ->name('patient.appointment.index');

    Route::get('/appointment/create', [AppointmentController::class, 'create'])
        ->middleware('permission:book_appointments')
        ->name('appointment.create');

    Route::post('/appointment', [AppointmentController::class, 'store'])
        ->middleware('permission:book_appointments')
        ->name('appointment.store');

    Route::get('/book-appointment', [AppointmentController::class, 'create'])
        ->middleware('permission:book_appointments')
        ->name('book.appointment.create');

    Route::post('/book-appointment', [AppointmentController::class, 'store'])
        ->middleware('permission:book_appointments')
        ->name('book.appointment.store');

    Route::get('/appointments', [AppointmentController::class, 'index'])
        ->middleware('permission:view_own_appointments')
        ->name('book.appointment.index');
});


/*
|--------------------------------------------------------------------------
| DENTIST ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('dentist')->middleware(['role:dentist'])->group(function () {

    // Dashboard Route
    Route::get('/dashboard', function () {
        $now   = \Carbon\Carbon::now();
        $today = $now->toDateString();

        $todayAppointments = \App\Models\Appointment::with('patient')
            ->whereDate('appointment_date', $today)
            ->whereIn('status', ['upcoming', 'rescheduled'])
            ->orderBy('appointment_time', 'asc')
            ->get();

        $appointmentCountsPerDay = \App\Models\Appointment::whereIn('status', ['upcoming', 'rescheduled'])
            ->selectRaw('appointment_date, COUNT(*) as count')
            ->groupBy('appointment_date')
            ->pluck('count', 'appointment_date')
            ->toArray();

        $dentalCasesThisMonth = \App\Models\Appointment::whereYear('appointment_date', $now->year)
            ->whereMonth('appointment_date', $now->month)
            ->where('status', 'completed')
            ->count();

        $lastMonth = $now->copy()->subMonth();

        $dentalCasesLastMonth = \App\Models\Appointment::whereYear('appointment_date', $lastMonth->year)
            ->whereMonth('appointment_date', $lastMonth->month)
            ->where('status', 'completed')
            ->count();

        $dentalCasesDelta = $dentalCasesLastMonth > 0
            ? round((($dentalCasesThisMonth - $dentalCasesLastMonth) / $dentalCasesLastMonth) * 100)
            : null;

        $totalApptsThisMonth = \App\Models\Appointment::whereYear('appointment_date', $now->year)
            ->whereMonth('appointment_date', $now->month)
            ->whereIn('status', ['upcoming', 'rescheduled', 'completed', 'cancelled'])
            ->count();

        $totalApptsLastMonth = \App\Models\Appointment::whereYear('appointment_date', $lastMonth->year)
            ->whereMonth('appointment_date', $lastMonth->month)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->count();

        $totalApptsDelta = $totalApptsLastMonth > 0
            ? round((($totalApptsThisMonth - $totalApptsLastMonth) / $totalApptsLastMonth) * 100)
            : null;

        $medicalSupplies = \Illuminate\Support\Facades\DB::table('inventory_items')
            ->where('category', 'Supplies')
            ->orderByRaw('(qty - used) ASC')
            ->limit(3)
            ->get();

        $medicineSupplies = \Illuminate\Support\Facades\DB::table('inventory_items')
            ->where('category', 'Medicine')
            ->orderByRaw('(qty - used) ASC')
            ->limit(3)
            ->get();

        $gadRaw = \Illuminate\Support\Facades\DB::table('daily_treatment_records')
            ->whereYear('treatment_date', $now->year)
            ->whereMonth('treatment_date', $now->month)
            ->select('office_type', 'gender', \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'))
            ->groupBy('office_type', 'gender')
            ->get();

        $gadLabels = ['Student', 'Administrative', 'Faculty', 'Dependent'];
        $gadFemale = [];
        $gadMale   = [];

        foreach ($gadLabels as $label) {
            $key = $label === 'Student' ? null : $label;
            $gadFemale[] = (int) $gadRaw->where('office_type', $key)->where('gender', 'Female')->sum('total');
            $gadMale[]   = (int) $gadRaw->where('office_type', $key)->where('gender', 'Male')->sum('total');
        }

        $philippineHolidays = PhilippineHolidays::range(yearsBefore: 1, yearsAfter: 5);
        $notifications = collect([]);

        return view('dentist.dentist-dashboard', compact(
            'todayAppointments',
            'appointmentCountsPerDay',
            'philippineHolidays',
            'notifications',
            'dentalCasesThisMonth',
            'dentalCasesDelta',
            'totalApptsThisMonth',
            'totalApptsDelta',
            'medicalSupplies',
            'medicineSupplies',
            'gadLabels',
            'gadFemale',
            'gadMale'
        ));
    })->middleware('permission:access_dentist_dashboard')->name('dentist.dentist.dashboard');

    // Appointments
    Route::get('/appointments', [DentistAppointmentController::class, 'index'])
        ->middleware('permission:manage_appointments')
        ->name('dentist.dentist.appointments');

    Route::get('/appointments/{appointment}/patient-profile', [DentistAppointmentController::class, 'patientProfile'])
        ->middleware('permission:manage_patient_profiles')
        ->name('dentist.dentist.appointments.patientProfile');

    Route::get('/appointments/{id}/reschedule', [AppointmentController::class, 'reschedule'])
        ->middleware('permission:manage_appointments')
        ->name('dentist.dentist.appointments.reschedule');

    Route::put('/appointments/{id}/reschedule', [AppointmentController::class, 'updateReschedule'])
        ->middleware('permission:manage_appointments')
        ->name('dentist.dentist.appointments.reschedule.update');

    Route::post('/appointments/{id}/cancel', [DentistAppointmentController::class, 'cancel'])
        ->middleware('permission:manage_appointments')
        ->name('dentist.dentist.appointments.cancel');

    // Patients
    Route::get('/patients', [DentistPatientController::class, 'index'])
        ->middleware('permission:manage_patient_profiles')
        ->name('dentist.dentist.patients');

    Route::get('/patients/{patient}/profile', [DentistPatientController::class, 'profile'])
        ->middleware('permission:manage_patient_profiles')
        ->name('dentist.dentist.patient.profile');

    // Reports
        

    // Report Page
    Route::get('/report', [\App\Http\Controllers\Dentist\DentistReportController::class, 'index'])
        ->middleware('permission:manage_reports')
        ->name('dentist.dentist.report');

    Route::get('/report/gad-data', [\App\Http\Controllers\Dentist\DentistReportController::class, 'gadData'])
        ->middleware('permission:manage_reports')
        ->name('dentist.dentist.report.gad-data');

    Route::get('/report/weekly-data', [\App\Http\Controllers\Dentist\DentistReportController::class, 'weeklyData'])
        ->middleware('permission:manage_reports')
        ->name('dentist.dentist.report.weekly-data');

    // Document Requests
    Route::get('/document-requests', function () {
        return view('dentist-documentrequests');
    })->middleware('permission:manage_document_requests')->name('dentist.documentrequests');
    // Route::get('/report', function () {
    //     if (session('role') !== 'dentist') {
    //         return redirect('/login');
    //     }
    //     return view('dentist-report');
    // })->name('dentist.report');

    // Document Requests – list page
    Route::get('/document-requests', [DocumentRequestController::class, 'dentistIndex'])
        ->name('dentist.dentist.documentrequests');

    // Approve (AJAX POST)
    Route::post('/document-requests/{id}/approve', [DocumentRequestController::class, 'approve'])
        ->name('dentist.dentist.documentrequests.approve');

    // Reject (AJAX POST)
    Route::post('/document-requests/{id}/reject', [DocumentRequestController::class, 'reject'])
        ->name('dentist.dentist.documentrequests.reject');

    Route::get('/document-requests/data', [DocumentRequestController::class, 'dentistData'])
        ->name('dentist.dentist.documentrequests.data');

    // Generate (AJAX POST)
    Route::post('/document-requests/generate', [DocumentRequestController::class, 'generate'])
        ->name('dentist.dentist.documentrequests.generate');

    // View Odontogram
    Route::get('/view-odontogram', function () {
        return view('dentist-view_odontogram');
    })->middleware('permission:manage_dental_records')->name('dentist.viewOdontogram');

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.dentist.inventory');

    Route::get('/inventory/data', [InventoryController::class, 'fetch'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.dentist.inventory.data');

    Route::post('/inventory', [InventoryController::class, 'store'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.dentist.inventory.store');

    Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.dentist.inventory.update');

    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.dentist.inventory.destroy');

});


/*
|--------------------------------------------------------------------------
| REPORT ROUTES (LEGACY DIRECT ACCESS)
|--------------------------------------------------------------------------
*/

Route::prefix('report')->middleware(['role:dentist', 'permission:manage_reports'])->group(function () {

    Route::get('/', [\App\Http\Controllers\Dentist\DentistReportController::class, 'index'])
        ->name('dentist.report.legacy');

    Route::get('/daily-treatment-record', function () {
        return view('dentist.daily-treatment');
    })->name('dentist.dentist.report.daily-treatment');

    Route::get('/dental-services', function () {
        return view('dentist.dental-services');
    })->name('dentist.dentist.report.dental-services');
});
