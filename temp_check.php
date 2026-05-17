<?php
$pdo = new PDO('sqlite:database/database.sqlite');
$query = "SELECT name FROM sqlite_master WHERE type='table'";
$result = $pdo->query($query);
$tables = $result->fetchAll(PDO::FETCH_COLUMN);
echo "Database Tables:\n";
foreach ($tables as $table) {
    echo "  - $table\n";
}
