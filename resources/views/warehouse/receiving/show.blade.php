<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📄 Receiving Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-900">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 p-4 text-sm text-yellow-900">
                    {{ session('warning') }}
                </div>
            @endif
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $receiving->receiving_code }}</h3>
                        <p class="text-sm text-gray-500">Status: <span class="font-medium">{{ ucfirst($receiving->status) }}</span></p>
                    </div>
                    <div class="flex flex-col items-start md:items-end gap-2 text-right">
                        <p class="text-sm text-gray-500">Date: {{ $receiving->receiving_date->format('M d, Y H:i') }}</p>
                        <p class="text-sm text-gray-500">Total Cost: <span class="font-semibold text-gray-900">₱{{ number_format($totalCost, 2) }}</span></p>
                        <div class="flex flex-wrap gap-2 justify-end">
                            <a href="{{ route('warehouse.inventory.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition text-sm font-medium">
                                View Inventory
                            </a>
                            @if($receiving->status === 'pending')
                                <form action="{{ route('warehouse.receiving.decline', $receiving->id) }}" method="POST" onsubmit="return confirm('Decline this pending receiving?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                                        Decline Receiving
                                    </button>
                                </form>
                                <form action="{{ route('warehouse.receiving.receive', $receiving->id) }}" method="POST" onsubmit="return confirm('Receive this pending record and update inventory?');">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                        Receive Items
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @if($receiving->status === 'pending')
                    <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 mb-6 text-sm text-yellow-800">
                        This receiving is still pending. Inventory will update only after you click <strong>Receive Items</strong>.
                    </div>
                @elseif($receiving->status === 'completed')
                    <div class="rounded-lg border border-green-200 bg-green-50 p-4 mb-6 text-sm text-green-800">
                        Receiving has been confirmed and inventory has been updated successfully.
                    </div>
                @elseif($receiving->status === 'declined')
                    <div class="rounded-lg border border-red-200 bg-red-50 p-4 mb-6 text-sm text-red-800">
                        This receiving has been declined and will not affect inventory.
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                        <p class="text-xs uppercase tracking-wide text-gray-500">PO Number</p>
                        <p class="mt-2 text-sm text-gray-900">{{ $receiving->purchase_order_number ?? 'N/A' }}</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Supplier</p>
                        @if($receiving->supplier)
                            <p class="mt-2 text-sm text-gray-900">{{ $receiving->supplier->name }}</p>
                            <p class="mt-1 text-sm text-gray-600">{{ $receiving->supplier->contact ?? '' }}{{ $receiving->supplier->email ? ' · ' . $receiving->supplier->email : '' }}</p>
                        @else
                            <p class="mt-2 text-sm text-gray-900">N/A</p>
                        @endif
                    </div>
                    <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Notes</p>
                        <p class="mt-2 text-sm text-gray-900">{{ $receiving->notes ?? 'No notes' }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Product Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Product Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Supplier</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Qty Ordered</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase">Qty Received</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Batch #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Expiry Date</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Unit Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Line Cost</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @forelse($receiving->receivingDetails as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-blue-600">
                                        <a href="{{ route('warehouse.inventory.index', ['search' => $detail->product_code]) }}" class="hover:underline">
                                            {{ $detail->product_code }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $detail->product_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ optional($detail->supplier)->name ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $detail->quantity_ordered }}</td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $detail->quantity_received }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $detail->batch_number ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ optional($detail->expiry_date)->format('M d, Y') ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-right text-gray-600">₱{{ number_format($detail->unit_price ?? 0, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-right text-gray-900">₱{{ number_format(($detail->unit_price ?? 0) * ($detail->quantity_received ?? 0), 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">No receiving items were found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="7"></td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 text-right">Total Cost</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 text-right">₱{{ number_format($totalCost, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('warehouse.receiving.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Back to Receivings
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
