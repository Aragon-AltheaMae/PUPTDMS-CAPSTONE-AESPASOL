<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use App\Http\Controllers\PatientController;
use App\Models\Appointment;
use App\Models\DentalHistory;
use App\Models\MedicalHistory;


// Show login page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Show register page
Route::get('/register', function () {
    return view('auth.register');
});

/*
|--------------------------------------------------------------------------
| REGISTRATION (POST)
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| LOGIN (POST)
|--------------------------------------------------------------------------
*/

Route::post('/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    // Hard-coded admin / staff
    $users = [
        'admin' => 'admin123',
        'staff' => 'staff123',
    ];

    if (isset($users[$username]) && $users[$username] === $password) {
        session([
            'role' => $username
        ]);

        return redirect('/homepage');
    }

    // Patient login
    $patient = Patient::where('email', $username)->first();

    if ($patient && Hash::check($password, $patient->password)) {
        session([
            'role' => 'patient',
            'patient_id' => $patient->id,
        ]);

        return redirect('/homepage');
    }

    return back()->with('error', 'Invalid credentials');
});

/*
|--------------------------------------------------------------------------
| HOMEPAGE (INDEX.BLADE.PHP)
|--------------------------------------------------------------------------
*/

Route::get('/homepage', function () {
    if (!session()->has('patient_id')) {
        return redirect('/login');
    }

    $patient = Patient::find(session('patient_id'));

    return view('index', compact('patient'));
});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| BOOK APPOINTMENT PAGE
|--------------------------------------------------------------------------
*/

Route::get('/appointment', function () {
    return view('appointment');
})->name('appointment');


Route::get('/', function () {
    return redirect('/login');
});


Route::get('/book-appointment', function () {
    return view('book-appointment');
})->name('book.appointment');

// -------------------
// Patient Dashboard
// -------------------
Route::get('/patient/dashboard', function () {
    if (!session()->has('patient_id')) {
        return redirect('/login');
    }

    $patient = Patient::find(session('patient_id'));

    return view('index', ['patient' => $patient]);
});

// -------------------
// Admin & Staff Dashboards
// -------------------
Route::get('/admin/dashboard', function () {
    if (!session()->has('username') || session('username') !== 'admin') {
        return redirect('/login');
    }
    return view('admin.dashboard');
});

Route::get('/staff/dashboard', function () {
    if (!session()->has('username') || session('username') !== 'staff') {
        return redirect('/login');
    }
    return view('staff.dashboard');
});

// -------------------
// Logout Route
// -------------------
Route::post('/logout', function () {
    session()->flush();
    return redirect('/login')->with('success', 'Logged out successfully!');
});

/*
|--------------------------------------------------------------------------
| Admin & Staff Routes
|--------------------------------------------------------------------------
*/

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    if (!session()->has('username') || session('username') !== 'admin') {
        return redirect('/login');
    }
    return "Welcome Admin! <form method='POST' action='/logout'>@csrf<button type='submit'>Logout</button></form>";
});

// Staff Dashboard
Route::get('/staff/dashboard', function () {
    if (!session()->has('username') || session('username') !== 'staff') {
        return redirect('/login');
    }
    return "Welcome Staff! <form method='POST' action='/logout'>@csrf<button type='submit'>Logout</button></form>";
});

/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
*/

// Patient Dashboard
Route::get('/patient/dashboard', function () {
    if (!session()->has('username') || session('username') !== 'patient') {
        return redirect('/login');
    }

    $patient = Patient::find(session('patient_id'));
    if (!$patient) return redirect('/register');

    // Fetch appointments with dental and medical histories
    $appointments = Appointment::with(['dentalHistories', 'medicalHistories'])
        ->where('patient', $patient->email)
        ->orderBy('datetime', 'desc')
        ->get();

    // Build dental records array for Blade
    $dentalRecords = [];
    foreach ($appointments as $appointment) {
        foreach ($appointment->dentalHistories as $dh) {
            $dentalRecords[] = [
                'date' => $appointment->datetime,
                'dentist' => 'Dr. Smith', // or store dentist name in appointment
                'notes' => $dh->question . ': ' . $dh->answer,
            ];
        }
    }

    return view('patient-dashboard', [
        'patient' => $patient,
        'dentalRecords' => $dentalRecords,
    ]);
});


