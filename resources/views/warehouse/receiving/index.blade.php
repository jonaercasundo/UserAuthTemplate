<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📥 Stock Receiving
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Receiving List</h3>
                    <a href="{{ route('warehouse.receiving.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        + New Receiving
                    </a>
                </div>

                @if($receivings->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Supplier</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Items</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($receivings as $receiving)
                                    @php $showUrl = route('warehouse.receiving.show', $receiving->id); @endphp
                                    <tr onclick="window.location='{{ $showUrl }}'" class="hover:bg-gray-50 cursor-pointer">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $receiving->receiving_code }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $receiving->supplier_id ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $receiving->receivingDetails_count ?? $receiving->receivingDetails->count() }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $receiving->total_quantity }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($receiving->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($receiving->status === 'in-progress') bg-blue-100 text-blue-800
                                                @elseif($receiving->status === 'completed') bg-green-100 text-green-800
                                                @elseif($receiving->status === 'declined') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($receiving->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $receiving->receiving_date->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $receivings->links() }}
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No receivings found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
