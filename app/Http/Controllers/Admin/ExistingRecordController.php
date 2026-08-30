<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ExistingRecordController extends Controller
{
    public function index()
    {
        return view('admin.add-existing-record');
    }
}
