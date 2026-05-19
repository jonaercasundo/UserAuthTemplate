<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📦 Inventory Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- PRODUCT INFO --}}
            <div class="bg-white shadow-sm border rounded-lg p-6 mb-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Product Information</h3>

                    <a href="{{ route('warehouse.inventory.index') }}"
                       class="bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">
                        Back
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">

                    <div>
                        <p class="text-gray-500">Product Code</p>
                        <p class="font-semibold">{{ $inventory->product_code }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Product Name</p>
                        <p class="font-semibold">{{ $inventory->product_name }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Unit Price</p>
                        <p class="font-semibold">
                            {{ number_format($inventory->unit_price, 2) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">On Hand</p>
                        <p class="font-semibold">{{ $inventory->quantity_on_hand }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Reserved</p>
                        <p class="font-semibold">{{ $inventory->quantity_reserved }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Available</p>
                        <p class="font-semibold">
                            {{ $inventory->quantity_available }}
                        </p>
                    </div>

                </div>

                {{-- COST BUTTON --}}
                <div class="mt-6">
                    <form method="POST" action="{{ route('warehouse.inventory.importCosts', $inventory->id) }}">
                        @csrf

                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            🔄 Import Weighted Average Cost
                        </button>
                    </form>

                    @if(isset($historicalAvg))
                        <p class="mt-2 text-sm text-gray-600">
                            Historical Average Cost:
                            <span class="font-semibold">
                                {{ number_format($historicalAvg, 2) }}
                            </span>
                        </p>
                    @endif
                </div>

            </div>

            {{-- RECEIVING HISTORY --}}
            <div class="bg-white shadow-sm border rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-4">Recent Receiving History</h3>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm border">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left">PO #</th>
                                <th class="px-3 py-2 text-left">Qty Received</th>
                                <th class="px-3 py-2 text-left">Unit Price</th>
                                <th class="px-3 py-2 text-left">Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($receivingDetails as $row)

                                <tr class="border-t">
                                    <td class="px-3 py-2">
                                        {{ $row->stockReceiving->purchase_order_number ?? 'N/A' }}
                                    </td>

                                    <td class="px-3 py-2">
                                        {{ $row->quantity_received }}
                                    </td>

                                    <td class="px-3 py-2">
                                        {{ number_format($row->unit_price, 2) }}
                                    </td>

                                    <td class="px-3 py-2">
                                        {{ optional($row->created_at)->format('M d, Y') }}
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500">
                                        No receiving history found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>