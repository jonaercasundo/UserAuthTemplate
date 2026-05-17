<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🚪 Item Pull-Out
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Pull-Out List</h3>
                    <a href="{{ route('warehouse.pullout.create') }}" class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 transition">
                        + New Pull-Out
                    </a>
                </div>

                @if($pullouts->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($pullouts as $pullout)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $pullout->pullout_code }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst(str_replace('-', ' ', $pullout->pullout_type)) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $pullout->total_quantity }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($pullout->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($pullout->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $pullout->pullout_date->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $pullouts->links() }}
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No pull-outs found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
