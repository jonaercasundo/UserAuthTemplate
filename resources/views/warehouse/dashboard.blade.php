<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🏭 Warehouse Management System
            </h2>
            <div class="text-sm text-gray-600">
                {{ now()->format('M d, Y H:i') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- QUICK STATS -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                <!-- Pending Receivings -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Pending Receivings</p>
                            <p class="text-2xl font-bold text-blue-600 mt-2">{{ $stats['pending_receivings'] }}</p>
                        </div>
                        <div class="text-3xl opacity-30">📥</div>
                    </div>
                </div>

                <!-- Pending Releases -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Pending Releases</p>
                            <p class="text-2xl font-bold text-orange-600 mt-2">{{ $stats['pending_releases'] }}</p>
                        </div>
                        <div class="text-3xl opacity-30">📤</div>
                    </div>
                </div>

                <!-- Pending Transfers -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Pending Transfers</p>
                            <p class="text-2xl font-bold text-purple-600 mt-2">{{ $stats['pending_transfers'] }}</p>
                        </div>
                        <div class="text-3xl opacity-30">↔️</div>
                    </div>
                </div>

                <!-- Active Counts -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Active Counts</p>
                            <p class="text-2xl font-bold text-green-600 mt-2">{{ $stats['active_counts'] }}</p>
                        </div>
                        <div class="text-3xl opacity-30">📊</div>
                    </div>
                </div>

                <!-- Today's Scans -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Today Scans</p>
                            <p class="text-2xl font-bold text-red-600 mt-2">{{ $stats['today_scans'] }}</p>
                        </div>
                        <div class="text-3xl opacity-30">🔍</div>
                    </div>
                </div>

                <!-- Active Batches -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Active Batches</p>
                            <p class="text-2xl font-bold text-indigo-600 mt-2">{{ $stats['total_batches'] }}</p>
                        </div>
                        <div class="text-3xl opacity-30">📦</div>
                    </div>
                </div>

                <!-- Tracked Serials -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Tracked Serials</p>
                            <p class="text-2xl font-bold text-pink-600 mt-2">{{ $stats['tracked_serials'] }}</p>
                        </div>
                        <div class="text-3xl opacity-30">🏷️</div>
                    </div>
                </div>

                <!-- Pending Adjustments -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Pending Adjustments</p>
                            <p class="text-2xl font-bold text-yellow-600 mt-2">{{ $stats['pending_adjustments'] }}</p>
                        </div>
                        <div class="text-3xl opacity-30">⚙️</div>
                    </div>
                </div>

                <!-- Pending Pullouts -->
                <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase">Pending Pullouts</p>
                            <p class="text-2xl font-bold text-cyan-600 mt-2">{{ $stats['pending_pullouts'] }}</p>
                        </div>
                        <div class="text-3xl opacity-30">🚪</div>
                    </div>
                </div>
            </div>

            <!-- FEATURE MODULES GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Stock Receiving -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">📥 Stock Receiving</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Receive and document incoming inventory from suppliers.</p>
                        <a href="{{ route('warehouse.receiving.index') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                            View Receivings
                        </a>
                        <a href="{{ route('warehouse.receiving.create') }}" class="inline-block ml-2 bg-blue-100 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-200 transition text-sm font-medium">
                            New Receiving
                        </a>
                    </div>
                </div>

                <!-- Stock Release -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">📤 Stock Release</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Release inventory for customer orders and shipments.</p>
                        <a href="{{ route('warehouse.release.index') }}" class="inline-block bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition text-sm font-medium">
                            View Releases
                        </a>
                        <a href="{{ route('warehouse.release.create') }}" class="inline-block ml-2 bg-orange-100 text-orange-600 px-4 py-2 rounded-lg hover:bg-orange-200 transition text-sm font-medium">
                            New Release
                        </a>
                    </div>
                </div>

                <!-- Warehouse Transfer -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">↔️ Warehouse Transfer</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Transfer inventory between warehouse locations.</p>
                        <a href="{{ route('warehouse.transfer.index') }}" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                            View Transfers
                        </a>
                        <a href="{{ route('warehouse.transfer.create') }}" class="inline-block ml-2 bg-purple-100 text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-200 transition text-sm font-medium">
                            New Transfer
                        </a>
                    </div>
                </div>

                <!-- Item Pull-Out -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">🚪 Item Pull-Out</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Pull out damaged, expired, or shortage items.</p>
                        <a href="{{ route('warehouse.pullout.index') }}" class="inline-block bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 transition text-sm font-medium">
                            View Pull-outs
                        </a>
                        <a href="{{ route('warehouse.pullout.create') }}" class="inline-block ml-2 bg-cyan-100 text-cyan-600 px-4 py-2 rounded-lg hover:bg-cyan-200 transition text-sm font-medium">
                            New Pull-out
                        </a>
                    </div>
                </div>

                <!-- Stock Adjustment -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">⚙️ Stock Adjustment</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Adjust inventory quantities for discrepancies.</p>
                        <a href="{{ route('warehouse.adjustment.index') }}" class="inline-block bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition text-sm font-medium">
                            View Adjustments
                        </a>
                        <a href="{{ route('warehouse.adjustment.create') }}" class="inline-block ml-2 bg-yellow-100 text-yellow-600 px-4 py-2 rounded-lg hover:bg-yellow-200 transition text-sm font-medium">
                            New Adjustment
                        </a>
                    </div>
                </div>

                <!-- Cycle Counting -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">📊 Cycle Counting</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Perform inventory counts and identify discrepancies.</p>
                        <a href="{{ route('warehouse.counting.index') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                            View Counts
                        </a>
                        <a href="{{ route('warehouse.counting.create') }}" class="inline-block ml-2 bg-green-100 text-green-600 px-4 py-2 rounded-lg hover:bg-green-200 transition text-sm font-medium">
                            New Count
                        </a>
                    </div>
                </div>

                <!-- Barcode Scanning -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">🔍 Barcode Scanning</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Scan and track items using barcode technology.</p>
                        <a href="{{ route('warehouse.barcode.index') }}" class="inline-block bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm font-medium">
                            View Scans
                        </a>
                    </div>
                </div>

                <!-- QR Code Scanning -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">📱 QR Code Scanning</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Advanced tracking with QR code technology.</p>
                        <a href="{{ route('warehouse.qrcode.index') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                            View QR Scans
                        </a>
                    </div>
                </div>

                <!-- Batch Tracking -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">📦 Batch Tracking</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Track product batches throughout their lifecycle.</p>
                        <a href="{{ route('warehouse.batch.index') }}" class="inline-block bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition text-sm font-medium">
                            View Batches
                        </a>
                    </div>
                </div>

                <!-- Serial Number Tracking -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">🏷️ Serial Tracking</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Track individual items with serial numbers.</p>
                        <a href="{{ route('warehouse.serial.index') }}" class="inline-block bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition text-sm font-medium">
                            View Serials
                        </a>
                    </div>
                </div>
            </div>

            <!-- RECENT ACTIVITIES -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Receivings & Releases -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">📥 Recent Receivings</h3>
                    </div>
                    <div class="p-4 max-h-64 overflow-y-auto">
                        @forelse($recentReceivings as $receiving)
                            <div class="flex items-center justify-between p-3 mb-2 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $receiving->receiving_code }}</p>
                                    <p class="text-xs text-gray-500">{{ $receiving->total_quantity }} items</p>
                                </div>
                                <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                    @if($receiving->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($receiving->status === 'in-progress') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($receiving->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-4">No recent receivings</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Transfers & Adjustments -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">⚙️ Recent Adjustments</h3>
                    </div>
                    <div class="p-4 max-h-64 overflow-y-auto">
                        @forelse($recentAdjustments as $adjustment)
                            <div class="flex items-center justify-between p-3 mb-2 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $adjustment->adjustment_code }}</p>
                                    <p class="text-xs text-gray-500">{{ $adjustment->product_name }}</p>
                                </div>
                                <span class="text-xs font-semibold {{ $adjustment->adjustment_type === 'increase' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $adjustment->adjustment_type === 'increase' ? '+' : '-' }}{{ $adjustment->adjustment_quantity }}
                                </span>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-4">No recent adjustments</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
