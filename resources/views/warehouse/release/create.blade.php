<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">📤 Create Stock Release</h2>
                <p class="text-sm text-gray-500 mt-1">Create a new stock release and prepare items for release.</p>
            </div>
            <a href="{{ route('warehouse.release.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition text-sm font-medium">Back to Releases</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <form method="POST" action="{{ route('warehouse.release.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Release Type</label>
                            <select name="release_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                                <option value="customer-order">customer-order</option>
                                <option value="internal-use">internal-use</option>
                                <option value="return">return</option>
                                <option value="disposal">disposal</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reference Number</label>
                            <input type="text" name="reference_number" value="{{ old('reference_number') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-orange-500 focus:border-orange-500">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Release Items</h3>
                        <button type="button" onclick="addReleaseRow()" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm font-medium">+ Add Item</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                    <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Product Code</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Product Name</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Supplier</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase">Qty To Release</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase">Notes</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody id="releaseItemsTable">
                                <tr class="border-b hover:bg-gray-50 item-row">
                                    <td class="px-4 py-3"><input type="text" name="items[0][product_code]" value="{{ old('items.0.product_code') }}" list="releaseProductOptions" oninput="syncReleaseProductName(this)" class="w-full px-2 py-1 border border-gray-300 rounded text-sm"></td>
                                    <td class="px-4 py-3"><input type="text" name="items[0][product_name]" value="{{ old('items.0.product_name') }}" class="w-full px-2 py-1 border border-gray-300 rounded text-sm"></td>
                                    <td class="px-4 py-3">
                                        <input type="hidden" name="items[0][supplier_id]" class="supplier-id-input">
                                        <span class="supplier-name text-sm text-gray-600">—</span>
                                    </td>
                                    <td class="px-4 py-3"><input type="number" name="items[0][quantity_to_release]" value="{{ old('items.0.quantity_to_release', 0) }}" min="0" class="w-full px-2 py-1 border border-gray-300 rounded text-sm text-center"></td>
                                    <td class="px-4 py-3"><input type="text" name="items[0][notes]" value="{{ old('items.0.notes') }}" class="w-full px-2 py-1 border border-gray-300 rounded text-sm"></td>
                                    <td class="px-4 py-3 text-center"><button type="button" onclick="removeReleaseRow(this)" class="text-red-600 hover:text-red-900 font-medium">Remove</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <datalist id="releaseProductOptions">
                        @foreach($inventoryProducts as $product)
                            <option value="{{ $product->product_code }}">{{ $product->product_name }}</option>
                        @endforeach
                    </datalist>
                    <script id="releaseProductData" type="application/json">
                        {!! json_encode($inventoryProducts->mapWithKeys(function($p){ return [$p->product_code => ['name' => $p->product_name, 'supplier' => ['id' => $p->supplier_id, 'name' => optional($p->supplier)->name]]]; })) !!}
                    </script>

                    <div class="flex gap-4 justify-end pt-6 border-t border-gray-200">
                        <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition">Create Release</button>
                        <a href="{{ route('warehouse.release.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 transition">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const releaseInventoryLookup = JSON.parse(document.getElementById('releaseProductData').textContent || '{}');
        let releaseItemCount = 1;

        function syncReleaseProductName(input) {
            const productCode = input.value.trim();
            const row = input.closest('tr');
            if (!row) return;
            const nameInput = row.querySelector('input[name$="[product_name]"]');

            const supplierSpan = row.querySelector('.supplier-name');
            const supplierIdInput = row.querySelector('.supplier-id-input');

            if (releaseInventoryLookup[productCode]) {
                const entry = releaseInventoryLookup[productCode];
                nameInput.value = entry.name || '';
                if (supplierSpan) supplierSpan.textContent = entry.supplier && entry.supplier.name ? entry.supplier.name : '—';
                if (supplierIdInput) supplierIdInput.value = entry.supplier && entry.supplier.id ? entry.supplier.id : '';
            }
        }

        function addReleaseRow() {
            const table = document.getElementById('releaseItemsTable');
            const row = document.createElement('tr');
            row.className = 'border-b hover:bg-gray-50 item-row';
            row.innerHTML = `
                <td class="px-4 py-3"><input type="text" name="items[${releaseItemCount}][product_code]" list="releaseProductOptions" oninput="syncReleaseProductName(this)" class="w-full px-2 py-1 border border-gray-300 rounded text-sm"></td>
                <td class="px-4 py-3"><input type="text" name="items[${releaseItemCount}][product_name]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm"></td>
                <td class="px-4 py-3">
                    <input type="hidden" name="items[${releaseItemCount}][supplier_id]" class="supplier-id-input">
                    <span class="supplier-name text-sm text-gray-600">—</span>
                </td>
                <td class="px-4 py-3"><input type="number" name="items[${releaseItemCount}][quantity_to_release]" value="0" min="0" class="w-full px-2 py-1 border border-gray-300 rounded text-sm text-center"></td>
                <td class="px-4 py-3"><input type="text" name="items[${releaseItemCount}][batch_number]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm"></td>
                <td class="px-4 py-3"><input type="text" name="items[${releaseItemCount}][serial_number]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm"></td>
                <td class="px-4 py-3"><input type="text" name="items[${releaseItemCount}][notes]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm"></td>
                <td class="px-4 py-3 text-center"><button type="button" onclick="removeReleaseRow(this)" class="text-red-600 hover:text-red-900 font-medium">Remove</button></td>
            `;
            table.appendChild(row);
            releaseItemCount++;
        }

        function removeReleaseRow(button) {
            const table = document.getElementById('releaseItemsTable');
            if (table.querySelectorAll('tr').length > 1) {
                button.closest('tr').remove();
            } else {
                alert('At least one item is required.');
            }
        }
    </script>
</x-app-layout>
