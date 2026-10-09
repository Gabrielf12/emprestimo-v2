<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dados = $_SESSION['dados_cadastro'] ?? [];
$nome  = !empty($dados['nome']) ? $dados['nome'] : '';
$cpf   = !empty($dados['cpf']) ? $dados['cpf'] : '';
$tel   = !empty($dados['telefone']) ? $dados['telefone'] : '';
$servico = $dados['servico'] ?? $_GET['servico'] ?? $_POST['servico'] ?? 'Kit Especial tudoAki 2026';

// Valor total alinhado rigorosamente em R$ 437,23
$valorPalpite = $_GET['valor'] ?? $_POST['valor'] ?? $_SESSION['valor_emprestimo'] ?? $dados['valor'] ?? '427.41';
$valorFloat = (float)$valorPalpite;
if ($valorFloat < 400) {
    $valorFloat = 427.41;
}

$valorFrete = 9.82; 
$valorTotalGeral = $valorFloat + $valorFrete; // 437.23
$_SESSION['valor_emprestimo'] = $valorTotalGeral;

$valorFormatado = number_format($valorTotalGeral, 2, ',', '.');
$valorProdutoFmt = number_format($valorFloat, 2, ',', '.');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento - tudoAki</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .text-blue-cb { color: #002D93; }
        .bg-blue-cb { background-color: #002D93; }
        .border-blue-cb { border-color: #002D93; }
        .payment-card { transition: all 0.2s ease; }
        .payment-card:hover {
            border-color: #002D93;
            box-shadow: 0 4px 12px rgba(0, 45, 147, 0.08);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800 flex flex-col justify-between">

    <!-- Topo Fiel ao Varejo -->
    <header class="bg-white border-b border-gray-200 shadow-sm py-3 px-6 relative">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-2">
                <span class="text-2xl font-black italic tracking-tighter text-blue-cb">tudo<span class="text-amber-500">Aki</span></span>
            </a>
            <div class="text-blue-cb text-lg flex items-center gap-1 font-bold text-xs">
                <i class="fa-solid fa-lock"></i> Pagamento Seguro
            </div>
        </div>
        <div class="absolute top-0 left-0 right-0 h-1 bg-red-600"></div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-7xl w-full mx-auto p-4 md:p-8 my-2 flex-grow">

        <h1 class="text-2xl md:text-3xl font-bold text-blue-cb mb-6">Identificação e Pagamento</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Coluna da Esquerda: Formulário de Dados + Pagamento -->
            <div class="lg:col-span-2 space-y-4">
                
                <form id="form-identificacao" class="space-y-4">
                    <input type="hidden" name="payment_method" value="pix">
                    <input type="hidden" name="servico" value="<?php echo htmlspecialchars($servico); ?>">
                    <input type="hidden" name="valor" id="input-valor-hidden" value="<?php echo $valorTotalGeral; ?>">

                    <!-- Bloco de Identificação Obrigatória (Campos Visíveis) -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 space-y-4">
                        <h2 class="text-xs font-bold text-blue-cb uppercase tracking-wider border-b border-gray-100 pb-2">
                            <i class="fa-solid fa-user-shield mr-1"></i> 1. Confirme seus dados para liberação
                        </h2>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">Nome Completo</label>
                            <input type="text" name="customer_name" id="input-nome" value="<?php echo htmlspecialchars($nome); ?>" required placeholder="Digite seu nome completo" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-blue-cb transition">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">CPF (somente números)</label>
                                <input type="text" name="customer_cpf" id="input-cpf" value="<?php echo htmlspecialchars($cpf); ?>" required placeholder="00000000000" maxlength="11" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-blue-cb transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">Telemóvel / WhatsApp</label>
                                <input type="text" name="phone" id="input-phone" value="<?php echo htmlspecialchars($tel); ?>" required placeholder="11999999999" maxlength="11" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs focus:outline-none focus:border-blue-cb transition">
                            </div>
                        </div>
                    </div>

                    <div class="text-xs font-bold text-gray-700 uppercase tracking-wider pt-2">2. Como você deseja pagar?</div>

                    <!-- Opção PIX com Botão de Envio -->
                    <button type="submit" class="w-full text-left payment-card bg-white rounded-xl p-4 shadow-sm border-2 border-emerald-600 cursor-pointer flex justify-between items-center transition">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-qrcode text-emerald-600 text-xl mt-1"></i>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Pix</h4>
                                <p class="text-[11px] text-emerald-700 font-bold">Aprovação em instantes</p>
                                <span class="text-sm font-black text-emerald-700 mt-1 block">R$ <span id="display-valor-texto"><?php echo $valorFormatado; ?></span> à vista</span>
                            </div>
                        </div>
                        <span class="bg-emerald-600 text-white font-bold text-xs px-4 py-2.5 rounded-lg shadow">Gerar PIX Agora <i class="fa-solid fa-arrow-right ml-1"></i></span>
                    </button>
                </form>

            </div>

            <!-- Coluna da Direita: Resumo do Pedido -->
            <div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 space-y-4 sticky top-6">
                    <h2 class="text-lg font-bold text-blue-cb border-b border-gray-100 pb-3">Resumo do pedido</h2>

                    <div class="flex items-start gap-3 pb-3 border-b border-gray-100">
                        <div class="w-12 h-12 bg-gray-100 rounded border border-gray-200 flex items-center justify-center text-blue-cb">
                            <i class="fa-solid fa-box-open text-xl"></i>
                        </div>
                        <div class="text-xs">
                            <span class="font-bold text-gray-900 block line-clamp-2">1x <?php echo htmlspecialchars($servico); ?></span>
                            <span class="text-gray-500">Vendido e entregue por <strong class="text-blue-cb">TUDOAKI OFICIAL</strong></span>
                            <div class="text-blue-cb font-bold mt-1">Entrega rápida: <span class="text-emerald-700">R$ <?php echo number_format($valorFrete, 2, ',', '.'); ?></span></div>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-gray-600 text-xs">
                            <span>01 Produto</span>
                            <span class="font-bold text-gray-900">R$ <?php echo $valorProdutoFmt; ?></span>
                        </div>
                        <div class="flex justify-between text-gray-600 text-xs pb-3 border-b border-gray-100">
                            <span>Entrega</span>
                            <span class="font-bold text-gray-900">R$ <?php echo number_format($valorFrete, 2, ',', '.'); ?></span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-gray-900 pt-1">
                            <span>Total</span>
                            <span class="text-blue-cb font-black text-lg">R$ <?php echo $valorFormatado; ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Modal de Carregamento -->
    <div id="loading-modal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex flex-col items-center justify-center p-6 hidden">
        <div class="bg-white rounded-2xl p-6 text-center shadow-2xl w-full max-w-xs flex flex-col items-center border border-slate-200">
            <div id="modal-spinner" class="w-12 h-12 border-4 border-emerald-500/20 border-t-emerald-600 rounded-full animate-spin mb-4"></div>
            <h4 class="font-bold text-gray-900 text-sm" id="loading-title">Gerando seu PIX...</h4>
            <p class="text-xs text-gray-500 mt-2">Aguarde um instante.</p>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-white text-gray-500 text-xs py-4 text-center border-t border-gray-200 mt-8">
        © 2026 tudoAki - Todos os direitos reservados.
    </footer>

    <script>
    let valorGlobalTransacao = "<?php echo $valorTotalGeral; ?>";

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('form-identificacao');
        const loadingModal = document.getElementById('loading-modal');

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const nomeVal = document.getElementById('input-nome').value.trim();
                const cpfVal = document.getElementById('input-cpf').value.replace(/\D/g, '');
                const phoneVal = document.getElementById('input-phone').value.replace(/\D/g, '');

                if (!nomeVal || cpfVal.length !== 11 || phoneVal.length < 10) {
                    alert('Por favor, preencha o Nome, um CPF válido com 11 dígitos e o Telemóvel corretamente.');
                    return;
                }

                loadingModal.classList.remove('hidden');

                const dataObj = {
                    payment_method: 'pix',
                    servico: "<?php echo htmlspecialchars($servico); ?>",
                    valor: valorGlobalTransacao,
                    amount: valorGlobalTransacao,
                    customer_name: nomeVal,
                    customer_cpf: cpfVal,
                    phone: phoneVal,
                    customer_phone: phoneVal
                };

                try {
                    const response = await fetch('api/create_payment.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(dataObj)
                    });

                    const result = await response.json();

                    if (response.ok && result.status === 'success') {
                        let cleanPix = result.pix_code.replace(/\\/g, '');
                        localStorage.setItem('current_pix_code', cleanPix);
                        localStorage.setItem('current_pedido_id', result.pedidoId);
                        localStorage.setItem('current_amount', valorGlobalTransacao);
                        window.location.href = 'qrcode.php';
                    } else {
                        loadingModal.classList.add('hidden');
                        alert('Erro ao processar requisição: ' + (result.message || 'Tente novamente.'));
                    }
                } catch (error) {
                    loadingModal.classList.add('hidden');
                    alert('Erro na comunicação com o servidor.');
                }
            });
        }
    });
    </script>
</body>
</html>