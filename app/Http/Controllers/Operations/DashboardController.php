<?php

namespace App\Http\Controllers\Operations;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WarehouseTask;
use App\Models\Order;
use App\Models\Inventory;
use App\Models\Delivery;
use App\Models\DamagedItem;
use App\Models\Approval;
use App\Models\InventoryAlert;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the operations dashboard with all features
     */
    public function index()
    {
        $user = Auth::user();

        // Daily Order Summary
        $dailyOrders = Order::whereDate('order_date', today())->get();
        $dailyOrdersCount = $dailyOrders->count();
        $dailyOrdersTotal = $dailyOrders->sum('total_amount');
        $dailyOrdersItems = $dailyOrders->sum('total_items');

        // Pending Warehouse Tasks
        $pendingTasks = WarehouseTask::where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $totalPendingTasks = WarehouseTask::where('status', 'Pending')->count();

        // Inventory Alerts
        $inventoryAlerts = InventoryAlert::where('status', 'active')
            ->orderBy('alert_date', 'desc')
            ->take(5)
            ->get();
        $totalActiveAlerts = InventoryAlert::where('status', 'active')->count();

        // Incoming Deliveries
        $incomingDeliveries = Delivery::where('type', 'incoming')
            ->where('status', '!=', 'delivered')
            ->orderBy('scheduled_date', 'asc')
            ->take(5)
            ->get();
        $totalIncomingPending = Delivery::where('type', 'incoming')
            ->where('status', '!=', 'delivered')
            ->count();

        // Outgoing Deliveries
        $outgoingDeliveries = Delivery::where('type', 'outgoing')
            ->where('status', '!=', 'delivered')
            ->orderBy('scheduled_date', 'asc')
            ->take(5)
            ->get();
        $totalOutgoingPending = Delivery::where('type', 'outgoing')
            ->where('status', '!=', 'delivered')
            ->count();

        // Low Stock Warning
        $lowStockItems = Inventory::whereRaw('quantity_available <= minimum_stock_level')
            ->orderBy('quantity_available', 'asc')
            ->take(5)
            ->get();
        $totalLowStockItems = Inventory::whereRaw('quantity_available <= minimum_stock_level')->count();

        // Damaged Item Reports
        $damagedItems = DamagedItem::where('status', '!=', 'resolved')
            ->orderBy('reported_date', 'desc')
            ->take(5)
            ->get();
        $totalDamagedReports = DamagedItem::where('status', '!=', 'resolved')->count();

        // Pending Approvals
        $pendingApprovals = Approval::where('status', 'pending')
            ->orderBy('requested_date', 'desc')
            ->take(5)
            ->get();
        $totalPendingApprovals = Approval::where('status', 'pending')->count();

        // Delivery Status Overview
        $deliveryStatusOverview = [
            'pending' => Delivery::where('status', 'pending')->count(),
            'in_transit' => Delivery::where('status', 'in-transit')->count(),
            'delivered' => Delivery::where('status', 'delivered')->count(),
            'delayed' => Delivery::where('status', 'delayed')->count(),
            'cancelled' => Delivery::where('status', 'cancelled')->count(),
        ];

        // KPI Cards Data
        $kpiData = [
            'total_orders_today' => Order::whereDate('order_date', today())->count(),
            'pending_tasks' => WarehouseTask::where('status', 'Pending')->count(),
            'completed_tasks_today' => WarehouseTask::where('status', 'Completed')
                ->whereDate('created_at', today())
                ->count(),
            'low_stock_items' => Inventory::whereRaw('quantity_available <= minimum_stock_level')->count(),
            'delayed_deliveries' => Delivery::where('status', 'delayed')->count(),
            'total_inventory_value' => Inventory::sum(DB::raw('quantity_on_hand * unit_price')),
            'pending_approvals' => Approval::where('status', 'pending')->count(),
            'unresolved_damages' => DamagedItem::where('status', '!=', 'resolved')->count(),
        ];

        // Recent Orders
        $recentOrders = Order::orderBy('order_date', 'desc')
            ->take(10)
            ->get();

        // Inventory Summary
        $inventorySummary = [
            'total_products' => Inventory::count(),
            'total_quantity' => Inventory::sum('quantity_on_hand'),
            'total_reserved' => Inventory::sum('quantity_reserved'),
            'total_available' => Inventory::sum('quantity_available'),
            'out_of_stock' => Inventory::where('quantity_available', '<=', 0)->count(),
        ];

        return view('operations.dashboard', [
            // Daily Orders
            'dailyOrdersCount' => $dailyOrdersCount,
            'dailyOrdersTotal' => $dailyOrdersTotal,
            'dailyOrdersItems' => $dailyOrdersItems,
            'recentOrders' => $recentOrders,

            // Pending Warehouse Tasks
            'pendingTasks' => $pendingTasks,
            'totalPendingTasks' => $totalPendingTasks,

            // Inventory Alerts
            'inventoryAlerts' => $inventoryAlerts,
            'totalActiveAlerts' => $totalActiveAlerts,

            // Incoming Deliveries
            'incomingDeliveries' => $incomingDeliveries,
            'totalIncomingPending' => $totalIncomingPending,

            // Outgoing Deliveries
            'outgoingDeliveries' => $outgoingDeliveries,
            'totalOutgoingPending' => $totalOutgoingPending,

            // Low Stock Warning
            'lowStockItems' => $lowStockItems,
            'totalLowStockItems' => $totalLowStockItems,

            // Damaged Items
            'damagedItems' => $damagedItems,
            'totalDamagedReports' => $totalDamagedReports,

            // Pending Approvals
            'pendingApprovals' => $pendingApprovals,
            'totalPendingApprovals' => $totalPendingApprovals,

            // Delivery Status Overview
            'deliveryStatusOverview' => $deliveryStatusOverview,

            // KPI Data
            'kpiData' => $kpiData,

            // Inventory Summary
            'inventorySummary' => $inventorySummary,
        ]);
    }
}
