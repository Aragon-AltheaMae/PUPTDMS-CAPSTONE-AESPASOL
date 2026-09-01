<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ExistingRecordController extends Controller
{
    public function index()
    {
        return view('dentist.add-existing-record', [
            'layoutRole' => 'admin',
            'existingAppointmentRoute' => 'admin.odontogram.existing-appointment.create',
        ]);
    }
}
