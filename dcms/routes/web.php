<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\DentalHistory;
use App\Models\MedicalHistory;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login Page
Route::get('/login', function () {
    return view('login');
})->name('login');

// Login POST
Route::post('/login', function (Request $request) {
    $users = [
        'admin' => 'admin123',
        'staff' => 'staff123',
    ];

    $username = $request->username;
    $password = $request->password;

    if ($username === 'patient') {
        // For demo, redirect patient to landing page
        session(['username' => 'patient']);
        return redirect('/patient/landing');
    }

    if (isset($users[$username]) && $users[$username] === $password) {
        session(['username' => $username]);
        if ($username === 'admin') return redirect('/admin/dashboard');
        if ($username === 'staff') return redirect('/staff/dashboard');
    }

    return back()->with('error', 'Invalid credentials');
});

// Logout
Route::get('/logout', function () {
    session()->flush();
    return redirect('/login');
});

// Generic Dashboard
Route::get('/dashboard', function () {
    if (!session()->has('username')) return redirect('/login');
    $username = session('username');
    return "Welcome, $username! <br><a href='/logout'>Logout</a>";
});

/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
*/

// Patient Landing Page (Input Personal Info)
Route::get('/patient/landing', function () {
    if (session('username') !== 'patient') return redirect('/login');

    // Check if patient info already exists
    $patient = Patient::where('email', session('email'))->first();
    if ($patient) {
        return redirect('/patient/dashboard');
    }

    return view('patient-landing');
});

// POST route to store patient info
Route::post('/patient/landing', function (Request $request) {
    if (session('username') !== 'patient') return redirect('/login');

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:patients,email',
        'phone' => 'nullable|string|max:20',
        'birthdate' => 'nullable|date',
        'gender' => 'nullable|string|max:10',
        'password' => 'required|string|min:6',
    ]);

    Patient::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'birthdate' => $request->birthdate,
        'gender' => $request->gender,
        'password' => Hash::make($request->password),
    ]);

    // Store actual email in session for future queries
    session(['email' => $request->email]);

    return redirect('/patient/dashboard')->with('success', 'Information saved successfully!');
});

// Patient Dashboard
Route::get('/patient/dashboard', function () {
    if (session('username') !== 'patient') return redirect('/login');

    // Fetch the patient model
    $patient = Patient::where('email', session('username'))->first();

    if (!$patient) {
        return redirect('/patient/landing')->with('error', 'Please complete your information first.');
    }

    // Fetch all appointments for this patient with dental history
    $appointments = Appointment::with('dentalHistory')
        ->where('patient', $patient->email) // use email to match patient
        ->orderBy('datetime', 'desc')
        ->get();

    // Prepare an array of records to use in Blade (keep your current table structure)
    $dentalRecords = [];
    foreach ($appointments as $appointment) {
        foreach ($appointment->dentalHistory as $dh) {
            $dentalRecords[] = [
                'date' => $appointment->datetime,
                'dentist' => 'Dr. Smith', // or store dentist name in appointment if you have it
                'notes' => $dh->question . ': ' . $dh->answer,
            ];
        }
    }

    return view('patient-dashboard', ['dentalRecords' => $dentalRecords]);
});


// Step 1: Appointment Calendar
Route::get('/patient/appointment/calendar', function () {
    if (session('username') !== 'patient') return redirect('/login');
    return view('appointment-calendar');
});

Route::post('/patient/appointment/calendar', function (Request $request) {
    if (session('username') !== 'patient') return redirect('/login');

    session(['appointment_datetime' => $request->date_time]);
    return redirect('/patient/appointment/services');
});

// Step 2: Services Selection
Route::get('/patient/appointment/services', function () {
    if (session('username') !== 'patient') return redirect('/login');
    return view('appointment-services');
});

Route::post('/patient/appointment/services', function (Request $request) {
    if (session('username') !== 'patient') return redirect('/login');

    $appointment = Appointment::create([
        'patient' => session('email'),
        'datetime' => session('appointment_datetime'),
        'service' => $request->service,
    ]);

    session(['appointment_id' => $appointment->id]);
    return redirect('/patient/appointment/dental-history');
});

