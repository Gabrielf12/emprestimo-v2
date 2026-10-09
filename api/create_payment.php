<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$customer_name  = trim($input['customer_name'] ?? $input['nome'] ?? 'Cliente tudoAki');
$customer_cpf   = preg_replace('/[^0-9]/', '', $input['customer_cpf'] ?? $input['cpf'] ?? '11144477735');
$raw_phone      = preg_replace('/[^0-9]/', '', $input['phone'] ?? $input['customer_phone'] ?? $input['telefone'] ?? '11999999999');
$custom_amount  = (float)($input['amount'] ?? $input['valor'] ?? 437.23);
$valor_centavos = (int)round($custom_amount * 100);

// Gera um código Pix simulado ou real válido para testar o fluxo completo para o qrcode.php
$pix_copia_cola = "00020126580014br.gov.bcb.pix0136123e4567-e89b-12d3-a456-4266141740005204000053039865802BR5913TudoAki Store6009Sao Paulo62070503***63041D3D";

require_once '../db_config.php';
$localPedidoId = rand(10000, 99999);

try {
    $stmt_insert = $pdo->prepare("INSERT INTO pedidos
        (status, customer_name, customer_cpf, customer_phone, total_amount_centavos, pix_code)
        VALUES
        ('PENDENTE', :name, :cpf, :phone, :total, :pix_code)");

    $stmt_insert->execute([
        'name'     => $customer_name,
        'cpf'      => $customer_cpf,
        'phone'    => $raw_phone,
        'total'    => $valor_centavos,
        'pix_code' => $pix_copia_cola
    ]);
    
    $db_id = $pdo->lastInsertId();
    if ($db_id) $localPedidoId = $db_id;
} catch (Exception $e) {}

http_response_code(200);
echo json_encode([
    'status'   => 'success',
    'pedidoId' => $localPedidoId,
    'pix_code' => $pix_copia_cola,
    'valor'    => number_format($custom_amount, 2, '.', '')
]);
exit;