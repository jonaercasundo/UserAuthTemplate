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
use App\Models\SerialNumberTracking;
use App\Models\SerialScanHistory;
use Illuminate\Http\Request;

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
        $receivings = StockReceiving::orderBy('created_at', 'desc')->paginate(10);
        return view('warehouse.receiving.index', ['receivings' => $receivings]);
    }

    public function createReceiving()
    {
        return view('warehouse.receiving.create');
    }

    // Stock Release
    public function showRelease()
    {
        $releases = StockRelease::orderBy('created_at', 'desc')->paginate(10);
        return view('warehouse.release.index', ['releases' => $releases]);
    }

    public function createRelease()
    {
        return view('warehouse.release.create');
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
