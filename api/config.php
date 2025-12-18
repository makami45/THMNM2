<?php
// Database configuration. Replace with your actual cloud DB values.
return [
    // Hostname, e.g. mysqlstudent-longnhatyi-9f82.b.aivencloud.com
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
        'host' => $getenv('DB_HOST', 'mysqlstudent-longnhatyi-9f82.b.aivencloud.com'),
        'port' => (int)$getenv('DB_PORT', 11215),
        'dbname' => $getenv('DB_NAME', 'defaultdb'),
        'user' => $getenv('DB_USER', 'avnadmin'),
        'pass' => $getenv('DB_PASS', 'REPLACE_PASSWORD'),
        // If a local ca.pem exists in the api folder, prefer it. Otherwise allow env var path or null.
        'ssl_ca' => $getenv('DB_SSL_CA', null),
    ];

];
