<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">📤 Release Details</h2>
                <p class="text-sm text-gray-500 mt-1">Review and process this release transaction.</p>
            </div>
            <a href="{{ route('warehouse.release.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition text-sm font-medium">Back to Releases</a>
        </div>
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

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Release Code</p>
                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ $release->release_code }}</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Type</p>
                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ ucfirst(str_replace('-', ' ', $release->release_type)) }}</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Release Date</p>
                        <p class="mt-2 text-lg font-semibold text-gray-900">{{ $release->release_date->format('M d, Y H:i') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="rounded-lg border border-gray-200 p-4 bg-white">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Reference Number</p>
                        <p class="mt-2 text-sm text-gray-900">{{ $release->reference_number ?? 'N/A' }}</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 p-4 bg-white">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Total Items</p>
                        <p class="mt-2 text-sm text-gray-900">{{ $release->total_items }}</p>
                    </div>
                    <div class="rounded-lg border border-gray-200 p-4 bg-white">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Total Quantity</p>
                        <p class="mt-2 text-sm text-gray-900">{{ $release->total_quantity }}</p>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 p-4 bg-gray-50">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Notes</p>
                    <p class="mt-2 text-sm text-gray-900">{{ $release->notes ?? 'No notes' }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Product Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Product Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Supplier</th>
                                <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-600">Qty To Release</th>
                                <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-600">Qty Released</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Batch</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Serial</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($release->releaseDetails as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $detail->product_code }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $detail->product_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ optional($detail->supplier)->name ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $detail->quantity_to_release }}</td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-700">{{ $detail->quantity_released }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $detail->batch_number ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $detail->serial_number ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                            @if($detail->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($detail->status === 'released') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ ucfirst($detail->status ?? 'pending') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($release->status === 'pending')
                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <form action="{{ route('warehouse.release.process', $release->id) }}" method="POST" onsubmit="return confirm('Process this release and update inventory?');">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm font-medium">
                                Release Items
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
