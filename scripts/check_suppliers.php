<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$result = [
    'has_suppliers' => \Illuminate\Support\Facades\Schema::hasTable('suppliers'),
    'has_supplier_col' => \Illuminate\Support\Facades\Schema::hasColumn('inventories','supplier_id'),
];
echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
