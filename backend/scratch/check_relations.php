<?php
$host = 'ep-odd-sunset-adjqvh29.c-2.us-east-1.aws.neon.tech';
$port = '5432';
$database = 'neondb';
$user = 'neondb_owner';
$password = 'npg_f2oEKZR1MJGA';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname='$database';sslmode=require;options='endpoint=ep-odd-sunset-adjqvh29'";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    // Query pg_class
    $stmt = $pdo->query("
        SELECT c.relname, c.relkind, n.nspname 
        FROM pg_class c 
        JOIN pg_namespace n ON n.oid = c.relnamespace 
        WHERE n.nspname = 'public' 
        ORDER BY c.relkind, c.relname
    ");
    
    echo "RELATIONS IN PUBLIC SCHEMA:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $type = 'unknown';
        switch ($row['relkind']) {
            case 'r': $type = 'table'; break;
            case 'i': $type = 'index'; break;
            case 'S': $type = 'sequence'; break;
            case 'v': $type = 'view'; break;
            case 'm': $type = 'materialized view'; break;
            case 'c': $type = 'composite type'; break;
            case 't': $type = 'toast table'; break;
            case 'p': $type = 'partitioned table'; break;
            case 'I': $type = 'partitioned index'; break;
        }
        echo "  - Name: {$row['relname']} | Type: $type\n";
    }
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
