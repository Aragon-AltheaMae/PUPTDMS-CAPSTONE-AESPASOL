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

        return view('admin.admin-inventory', [
            'notifications' => collect([]),

            'layoutRole' => 'dentist',
            'pageShellClass' => 'dentist-page-shell',
            'isDentistView' => true,

            'inventoryRouteNames' => [
                'data' => 'dentist.dentist.inventory.data',
                'store' => 'dentist.dentist.inventory.store',
                'update' => 'dentist.dentist.inventory.update',
                'destroy' => 'dentist.dentist.inventory.destroy',
            ],

            'inventoryWatcherKey' => 'dentist-inventory',
        ]);
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
            'Dentist added inventory item: ' . $request->name
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
