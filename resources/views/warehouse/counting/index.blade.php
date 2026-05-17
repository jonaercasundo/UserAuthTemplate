<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Cycle Counting
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Cycle Count List</h3>
                    <a href="{{ route('warehouse.counting.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        + New Count
                    </a>
                </div>

                @if($counts->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Items Counted</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Discrepancies</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($counts as $count)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $count->count_code }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $count->total_items_counted }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $count->discrepancies }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($count->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($count->status === 'in-progress') bg-blue-100 text-blue-800
                                                @elseif($count->status === 'completed') bg-purple-100 text-purple-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($count->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $count->count_date->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $counts->links() }}
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No counts found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
