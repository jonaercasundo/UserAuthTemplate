<?php
$pdo = new PDO("sqlite:database/database.sqlite");

$tables = [
    "stock_receivings",
    "batch_trackings",
    "serial_number_trackings",
    "barcode_scans"
];

echo "Warehouse Data Seed Check:\n";
echo str_repeat("=", 50) . "\n";

foreach ($tables as $table) {
    try {
        $query = "SELECT COUNT(*) as count FROM $table";
        $result = $pdo->query($query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $count = $row["count"];
        echo "$table: $count records\n";
    } catch (Exception $e) {
        echo "$table: ERROR - " . $e->getMessage() . "\n";
    }
}

echo str_repeat("=", 50) . "\n";
?>
