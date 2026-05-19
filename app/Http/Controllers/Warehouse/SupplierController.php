<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\ReceivingDetail;
use App\Models\ReleaseDetail;
use App\Models\StockReceiving;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('inventories')->orderBy('name')->paginate(20);
        return view('warehouse.settings.suppliers', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email',
        ]);

        Supplier::create($validated);

        return redirect()->route('warehouse.settings.suppliers')
            ->with('success', 'Supplier added.');
    }

    public function show($id)
    {
        $supplier = Supplier::with('inventories')->findOrFail($id);

        $productCodes = $supplier->inventories->pluck('product_code')->unique()->filter()->all();
        $priceAverages = Inventory::selectRaw('product_code, AVG(unit_price) as avg_price')
            ->whereIn('product_code', $productCodes)
            ->groupBy('product_code')
            ->pluck('avg_price', 'product_code');

        $inventoryValue = $supplier->inventories->sum(function ($item) {
            return $item->quantity_on_hand * $item->unit_price;
        });

        $averagePrice = $supplier->inventories->avg('unit_price');

        return view('warehouse.settings.suppliers.show', compact('supplier', 'priceAverages', 'inventoryValue', 'averagePrice'));
    }

    public function storeProduct(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'product_code' => 'required|string|unique:inventories,product_code',
            'product_name' => 'required|string|max:255',
            'quantity_on_hand' => 'required|integer|min:0',
            'quantity_reserved' => 'nullable|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'reorder_quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $quantityReserved = $validated['quantity_reserved'] ?? 0;
        $quantityAvailable = max(0, $validated['quantity_on_hand'] - $quantityReserved);

        Inventory::create([
            'product_code' => $validated['product_code'],
            'product_name' => $validated['product_name'],
            'supplier_id' => $supplier->id,
            'quantity_on_hand' => $validated['quantity_on_hand'],
            'quantity_reserved' => $quantityReserved,
            'quantity_available' => $quantityAvailable,
            'minimum_stock_level' => $validated['minimum_stock_level'],
            'reorder_quantity' => $validated['reorder_quantity'],
            'unit_price' => $validated['unit_price'],
            'last_updated' => now(),
        ]);

        return redirect()->route('warehouse.settings.suppliers.show', $supplier->id)
            ->with('success', 'Product entry added to this supplier.');
    }

    public function edit($id)
    {
        $suppliers = Supplier::withCount('inventories')->orderBy('name')->paginate(20);
        $editingSupplier = Supplier::findOrFail($id);

        return view('warehouse.settings.suppliers', compact('suppliers', 'editingSupplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:suppliers,email,' . $supplier->id,
        ]);

        $supplier->update($validated);

        return redirect()->route('warehouse.settings.suppliers')
            ->with('success', 'Supplier updated.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $inUse = Inventory::where('supplier_id', $supplier->id)->exists()
            || ReceivingDetail::where('supplier_id', $supplier->id)->exists()
            || ReleaseDetail::where('supplier_id', $supplier->id)->exists()
            || StockReceiving::where('supplier_id', $supplier->id)->exists();

        if ($inUse) {
            return redirect()->route('warehouse.settings.suppliers')
                ->with('warning', 'Cannot delete supplier linked to active warehouse records.');
        }

        $supplier->delete();

        return redirect()->route('warehouse.settings.suppliers')
            ->with('success', 'Supplier removed.');
    }
}
