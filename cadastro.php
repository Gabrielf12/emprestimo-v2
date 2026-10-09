<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php';

// Captura o produto enviado pelo index ou carrinho, ou define um padrão
$produtoEscolhido = isset($_GET['servico']) ? $_GET['servico'] : (isset($_GET['produto']) ? $_GET['produto'] : 'Kit Especial tudoAki 2026 + Número da Sorte');
$valorEscolhido = isset($_GET['valor']) ? floatval($_GET['valor']) : 100.00;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout e Cadastro - tudoAki</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-navy { background-color: #0b192c; }
        .bg-navy-dark { background-color: #060e18; }
        .text-gold { color: #d4af37; }
        .bg-gold { background-color: #d4af37; color: #0b192c; }
        .border-gold { border-color: #d4af37; }
    </style>
</head>
<body class="bg-navy min-h-screen font-sans text-gray-100 flex flex-col justify-between">

    <!-- Topo -->
    <header class="bg-navy-dark border-b border-gold/30 shadow-lg py-4 px-6">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-3">
                <img src="logo.jpg" alt="tudoAki Logo" class="h-10 object-contain rounded-lg border border-gold/40 bg-navy">
            </a>
            <span class="text-xs text-gold font-bold tracking-wider uppercase"><i class="fa-solid fa-lock text-gold mr-1"></i> Checkout Seguro tudoAki</span>
        </div>
    </header>

    <!-- Conteúdo do Checkout -->
    <main class="max-w-4xl w-full mx-auto p-4 md:p-6 my-auto space-y-6 flex-grow">

        <div class="text-center space-y-1">
            <h1 class="text-xl md:text-2xl font-black text-gold">Finalizar sua Compra / Participação</h1>
            <p class="text-xs text-gray-300">Preencha seus dados abaixo para gerar o Pix e garantir seus cupons de sorteio.</p>
        </div>

        <div class="bg-[#0f2238] border border-gold/30 rounded-2xl p-6 shadow-2xl space-y-6">
            
            <!-- Resumo do Item Selecionado -->
            <div class="bg-navy border border-gold/40 rounded-xl p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <span class="text-[10px] text-gold uppercase font-bold tracking-wider">Item / Campanha Selecionada:</span>
                    <h2 class="text-sm font-black text-white"><?php echo htmlspecialchars($produtoEscolhido); ?></h2>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-gray-400 block uppercase">Valor Total</span>
                    <span class="text-lg font-black text-gold">R$ <?php echo number_format($valorEscolhido, 2, ',', '.'); ?></span>
                </div>
            </div>

            <!-- Formulário de Cadastro / Dados para Entrega e Pagamento -->
            <form action="pay.php" method="POST" class="space-y-4">
                
                <input type="hidden" name="produto" value="<?php echo htmlspecialchars($produtoEscolhido); ?>">
                <input type="hidden" name="valor" value="<?php echo $valorEscolhido; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-300 uppercase">Nome Completo</label>
                        <input type="text" name="nome" required placeholder="Seu nome completo" class="w-full bg-navy border border-gold/40 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-gold">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-300 uppercase">CPF</label>
                        <input type="text" name="cpf" required placeholder="000.000.000-00" class="w-full bg-navy border border-gold/40 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-gold">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-300 uppercase">E-mail</label>
                        <input type="email" name="email" required placeholder="seu@email.com" class="w-full bg-navy border border-gold/40 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-gold">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-gray-300 uppercase">WhatsApp / Telefone</label>
                        <input type="text" name="telefone" required placeholder="(11) 99999-9999" class="w-full bg-navy border border-gold/40 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-gold">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-300 uppercase">Endereço de Entrega / Envio</label>
                    <input type="text" name="endereco" required placeholder="Rua, Número, Bairro, Cidade - Estado" class="w-full bg-navy border border-gold/40 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-gold">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-gold hover:opacity-90 text-navy font-black py-4 rounded-xl text-sm uppercase tracking-wider transition shadow-lg flex items-center justify-center gap-2">
                        <span>Ir para o Pagamento Pix</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>

            </form>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="text-center text-[10px] text-gray-400 py-4 border-t border-gold/30 bg-navy-dark">
        © 2026 tudoAki - Sua Loja de Tudo. Aqui. Todos os direitos reservados.
    </footer>

</body>
</html>