<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">📤 Stock Release</h2>
                <p class="text-sm text-gray-500 mt-1">Manage outgoing warehouse releases.</p>
            </div>
            <a href="{{ route('warehouse.release.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm font-medium">
                + New Release
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                @if($releases->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Type</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Items</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase">Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($releases as $release)
                                    @php $showReleaseUrl = route('warehouse.release.show', $release->id); @endphp
                                    <tr onclick="window.location='{{ $showReleaseUrl }}'" class="hover:bg-gray-50 cursor-pointer">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $release->release_code }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst(str_replace('-', ' ', $release->release_type)) }}</td>
                                        <td class="px-6 py-4 text-sm text-right text-gray-700">{{ $release->total_items }}</td>
                                        <td class="px-6 py-4 text-sm text-right text-gray-700">{{ $release->total_quantity }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($release->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($release->status === 'released') bg-blue-100 text-blue-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($release->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $release->release_date->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $releases->links() }}
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>No releases found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
