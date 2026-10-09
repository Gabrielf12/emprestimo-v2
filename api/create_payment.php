<?php
// api/create_payment.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: application/json');

$user_id_sessao = $_SESSION['user_id'] ?? null;
require_once '../db_config.php';

$IRONPAY_API_TOKEN = 'dHWOXlpdPL7MuNxonLM4JtwsWAClZ4bTJdBYc6eJxl2tEtLsQvaocwlEDttP';
$product_hash      = 'iatlfawko9';
$offer_hash        = 'ksf2tt43yt';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$payment_method = $input['payment_method'] ?? 'pix';
$quantity = (int)($input['quantity'] ?? 1);
if ($quantity <= 0) $quantity = 1;

$customer_name  = trim($input['customer_name'] ?? $input['nome'] ?? 'Cliente tudoAki');
$customer_email = trim($input['customer_email'] ?? $input['email'] ?? 'atendimento@portal.com');
$customer_cpf   = preg_replace('/[^0-9]/', '', $input['customer_cpf'] ?? $input['cpf'] ?? '11144477735');
if (strlen($customer_cpf) !== 11) { $customer_cpf = '11144477735'; }

$raw_phone_input = $input['phone'] ?? $input['customer_phone'] ?? $input['telefone'] ?? '11999999999';
$raw_phone       = preg_replace('/[^0-9]/', '', $raw_phone_input);
if (strlen($raw_phone) < 10) { $raw_phone = '11999999999'; }
$full_phone_55 = (strlen($raw_phone) <= 11) ? '55' . $raw_phone : $raw_phone;

$servico_nome   = trim($input['servico'] ?? $input['product_name'] ?? 'Kit Especial tudoAki 2026');
$custom_amount  = (float)($input['amount'] ?? $input['valor'] ?? 437.23);

try {
    if (empty($customer_name) || strlen($customer_cpf) !== 11) {
        throw new Exception("Informe um Nome completo e um CPF válido com 11 dígitos.");
    }

    $valor_total_centavos = (int)round($custom_amount * 100);
    $postback_url = 'https://www.tiktokshoop.store/api/webhook_ironpay.php';
    $api_url_full = "https://api.ironpayapp.com.br/api/public/v1/transactions";

    $payload = [
        'api_token'      => $IRONPAY_API_TOKEN,
        'product_hash'   => $product_hash,
        'offer_hash'     => $offer_hash,
        'payment_method' => 'pix',
        'amount'         => $valor_total_centavos,
        'postback_url'   => $postback_url,
        'customer'       => [
            'name'     => $customer_name,
            'email'    => $customer_email,
            'phone'    => $full_phone_55,
            'document' => $customer_cpf
        ],
        'cart' => [
            [
                'product_hash'   => $product_hash,
                'offer_hash'     => $offer_hash,
                'title'          => $servico_nome,
                'price'          => $valor_total_centavos,
                'quantity'       => $quantity,
                'tangible'       => false,
                'operation_type' => 1
            ]
        ]
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url_full);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $IRONPAY_API_TOKEN,
        'Content-Type: application/json',
        'Accept: application/json'
    ]);

    $response   = curl_exec($ch);
    $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        throw new Exception("cURL Error: " . $curl_error);
    }

    $responseData = json_decode($response, true);

    if ($http_code !== 200 && $http_code !== 201) {
        $msg_erro = $responseData['message'] ?? $responseData['error'] ?? $response;
        throw new Exception("Iron Pay [$http_code]: " . (is_array($msg_erro) ? json_encode($msg_erro) : $msg_erro));
    }

    $pix_code_final = $responseData['pix_qr_code'] ?? $responseData['pix_code'] ?? $responseData['data']['pix_qr_code'] ?? $responseData['data']['pix_code'] ?? null;
    
    if (empty($pix_code_final)) {
        if (preg_match('/"pix_qr_code"\s*:\s*"([^"]+)"/', $response, $matches)) {
            $pix_code_final = $matches[1];
        } elseif (preg_match('/"pix_code"\s*:\s*"([^"]+)"/', $response, $matches)) {
            $pix_code_final = $matches[1];
        }
    }

    $gateway_txid_final = $responseData['hash'] ?? $responseData['token'] ?? $responseData['data']['hash'] ?? ('iron_' . uniqid());

    if (empty($pix_code_final)) {
        throw new Exception("Pix não retornado. Resposta: " . $response);
    }

    $localPedidoId = rand(10000, 99999);
    try {
        $stmt_insert = $pdo->prepare("INSERT INTO pedidos
            (user_id, gateway_txid, status, customer_name, customer_email, customer_cpf, customer_phone, product_name, quantity, total_amount_centavos, pix_code)
            VALUES
            (:user_id, :txid, 'PENDENTE', :name, :email, :cpf, :phone, :prod_name, :qty, :total, :pix_code)");

        $stmt_insert->execute([
            'user_id'   => $user_id_sessao ? (int)$user_id_sessao : null,
            'txid'      => $gateway_txid_final,
            'name'      => $customer_name,
            'email'     => $customer_email,
            'cpf'       => $customer_cpf,
            'phone'     => $full_phone_55,
            'prod_name' => $servico_nome,
            'qty'       => $quantity,
            'total'     => $valor_total_centavos,
            'pix_code'  => $pix_code_final
        ]);

        $db_id = $pdo->lastInsertId();
        if ($db_id) $localPedidoId = $db_id;
    } catch (Exception $dbErr) {}

    http_response_code(200);
    echo json_encode([
        'status'    => 'success',
        'pix_code'  => $pix_code_final,
        'pedidoId'  => $localPedidoId,
        'valor'     => number_format($valor_total_centavos / 100, 2, '.', ''),
        'expira_em' => date(DATE_ATOM, strtotime('+10 minutes'))
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}