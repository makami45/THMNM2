<?php
header('Content-Type: application/json; charset=utf-8');

$cfg = null;
if (file_exists(__DIR__ . '/config.local.php')) {
    $cfg = require __DIR__ . '/config.local.php';
} else {
    $cfg = require __DIR__ . '/config.php';
}

try {
    $host = $cfg['host'] ?? 'localhost';
    $port = $cfg['port'] ?? 3306;
    $dbname = $cfg['dbname'] ?? null;
    $user = $cfg['user'] ?? null;
    $pass = $cfg['pass'] ?? null;

    if (!$user) throw new Exception('DB user not configured');

    $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";
    if ($dbname) $dsn .= ";dbname={$dbname}";

    $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    if (!empty($cfg['ssl_ca'])) {
        if (file_exists($cfg['ssl_ca'])) {
            $opts[PDO::MYSQL_ATTR_SSL_CA] = $cfg['ssl_ca'];
        } elseif (strpos($cfg['ssl_ca'], '-----BEGIN') !== false) {
            $tmp = sys_get_temp_dir() . '/debug_ca.pem';
            file_put_contents($tmp, $cfg['ssl_ca']);
            $opts[PDO::MYSQL_ATTR_SSL_CA] = $tmp;
        }
    }

    $pdo = new PDO($dsn, $user, $pass, $opts);

    // Quick test query
    $stmt = $pdo->query('SELECT 1 as ok');
    $row = $stmt->fetch();

    echo json_encode(['ok' => true, 'db_test' => $row]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => $e->getMessage(),
        'type' => get_class($e),
    ]);
}
