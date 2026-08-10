<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
    $total = filter_input(INPUT_POST, 'total', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if ($nome && $cpf) {
        $_SESSION['cliente_nome'] = $nome;
        $_SESSION['cliente_cpf'] = $cpf;
        
        // Redireciona direto para a geração do pagamento Pix
        header("Location: pay.php?total=" . urlencode($total));
        exit;
    }
}

$total = $_GET['total'] ?? '0.00';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identificação - Zé Promoções</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-zinc-950 text-white min-h-screen flex items-center justify-center p-4">

    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-6 w-full max-w-md shadow-2xl">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-amber-400 text-black rounded-full flex items-center justify-center text-lg font-black">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <h2 class="text-xl font-black">Dados para o Pix</h2>
                <p class="text-xs text-zinc-400">Preencha seus dados para gerar o comprovante.</p>
            </div>
        </div>

        <form action="create_payment.php" method="POST" id="form-pix" class="space-y-4">
    
    <div>
        <label class="text-xs text-zinc-400 block mb-1">Nome Completo</label>
        <input type="text" name="nome" placeholder="Gag" required 
               class="w-full bg-zinc-800 text-white p-3 rounded-lg border border-zinc-700 outline-none focus:border-amber-400">
    </div>

    <div>
        <label class="text-xs text-zinc-400 block mb-1">CPF (apenas números)</label>
        <input type="text" name="cpf" placeholder="00000000000" required 
               class="w-full bg-zinc-800 text-white p-3 rounded-lg border border-zinc-700 outline-none focus:border-amber-400">
    </div>
    
    <!-- Pega o valor real da sacola de forma invisível -->
    <input type="hidden" name="amount" id="pix-amount" value="">

    <button type="submit" class="ze-yellow w-full py-3.5 rounded-xl font-bold uppercase tracking-wider flex items-center justify-center gap-2">
    IR PARA O PAGAMENTO <i class="fa-solid fa-qrcode"></i>
</button>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault(); // Evita recarregar a página da forma tradicional

        // Pega os dados dos campos
        const nome = form.querySelector('input[name="nome"]').value;
        const cpf = form.querySelector('input[name="cpf"]').value;
        const totalSacola = localStorage.getItem('ze_total') || '16.98';

        try {
            // Envia via JSON exatamente como a API da IronPay quer
            const response = await fetch('api/create_payment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    customer_name: nome,
                    customer_cpf: cpf,
                    amount: parseFloat(totalSacola)
                })
            });

            const data = await response.json();

            if (data.status === 'success' && data.pix_code) {
                // Salva o código do Pix para exibir na tela final
                localStorage.setItem('pix_code', data.pix_code);
                localStorage.setItem('pedido_id', data.pedidoId);
                
                // Redireciona para a tela que mostra o QR Code PIX
                window.location.href = 'pay.php'; // Ou o arquivo da sua tela de QR Code
            } else {
                alert('Erro ao gerar PIX: ' + (data.message || 'Tente novamente.'));
            }
        } catch (err) {
            console.error(err);
            alert('Erro ao conectar com o servidor. Tente novamente.');
        }
    });
});
</script>