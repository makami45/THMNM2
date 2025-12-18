<?php
// Database configuration. Replace with your actual cloud DB values.
return [
    // Hostname, e.g. mysqlstudent-longnhatyi-9f82.b.aivencloud.com
    'host' => 'mysqlstudent-longnhatyi-9f82.b.aivencloud.com',
    'port' => 11215,
    'dbname' => 'defaultdb',
    'user' => 'avnadmin',
    // DO NOT store real secrets in the repo. Replace with your password at runtime
    'pass' => 'REPLACE_PASSWORD',
    // Optional path to CA cert if your DB requires SSL (leave null to skip)
    'ssl_ca' => null,
];
