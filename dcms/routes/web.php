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

// -------------------
// AUTH PAGES
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
// AUTH ACTIONS
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

        return redirect('/homepage');
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

        return view('dentist-dashboard');
    }

    return back()->with('error', 'Invalid dentist credentials');
})->name('dentist.login.submit');

// Logout (all roles)
Route::post('/logout', function () {
    session()->flush();

    // Keeping this so other existing auth logic (if any) won't break.
    // If you're not using Laravel Auth at all, it's harmless.
    Auth::logout();

    return redirect('/login');
})->name('logout');


// -------------------
// HOMEPAGE
// -------------------

Route::get('/homepage', function () {
    $patient = session()->has('patient_id')
        ? Patient::find(session('patient_id'))
        : null;

    return view('index', compact('patient'));
})->name('homepage');


// -------------------
// DENTIST ROUTES
// -------------------

Route::prefix('dentist')->group(function () {

    // Dashboard Route
    Route::get('/dashboard', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-dashboard');
    })->name('dentist.dashboard');

    // Patients Route
    Route::get('/patients', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-patient');
    })->name('dentist.patients');

    // Appointments Route
    Route::get('/appointments', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-appointments');
    })->name('dentist.appointments');

    // Patient Profile Route
    Route::get('/patient', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-patientprofile');
    })->name('dentist.patient.profile');

    Route::get('/report', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-report');
    })->name('dentist.report');

    Route::get('/dentist/view-odontogram', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-view_odontogram');
    })->name('dentist.viewOdontogram');

});


// ================= REPORTS =================
Route::prefix('report')->group(function () {

    Route::get('/', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('dentist-report');
    })->name('dentist.report');

    // ✅ DAILY TREATMENT RECORD
    Route::get('/daily-treatment-record', function () {
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }
        return view('daily-treatment');
    })->name('dentist.report.daily-treatment');

    // ✅ DENTAL SERVICES
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
// PUBLIC PAGES
// -------------------

Route::get('/', fn () => redirect('/login'));

// NOTE: You already have /patient/book-appointment above (protected).
// Keeping this public route as you originally had (won't affect others).
Route::get('/book-appointment', [AppointmentController::class, 'create'])
    ->name('book.appointment');

// ✅ FIX: record should use role:patient (because login is session-based, not Auth guard)
Route::get('/record', [RecordController::class, 'index'])
    ->name('record')
    ->middleware('role:patient');

Route::get('/about-us', fn () => view('about-us'))
    ->name('about.us')
    ->middleware('role:patient');


// -------------------
// INVENTORY
// -------------------
Route::prefix('dentist')->group(function () {
    Route::get('/inventory', [InventoryController::class, 'index'])
        ->name('dentist.inventory');
    Route::get('/inventory/data', [InventoryController::class, 'fetch']);
    Route::post('/inventory', [InventoryController::class, 'store']);
    Route::put('/inventory/{inventory}', [InventoryController::class, 'update']);
    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy']);
});


// -------------------
// GET SELECTED DATES
// -------------------
Route::get('/available-slots', [AppointmentController::class, 'availableSlots'])
    ->name('appointments.available-slots');


// =======================
// DOCUMENT REQUESTS
// =======================

// Patient submits request
Route::post('/document-requests', [DocumentRequestController::class, 'store'])
    ->name('document.requests.store');

// Patient views own requests
Route::get('/document-requests', [DocumentRequestController::class, 'index'])
    ->name('document.requests.index');

// Admin / Dentist updates status
Route::post('/document-requests/{id}/status', [DocumentRequestController::class, 'updateStatus'])
    ->name('document.requests.updateStatus');
