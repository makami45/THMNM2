<?php
$cfg = require __DIR__ . '/config.php';

function getPDO()
{
    global $cfg;
    $host = $cfg['host'];
    $port = $cfg['port'];
    $dbname = $cfg['dbname'];
    $user = $cfg['user'];
    $pass = $cfg['pass'];

    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // If SSL CA file is provided, set MYSQL_ATTR_SSL_CA
    if (!empty($cfg['ssl_ca'])) {
        $ssl = $cfg['ssl_ca'];
        $ssl_path = null;

        // If the value is an existing file path, use it.
        if (file_exists($ssl)) {
            $ssl_path = $ssl;
        } elseif (strpos($ssl, '-----BEGIN CERTIFICATE-----') !== false) {
            // If the secret contains the PEM contents, write it to a temp file and use that path.
            $hash = substr(sha1($ssl), 0, 12);
            $tmp = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'db_ca_' . $hash . '.pem';
            if (!file_exists($tmp)) {
                file_put_contents($tmp, $ssl);
                @chmod($tmp, 0644);
            }
            $ssl_path = $tmp;
        } else {
            // Fallback: treat as a path (may fail later if invalid)
            $ssl_path = $ssl;
        }

        if ($ssl_path) {
            $options[PDO::MYSQL_ATTR_SSL_CA] = $ssl_path;
        }
    }

    return new PDO($dsn, $user, $pass, $options);
}
