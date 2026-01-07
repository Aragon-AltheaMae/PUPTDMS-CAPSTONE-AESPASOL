<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use App\Models\Appointment;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Auth;

// -------------------
// Guest Routes
// -------------------

// Show login page
Route::get('/login', function () {
    return view('auth.login'); // points to resources/views/auth/login.blade.php
})->name('login');

// Show register page
Route::get('/register', function () {
    return view('auth.register'); // points to resources/views/auth/register.blade.php
});


// Registration POST
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

// Login POST
Route::post('/login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    // Hard-coded admin/staff
    $users = [
        'admin' => 'admin123',
        'staff' => 'staff123',
    ];

    if (isset($users[$email]) && $users[$email] === $password) {
        session(['role' => $email]);
        return redirect()->route('homepage');
    }

    // Patient login
    $patient = Patient::where('email', $email)->first();

    if ($patient && Hash::check($password, $patient->password)) {
        session([
            'role' => 'patient',
            'patient_id' => $patient->id,
            'email' => $patient->email,
        ]);
        return redirect()->route('homepage');
    }

    return back()->with('error', 'Invalid credentials');
});


// Logout
// Route::get('/logout', function () {
//     session()->flush();
//     return redirect('/login');
// });

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// -------------------
// Homepage
// -------------------
Route::get('/homepage', function () {
    $patient = null;

    // Optional: load patient if logged in
    if (session()->has('patient_id')) {
        $patient = Patient::find(session('patient_id'));
    }

    return view('index', compact('patient')); // points to index.blade.php
})->name('homepage');


// -------------------
// Admin Routes
// -------------------
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        if (session('role') !== 'admin') {
            return redirect('/login');
        }
        return view('admin.dashboard');
    });
});

// -------------------
// Staff Routes
// -------------------
Route::prefix('staff')->group(function () {
    Route::get('/dashboard', function () {
        if (session('role') !== 'staff') {
            return redirect('/login');
        }
        return view('staff.dashboard');
    });
});

// -------------------
// Patient Routes
// -------------------
Route::prefix('patient')->group(function () {
    Route::get('/dashboard', function () {
        if (!session()->has('patient_id')) {
            return redirect('/login');
        }

        $patient = \App\Models\Patient::find(session('patient_id'));
        return view('patient-dashboard', compact('patient'));
    });


    // Appointments
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
    Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    // Show the booking form
Route::get('/book-appointment', [AppointmentController::class, 'create'])->name('book.appointment.create');

// Store the form submission
Route::post('/book-appointment', [AppointmentController::class, 'store'])->name('book.appointment.store');

// Show all appointments (optional dashboard)
Route::get('/appointments', [AppointmentController::class, 'index'])->name('book.appointment.index');
});


// Dentist routes
Route::prefix('dentist')->group(function () {
    Route::get('/dashboard', function () {
        return view('dentist-dashboard'); // resources/views/dentist/dashboard.blade.php
    });
});


// -------------------
// Public Pages
// -------------------
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/book-appointment', [AppointmentController::class, 'create'])->name('book.appointment');


Route::get('/record', function () {
    return view('record'); // points to resources/views/record.blade.php
})->name('record');


Route::get('/about-us', function () {
    return view('about-us');
})->name('about.us');
