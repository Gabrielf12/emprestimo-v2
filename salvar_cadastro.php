<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Salva tudo na sessão para usarmos lá na frente no pagamento/banco
    $_SESSION['dados_cadastro'] = [
        'servico'      => $_POST['servico'] ?? '',
        'nome'         => $_POST['nome'] ?? '',
        'cpf'          => $_POST['cpf'] ?? '',
        'rg'           => $_POST['rg'] ?? '',
        'estado_civil' => $_POST['estado_civil'] ?? '',
        'telefone'     => $_POST['telefone'] ?? '',
        'endereco'     => $_POST['endereco'] ?? ''
    ];

    // Redireciona para a tela de aviso levando o serviço junto na URL
    $servico_url = urlencode($_POST['servico']);
    header("Location: aviso.php?servico={$servico_url}");
    exit;
}