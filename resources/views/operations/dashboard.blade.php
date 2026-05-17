<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📊 Operations Dashboard
            </h2>
            <div class="text-sm text-gray-600">
                Last updated: {{ now()->format('M d, Y H:i:s') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- KPI CARDS SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Orders Today -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Orders Today</p>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $kpiData['total_orders_today'] }}</p>
                        </div>
                        <div class="text-4xl opacity-30">📦</div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Total: ₱{{ number_format($dailyOrdersTotal, 2) }}</p>
                </div>

                <!-- Pending Tasks -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Pending Tasks</p>
                            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $kpiData['pending_tasks'] }}</p>
                        </div>
                        <div class="text-4xl opacity-30">⏳</div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">{{ $kpiData['completed_tasks_today'] }} completed today</p>
                </div>

                <!-- Low Stock Items -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Low Stock Items</p>
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $kpiData['low_stock_items'] }}</p>
                        </div>
                        <div class="text-4xl opacity-30">⚠️</div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Needs reordering</p>
                </div>

                <!-- Pending Approvals -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Pending Approvals</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $kpiData['pending_approvals'] }}</p>
                        </div>
                        <div class="text-4xl opacity-30">✓</div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Awaiting action</p>
                </div>

                <!-- Delayed Deliveries -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Delayed Deliveries</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $kpiData['delayed_deliveries'] }}</p>
                        </div>
                        <div class="text-4xl opacity-30">🚚</div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Requires attention</p>
                </div>

                <!-- Unresolved Damages -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Unresolved Damages</p>
                            <p class="text-3xl font-bold text-pink-600 mt-2">{{ $kpiData['unresolved_damages'] }}</p>
                        </div>
                        <div class="text-4xl opacity-30">🔨</div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Under review</p>
                </div>

                <!-- Total Inventory Value -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Inventory Value</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">₱{{ number_format($kpiData['total_inventory_value'] ?? 0, 0) }}</p>
                        </div>
                        <div class="text-4xl opacity-30">💰</div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Total on hand</p>
                </div>

                <!-- Active Alerts -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Active Alerts</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalActiveAlerts }}</p>
                        </div>
                        <div class="text-4xl opacity-30">🔔</div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Inventory alerts</p>
                </div>
            </div>

            <!-- MAIN CONTENT GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                <!-- LEFT COLUMN: Daily Orders & Recent Orders -->
                <div class="lg:col-span-2">
                    <!-- Daily Order Summary -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">📋 Daily Order Summary</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">Today</span>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600 mb-1">Total Orders</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ $dailyOrdersCount }}</p>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600 mb-1">Total Amount</p>
                                    <p class="text-2xl font-bold text-green-600">₱{{ number_format($dailyOrdersTotal, 2) }}</p>
                                </div>
                                <div class="bg-purple-50 p-4 rounded-lg"> 
                                    <p class="text-sm text-gray-600 mb-1">Total Items</p>
                                    <p class="text-2xl font-bold text-purple-600">{{ $dailyOrdersItems }}</p>
                                </div>
                            </div>
                            
                            @if($recentOrders->isNotEmpty())
                                <div class="mt-4">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Recent Orders</h4>
                                    <div class="space-y-2 max-h-48 overflow-y-auto">
                                        @foreach($recentOrders->take(5) as $order)
                                            <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-800">{{ $order->order_code }}</p>
                                                    <p class="text-xs text-gray-500">{{ $order->order_date->format('M d, H:i') }}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-semibold text-gray-800">₱{{ number_format($order->total_amount, 2) }}</p>
                                                    <span class="inline-block px-2 py-1 text-xs font-medium rounded 
                                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                                        @else bg-red-100 text-red-800
                                                        @endif">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-center text-gray-500 py-4">No orders today</p>
                            @endif
                        </div>
                    </div>

                    <!-- Delivery Status Overview -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">🚚 Delivery Status Overview</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-5 gap-2">
                                <div class="text-center p-3 bg-gray-50 rounded-lg">
                                    <p class="text-2xl font-bold text-gray-800">{{ $deliveryStatusOverview['pending'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 mt-1">Pending</p>
                                </div>
                                <div class="text-center p-3 bg-blue-50 rounded-lg">
                                    <p class="text-2xl font-bold text-blue-600">{{ $deliveryStatusOverview['in_transit'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 mt-1">In Transit</p>
                                </div>
                                <div class="text-center p-3 bg-green-50 rounded-lg">
                                    <p class="text-2xl font-bold text-green-600">{{ $deliveryStatusOverview['delivered'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 mt-1">Delivered</p>
                                </div>
                                <div class="text-center p-3 bg-red-50 rounded-lg">
                                    <p class="text-2xl font-bold text-red-600">{{ $deliveryStatusOverview['delayed'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 mt-1">Delayed</p>
                                </div>
                                <div class="text-center p-3 bg-gray-100 rounded-lg">
                                    <p class="text-2xl font-bold text-gray-600">{{ $deliveryStatusOverview['cancelled'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 mt-1">Cancelled</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Alerts & Approvals -->
                <div>
                    <!-- Inventory Alerts -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">🔔 Inventory Alerts</h3>
                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $totalActiveAlerts }}</span>
                        </div>
                        <div class="p-4">
                            @if($inventoryAlerts->isNotEmpty())
                                <div class="space-y-2 max-h-60 overflow-y-auto">
                                    @foreach($inventoryAlerts as $alert)
                                        <div class="p-3 border-l-4 
                                            @if($alert->alert_type === 'low-stock') border-orange-500 bg-orange-50
                                            @elseif($alert->alert_type === 'out-of-stock') border-red-500 bg-red-50
                                            @else border-blue-500 bg-blue-50
                                            @endif rounded">
                                            <p class="text-sm font-semibold text-gray-800">{{ $alert->product_name }}</p>
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="text-xs text-gray-600">{{ ucfirst(str_replace('-', ' ', $alert->alert_type)) }}</span>
                                                <span class="text-xs font-bold 
                                                    @if($alert->alert_type === 'low-stock') text-orange-600
                                                    @elseif($alert->alert_type === 'out-of-stock') text-red-600
                                                    @else text-blue-600
                                                    @endif">{{ $alert->current_quantity }} units</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center text-gray-500 py-6">No active alerts</p>
                            @endif
                        </div>
                    </div>

                    <!-- Pending Approvals -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">✓ Pending Approvals</h3>
                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $totalPendingApprovals }}</span>
                        </div>
                        <div class="p-4">
                            @if($pendingApprovals->isNotEmpty())
                                <div class="space-y-2 max-h-60 overflow-y-auto">
                                    @foreach($pendingApprovals as $approval)
                                        <div class="p-3 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                                            <p class="text-sm font-semibold text-gray-800">{{ $approval->approval_code }}</p>
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="text-xs text-gray-600">{{ ucfirst(str_replace('-', ' ', $approval->approval_type)) }}</span>
                                                <span class="text-xs text-gray-500">{{ $approval->requested_date->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center text-gray-500 py-6">No pending approvals</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECOND ROW: Deliveries, Tasks, Damaged Items -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                <!-- Incoming Deliveries -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">📥 Incoming Deliveries</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $totalIncomingPending }}</span>
                    </div>
                    <div class="p-4">
                        @if($incomingDeliveries->isNotEmpty())
                            <div class="space-y-2 max-h-72 overflow-y-auto">
                                @foreach($incomingDeliveries as $delivery)
                                    <div class="p-3 bg-blue-50 border-l-4 border-blue-500 rounded">
                                        <p class="text-sm font-semibold text-gray-800">{{ $delivery->delivery_code }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $delivery->supplier_or_customer }}</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-600">{{ $delivery->items_count }} items</span>
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded bg-blue-200 text-blue-800">
                                                {{ ucfirst($delivery->status) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $delivery->scheduled_date->format('M d, H:i') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-6">No pending incoming deliveries</p>
                        @endif
                    </div>
                </div>

                <!-- Outgoing Deliveries -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">📤 Outgoing Deliveries</h3>
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $totalOutgoingPending }}</span>
                    </div>
                    <div class="p-4">
                        @if($outgoingDeliveries->isNotEmpty())
                            <div class="space-y-2 max-h-72 overflow-y-auto">
                                @foreach($outgoingDeliveries as $delivery)
                                    <div class="p-3 bg-green-50 border-l-4 border-green-500 rounded">
                                        <p class="text-sm font-semibold text-gray-800">{{ $delivery->delivery_code }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $delivery->supplier_or_customer }}</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-600">{{ $delivery->items_count }} items</span>
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded bg-green-200 text-green-800">
                                                {{ ucfirst($delivery->status) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $delivery->scheduled_date->format('M d, H:i') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-6">No pending outgoing deliveries</p>
                        @endif
                    </div>
                </div>

                <!-- Pending Warehouse Tasks -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">📋 Pending Tasks</h3>
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $totalPendingTasks }}</span>
                    </div>
                    <div class="p-4">
                        @if($pendingTasks->isNotEmpty())
                            <div class="space-y-2 max-h-72 overflow-y-auto">
                                @foreach($pendingTasks as $task)
                                    <div class="p-3 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                                        <p class="text-sm font-semibold text-gray-800">{{ $task->task_code }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ $task->item_name }}</p>
                                        <div class="flex justify-between items-center mt-2">
                                            <span class="text-xs text-gray-600">{{ $task->quantity }} qty</span>
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded bg-yellow-200 text-yellow-800">
                                                {{ $task->status }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-6">No pending tasks</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- THIRD ROW: Low Stock, Damaged Items -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                <!-- Low Stock Warning -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">⚠️ Low Stock Warning</h3>
                        <span class="bg-orange-100 text-orange-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $totalLowStockItems }}</span>
                    </div>
                    <div class="p-4">
                        @if($lowStockItems->isNotEmpty())
                            <div class="space-y-2 max-h-72 overflow-y-auto">
                                @foreach($lowStockItems as $item)
                                    <div class="p-3 bg-orange-50 border-l-4 border-orange-500 rounded">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">{{ $item->product_name }}</p>
                                                <p class="text-xs text-gray-600 mt-1">{{ $item->product_code }}</p>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center mt-2">
                                            <div class="flex-1">
                                                <div class="flex justify-between text-xs mb-1">
                                                    <span class="text-gray-600">Stock Level</span>
                                                    <span class="font-semibold">{{ $item->quantity_available }}/{{ $item->minimum_stock_level }}</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                    <div class="bg-orange-500 h-1.5 rounded-full" style="width: {{ min(($item->quantity_available / $item->minimum_stock_level) * 100, 100) }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-xs text-orange-600 mt-2 font-medium">Order qty: {{ $item->reorder_quantity }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-6">All items have sufficient stock</p>
                        @endif
                    </div>
                </div>

                <!-- Damaged Item Reports -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">🔨 Damaged Item Reports</h3>
                        <span class="bg-pink-100 text-pink-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $totalDamagedReports }}</span>
                    </div>
                    <div class="p-4">
                        @if($damagedItems->isNotEmpty())
                            <div class="space-y-2 max-h-72 overflow-y-auto">
                                @foreach($damagedItems as $item)
                                    <div class="p-3 bg-pink-50 border-l-4 border-pink-500 rounded">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800">{{ $item->report_code }}</p>
                                                <p class="text-xs text-gray-600 mt-1">{{ $item->product_name }}</p>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center mt-2">
                                            <div>
                                                <p class="text-xs text-gray-600">{{ $item->quantity_damaged }} units</p>
                                                <p class="text-xs text-gray-500">{{ ucfirst(str_replace('-', ' ', $item->damage_type)) }}</p>
                                            </div>
                                            <span class="inline-block px-2 py-1 text-xs font-medium rounded
                                                @if($item->status === 'reported') bg-red-200 text-red-800
                                                @elseif($item->status === 'under-review') bg-yellow-200 text-yellow-800
                                                @else bg-green-200 text-green-800
                                                @endif">
                                                {{ ucfirst(str_replace('-', ' ', $item->status)) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Reported: {{ $item->reported_date->format('M d, H:i') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 py-6">No damaged item reports</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- INVENTORY SUMMARY SECTION -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">📦 Inventory Summary</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-gray-800">{{ $inventorySummary['total_products'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-2">Total Products</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-blue-600">{{ $inventorySummary['total_quantity'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-2">Units On Hand</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-yellow-600">{{ $inventorySummary['total_reserved'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-2">Units Reserved</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-green-600">{{ $inventorySummary['total_available'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-2">Units Available</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-red-600">{{ $inventorySummary['out_of_stock'] ?? 0 }}</p>
                            <p class="text-sm text-gray-600 mt-2">Out of Stock</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
