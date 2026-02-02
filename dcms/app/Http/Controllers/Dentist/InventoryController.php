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
            'category' => 'required|in:Medicine,Supplies',
            'date_received' => 'required|date',
            'stock_no' => 'required|unique:inventory_items,stock_no',
            'name' => 'required|string',
            'unit' => 'required|in:Box,Pack,Bottle,Piece',
            'qty' => 'required|integer|min:0',
            'used' => 'required|integer|min:0',
        ]));

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $inventory->update($request->validate([
            'category' => 'required|in:Medicine,Supplies',
            'date_received' => 'required|date',
            'stock_no' => 'required|unique:inventory_items,stock_no,' . $inventory->id,
            'name' => 'required|string',
            'unit' => 'required|in:Box,Pack,Bottle,Piece',
            'qty' => 'required|integer|min:0',
            'used' => 'required|integer|min:0',
        ]));

        return response()->json(['success' => true]);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json(['success' => true]);
    }
}