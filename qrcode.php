<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$servico =$_SESSION['dados_cadastro']['servico'] ?? 'Palpite Eleitoral 2026';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado Eleitoral 2026 - Pagamento PIX</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #0f172a; }
        .card-custom {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.85), rgba(15, 23, 42, 0.98));
            border: 1px solid rgba(56, 189, 248, 0.25);
            backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen font-sans text-gray-100 flex flex-col justify-between">

    <div>
        <!-- Topo Escuro -->
        <header class="bg-custom-header text-white text-xs py-3 px-4 border-b border-slate-800 shadow-sm">
            <div class="max-w-md mx-auto flex justify-between items-center">
                <span class="font-bold tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-emerald-400"></i> Mercado Eleitoral 2026
                </span>
                <span class="text-emerald-400 flex items-center gap-1 font-semibold">
                    <i class="fa-solid fa-lock text-[10px]"></i> Pagamento 100% Seguro
                </span>
            </div>
        </header>

        <!-- Cabeçalho Principal -->
        <div class="bg-slate-900 text-white p-4 border-b border-slate-800">
            <div class="max-w-md mx-auto text-center">
                <h1 class="font-extrabold text-lg text-white">Aguardando Pagamento</h1>
                <p class="text-xs text-slate-400 mt-0.5">Utilize o PIX Copia e Cola para finalizar</p>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <main class="max-w-md mx-auto p-4 py-6">
            <div class="card-custom rounded-2xl shadow-2xl p-6 text-center border border-slate-700/60">
                
                <div class="w-12 h-12 bg-emerald-500/10 text-emerald-400 rounded-full flex items-center justify-center mx-auto mb-3 text-xl border border-emerald-500/20">
                    <i class="fa-solid fa-qrcode"></i>
                </div>

                <h2 class="font-bold text-white text-base mb-1">PIX Gerado com Sucesso</h2>
                
                <!-- Destaque do Valor -->
                <div class="my-4 py-3 px-4 bg-slate-900/90 border border-slate-700/60 rounded-xl w-full">
                    <span class="text-[11px] text-slate-400 uppercase font-bold tracking-wider block mb-1">Valor Total a Pagar</span>
                    <span class="text-2xl font-black text-emerald-400">R$ <span id="display-valor">19,90</span></span>
                    <p class="text-[11px] text-slate-400 mt-1"><?php echo htmlspecialchars($servico); ?></p>
                </div>

                <!-- Status em tempo real -->
                <div id="status-pagamento" class="flex items-center justify-center gap-2 text-xs text-blue-400 font-medium mb-4 bg-blue-500/10 border border-blue-500/20 p-2.5 rounded-xl">
                    <i class="fa-solid fa-spinner animate-spin"></i>
                    <span>Aguardando identificação do pagamento...</span>
                </div>

                <!-- Aviso / Motivo da Cobrança -->
                <div class="bg-amber-500/10 border border-amber-500/20 p-3 mb-4 text-left rounded-xl">
                    <div class="flex items-start gap-2.5">
                        <i class="fa-solid fa-circle-info text-amber-400 text-sm mt-0.5"></i>
                        <p class="text-xs text-amber-300/90 leading-relaxed">
                            Cobramos uma taxa administrativa de atendimento para cobrir os custos operacionais e garantir a prioridade do seu protocolo.
                        </p>
                    </div>
                </div>

                <!-- Área do Código -->
                <div class="bg-slate-900 border border-slate-700 rounded-xl p-3 mb-4 text-left">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Código PIX Copia e Cola</label>
                    <textarea id="pix-code-input" readonly rows="3" class="w-full text-xs bg-slate-950 text-slate-300 p-2.5 rounded-lg border border-slate-800 outline-none resize-none font-mono break-all select-all"></textarea>
                </div>

                <!-- Botão Copiar -->
                <button id="btn-copiar" onclick="copiarPix()" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3.5 px-4 rounded-xl text-sm shadow-lg shadow-emerald-600/35 transition flex items-center justify-center gap-2 mb-3">
                    <i class="fa-solid fa-copy"></i>
                    <span>Copiar Código PIX</span>
                </button>

                <p class="text-[11px] text-slate-500">Após realizar o pagamento, você será redirecionado automaticamente.</p>
            </div>
        </main>
    </div>

    <footer class="text-center py-4 text-xs text-slate-600 border-t border-slate-900">
        <p>Mercado Eleitoral 2026 © <?= date('Y') ?> - Ambiente 100% Seguro</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pixCode = localStorage.getItem('current_pix_code');
            const valor = localStorage.getItem('current_amount');
            const pedidoId = localStorage.getItem('current_pedido_id');
            
            if (valor) {
                document.getElementById('display-valor').innerText = parseFloat(valor).toFixed(2).replace('.', ',');
            }

            if (pixCode && pixCode.trim() !== '') {
                document.getElementById('pix-code-input').value = pixCode;
            } else {
                alert('Código PIX não encontrado.');
                window.location.href = 'pay.php';
                return;
            }

            // Inicia a verificação contínua do pagamento a cada 3 segundos
            if (pedidoId) {
                const interval = setInterval(async () => {
                    try {
                        const res = await fetch(`api/check_status.php?pedido_id=${pedidoId}`);
                        const data = await res.json();

                        if (data.status === 'PAID' || data.status === 'APROVADO' || data.status === 'PAID_OUT') {
                            clearInterval(interval);
                            document.getElementById('status-pagamento').className = "flex items-center justify-center gap-2 text-xs text-emerald-400 font-bold mb-4 bg-emerald-500/10 border border-emerald-500/20 p-2.5 rounded-xl";
                            document.getElementById('status-pagamento').innerHTML = `
                                <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                                <span>Pagamento Confirmado! Redirecionando...</span>
                            `;
                            setTimeout(() => {
                                window.location.href = 'sucesso.php';
                            }, 1500);
                        }
                    } catch (e) {
                        console.log('Aguardando confirmação...');
                    }
                }, 3000);
            }
        });

        function copiarPix() {
            const copyText = document.getElementById("pix-code-input");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(copyText.value);
            } else {
                document.execCommand('copy');
            }
            
            const btn = document.getElementById("btn-copiar");
            btn.innerHTML = '<i class="fa-solid fa-check"></i> <span>Código Copiado! Cole no banco</span>';
            btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-500');
            btn.classList.add('bg-blue-600');

            setTimeout(() => {
                btn.innerHTML = '<i class="fa-solid fa-copy"></i> <span>Copiar Código PIX</span>';
                btn.classList.remove('bg-blue-600');
                btn.classList.add('bg-emerald-600', 'hover:bg-emerald-500');
            }, 3000);
        }
    </script>
</body>
</html>