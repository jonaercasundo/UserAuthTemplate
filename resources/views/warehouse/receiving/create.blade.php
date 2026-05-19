<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📥 Create Stock Receiving
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <form method="POST" action="{{ route('warehouse.receiving.store') }}" class="space-y-6">
                    @csrf

                    <!-- Receiving Header -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold mb-4">Receiving Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">PO Number</label>
                                <input type="text" name="purchase_order_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                                <select id="supplierSelect" name="supplier_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>

                    <!-- Receiving Items -->
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Receiving Items</h3>
                            <button type="button" onclick="addItemRow()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                + Add Item
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Product Code</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Product Name</th>
                                        <th class="px-4 py-3 text-left text-sm font-semibold">Supplier</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold">Qty Ordered</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold">Qty Received</th>
                                        <th class="px-4 py-3 text-right text-sm font-semibold">Unit Price</th>
                                        <th class="px-4 py-3 text-center text-sm font-semibold">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsTable">
                                    <tr class="border-b hover:bg-gray-50 item-row">
                                        <td class="px-4 py-3"><Input type="text" name="items[0][product_code]" list="productOptions" oninput="syncProductName(this)" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" placeholder="Select supplier first" disabled></td>
                                        <td class="px-4 py-3"><input type="text" name="items[0][product_name]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" placeholder="Product name" readonly></td>
                                        <td class="px-4 py-3">
                                            <input type="hidden" name="items[0][supplier_id]" class="supplier-id-input">
                                            <span class="supplier-name text-sm text-gray-600">—</span>
                                        </td>
                                        <td class="px-4 py-3"><input type="number" name="items[0][quantity_ordered]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm text-center" min="0" value="0"></td>
                                        <td class="px-4 py-3"><input type="number" name="items[0][quantity_received]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm text-center" min="0" value="0"></td>
                                        <td class="px-4 py-3"><input type="number" name="items[0][unit_price]" step="0.01" class="w-full px-2 py-1 border border-gray-300 rounded text-sm text-right" min="0" placeholder="0.00"></td>
                                        <td class="px-4 py-3 text-center"><button type="button" onclick="removeItemRow(this)" class="text-red-600 hover:text-red-900 font-medium">Remove</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <datalist id="productOptions"></datalist>
                        <script id="productNameLookup" type="application/json">
                            {!! json_encode($inventoryProducts->pluck('product_name', 'product_code')) !!}
                        </script>
                        <script id="productSupplierLookup" type="application/json">
                            {!! json_encode($inventoryProducts->mapWithKeys(function($p) {
                                return [$p->product_code => ['id' => $p->supplier_id, 'name' => optional($p->supplier)->name]];
                            })->toArray()) !!}
                        </script>
                        <script id="productListBySupplier" type="application/json">
                            {!! json_encode($inventoryProducts->groupBy('supplier_id')->map(function($items) {
                                return $items->map(function($item) {
                                    return ['code' => $item->product_code, 'name' => $item->product_name];
                                })->values();
                            })->toArray()) !!}
                        </script>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 border-t pt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                            Create Receiving
                        </button>
                        <a href="{{ route('warehouse.receiving.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 transition font-medium">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const inventoryLookup = JSON.parse(document.getElementById('productNameLookup').textContent || '{}');
        const inventorySupplierLookup = JSON.parse(document.getElementById('productSupplierLookup').textContent || '{}');
        const inventoryProductsBySupplier = JSON.parse(document.getElementById('productListBySupplier').textContent || '{}');
        const supplierSelect = document.getElementById('supplierSelect');
        let itemCount = 1;

        function updateProductOptions() {
            const supplierId = supplierSelect.value;
            const datalist = document.getElementById('productOptions');
            datalist.innerHTML = '';

            if (!supplierId || !inventoryProductsBySupplier[supplierId]) {
                return;
            }

            inventoryProductsBySupplier[supplierId].forEach(product => {
                const option = document.createElement('option');
                option.value = product.code;
                option.textContent = product.name;
                datalist.appendChild(option);
            });
        }

        function setRowInputsEnabled(row, enabled) {
            const productCodeInput = row.querySelector('input[name$="[product_code]"]');
            const productNameInput = row.querySelector('input[name$="[product_name]"]');
            if (productCodeInput) {
                productCodeInput.disabled = !enabled;
                productCodeInput.placeholder = enabled ? 'e.g., PROD001' : 'Select supplier first';
            }
            if (productNameInput) {
                productNameInput.readOnly = true;
                if (!enabled) {
                    productNameInput.value = '';
                }
            }
        }

        function updateRowsSupplierInfo() {
            const supplierId = supplierSelect.value;
            const supplierName = supplierSelect.options[supplierSelect.selectedIndex]?.text || '—';
            document.querySelectorAll('.item-row').forEach(row => {
                const supplierIdInput = row.querySelector('.supplier-id-input');
                const supplierSpan = row.querySelector('.supplier-name');
                if (supplierIdInput) supplierIdInput.value = supplierId || '';
                if (supplierSpan) supplierSpan.textContent = supplierId ? supplierName : '—';

                const productCodeInput = row.querySelector('input[name$="[product_code]"]');
                const productNameInput = row.querySelector('input[name$="[product_name]"]');
                if (productCodeInput && productNameInput) {
                    const code = productCodeInput.value.trim();
                    if (code && inventoryLookup[code] && inventorySupplierLookup[code]?.id == supplierId) {
                        productNameInput.value = inventoryLookup[code];
                    } else if (code) {
                        productNameInput.value = '';
                        productCodeInput.value = '';
                    }
                }
                setRowInputsEnabled(row, !!supplierId);
            });
        }

        function syncProductName(input) {
            const productCode = input.value.trim();
            const row = input.closest('tr');
            if (!row) return;
            const nameInput = row.querySelector('input[name$="[product_name]"]');
            const supplierIdInput = row.querySelector('.supplier-id-input');
            const supplierSpan = row.querySelector('.supplier-name');
            const selectedSupplier = supplierSelect.value;

            if (selectedSupplier && inventoryProductsBySupplier[selectedSupplier]) {
                const product = inventoryProductsBySupplier[selectedSupplier].find(p => p.code === productCode);
                if (product) {
                    if (nameInput) nameInput.value = product.name;
                    if (supplierIdInput) supplierIdInput.value = selectedSupplier;
                    if (supplierSpan) supplierSpan.textContent = supplierSelect.options[supplierSelect.selectedIndex]?.text || '—';
                    return;
                }
            }

            if (nameInput) nameInput.value = '';
            if (supplierIdInput) supplierIdInput.value = '';
            if (supplierSpan) supplierSpan.textContent = '—';
        }

        if (supplierSelect) {
            supplierSelect.addEventListener('change', () => {
                updateProductOptions();
                updateRowsSupplierInfo();
            });
        }

        function addItemRow() {
            const table = document.getElementById('itemsTable');
            const newRow = document.createElement('tr');
            newRow.className = 'border-b hover:bg-gray-50 item-row';
            newRow.innerHTML = `
                <td class="px-4 py-3"><input type="text" name="items[${itemCount}][product_code]" list="productOptions" oninput="syncProductName(this)" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" placeholder="Select supplier first" ${supplierSelect.value ? '' : 'disabled'}></td>
                <td class="px-4 py-3"><input type="text" name="items[${itemCount}][product_name]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" placeholder="Product name" readonly></td>
                <td class="px-4 py-3">
                    <input type="hidden" name="items[${itemCount}][supplier_id]" class="supplier-id-input" value="${supplierSelect.value || ''}">
                    <span class="supplier-name text-sm text-gray-600">${supplierSelect.value ? supplierSelect.options[supplierSelect.selectedIndex]?.text : '—'}</span>
                </td>
                <td class="px-4 py-3"><input type="number" name="items[${itemCount}][quantity_ordered]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm text-center" min="0" value="0"></td>
                <td class="px-4 py-3"><input type="number" name="items[${itemCount}][quantity_received]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm text-center" min="0" value="0"></td>
                <td class="px-4 py-3"><input type="text" name="items[${itemCount}][batch_number]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm" placeholder="Batch #"></td>
                <td class="px-4 py-3"><input type="date" name="items[${itemCount}][expiry_date]" class="w-full px-2 py-1 border border-gray-300 rounded text-sm"></td>
                <td class="px-4 py-3"><input type="number" name="items[${itemCount}][unit_price]" step="0.01" class="w-full px-2 py-1 border border-gray-300 rounded text-sm text-right" min="0" placeholder="0.00"></td>
                <td class="px-4 py-3 text-center"><button type="button" onclick="removeItemRow(this)" class="text-red-600 hover:text-red-900 font-medium">Remove</button></td>
            `;
            table.appendChild(newRow);
            itemCount++;
        }

        function removeItemRow(button) {
            const table = document.getElementById('itemsTable');
            if (table.querySelectorAll('tr').length > 1) {
                button.closest('tr').remove();
            } else {
                alert('At least one item is required');
            }
        }

        updateProductOptions();
        updateRowsSupplierInfo();
    </script>
</x-app-layout>