// Appointment Steps
Route::get('/patient/appointment/calendar', function () {
    if (!session()->has('username') || session('username') !== 'patient') return redirect('/login');
    return view('appointment-calendar');
});
Route::post('/patient/appointment/calendar', function (Request $request) {
    session(['appointment_datetime' => $request->date_time]);
    return redirect('/patient/appointment/services');
});

Route::get('/patient/appointment/services', function () {
    if (!session()->has('username') || session('username') !== 'patient') return redirect('/login');
    return view('appointment-services');
});
Route::post('/patient/appointment/services', function (Request $request) {
    $appointment = Appointment::create([
        'patient' => session('email'),
        'datetime' => session('appointment_datetime'),
        'service' => $request->service,
    ]);
    session(['appointment_id' => $appointment->id]);
    return redirect('/patient/appointment/dental-history');
});

Route::get('/patient/appointment/dental-history', function () {
    if (!session()->has('username') || session('username') !== 'patient') return redirect('/login');
    return view('appointment-dental-history');
});
Route::post('/patient/appointment/dental-history', function (Request $request) {
    $appointment_id = session('appointment_id');
    $dental_questions = [
        'Tooth Sensitivity' => $request->has('question1') ? 'Yes' : 'No',
        'Brush Twice a Day' => $request->has('question2') ? 'Yes' : 'No',
        'Floss Regularly' => $request->has('question3') ? 'Yes' : 'No',
        'Tooth Extractions' => $request->has('question4') ? 'Yes' : 'No',
        'Gum Bleeding' => $request->has('question5') ? 'Yes' : 'No',
    ];
    foreach ($dental_questions as $q => $a) {
        DentalHistory::create(['appointment_id' => $appointment_id, 'question' => $q, 'answer' => $a]);
    }
    return redirect('/patient/appointment/medical-history');
});

Route::get('/patient/appointment/medical-history', function () {
    if (!session()->has('username') || session('username') !== 'patient') return redirect('/login');
    return view('appointment-medical-history');
});
Route::post('/patient/appointment/medical-history', function (Request $request) {
    $appointment_id = session('appointment_id');
    $medical_questions = [
        'Allergies' => $request->has('allergies') ? 'Yes' : 'No',
        'Heart Condition' => $request->has('heart_condition') ? 'Yes' : 'No',
        'Diabetes' => $request->has('diabetes') ? 'Yes' : 'No',
        'Pregnant' => $request->has('pregnant') ? 'Yes' : 'No',
        'Other Conditions' => $request->has('other_conditions') ? 'Yes' : 'No',
    ];
    foreach ($medical_questions as $q => $a) {
        MedicalHistory::create(['appointment_id' => $appointment_id, 'question' => $q, 'answer' => $a]);
    }
    return redirect('/patient/appointment/final-confirmation');
});

// Final Confirmation
Route::get('/patient/appointment/final-confirmation', function () {
    if (!session()->has('username') || session('username') !== 'patient') return redirect('/login');

    $appointment = Appointment::with(['dentalHistories', 'medicalHistories'])
        ->find(session('appointment_id'));

    if (!$appointment) return redirect('/patient/dashboard')->with('error', 'No appointment found.');

    return view('appointment-final-confirmation', compact('appointment'));
});

// Requests
Route::post('/patient/request-clearance', function () {
    if (!session()->has('username') || session('username') !== 'patient') return redirect('/login');

    $clearances = session('dental_clearance_requests', []);
    $clearances[] = ['date' => date('Y-m-d'), 'status' => 'Pending'];
    session(['dental_clearance_requests' => $clearances]);

    return back()->with('success_clearance', 'Dental clearance requested!');
});

Route::post('/patient/request-health-record', function () {
    if (!session()->has('username') || session('username') !== 'patient') return redirect('/login');

    $records = session('dental_health_requests', []);
    $records[] = ['date' => date('Y-m-d'), 'status' => 'Pending'];
    session(['dental_health_requests' => $records]);

    return back()->with('success_health', 'Dental health record requested!');
});
