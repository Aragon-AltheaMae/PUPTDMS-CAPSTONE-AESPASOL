<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class ExistingRecordController extends Controller
{
    public function index()
    {
        $patients = Patient::select('id', 'name', 'email', 'phone', 'gender', 'birthdate', 'student_no', 'course_name', 'year_level', 'section')
            ->orderBy('name', 'asc')
            ->get();

        return view('dentist.add-existing-record', compact('patients'));
    }
}
