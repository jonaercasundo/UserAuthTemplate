<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📦 Batch Tracking
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- STATS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Active Batches</p>
                    <p class="text-2xl font-bold text-green-600">{{ $activeBatches }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Expiring Soon</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $expiringBatches }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <p class="text-sm text-gray-600">Expired</p>
                    <p class="text-2xl font-bold text-red-600">{{ $expiredBatches }}</p>
                </div>
            </div>

            <!-- BATCH LIST -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Batch List</h3>

                @if($batches->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Batch Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Expiry</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($batches as $batch)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $batch->batch_code }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $batch->product_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $batch->quantity_available }}/{{ $batch->quantity_received }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $batch->expiry_date?->format('M d, Y') ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($batch->status === 'active') bg-green-100 text-green-800
                                                @elseif($batch->status === 'expired') bg-red-100 text-red-800
                                                @elseif($batch->status === 'exhausted') bg-gray-100 text-gray-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($batch->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <a href="{{ route('warehouse.batch.detail', $batch->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $batches->links() }}
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No batches found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
