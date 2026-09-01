<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;

class ExistingRecordController extends Controller
{
    public function index()
    {
        return view('dentist.add-existing-record', [
            'layoutRole' => 'dentist',
            'existingAppointmentRoute' => 'dentist.odontogram.existing-appointment.create',
        ]);
    }
}
