<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ↔️ Warehouse Transfer
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Transfer List</h3>
                    <a href="{{ route('warehouse.transfer.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        + New Transfer
                    </a>
                </div>

                @if($transfers->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">From</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">To</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($transfers as $transfer)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $transfer->transfer_code }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $transfer->from_warehouse }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $transfer->to_warehouse }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $transfer->total_quantity }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($transfer->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($transfer->status === 'in-transit') bg-blue-100 text-blue-800
                                                @elseif($transfer->status === 'received') bg-green-100 text-green-800
                                                @else bg-purple-100 text-purple-800
                                                @endif">
                                                {{ ucfirst($transfer->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transfers->links() }}
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No transfers found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
