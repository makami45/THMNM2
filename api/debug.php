<?php
// debug endpoint removed by project owner.
http_response_code(410);
header('Content-Type: application/json; charset=utf-8');
echo json_encode(['ok' => false, 'error' => 'debug endpoint removed']);
