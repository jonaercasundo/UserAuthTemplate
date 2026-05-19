<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📦 Warehouse Inventory
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER ACTIONS --}}
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Inventory List</h3>
                    <p class="text-sm text-gray-500">Manage product stocks, availability, and pricing</p>
                </div>

                <a href="{{ route('warehouse.inventory.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    + Add Item
                </a>
            </div>

            {{-- SEARCH BOX --}}
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('warehouse.inventory.index') }}">
                    <div class="flex gap-2">

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Search product code or product name...">

                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Search
                        </button>

                        <a href="{{ route('warehouse.inventory.index') }}"
                           class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">
                            Reset
                        </a>

                    </div>
                </form>
            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">

                        <thead class="bg-gray-100 border-b">
                            <tr class="text-gray-700">
                                <th class="px-4 py-3">Code</th>
                                <th class="px-4 py-3">Product Name</th>
                                <th class="px-4 py-3 text-center">On Hand</th>
                                <th class="px-4 py-3 text-center">Reserved</th>
                                <th class="px-4 py-3 text-center">Available</th>
                                <th class="px-4 py-3 text-right">Unit Price</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Last Updated</th>
                                <th class="px-4 py-3 text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            @forelse($inventories as $item)

                                @php
                                    $onHand = $item->quantity_on_hand ?? 0;
                                    $reserved = $item->quantity_reserved ?? 0;
                                    $available = $item->quantity_available ?? ($onHand - $reserved);

                                    $min = $item->minimum_stock_level ?? 0;

                                    if ($available <= 0) {
                                        $status = 'OUT OF STOCK';
                                        $badge = 'bg-red-100 text-red-700';
                                    } elseif ($available <= $min) {
                                        $status = 'LOW STOCK';
                                        $badge = 'bg-yellow-100 text-yellow-700';
                                    } else {
                                        $status = 'IN STOCK';
                                        $badge = 'bg-green-100 text-green-700';
                                    }
                                @endphp

                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-3 font-semibold text-gray-800">
                                        {{ $item->product_code }}
                                    </td>

                                    <td class="px-4 py-3">
                                        {{ $item->product_name }}
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2 py-1 bg-gray-800 text-white rounded">
                                            {{ $onHand }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2 py-1 bg-gray-500 text-white rounded">
                                            {{ $reserved }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">
                                            {{ $available }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-right">
                                        {{ number_format($item->unit_price, 2) }}
                                    </td>

                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $badge }}">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-gray-600">
                                        {{ optional($item->last_updated)->format('M d, Y h:i A') }}
                                    </td>

                                    <td class="px-4 py-3 text-center">

                                        <div class="flex justify-center gap-2">

                                            <a href="{{ route('warehouse.inventory.show', $item->id) }}"
                                               class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs">
                                                View
                                            </a>

                                            <a href="{{ route('warehouse.inventory.edit', $item->id) }}"
                                               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-xs">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('warehouse.inventory.destroy', $item->id) }}"
                                                  onsubmit="return confirm('Delete this item?')">

                                                @csrf
                                                @method('DELETE')

                                                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-xs">
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-6 text-gray-500">
                                        No inventory records found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="p-4 border-t">
                    {{ $inventories->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>