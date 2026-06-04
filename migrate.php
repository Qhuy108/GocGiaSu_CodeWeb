<?php
require_once __DIR__ . '/core/Connect_DataBase.php';

$pdo = getDB();

try {
    $sql = "ALTER TABLE users 
            ADD COLUMN is_verified TINYINT(1) DEFAULT 0,
            ADD COLUMN verification_code VARCHAR(10) DEFAULT NULL,
            ADD COLUMN verification_expires_at DATETIME DEFAULT NULL";
    
    $pdo->exec($sql);
    echo "Database migrated successfully.\n";
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "Columns already exist. Skipping migration.\n";
    } else {
        echo "Migration failed: " . $e->getMessage() . "\n";
    }
}
