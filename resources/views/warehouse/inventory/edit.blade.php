<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">✏️ Edit Inventory Item</h2>
                <p class="text-sm text-gray-500 mt-1">Update the product details and stock levels.</p>
            </div>
            <a href="{{ route('warehouse.inventory.show', $inventory->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition text-sm font-medium">Back to Details</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-900">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <form method="POST" action="{{ route('warehouse.inventory.update', $inventory->id) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Code</label>
                            <input type="text" name="product_code" value="{{ old('product_code', $inventory->product_code) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                            <input type="text" name="product_name" value="{{ old('product_name', $inventory->product_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity On Hand</label>
                            <input type="number" name="quantity_on_hand" value="{{ old('quantity_on_hand', $inventory->quantity_on_hand) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity Reserved</label>
                            <input type="number" name="quantity_reserved" value="{{ old('quantity_reserved', $inventory->quantity_reserved) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
                            <input id="unit_price_input" type="number" step="0.01" name="unit_price" value="{{ old('unit_price', $inventory->unit_price) }}" min="0" data-original-price="{{ number_format($inventory->unit_price, 2, '.', '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <p id="unit_price_info" class="mt-2 text-sm text-gray-500">Previous price: ₱{{ number_format($inventory->unit_price, 2) }} · Difference: ₱0.00</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock Level</label>
                            <input type="number" name="minimum_stock_level" value="{{ old('minimum_stock_level', $inventory->minimum_stock_level) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reorder Quantity</label>
                            <input type="number" name="reorder_quantity" value="{{ old('reorder_quantity', $inventory->reorder_quantity) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity Available</label>
                            <input type="number" value="{{ old('quantity_on_hand', $inventory->quantity_on_hand) - old('quantity_reserved', $inventory->quantity_reserved) }}" disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('warehouse.inventory.show', $inventory->id) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const unitPriceInput = document.getElementById('unit_price_input');
            const unitPriceInfo = document.getElementById('unit_price_info');
            if (!unitPriceInput || !unitPriceInfo) {
                return;
            }

            const originalPrice = parseFloat(unitPriceInput.dataset.originalPrice || '0');

            function formatPrice(value) {
                return '₱' + Number(value).toFixed(2);
            }

            function updateUnitPriceInfo() {
                const currentPrice = parseFloat(unitPriceInput.value || '0');
                const diff = currentPrice - originalPrice;
                const diffPrefix = diff >= 0 ? '+' : '-';
                const diffValue = Math.abs(diff).toFixed(2);
                unitPriceInfo.textContent = `Previous price: ${formatPrice(originalPrice)} · Difference: ${diffPrefix}${diffValue}`;
                if (diff < 0) {
                    unitPriceInfo.classList.remove('text-gray-500');
                    unitPriceInfo.classList.add('text-red-600');
                } else {
                    unitPriceInfo.classList.remove('text-red-600');
                    unitPriceInfo.classList.add('text-gray-500');
                }
            }

            unitPriceInput.addEventListener('input', updateUnitPriceInfo);
            updateUnitPriceInfo();
        });
    </script>
</x-app-layout>
