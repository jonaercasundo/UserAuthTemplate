<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\ReceivingDetail;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($sub) use ($search) {
                $sub->where('product_code', 'like', "%{$search}%")
                    ->orWhere('product_name', 'like', "%{$search}%");
            });
        }

        $inventories = $query->orderBy('product_name')
            ->paginate(15)
            ->withQueryString();

        return view('warehouse.inventory.index', compact('inventories'));
    }

    public function create()
    {
        return view('warehouse.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|unique:inventories,product_code',
            'product_name' => 'required|string',
            'quantity_on_hand' => 'required|integer|min:0',
            'quantity_reserved' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'reorder_quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $validated['quantity_available'] = max(0, $validated['quantity_on_hand'] - $validated['quantity_reserved']);
        $validated['last_updated'] = now();

        Inventory::create($validated);

        return redirect()->route('warehouse.inventory.index')
            ->with('success', 'Inventory item created successfully.');
    }

    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);

        $receivingDetails = ReceivingDetail::with('stockReceiving')
            ->where('product_code', $inventory->product_code)
            ->orderByDesc('id')
            ->take(10)
            ->get();

        // compute weighted historical average from history (qty * price) / total qty
        $totalQty = $receivingDetails->sum('quantity_received');
        $totalCost = $receivingDetails->sum(function ($d) {
            return ($d->quantity_received ?? 0) * ($d->unit_price ?? 0);
        });

        $historicalAvg = $totalQty > 0 ? ($totalCost / $totalQty) : null;

        return view('warehouse.inventory.show', compact('inventory', 'receivingDetails', 'historicalAvg'));
    }

    public function importCosts(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $receivingDetails = ReceivingDetail::where('product_code', $inventory->product_code)->get();

        $totalQty = $receivingDetails->sum('quantity_received');
        $totalCost = $receivingDetails->sum(function ($d) {
            return ($d->quantity_received ?? 0) * ($d->unit_price ?? 0);
        });

        if ($totalQty <= 0) {
            return redirect()->route('warehouse.inventory.show', $inventory->id)
                ->with('warning', 'No historical receiving quantity to import costs from.');
        }

        $average = $totalCost / $totalQty;
        $inventory->unit_price = $average;
        $inventory->last_updated = now();
        $inventory->save();

        return redirect()->route('warehouse.inventory.show', $inventory->id)
            ->with('success', 'Inventory unit price updated using historical weighted average.');
    }

    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);

        return view('warehouse.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $validated = $request->validate([
            'product_code' => 'required|string|unique:inventories,product_code,' . $inventory->id,
            'product_name' => 'required|string',
            'quantity_on_hand' => 'required|integer|min:0',
            'quantity_reserved' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'reorder_quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $validated['quantity_available'] = max(0, $validated['quantity_on_hand'] - $validated['quantity_reserved']);
        $validated['last_updated'] = now();

        $inventory->update($validated);

        return redirect()->route('warehouse.inventory.show', $inventory->id)
            ->with('success', 'Inventory item updated successfully.');
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('warehouse.inventory.index')
            ->with('success', 'Inventory item removed successfully.');
    }
}
