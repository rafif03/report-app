<?php
try {
    $path = __DIR__ . '/../database/database.sqlite';
    $pdo = new PDO('sqlite:' . $path);
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
    $tables = $stmt ? $stmt->fetchAll(PDO::FETCH_COLUMN) : [];
    echo "Database file: $path\n\n";
    echo "Tables:\n";
    foreach ($tables as $t) {
        echo "- $t\n";
    }
    echo "\nRow counts:\n";
    $check = ['roles','users','monthly_car_targets','monthly_motor_targets','migrations','car_reports','motor_reports'];
    foreach ($check as $tbl) {
        try {
            $c = $pdo->query("SELECT count(*) FROM \"$tbl\"")->fetchColumn();
            echo "$tbl: $c\n";
        } catch (Exception $e) {
            echo "$tbl: (table not found)\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
