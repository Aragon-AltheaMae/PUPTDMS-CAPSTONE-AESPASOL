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
use App\Helpers\PhilippineHolidays;



// -------------------
// AUTH PAGES (PUBLIC)
// -------------------

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


// -------------------
// AUTH ACTIONS (PUBLIC)
// -------------------

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

// Dentist Login POST (Hard-coded)
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

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

// Show admin login page
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

// Process admin login
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Admin dashboard (protected)
Route::get('/admin/dashboard', function () {

    if (!session('admin_logged_in')) {
        return redirect('/admin/login');
    }

    return view('admin-dashboard');
})->name('admin.dashboard');

// Admin logout
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Logout (all roles)
Route::post('/logout', function () {
    session()->flush();
    Auth::logout();

    return redirect('/login');
})->name('logout');


// -------------------
// ROOT REDIRECT (PUBLIC)
// -------------------

Route::get('/', fn() => redirect('/login'));


// -------------------
// PATIENT-PROTECTED ROUTES
// -------------------

Route::middleware('role:patient')->group(function () {

    Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage');
    // Route::get('/homepage', function () {
    //     $patient = session()->has('patient_id')
    //         ? Patient::find(session('patient_id'))
    //         : null;

    //     return view('index', compact('patient'));
    // })->name('homepage');

    //BOOK APPOINTMENT (now protected; keeps same path + name)
    Route::get('/book-appointment', [AppointmentController::class, 'create'])
        ->name('book.appointment');

    // GET SELECTED DATES / AVAILABLE SLOTS (now protected; keeps same path + name)
    Route::get('/available-slots', [AppointmentController::class, 'availableSlots'])
        ->name('appointments.available-slots');

    // DOCUMENT REQUESTS (now protected; keeps same paths + names)
    Route::post('/document-requests', [DocumentRequestController::class, 'store'])
        ->name('document.requests.store');

    Route::get('/document-requests', [DocumentRequestController::class, 'index'])
        ->name('document.requests.index');

    Route::post('/document-requests/{id}/status', [DocumentRequestController::class, 'updateStatus'])
        ->name('document.requests.updateStatus');

    // record should use role:patient (already protected before; kept here too)
    Route::get('/record', [RecordController::class, 'index'])
        ->name('record');

    // about-us (already protected before; kept here too)
    Route::get('/about-us', fn() => view('about-us'))
        ->name('about.us');
});


// -------------------
// DENTIST ROUTES (KEEP AS-IS; FORMATTED)
// -------------------

Route::prefix('dentist')->group(function () {

    // Dashboard Route
    Route::get('/dashboard', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }

        $now   = \Carbon\Carbon::now();
        $today = $now->toDateString();

        // ── Today's appointments ──────────────────────────────────────────────
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

        // ── KPI: Dental Cases this month ──────────────────────────────────────
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

        // ── KPI: Total Appointments this month ───────────────────────────────
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

        // ── Inventory tables ──────────────────────────────────────────────────
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

        // ── GAD chart ─────────────────────────────────────────────────────────
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
            $key       = $label === 'Student' ? null : $label;
            $gadFemale[] = (int) $gadRaw->where('office_type', $key)->where('gender', 'Female')->sum('total');
            $gadMale[]   = (int) $gadRaw->where('office_type', $key)->where('gender', 'Male')->sum('total');
        }

        // ── Philippine Holidays — dynamic for any year ────────────────────────
        // Covers current year ± 1 so the calendar works when navigating months.
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
    })->name('dentist.dashboard');

    // Patients Route
    Route::get('/dentist/patients', [DentistPatientController::class, 'index'])
        ->name('dentist.patients');

    // Appointments Route
    // Appointments Route (Controller)
    Route::get('/appointments', [DentistAppointmentController::class, 'index'])
        ->name('dentist.appointments');

    Route::get('/dentist/appointments/{id}/reschedule', [AppointmentController::class, 'reschedule'])
        ->name('dentist.appointments.reschedule');

    Route::put('/dentist/appointments/{id}/reschedule', [AppointmentController::class, 'updateReschedule'])
        ->name('dentist.appointments.reschedule.update');

    Route::post('/appointments/{id}/cancel', [DentistAppointmentController::class, 'cancel'])
        ->name('dentist.appointments.cancel');

    // Patient Profile Route
    Route::get('/patient', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-patientprofile');
    })->name('dentist.patient.profile');

    // Report Page
    Route::get('/report', [\App\Http\Controllers\Dentist\DentistReportController::class, 'index'])
        ->name('dentist.report');

    Route::get('/report/gad-data', [\App\Http\Controllers\Dentist\DentistReportController::class, 'gadData'])
        ->name('dentist.report.gad-data');

    Route::get('/report/weekly-data', [\App\Http\Controllers\Dentist\DentistReportController::class, 'weeklyData'])
        ->name('dentist.report.weekly-data');
    // Route::get('/report', function () {
    //     if (session('role') !== 'dentist') {
    //         return redirect('/login');
    //     }
    //     return view('dentist-report');
    // })->name('dentist.report');

    // Document Requests Page
    Route::get('/document-requests', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-documentrequests');
    })->name('dentist.documentrequests');

    // View Odontogram Page
    Route::get('/dentist/view-odontogram', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-view_odontogram');
    })->name('dentist.viewOdontogram');
});


// -------------------
// REPORT ROUTES (KEEP AS-IS; FORMATTED)
// -------------------

Route::prefix('report')->group(function () {

    Route::get('/', [\App\Http\Controllers\Dentist\DentistReportController::class, 'index'])
        ->name('dentist.report');

    // Route::get('/', function () {
    //     if (session('role') !== 'dentist') {
    //         return redirect('/login');
    //     }
    //     return view('dentist-report');
    // })->name('dentist.report');

    // DAILY TREATMENT RECORD
    Route::get('/daily-treatment-record', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('daily-treatment');
    })->name('dentist.report.daily-treatment');

    // DENTAL SERVICES
    Route::get('/dental-services', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dental-services');
    })->name('dentist.report.dental-services');
});


// -------------------
// PATIENT ROUTES 
// -------------------

Route::prefix('patient')->middleware('role:patient')->group(function () {

    Route::get('/dashboard', function () {
        $patient = Patient::find(session('patient_id'));
        return view('patient-dashboard', compact('patient'));
    })->name('patient.dashboard');

    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index');
    Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');

    Route::get('/book-appointment', [AppointmentController::class, 'create'])->name('book.appointment.create');
    Route::post('/book-appointment', [AppointmentController::class, 'store'])->name('book.appointment.store');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('book.appointment.index');
});


// -------------------
// INVENTORY (KEEP AS-IS; FORMATTED)
// -------------------

Route::prefix('dentist')->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('dentist.inventory');

    Route::get('/inventory/data', [InventoryController::class, 'fetch']);
    Route::post('/inventory', [InventoryController::class, 'store']);
    Route::put('/inventory/{inventory}', [InventoryController::class, 'update']);
    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy']);
});
