<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return view('dentist-inventory');
    }

    public function fetch()
    {
        return Inventory::orderBy('date_received', 'desc')->get();
    }

    public function store(Request $request)
    {
        Inventory::create($request->validate([
            'category' => 'required',
            'date_received' => 'required|date',
            'stock_no' => 'required',
            'name' => 'required',
            'unit' => 'required',
            'qty' => 'required|integer',
            'used' => 'required|integer',
        ]));

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $inventory->update($request->validate([
            'category' => 'required',
            'date_received' => 'required|date',
            'stock_no' => 'required',
            'name' => 'required',
            'unit' => 'required',
            'qty' => 'required|integer',
            'used' => 'required|integer',
        ]));

        return response()->json(['success' => true]);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json(['success' => true]);
    }
}