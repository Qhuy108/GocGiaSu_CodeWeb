<?php
/**
 * Kết nối database bằng PDO.
 * File này được require một lần duy nhất từ index.php.
 */

$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Bỏ qua comment
        if (strpos(trim($line), '#') === 0) continue;
        
        if (strpos($line, '=') !== false) {
            [$key, $val] = explode('=', $line, 2);
            $key = trim($key);
            $val = trim($val);
            
            // Loại bỏ dấu ngoặc kép hoặc đơn bao quanh giá trị
            if (preg_match('/^["\'](.*)["\']$/', $val, $matches)) {
                $val = $matches[1];
            }
            
            $_ENV[$key] = $val;
            putenv("$key=$val");
        }
    }
}

define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'DB_GocGiaSu');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST, DB_NAME, DB_CHARSET
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Trong môi trường production, KHÔNG hiện lỗi ra màn hình
            error_log('Lỗi kết nối database: ' . $e->getMessage());
            die(json_encode(['error' => 'Không thể kết nối cơ sở dữ liệu.']));
        }
    }

    return $pdo;
}
