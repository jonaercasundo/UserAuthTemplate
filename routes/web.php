    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\EmployeeController;
    use App\Http\Controllers\Operations\WarehouseController;
    use App\Http\Controllers\Operations\DashboardController;
    use App\Http\Controllers\Warehouse\WarehouseManagementController;
    use App\Http\Controllers\Warehouse\InventoryController;
    use App\Http\Controllers\Warehouse\ProductSettingsController;

    /*
    |--------------------------------------------------------------------------
    | Public Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return view('welcome');
    });

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Authenticated User Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth')->group(function () {

        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:Admin'])->group(function () {

        Route::get('/admin', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        /*
        | Employee Management
        */
        Route::prefix('employees')->group(function () {

            Route::get('/', [EmployeeController::class, 'index'])
                ->name('employee.index');

            Route::get('/register', [EmployeeController::class, 'create'])
                ->name('employee.register');

            Route::post('/register', [EmployeeController::class, 'store'])
                ->name('employee.store');

            Route::get('/{id}/edit', [EmployeeController::class, 'edit'])
                ->name('employee.edit');

            Route::put('/{id}', [EmployeeController::class, 'update'])
                ->name('employee.update');

            Route::patch('/{id}/toggle-status', [EmployeeController::class, 'toggleStatus'])
                ->name('employee.toggleStatus');
        });

        Route::get('/employees/export/csv', [EmployeeController::class, 'exportCsv'])
            ->name('employee.export.csv');
    });

    /*
    |--------------------------------------------------------------------------
    | OPERATIONS (Warehouse Staff + Admin)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', 'role:Operations'])
        ->prefix('operations')
        ->group(function () {

            Route::get('/', [DashboardController::class, 'index'])
                ->name('operations.dashboard');

            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('operation.dashboard');

            Route::get('/create', [WarehouseController::class, 'create'])
                ->name('warehouse.create');

            Route::post('/', [WarehouseController::class, 'store'])
                ->name('warehouse.store');
        });

    /*
    |--------------------------------------------------------------------------
    | WAREHOUSE MANAGEMENT (Warehouse Operations)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', 'role:Operations'])
        ->prefix('warehouse')
        ->group(function () {

            // Dashboard
            Route::get('/', [WarehouseManagementController::class, 'dashboard'])
                ->name('warehouse.dashboard');

            // Stock Receiving
            Route::prefix('receiving')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showReceiving'])
                    ->name('warehouse.receiving.index');
                Route::get('/create', [WarehouseManagementController::class, 'createReceiving'])
                    ->name('warehouse.receiving.create');
                Route::post('/', [WarehouseManagementController::class, 'storeReceiving'])
                    ->name('warehouse.receiving.store');
                Route::get('/{id}', [WarehouseManagementController::class, 'showReceivingDetail'])
                    ->name('warehouse.receiving.show');
                Route::post('/{id}/receive', [WarehouseManagementController::class, 'receiveItems'])
                    ->name('warehouse.receiving.receive');
                Route::post('/{id}/decline', [WarehouseManagementController::class, 'declineReceiving'])
                    ->name('warehouse.receiving.decline');
            });

            // Stock Release
            Route::prefix('release')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showRelease'])
                    ->name('warehouse.release.index');
                Route::get('/create', [WarehouseManagementController::class, 'createRelease'])
                    ->name('warehouse.release.create');
                Route::post('/', [WarehouseManagementController::class, 'storeRelease'])
                    ->name('warehouse.release.store');
                Route::get('/{id}', [WarehouseManagementController::class, 'showReleaseDetail'])
                    ->name('warehouse.release.show');
                Route::post('/{id}/process', [WarehouseManagementController::class, 'processRelease'])
                    ->name('warehouse.release.process');
            });

            // Warehouse Transfer
            Route::prefix('transfer')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showTransfer'])
                    ->name('warehouse.transfer.index');
                Route::get('/create', [WarehouseManagementController::class, 'createTransfer'])
                    ->name('warehouse.transfer.create');
            });

            // Item Pull Out
            Route::prefix('pullout')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showPullOut'])
                    ->name('warehouse.pullout.index');
                Route::get('/create', [WarehouseManagementController::class, 'createPullOut'])
                    ->name('warehouse.pullout.create');
            });

            // Stock Adjustment
            Route::prefix('adjustment')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showAdjustment'])
                    ->name('warehouse.adjustment.index');
                Route::get('/create', [WarehouseManagementController::class, 'createAdjustment'])
                    ->name('warehouse.adjustment.create');
            });

            // Cycle Counting
            Route::prefix('counting')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showCounting'])
                    ->name('warehouse.counting.index');
                Route::get('/create', [WarehouseManagementController::class, 'createCounting'])
                    ->name('warehouse.counting.create');
            });

            // Barcode Scanning
            Route::prefix('barcode')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showBarcodeScan'])
                    ->name('warehouse.barcode.index');
            });

            // QR Code Scanning
            Route::prefix('qrcode')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showQRCodeScan'])
                    ->name('warehouse.qrcode.index');
            });

            // Batch Tracking
            Route::prefix('batch')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showBatchTracking'])
                    ->name('warehouse.batch.index');
                Route::get('/{id}', [WarehouseManagementController::class, 'showBatchDetail'])
                    ->name('warehouse.batch.detail');
            });

            // Serial Number Tracking
            Route::prefix('serial')->group(function () {
                Route::get('/', [WarehouseManagementController::class, 'showSerialTracking'])
                    ->name('warehouse.serial.index');
                Route::get('/{id}', [WarehouseManagementController::class, 'showSerialDetail'])
                    ->name('warehouse.serial.detail');
            });

            // Inventory Management
            Route::prefix('inventory')->group(function () {
                Route::get('/', [InventoryController::class, 'index'])
                    ->name('warehouse.inventory.index');
                Route::get('/create', [InventoryController::class, 'create'])
                    ->name('warehouse.inventory.create');
                Route::post('/', [InventoryController::class, 'store'])
                    ->name('warehouse.inventory.store');
                Route::get('/{id}', [InventoryController::class, 'show'])
                    ->name('warehouse.inventory.show');
                Route::get('/{id}/edit', [InventoryController::class, 'edit'])
                    ->name('warehouse.inventory.edit');
                Route::put('/{id}', [InventoryController::class, 'update'])
                    ->name('warehouse.inventory.update');
                Route::post('/{id}/import-costs', [InventoryController::class, 'importCosts'])
                    ->name('warehouse.inventory.importCosts');
                Route::delete('/{id}', [InventoryController::class, 'destroy'])
                    ->name('warehouse.inventory.destroy');
            });

            // Settings
            Route::prefix('settings')->group(function () {
                Route::get('/products', [ProductSettingsController::class, 'index'])
                    ->name('warehouse.settings.products');
                Route::post('/products', [ProductSettingsController::class, 'store'])
                    ->name('warehouse.settings.products.store');
                Route::put('/products/{id}', [ProductSettingsController::class, 'update'])
                    ->name('warehouse.settings.products.update');
                Route::delete('/products/{id}', [ProductSettingsController::class, 'destroy'])
                    ->name('warehouse.settings.products.destroy');
                // Suppliers
                Route::get('/suppliers', [\App\Http\Controllers\Warehouse\SupplierController::class, 'index'])
                    ->name('warehouse.settings.suppliers');
                Route::post('/suppliers', [\App\Http\Controllers\Warehouse\SupplierController::class, 'store'])
                    ->name('warehouse.settings.suppliers.store');
                Route::get('/suppliers/{id}/edit', [\App\Http\Controllers\Warehouse\SupplierController::class, 'edit'])
                    ->name('warehouse.settings.suppliers.edit');
                Route::get('/suppliers/{id}', [\App\Http\Controllers\Warehouse\SupplierController::class, 'show'])
                    ->name('warehouse.settings.suppliers.show');
                Route::post('/suppliers/{id}/products', [\App\Http\Controllers\Warehouse\SupplierController::class, 'storeProduct'])
                    ->name('warehouse.settings.suppliers.products.store');
                Route::put('/suppliers/{id}', [\App\Http\Controllers\Warehouse\SupplierController::class, 'update'])
                    ->name('warehouse.settings.suppliers.update');
                Route::delete('/suppliers/{id}', [\App\Http\Controllers\Warehouse\SupplierController::class, 'destroy'])
                    ->name('warehouse.settings.suppliers.destroy');
            });
        });

    require __DIR__.'/auth.php';