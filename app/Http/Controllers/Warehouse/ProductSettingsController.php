<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\ReceivingDetail;
use App\Models\Supplier;

class ProductSettingsController extends Controller
{
    // Show product settings list and add form
    public function index()
    {
        $products = Inventory::with('supplier')->orderBy('product_name')->paginate(20);
        $suppliers = Supplier::orderBy('name')->get();
        return view('warehouse.settings.products', compact('products', 'suppliers'));
    }

    // Create a new product (inventory skeleton)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_code' => 'required|string|unique:inventories,product_code',
            'product_name' => 'required|string',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        Inventory::create([
            'product_code' => $validated['product_code'],
            'product_name' => $validated['product_name'],
            'supplier_id' => $validated['supplier_id'] ?? null,
            'quantity_on_hand' => 0,
            'quantity_reserved' => 0,
            'quantity_available' => 0,
            'minimum_stock_level' => 0,
            'reorder_quantity' => 0,
            'unit_price' => 0,
            'last_updated' => now(),
        ]);

        return redirect()->route('warehouse.settings.products')
            ->with('success', 'Product added to inventory list.');
    }

    // Remove a product
    public function destroy($id)
    {
        $product = Inventory::findOrFail($id);

        // Safety: prevent deletion if there is stock or receiving history
        $hasStock = $product->quantity_on_hand > 0 || $product->quantity_reserved > 0 || $product->quantity_available > 0;
        $hasHistory = ReceivingDetail::where('product_code', $product->product_code)->exists();

        if ($hasStock || $hasHistory) {
            return redirect()->route('warehouse.settings.products')
                ->with('warning', 'Cannot delete product with stock or receiving history.');
        }

        $product->delete();

        return redirect()->route('warehouse.settings.products')
            ->with('success', 'Product removed.');
    }

    public function update(Request $request, $id)
    {
        $product = Inventory::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'required|string',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $product->update([
            'product_name' => $validated['product_name'],
            'supplier_id' => $validated['supplier_id'] ?? null,
        ]);

        return redirect()->route('warehouse.settings.products')
            ->with('success', 'Product updated.');
    }
}
