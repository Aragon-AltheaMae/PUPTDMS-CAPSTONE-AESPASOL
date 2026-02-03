<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OdontogramController extends Controller
{
    public function show($id)
    {
        // 🔐 Dentist guard (same logic you use now)
        if (session('role') !== 'dentist') {
            return redirect('/login');
        }

        // TEMP SAMPLE DATA (replace with DB later)
        $patient = [
            'id' => $id,
            'name' => 'Capilitan, Beyonce',
            'student_no' => '2023-00099-TG-0',
            'program' => 'BSIT 3-1',
            'age' => 18,
            'sex' => 'Female',
        ];

        $records = [
            [
                'date' => '2025-05-03',
                'condition' => 'Caries',
                'tooth_no' => 14,
                'treatment' => 'Tooth Filling',
                'status' => 'done',
                'notes' => 'Advanced Decay',
            ],
            [
                'date' => '2025-04-12',
                'condition' => 'Caries',
                'tooth_no' => 14,
                'treatment' => 'Tooth Filling',
                'status' => 'pending',
                'reason' => 'Not enough time',
                'notes' => 'Decay in pulp',
            ],
        ];

        return view('dentist-view_odontogram', compact('patient', 'records'));
    }
}

