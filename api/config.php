<?php
// Allow a local override for development (api/config.local.php)
if (file_exists(__DIR__ . '/config.local.php')) {
    return require __DIR__ . '/config.local.php';
}

// Database configuration using environment variables.
// The code reads these environment variables (recommended):
//  DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS, DB_SSL_CA
// If the env var is missing, a sensible fallback is used.

$getenv = function($name, $default = null) {
    $val = getenv($name);
    if ($val !== false) return $val;
    if (isset($_SERVER[$name]) && $_SERVER[$name] !== '') return $_SERVER[$name];
    return $default;
};

return [
    'host' => $getenv('DB_HOST', '127.0.0.1'),
    'port' => (int)$getenv('DB_PORT', 3306),
    'dbname' => $getenv('DB_NAME', 'student_db'),
    'user' => $getenv('DB_USER', 'root'),
    'pass' => $getenv('DB_PASS', ''),
    // No SSL CA by default for local WAMP development.
    'ssl_ca' => null,
];

