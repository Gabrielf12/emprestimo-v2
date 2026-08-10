<?php
// api/check_status.php
header('Content-Type: application/json');
require_once '../db_config.php';

$pedido_id = $_GET['pedido_id'] ?? null;

if (!$pedido_id) {
    echo json_encode(['status' => 'PENDENTE']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT status FROM pedidos WHERE id = ? OR gateway_txid = ?");
    $stmt->execute([$pedido_id, $pedido_id]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pedido) {
        echo json_encode(['status' => strtoupper($pedido['status'])]);
    } else {
        echo json_encode(['status' => 'PENDENTE']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'PENDENTE']);
}