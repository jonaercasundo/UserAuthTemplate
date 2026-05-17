<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏷️ Serial Number Tracking
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- STATS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">In Warehouse</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $inWarehouse }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Released</p>
                    <p class="text-2xl font-bold text-green-600">{{ $released }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Damaged</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $damaged }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Lost</p>
                    <p class="text-2xl font-bold text-red-600">{{ $lost }}</p>
                </div>
            </div>

            <!-- SERIAL LIST -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Serial Number List</h3>

                @if($serials->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Serial Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Batch</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($serials as $serial)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $serial->serial_number }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $serial->product_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $serial->batch_number ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($serial->status === 'in-warehouse') bg-green-100 text-green-800
                                                @elseif($serial->status === 'released') bg-blue-100 text-blue-800
                                                @elseif($serial->status === 'damaged') bg-orange-100 text-orange-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst(str_replace('-', ' ', $serial->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $serial->warehouse_location ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <a href="{{ route('warehouse.serial.detail', $serial->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $serials->links() }}
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No serials found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
