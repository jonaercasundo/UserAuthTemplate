<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$result = [
    'receiving_details_supplier_id' => \Illuminate\Support\Facades\Schema::hasColumn('receiving_details','supplier_id'),
    'release_details_supplier_id' => \Illuminate\Support\Facades\Schema::hasColumn('release_details','supplier_id'),
];
echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
