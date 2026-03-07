<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\Patient;

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

        return redirect()->route('dentist.dashboard');
    }

    return back()->with('error', 'Invalid dentist credentials');
})->name('dentist.login.submit');

// Admin Login POST
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Logout (all roles)
Route::post('/logout', function () {
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

        return view('admin-dashboard');
    })->name('admin.dashboard');

    Route::get('/role-permissions', [RolePermissionController::class, 'index'])
        ->name('admin.role_permissions');

    Route::post('/role-permissions/update', [RolePermissionController::class, 'update'])
        ->name('admin.role_permissions.update');

    Route::post('/role-permissions/reset', [RolePermissionController::class, 'reset'])
        ->name('admin.role_permissions.reset');
});


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
        ->name('book.appointment');

    Route::get('/available-slots', [AppointmentController::class, 'availableSlots'])
        ->middleware('permission:book_appointments')
        ->name('appointments.available-slots');

    Route::post('/document-requests', [DocumentRequestController::class, 'store'])
        ->middleware('permission:request_documents')
        ->name('document.requests.store');

    Route::get('/document-requests', [DocumentRequestController::class, 'index'])
        ->middleware('permission:request_documents')
        ->name('document.requests.index');

    Route::post('/document-requests/{id}/status', [DocumentRequestController::class, 'updateStatus'])
        ->middleware('permission:request_documents')
        ->name('document.requests.updateStatus');

    Route::get('/record', [RecordController::class, 'index'])
        ->middleware('permission:view_own_records')
        ->name('record');

    Route::get('/about-us', fn() => view('about-us'))
        ->name('about.us');
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
        ->name('appointment.index');

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
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_time', 'asc')
            ->get();

        $appointmentCountsPerDay = \App\Models\Appointment::whereIn('status', ['pending', 'confirmed'])
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
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
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

        return view('dentist-dashboard', compact(
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
    })->middleware('permission:access_dentist_dashboard')->name('dentist.dashboard');

    // Appointments
    Route::get('/appointments', [DentistAppointmentController::class, 'index'])
        ->middleware('permission:manage_appointments')
        ->name('dentist.appointments');

    Route::get('/appointments/{appointment}/patient-profile', [DentistAppointmentController::class, 'patientProfile'])
        ->middleware('permission:manage_patient_profiles')
        ->name('dentist.appointments.patientProfile');

    Route::get('/appointments/{id}/reschedule', [AppointmentController::class, 'reschedule'])
        ->middleware('permission:manage_appointments')
        ->name('dentist.appointments.reschedule');

    Route::put('/appointments/{id}/reschedule', [AppointmentController::class, 'updateReschedule'])
        ->middleware('permission:manage_appointments')
        ->name('dentist.appointments.reschedule.update');

    Route::post('/appointments/{id}/cancel', [DentistAppointmentController::class, 'cancel'])
        ->middleware('permission:manage_appointments')
        ->name('dentist.appointments.cancel');

    // Patients
    Route::get('/patients', [DentistPatientController::class, 'index'])
        ->middleware('permission:manage_patient_profiles')
        ->name('dentist.patients');

    Route::get('/patients/{patient}/profile', [DentistPatientController::class, 'profile'])
        ->middleware('permission:manage_patient_profiles')
        ->name('dentist.patient.profile');

    // Reports
    Route::get('/report', [\App\Http\Controllers\Dentist\DentistReportController::class, 'index'])
        ->middleware('permission:manage_reports')
        ->name('dentist.report');

    Route::get('/report/gad-data', [\App\Http\Controllers\Dentist\DentistReportController::class, 'gadData'])
        ->middleware('permission:manage_reports')
        ->name('dentist.report.gad-data');

    Route::get('/report/weekly-data', [\App\Http\Controllers\Dentist\DentistReportController::class, 'weeklyData'])
        ->middleware('permission:manage_reports')
        ->name('dentist.report.weekly-data');

    // Document Requests
    Route::get('/document-requests', function () {
        return view('dentist-documentrequests');
    })->middleware('permission:manage_document_requests')->name('dentist.documentrequests');

    // View Odontogram
    Route::get('/view-odontogram', function () {
        return view('dentist-view_odontogram');
    })->middleware('permission:manage_dental_records')->name('dentist.viewOdontogram');

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.inventory');

    Route::get('/inventory/data', [InventoryController::class, 'fetch'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.inventory.data');

    Route::post('/inventory', [InventoryController::class, 'store'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.inventory.store');

    Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.inventory.update');

    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])
        ->middleware('permission:manage_inventory')
        ->name('dentist.inventory.destroy');
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
        return view('daily-treatment');
    })->name('dentist.report.daily-treatment');

    Route::get('/dental-services', function () {
        return view('dental-services');
    })->name('dentist.report.dental-services');
});