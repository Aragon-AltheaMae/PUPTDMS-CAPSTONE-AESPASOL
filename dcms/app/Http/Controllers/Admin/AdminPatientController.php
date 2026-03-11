<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\AuditLogger;

class AdminPatientController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'patient')->get();

        AuditLogger::log(
            'view',
            'patients',
            'Admin viewed patient list'
        );

        return view('admin.patient-directory', compact('patients'));
    }
}
