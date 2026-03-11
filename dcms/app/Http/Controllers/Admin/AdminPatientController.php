<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminPatientController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'patient')->get();

        return view('admin.patient-directory', compact('patients'));
    }
}