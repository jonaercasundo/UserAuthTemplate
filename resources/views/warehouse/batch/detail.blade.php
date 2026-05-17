<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📦 Batch Details - {{ $batch->batch_code }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- BATCH INFO -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Batch Information</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Batch Code:</span>
                            <span class="font-medium">{{ $batch->batch_code }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Product:</span>
                            <span class="font-medium">{{ $batch->product_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Batch Number:</span>
                            <span class="font-medium">{{ $batch->batch_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                @if($batch->status === 'active') bg-green-100 text-green-800
                                @elseif($batch->status === 'expired') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($batch->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quantity & Dates</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Received:</span>
                            <span class="font-medium">{{ $batch->quantity_received }} units</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Available:</span>
                            <span class="font-medium">{{ $batch->quantity_available }} units</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Used:</span>
                            <span class="font-medium">{{ $batch->quantity_used }} units</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Manufacture Date:</span>
                            <span class="font-medium">{{ $batch->manufacture_date?->format('M d, Y') ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Expiry Date:</span>
                            <span class="font-medium">{{ $batch->expiry_date?->format('M d, Y') ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TRACKING HISTORY -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Batch History</h3>

                @if($history->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Quantity Changed</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Reference</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($history as $record)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ ucfirst($record->action_type) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $record->quantity_changed }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $record->reference_code ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $record->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $record->action_date->format('M d, Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No history found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
