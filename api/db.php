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
        $options[PDO::MYSQL_ATTR_SSL_CA] = $cfg['ssl_ca'];
    }

    return new PDO($dsn, $user, $pass, $options);
}
