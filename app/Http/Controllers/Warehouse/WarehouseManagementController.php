<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\StockReceiving;
use App\Models\ReceivingDetail;
use App\Models\StockRelease;
use App\Models\ReleaseDetail;
use App\Models\WarehouseTransfer;
use App\Models\TransferDetail;
use App\Models\ItemPullOut;
use App\Models\PullOutDetail;
use App\Models\StockAdjustment;
use App\Models\CycleCounting;
use App\Models\CountDetail;
use App\Models\BarcodeScan;
use App\Models\QRCodeScan;
use App\Models\BatchTracking;
use App\Models\BatchTrackingHistory;
use App\Models\Inventory;
use App\Models\SerialNumberTracking;
use App\Models\SerialScanHistory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseManagementController extends Controller
{
    /**
     * Show the warehouse management dashboard
     */
    public function dashboard()
    {
        $stats = [
            'pending_receivings' => StockReceiving::where('status', 'pending')->count(),
            'pending_releases' => StockRelease::where('status', 'pending')->count(),
            'pending_transfers' => WarehouseTransfer::where('status', 'pending')->count(),
            'pending_pullouts' => ItemPullOut::where('status', 'pending')->count(),
            'pending_adjustments' => StockAdjustment::where('status', 'pending')->count(),
            'active_counts' => CycleCounting::where('status', 'in-progress')->count(),
            'today_scans' => BarcodeScan::whereDate('scan_date', today())->count(),
            'total_batches' => BatchTracking::where('status', 'active')->count(),
            'tracked_serials' => SerialNumberTracking::where('status', 'in-warehouse')->count(),
        ];

        // Recent activities
        $recentReceivings = StockReceiving::orderBy('created_at', 'desc')->take(5)->get();
        $recentReleases = StockRelease::orderBy('created_at', 'desc')->take(5)->get();
        $recentTransfers = WarehouseTransfer::orderBy('created_at', 'desc')->take(5)->get();
        $recentAdjustments = StockAdjustment::orderBy('created_at', 'desc')->take(5)->get();

        return view('warehouse.dashboard', [
            'stats' => $stats,
            'recentReceivings' => $recentReceivings,
            'recentReleases' => $recentReleases,
            'recentTransfers' => $recentTransfers,
            'recentAdjustments' => $recentAdjustments,
        ]);
    }

    // Stock Receiving
    public function showReceiving()
    {
        $receivings = StockReceiving::withCount('receivingDetails')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('warehouse.receiving.index', ['receivings' => $receivings]);
    }

    public function createReceiving()
    {
        $inventoryProducts = Inventory::with('supplier')
            ->orderBy('product_name')
            ->get(['product_code', 'product_name', 'supplier_id']);

        $suppliers = Supplier::orderBy('name')->get(['id', 'name']);

        return view('warehouse.receiving.create', [
            'inventoryProducts' => $inventoryProducts,
            'suppliers' => $suppliers,
        ]);
    }

    public function showReceivingDetail($id)
    {
        $receiving = StockReceiving::with('receivingDetails')
            ->findOrFail($id);

        $totalCost = $receiving->receivingDetails->sum(function ($detail) {
            return ($detail->unit_price ?? 0) * ($detail->quantity_received ?? 0);
        });

        return view('warehouse.receiving.show', [
            'receiving' => $receiving,
            'totalCost' => $totalCost,
        ]);
    }

    public function receiveItems(Request $request, $id)
    {
        $receiving = StockReceiving::with('receivingDetails')
            ->findOrFail($id);

        if ($receiving->status !== 'pending') {
            return redirect()->route('warehouse.receiving.show', $receiving->id)
                ->with('warning', 'Only pending receivings can be received.');
        }

        DB::transaction(function () use ($receiving) {
            foreach ($receiving->receivingDetails as $detail) {
                $inventory = Inventory::where('product_code', $detail->product_code)->first();

                $recvQty = (int) ($detail->quantity_received ?? 0);
                $recvPrice = (float) ($detail->unit_price ?? 0);

                if ($inventory) {
                    $existingQty = (int) $inventory->quantity_on_hand;
                    $existingPrice = (float) ($inventory->unit_price ?? 0);

                    $newQty = $existingQty + $recvQty;

                    if ($newQty > 0) {
                        $newUnitPrice = (($existingQty * $existingPrice) + ($recvQty * $recvPrice)) / $newQty;
                    } else {
                        $newUnitPrice = $existingPrice;
                    }

                    $inventory->quantity_on_hand = $newQty;
                    $inventory->quantity_available += $recvQty;
                    $inventory->unit_price = $newUnitPrice;
                    $inventory->last_updated = now();
                    $inventory->save();
                } else {
                    Inventory::create([
                        'product_code' => $detail->product_code,
                        'product_name' => $detail->product_name,
                        'quantity_on_hand' => $recvQty,
                        'quantity_reserved' => 0,
                        'quantity_available' => $recvQty,
                        'minimum_stock_level' => 0,
                        'reorder_quantity' => 0,
                        'unit_price' => $recvPrice,
                        'last_updated' => now(),
                    ]);
                }

                $detail->update([
                    'status' => 'received',
                ]);
            }

            $receiving->update([
                'status' => 'completed',
            ]);
        });

        return redirect()->route('warehouse.receiving.show', $receiving->id)
            ->with('success', 'Receiving has been completed and inventory updated.');
    }

    public function declineReceiving(Request $request, $id)
    {
        $receiving = StockReceiving::findOrFail($id);

        if ($receiving->status !== 'pending') {
            return redirect()->route('warehouse.receiving.show', $receiving->id)
                ->with('warning', 'Only pending receivings can be declined.');
        }

        $receiving->update([
            'status' => 'declined',
        ]);

        return redirect()->route('warehouse.receiving.show', $receiving->id)
            ->with('success', 'Receiving has been declined.');
    }

    public function storeReceiving(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_number' => 'nullable|string',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_code' => 'required|string',
            'items.*.product_name' => 'required|string',
            'items.*.supplier_id' => 'nullable|exists:suppliers,id',
            'items.*.quantity_ordered' => 'required|integer|min:0',
            'items.*.quantity_received' => 'required|integer|min:0',
            'items.*.batch_number' => 'nullable|string',
            'items.*.expiry_date' => 'nullable|date',
            'items.*.unit_price' => 'nullable|numeric|min:0',
        ]);

        // Generate unique receiving code
        $receiving_code = 'RCV-' . date('YmdHis') . '-' . rand(1000, 9999);

        // Calculate totals
        $totalItems = count($validated['items']);
        $totalQuantity = array_sum(array_column($validated['items'], 'quantity_received'));

        // Create receiving record
        $receiving = StockReceiving::create([
            'receiving_code' => $receiving_code,
            'purchase_order_number' => $validated['purchase_order_number'] ?? null,
            'supplier_id' => $validated['supplier_id'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'received_by' => auth()->id(),
            'receiving_date' => now(),
            'total_items' => $totalItems,
            'total_quantity' => $totalQuantity,
        ]);

        // Create receiving details
        foreach ($validated['items'] as $item) {
            ReceivingDetail::create([
                'stock_receiving_id' => $receiving->id,
                'product_code' => $item['product_code'],
                'product_name' => $item['product_name'],
                'supplier_id' => $item['supplier_id'] ?? null,
                'quantity_ordered' => $item['quantity_ordered'] ?? 0,
                'quantity_received' => $item['quantity_received'] ?? 0,
                'batch_number' => $item['batch_number'] ?? null,
                'expiry_date' => $item['expiry_date'] ?? null,
                'unit_price' => $item['unit_price'] ?? null,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('warehouse.receiving.index')
            ->with('success', 'Stock receiving created successfully with ' . $totalItems . ' item(s)!');
    }

    // Stock Release
    public function showRelease()
    {
        $releases = StockRelease::orderBy('created_at', 'desc')->paginate(10);
        return view('warehouse.release.index', ['releases' => $releases]);
    }

    public function createRelease()
    {
        $inventoryProducts = Inventory::with('supplier')
            ->orderBy('product_name')
            ->get(['product_code', 'product_name', 'supplier_id']);

        return view('warehouse.release.create', [
            'inventoryProducts' => $inventoryProducts,
        ]);
    }

    public function storeRelease(Request $request)
    {
        $validated = $request->validate([
            'release_type' => 'required|in:customer-order,internal-use,return,disposal',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_code' => 'required|string',
            'items.*.product_name' => 'required|string',
            'items.*.supplier_id' => 'nullable|exists:suppliers,id',
            'items.*.quantity_to_release' => 'required|integer|min:0',
            'items.*.batch_number' => 'nullable|string',
            'items.*.serial_number' => 'nullable|string',
            'items.*.notes' => 'nullable|string',
        ]);

        $releaseCode = 'RLS-' . date('YmdHis') . '-' . rand(1000, 9999);
        $totalItems = count($validated['items']);
        $totalQuantity = array_sum(array_column($validated['items'], 'quantity_to_release'));

        $release = StockRelease::create([
            'release_code' => $releaseCode,
            'release_type' => $validated['release_type'],
            'reference_number' => $validated['reference_number'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'released_by' => auth()->id(),
            'release_date' => now(),
            'total_items' => $totalItems,
            'total_quantity' => $totalQuantity,
        ]);

        foreach ($validated['items'] as $item) {
            ReleaseDetail::create([
                'stock_release_id' => $release->id,
                'product_code' => $item['product_code'],
                'product_name' => $item['product_name'],
                'supplier_id' => $item['supplier_id'] ?? null,
                'quantity_to_release' => $item['quantity_to_release'],
                'quantity_released' => 0,
                'batch_number' => $item['batch_number'] ?? null,
                'serial_number' => $item['serial_number'] ?? null,
                'status' => 'pending',
                'notes' => $item['notes'] ?? null,
            ]);
        }

        return redirect()->route('warehouse.release.index')
            ->with('success', 'Stock release created successfully with ' . $totalItems . ' item(s).');
    }

    public function showReleaseDetail($id)
    {
        $release = StockRelease::with('releaseDetails')
            ->findOrFail($id);

        return view('warehouse.release.show', [
            'release' => $release,
        ]);
    }

    public function processRelease(Request $request, $id)
    {
        $release = StockRelease::with('releaseDetails')
            ->findOrFail($id);

        if ($release->status !== 'pending') {
            return redirect()->route('warehouse.release.show', $release->id)
                ->with('warning', 'Only pending releases can be processed.');
        }

        $insufficient = $release->releaseDetails->filter(function ($detail) {
            $inventory = Inventory::where('product_code', $detail->product_code)->first();
            return !$inventory || $inventory->quantity_available < $detail->quantity_to_release;
        });

        if ($insufficient->isNotEmpty()) {
            return redirect()->route('warehouse.release.show', $release->id)
                ->with('warning', 'Some items do not have enough available stock to release.');
        }

        DB::transaction(function () use ($release) {
            foreach ($release->releaseDetails as $detail) {
                $inventory = Inventory::where('product_code', $detail->product_code)->first();
                $inventory->quantity_on_hand -= $detail->quantity_to_release;
                $inventory->quantity_available -= $detail->quantity_to_release;
                $inventory->last_updated = now();
                $inventory->save();

                $detail->update([
                    'quantity_released' => $detail->quantity_to_release,
                    'status' => 'released',
                ]);
            }

            $release->update([
                'status' => 'released',
            ]);
        });

        return redirect()->route('warehouse.release.show', $release->id)
            ->with('success', 'Release processed successfully and inventory updated.');
    }

    // Warehouse Transfer
    public function showTransfer()
    {
        $transfers = WarehouseTransfer::orderBy('created_at', 'desc')->paginate(10);
        return view('warehouse.transfer.index', ['transfers' => $transfers]);
    }

    public function createTransfer()
    {
        return view('warehouse.transfer.create');
    }

    // Item Pull Out
    public function showPullOut()
    {
        $pullouts = ItemPullOut::orderBy('created_at', 'desc')->paginate(10);
        return view('warehouse.pullout.index', ['pullouts' => $pullouts]);
    }

    public function createPullOut()
    {
        return view('warehouse.pullout.create');
    }

    // Stock Adjustment
    public function showAdjustment()
    {
        $adjustments = StockAdjustment::orderBy('created_at', 'desc')->paginate(10);
        return view('warehouse.adjustment.index', ['adjustments' => $adjustments]);
    }

    public function createAdjustment()
    {
        return view('warehouse.adjustment.create');
    }

    // Cycle Counting
    public function showCounting()
    {
        $counts = CycleCounting::orderBy('created_at', 'desc')->paginate(10);
        return view('warehouse.counting.index', ['counts' => $counts]);
    }

    public function createCounting()
    {
        return view('warehouse.counting.create');
    }

    // Barcode Scanning
    public function showBarcodeScan()
    {
        $scans = BarcodeScan::orderBy('scan_date', 'desc')->paginate(15);
        $todayScans = BarcodeScan::whereDate('scan_date', today())->count();
        $successfulScans = BarcodeScan::where('status', 'success')->whereDate('scan_date', today())->count();
        $errorScans = BarcodeScan::where('status', 'error')->whereDate('scan_date', today())->count();
        
        return view('warehouse.barcode.index', [
            'scans' => $scans,
            'todayScans' => $todayScans,
            'successfulScans' => $successfulScans,
            'errorScans' => $errorScans,
        ]);
    }

    // QR Code Scanning
    public function showQRCodeScan()
    {
        $scans = QRCodeScan::orderBy('scan_date', 'desc')->paginate(15);
        $todayScans = QRCodeScan::whereDate('scan_date', today())->count();
        $successfulScans = QRCodeScan::where('status', 'success')->whereDate('scan_date', today())->count();
        $invalidScans = QRCodeScan::where('status', 'invalid')->whereDate('scan_date', today())->count();
        
        return view('warehouse.qrcode.index', [
            'scans' => $scans,
            'todayScans' => $todayScans,
            'successfulScans' => $successfulScans,
            'invalidScans' => $invalidScans,
        ]);
    }

    // Batch Tracking
    public function showBatchTracking()
    {
        $batches = BatchTracking::where('status', '!=', 'exhausted')
            ->orderBy('expiry_date', 'asc')
            ->paginate(10);
        
        $expiredBatches = BatchTracking::where('status', 'expired')->count();
        $activeBatches = BatchTracking::where('status', 'active')->count();
        $expiringBatches = BatchTracking::whereDate('expiry_date', '<=', now()->addDays(30))
            ->where('status', 'active')
            ->count();
        
        return view('warehouse.batch.index', [
            'batches' => $batches,
            'expiredBatches' => $expiredBatches,
            'activeBatches' => $activeBatches,
            'expiringBatches' => $expiringBatches,
        ]);
    }

    public function showBatchDetail($id)
    {
        $batch = BatchTracking::findOrFail($id);
        $history = BatchTrackingHistory::where('batch_tracking_id', $id)
            ->orderBy('action_date', 'desc')
            ->get();
        
        return view('warehouse.batch.detail', [
            'batch' => $batch,
            'history' => $history,
        ]);
    }

    // Serial Number Tracking
    public function showSerialTracking()
    {
        $serials = SerialNumberTracking::where('status', 'in-warehouse')
            ->orderBy('received_date', 'desc')
            ->paginate(10);
        
        $inWarehouse = SerialNumberTracking::where('status', 'in-warehouse')->count();
        $released = SerialNumberTracking::where('status', 'released')->count();
        $damaged = SerialNumberTracking::where('status', 'damaged')->count();
        $lost = SerialNumberTracking::where('status', 'lost')->count();
        
        return view('warehouse.serial.index', [
            'serials' => $serials,
            'inWarehouse' => $inWarehouse,
            'released' => $released,
            'damaged' => $damaged,
            'lost' => $lost,
        ]);
    }

    public function showSerialDetail($id)
    {
        $serial = SerialNumberTracking::findOrFail($id);
        $scanHistory = SerialScanHistory::where('serial_number_tracking_id', $id)
            ->orderBy('scan_date', 'desc')
            ->get();
        
        return view('warehouse.serial.detail', [
            'serial' => $serial,
            'scanHistory' => $scanHistory,
        ]);
    }
}