// Step 3: Dental History Survey
Route::get('/patient/appointment/dental-history', function () {
    if (session('username') !== 'patient') return redirect('/login');
    return view('appointment-dental-history');
});

Route::post('/patient/appointment/dental-history', function (Request $request) {
    if (session('username') !== 'patient') return redirect('/login');

    $appointment_id = session('appointment_id');

    $dental_questions = [
        'Tooth Sensitivity' => $request->has('question1') ? 'Yes' : 'No',
        'Brush Twice a Day' => $request->has('question2') ? 'Yes' : 'No',
        'Floss Regularly' => $request->has('question3') ? 'Yes' : 'No',
        'Tooth Extractions' => $request->has('question4') ? 'Yes' : 'No',
        'Gum Bleeding' => $request->has('question5') ? 'Yes' : 'No',
    ];

    foreach ($dental_questions as $question => $answer) {
        DentalHistory::create([
            'appointment_id' => $appointment_id,
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    return redirect('/patient/appointment/medical-history');
});

// Step 4: Medical History Survey
Route::get('/patient/appointment/medical-history', function () {
    if (session('username') !== 'patient') return redirect('/login');
    return view('appointment-medical-history');
});

Route::post('/patient/appointment/medical-history', function (Request $request) {
    if (session('username') !== 'patient') return redirect('/login');

    $appointment_id = session('appointment_id');

    $medical_questions = [
        'Allergies' => $request->has('allergies') ? 'Yes' : 'No',
        'Heart Condition' => $request->has('heart_condition') ? 'Yes' : 'No',
        'Diabetes' => $request->has('diabetes') ? 'Yes' : 'No',
        'Pregnant' => $request->has('pregnant') ? 'Yes' : 'No',
        'Other Conditions' => $request->has('other_conditions') ? 'Yes' : 'No',
    ];

    foreach ($medical_questions as $question => $answer) {
        MedicalHistory::create([
            'appointment_id' => $appointment_id,
            'question' => $question,
            'answer' => $answer,
        ]);
    }

    return redirect('/patient/appointment/final-confirmation');
});

// Step 5: Final Confirmation
Route::get('/patient/appointment/final-confirmation', function () {
    if (session('username') !== 'patient') return redirect('/login');

    $appointment = Appointment::with(['dentalHistory', 'medicalHistory'])
        ->find(session('appointment_id'));

    if (!$appointment) return redirect('/patient/dashboard')->with('error', 'No appointment found.');

    return view('appointment-final-confirmation', compact('appointment'));
});

// Request Dental Clearance
Route::post('/patient/request-clearance', function () {
    if (session('username') !== 'patient') return redirect('/login');

    $clearances = session('dental_clearance_requests', []);
    $clearances[] = ['date' => date('Y-m-d'), 'status' => 'Pending'];
    session(['dental_clearance_requests' => $clearances]);

    return back()->with('success_clearance', 'Dental clearance requested successfully!');
});

// Request Dental Health Record
Route::post('/patient/request-health-record', function () {
    if (session('username') !== 'patient') return redirect('/login');

    $healthRecords = session('dental_health_requests', []);
    $healthRecords[] = ['date' => date('Y-m-d'), 'status' => 'Pending'];
    session(['dental_health_requests' => $healthRecords]);

    return back()->with('success_health', 'Dental health record requested successfully!');
});

/*
|--------------------------------------------------------------------------
| Admin & Staff Routes
|--------------------------------------------------------------------------
*/

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    if (session('username') !== 'admin') return redirect('/login');
    return "Welcome Admin! <br><a href='/logout'>Logout</a>";
});

// Staff Dashboard
Route::get('/staff/dashboard', function () {
    if (session('username') !== 'staff') return redirect('/login');
    return "Welcome Staff! <br><a href='/logout'>Logout</a>";
});
