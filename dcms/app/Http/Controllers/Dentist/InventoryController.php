<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Helpers\AuditLogger;

class InventoryController extends Controller
{
    public function index()
    {
        AuditLogger::log(
            'view',
            'inventory',
            'Dentist viewed inventory page'
        );

        return view('dentist.dentist-inventory');
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

        AuditLogger::log(
            'create_inventory',
            'inventory',
            'Dentist added inventory item: ' . $request->name
        );

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

        AuditLogger::log(
            'update_inventory',
            'inventory',
            'Dentist updated inventory item ID ' . $inventory->id
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        AuditLogger::log(
            'delete_inventory',
            'inventory',
            'Dentist deleted inventory item ID ' . $inventory->id
        );
        return response()->json(['success' => true]);
    }
}
