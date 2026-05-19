@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-semibold">Supplier Portal</h2>
                <p class="text-sm text-gray-500">Supplier details, products supplied, unit costs, and price comparisons for ordering decisions.</p>
            </div>
            <div class="flex flex-wrap gap-2 items-center">
                <a href="{{ route('warehouse.settings.suppliers') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-200">Back to Suppliers</a>
                <a href="{{ route('warehouse.settings.suppliers.edit', $supplier->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Edit Supplier</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-900">
                {{ session('success') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="mb-4 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-900">
                {{ session('warning') }}
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm uppercase tracking-[0.2em] text-gray-500">Supplier</h3>
                <p class="mt-3 text-xl font-semibold text-gray-900">{{ $supplier->name }}</p>
                <p class="mt-2 text-sm text-gray-600">{{ $supplier->contact ?? 'No contact provided' }}</p>
                <p class="mt-1 text-sm text-gray-600">{{ $supplier->email ?? 'No email provided' }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm uppercase tracking-[0.2em] text-gray-500">Products supplied</h3>
                <p class="mt-3 text-3xl font-semibold text-gray-900">{{ $supplier->inventories->count() }}</p>
                <p class="mt-2 text-sm text-gray-600">Active item codes assigned to this supplier.</p>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm uppercase tracking-[0.2em] text-gray-500">Inventory value</h3>
                <p class="mt-3 text-3xl font-semibold text-gray-900">₱{{ number_format($inventoryValue, 2) }}</p>
                <p class="mt-2 text-sm text-gray-600">Current value of stocked products from this supplier.</p>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 shadow-sm mb-6">
            <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Product pricing overview</h3>
                    <p class="text-sm text-gray-500">Compare this supplier's costs against the warehouse average for each product.</p>
                </div>
                <div class="text-sm text-gray-500">
                    Average price across this supplier's active items: <span class="font-semibold text-gray-900">{{ $averagePrice ? '₱' . number_format($averagePrice, 2) : 'N/A' }}</span>
                </div>
            </div>

            <div class="mt-6 rounded-lg border border-dashed border-gray-200 bg-gray-50 p-5">
                <h4 class="text-sm font-semibold text-gray-900">Add supplier product entry</h4>
                <p class="text-sm text-gray-500 mb-4">Create a new product record belonging to this supplier, including quantity and unit cost.</p>

                <form method="POST" action="{{ route('warehouse.settings.suppliers.products.store', $supplier->id) }}" class="grid grid-cols-1 xl:grid-cols-4 gap-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Product Code</label>
                        <input name="product_code" value="{{ old('product_code') }}" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('product_code')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Product Name</label>
                        <input name="product_name" value="{{ old('product_name') }}" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('product_name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Unit Price</label>
                        <input name="unit_price" value="{{ old('unit_price') }}" type="number" step="0.01" min="0" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('unit_price')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">On Hand Qty</label>
                        <input name="quantity_on_hand" value="{{ old('quantity_on_hand', 0) }}" type="number" step="1" min="0" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('quantity_on_hand')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Reserved Qty</label>
                        <input name="quantity_reserved" value="{{ old('quantity_reserved', 0) }}" type="number" step="1" min="0" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('quantity_reserved')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Minimum Stock</label>
                        <input name="minimum_stock_level" value="{{ old('minimum_stock_level', 0) }}" type="number" step="1" min="0" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('minimum_stock_level')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600">Reorder Qty</label>
                        <input name="reorder_quantity" value="{{ old('reorder_quantity', 0) }}" type="number" step="1" min="0" class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('reorder_quantity')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Add Product</button>
                    </div>
                </form>
            </div>

            @if($supplier->inventories->count())
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700">Product Code</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-700">Product Name</th>
                                <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-700">On Hand</th>
                                <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-700">Unit Price</th>
                                <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-700">Total Value</th>
                                <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-700">Price vs Avg</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($supplier->inventories as $inventory)
                                @php
                                    $avgPrice = $priceAverages[$inventory->product_code] ?? null;
                                    $difference = $avgPrice !== null ? $inventory->unit_price - $avgPrice : null;
                                    $differenceText = $difference !== null ? (abs($difference) < 0.01 ? '±0.00' : number_format($difference, 2)) : 'N/A';
                                    $differenceClass = $difference !== null ? ($difference <= 0 ? 'text-emerald-700' : 'text-red-600') : 'text-gray-500';
                                @endphp
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-800">{{ $inventory->product_code }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $inventory->product_name }}</td>
                                    <td class="px-4 py-3 text-right text-sm text-gray-700">{{ $inventory->quantity_on_hand }}</td>
                                    <td class="px-4 py-3 text-right text-sm text-gray-700">₱{{ number_format($inventory->unit_price, 2) }}</td>
                                    <td class="px-4 py-3 text-right text-sm text-gray-700">₱{{ number_format($inventory->quantity_on_hand * $inventory->unit_price, 2) }}</td>
                                    <td class="px-4 py-3 text-right text-sm font-semibold {{ $differenceClass }}">
                                        @if($avgPrice !== null)
                                            {{ $difference < 0 ? '-' : '+' }}₱{{ $differenceText }}
                                            <span class="text-xs text-gray-500">({{ number_format($avgPrice, 2) }})</span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="mt-6 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-600">
                    No supplier products are currently associated. Assign products in Product Settings to build order-ready supplier details.
                </div>
            @endif
        </div>
    </div>
@endsection
