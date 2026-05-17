<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📱 QR Code Scanning
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- STATS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Today's QR Scans</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $todayScans }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Successful</p>
                    <p class="text-2xl font-bold text-green-600">{{ $successfulScans }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Invalid</p>
                    <p class="text-2xl font-bold text-red-600">{{ $invalidScans }}</p>
                </div>
            </div>

            <!-- SCAN LIST -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">QR Code Scan History</h3>

                @if($scans->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Serial</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Batch</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($scans as $scan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $scan->serial_number ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $scan->product_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $scan->batch_number ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($scan->scan_type) }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($scan->status === 'success') bg-green-100 text-green-800
                                                @elseif($scan->status === 'invalid') bg-red-100 text-red-800
                                                @elseif($scan->status === 'duplicate') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($scan->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $scan->scan_date->format('M d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $scans->links() }}
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No QR scans found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
