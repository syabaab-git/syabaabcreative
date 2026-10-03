<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require dirname(__DIR__) . '/vendor/autoload.php';

$app = require dirname(__DIR__) . '/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$app['config']->set('database.connections.sqlite.database', database_path('database.sqlite'));

$sqlite = DB::connection('sqlite');
$mysql = DB::connection('mysql');
$tables = $sqlite->select("SELECT name FROM sqlite_master WHERE type = 'table' AND name NOT LIKE 'sqlite_%' ORDER BY name");
$skipped = ['migrations'];
$totalRows = 0;

$mysql->statement('SET FOREIGN_KEY_CHECKS=0');

try {
    foreach ($tables as $tableRow) {
        $table = $tableRow->name;

        if (in_array($table, $skipped, true) || !Schema::connection('mysql')->hasTable($table)) {
            continue;
        }

        $rows = $sqlite->table($table)->get()->map(static fn ($row) => (array) $row)->all();
        $count = count($rows);

        if ($count > 0) {
            foreach (array_chunk($rows, 500) as $chunk) {
                $mysql->table($table)->insert($chunk);
            }
        }

        $totalRows += $count;
        echo sprintf("%s: %d rows\n", $table, $count);
    }
} finally {
    $mysql->statement('SET FOREIGN_KEY_CHECKS=1');
}

echo sprintf("Transferred: %d rows\n", $totalRows);
