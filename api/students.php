<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

try {
    $pdo = getPDO();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'DB connection failed', 'details' => $e->getMessage()]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// Allow simple CORS for testing (remove/adjust in production)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($method === 'OPTIONS') exit;

function getInputJson() {
    $raw = file_get_contents('php://input');
    return json_decode($raw, true);
}

if ($method === 'GET') {
    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $stmt = $pdo->prepare('SELECT id, email, name FROM student WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if ($row) echo json_encode($row);
        else { http_response_code(404); echo json_encode(['error' => 'Not found']); }
        exit;
    }
    $stmt = $pdo->query('SELECT id, email, name FROM student ORDER BY id');
    $rows = $stmt->fetchAll();
    echo json_encode($rows);
    exit;
}

if ($method === 'POST') {
    $data = getInputJson();
    if (empty($data['email']) || empty($data['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'email and name required']);
        exit;
    }
    $stmt = $pdo->prepare('INSERT INTO student (email, name) VALUES (?, ?)');
    $stmt->execute([$data['email'], $data['name']]);
    $id = $pdo->lastInsertId();
    http_response_code(201);
    echo json_encode(['id' => (int)$id, 'email' => $data['email'], 'name' => $data['name']]);
    exit;
}

if ($method === 'PUT') {
    $data = getInputJson();
    if (empty($data['id']) || empty($data['email']) || empty($data['name'])) {
        http_response_code(400);
        echo json_encode(['error' => 'id, email and name required']);
        exit;
    }
    $stmt = $pdo->prepare('UPDATE student SET email = ?, name = ? WHERE id = ?');
    $stmt->execute([$data['email'], $data['name'], (int)$data['id']]);
    echo json_encode(['ok' => true]);
    exit;
}

if ($method === 'DELETE') {
    // Accept id by query or JSON
    $id = null;
    if (isset($_GET['id'])) $id = (int)$_GET['id'];
    else {
        $data = getInputJson();
        if (!empty($data['id'])) $id = (int)$data['id'];
    }
    if (!$id) { http_response_code(400); echo json_encode(['error'=>'id required']); exit; }
    $stmt = $pdo->prepare('DELETE FROM student WHERE id = ?');
    $stmt->execute([$id]);
    echo json_encode(['ok' => true]);
    exit;
}

http_response_code(405);
echo json_encode(['error' => 'Method not allowed']);
