<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceType;

class ServiceTypeController extends Controller
{

    public function index()
    {
        $services = ServiceType::orderBy('name')->get();

        return view('admin.service-types', compact('services'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:service_types,name',
            'description' => 'nullable|string|max:255',
        ]);

        ServiceType::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Service type added');
    }


    public function destroy($id)
    {
        ServiceType::findOrFail($id)->delete();

        return back()->with('success','Service type deleted');
    }

}