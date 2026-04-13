<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Helpers\AuditLogger;

class AdminInventoryController extends Controller
{
    public function index()
    {
        AuditLogger::log(
            'view',
            'inventory',
            'Admin viewed inventory page'
        );

        $notifications = collect([]);

        return view('admin.admin-inventory', compact('notifications'));
    }

    public function fetch()
    {
        return Inventory::orderBy('date_received', 'desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|in:Medicine,Supplies',
            'date_received' => 'required|date',
            'stock_no' => 'required|unique:inventory_items,stock_no',
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'qty' => 'required|integer|min:0',
            'used' => 'required|integer|min:0',
        ]);

        $data['unit'] = ucwords(strtolower(trim($data['unit'])));

        Inventory::create($data);

        AuditLogger::log(
            'create_inventory',
            'inventory',
            'Admin added inventory item: ' . $request->name
        );

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $data = $request->validate([
            'category' => 'required|in:Medicine,Supplies',
            'date_received' => 'required|date',
            'stock_no' => 'required|unique:inventory_items,stock_no,' . $inventory->id,
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'qty' => 'required|integer|min:0',
            'used' => 'required|integer|min:0',
        ]);

        $data['unit'] = ucwords(strtolower(trim($data['unit'])));

        $inventory->update($data);

        AuditLogger::log(
            'update_inventory',
            'inventory',
            'Admin updated inventory item ID ' . $inventory->id
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        AuditLogger::log(
            'delete_inventory',
            'inventory',
            'Admin deleted inventory item ID ' . $inventory->id
        );

        return response()->json(['success' => true]);
    }
}
