    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\EmployeeController;
    use App\Http\Controllers\Operations\WarehouseController;
    use App\Http\Controllers\Operations\DashboardController;

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

    require __DIR__.'/auth.php';