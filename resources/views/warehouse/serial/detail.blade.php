<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🏷️ Serial Details - {{ $serial->serial_number }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- SERIAL INFO -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Serial Information</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Serial Number:</span>
                            <span class="font-mono font-medium">{{ $serial->serial_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Product:</span>
                            <span class="font-medium">{{ $serial->product_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Batch:</span>
                            <span class="font-medium">{{ $serial->batch_number ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                @if($serial->status === 'in-warehouse') bg-green-100 text-green-800
                                @elseif($serial->status === 'released') bg-blue-100 text-blue-800
                                @elseif($serial->status === 'damaged') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst(str_replace('-', ' ', $serial->status)) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Location & Tracking</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Warehouse Location:</span>
                            <span class="font-medium">{{ $serial->warehouse_location ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Current Location:</span>
                            <span class="font-medium">{{ $serial->current_location ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Received Date:</span>
                            <span class="font-medium">{{ $serial->received_date->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Scanned:</span>
                            <span class="font-medium">{{ $serial->last_scanned_date?->format('M d, Y H:i') ?? 'Never' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SCAN HISTORY -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Scan History</h3>

                @if($scanHistory->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Scan Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Scanned By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($scanHistory as $scan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ ucfirst($scan->scan_type) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $scan->scan_location ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $scan->scannedByUser->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($scan->status === 'success') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($scan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $scan->scan_date->format('M d, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No scan history found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
