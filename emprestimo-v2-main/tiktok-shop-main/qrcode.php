<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento PIX - Atendimento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen font-sans flex flex-col justify-between">

    <div>
        <!-- Topo Escuro -->
        <header class="bg-[#102a43] text-white text-xs py-2 px-4">
            <div class="max-w-md mx-auto flex justify-between">
                <span>Portal de Atendimento</span>
                <span>Pagamento Seguro</span>
            </div>
        </header>

        <!-- Cabeçalho Principal -->
        <div class="bg-[#183b56] text-white p-4 border-b-4 border-blue-600">
            <div class="max-w-md mx-auto text-center">
                <h1 class="font-bold text-lg">Aguardando Pagamento</h1>
                <p class="text-xs text-blue-200">Utilize o PIX Copia e Cola para finalizar</p>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <main class="max-w-md mx-auto p-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 text-center">
                
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">
                    <i class="fa-solid fa-qrcode"></i>
                </div>

                <h2 class="font-bold text-gray-800 text-base mb-1">PIX Gerado com Sucesso</h2>
                
                <!-- Destaque do Valor -->
                <div class="my-3 py-2 px-4 bg-blue-50 border border-blue-100 rounded-lg inline-block w-full">
                    <span class="text-xs text-gray-500 uppercase font-semibold block mb-0.5">Valor Total a Pagar</span>
                    <span class="text-2xl font-black text-gray-800">R$ <span id="display-valor">19,90</span></span>
                </div>

                <!-- Status em tempo real -->
                <div id="status-pagamento" class="flex items-center justify-center gap-2 text-xs text-blue-600 font-medium mb-3">
                    <i class="fa-solid fa-spinner animate-spin"></i>
                    <span>Aguardando identificação do pagamento...</span>
                </div>

                <!-- Aviso / Motivo da Cobrança -->
                <div class="bg-amber-50 border-l-4 border-amber-400 p-3 mb-4 text-left rounded-r-lg">
                    <div class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-info text-amber-600 text-sm mt-0.5"></i>
                        <p class="text-xs text-amber-800 leading-snug">
                            Cobramos uma taxa administrativa de atendimento para cobrir os custos operacionais e garantir a prioridade do seu protocolo.
                        </p>
                    </div>
                </div>

                <!-- Área do Código -->
                <div class="bg-gray-50 border border-gray-300 rounded-lg p-3 mb-4 text-left">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Código PIX Copia e Cola</label>
                    <textarea id="pix-code-input" readonly rows="4" class="w-full text-xs bg-transparent text-gray-700 outline-none resize-none font-mono break-all"></textarea>
                </div>

                <!-- Botão Copiar -->
                <button id="btn-copiar" onclick="copiarPix()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-4 rounded-lg text-sm shadow transition flex items-center justify-center gap-2 mb-3">
                    <i class="fa-solid fa-copy"></i>
                    <span>Copiar Código PIX</span>
                </button>

                <p class="text-[11px] text-gray-400">Após realizar o pagamento, você será redirecionado automaticamente.</p>
            </div>
        </main>
    </div>

    <footer class="text-center py-4 text-xs text-gray-500">
        <p>Ambiente seguro © <?= date('Y') ?></p>
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
                window.location.href = 'index.php';
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
                            document.getElementById('status-pagamento').innerHTML = `
                                <i class="fa-solid fa-circle-check text-green-600 text-base"></i>
                                <span class="text-green-600 font-bold">Pagamento Confirmado!</span>
                            `;
                            setTimeout(() => {
                                window.location.href = 'sucesso.php'; // Página final de atendimento
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
            btn.innerHTML = '<i class="fa-solid fa-check"></i> <span>Código Copiado!</span>';
            btn.classList.remove('bg-green-600', 'hover:bg-green-700');
            btn.classList.add('bg-blue-600');

            setTimeout(() => {
                btn.innerHTML = '<i class="fa-solid fa-copy"></i> <span>Copiar Código PIX</span>';
                btn.classList.remove('bg-blue-600');
                btn.classList.add('bg-green-600', 'hover:bg-green-700');
            }, 3000);
        }
    </script>
</body>
</html>