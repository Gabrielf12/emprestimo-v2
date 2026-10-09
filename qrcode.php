<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$servico =$_SESSION['dados_cadastro']['servico'] ?? 'Kit Especial tudoAki 2026';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento PIX - tudoAki</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .text-blue-cb { color: #002D93; }
        .bg-blue-cb { background-color: #002D93; }
        .border-blue-cb { border-color: #002D93; }
        .btn-green-cb { background-color: #178900; }
        .btn-green-cb:hover { background-color: #137200; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800 flex flex-col justify-between">

    <!-- Topo Fiel ao Layout -->
    <header class="bg-white border-b border-gray-200 shadow-sm py-3 px-6 relative">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-2">
                <span class="text-2xl font-black italic tracking-tighter text-blue-cb">tudo<span class="text-amber-500">Aki</span></span>
            </a>
            <div class="text-blue-cb text-lg">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
        </div>
        <div class="absolute top-0 left-0 right-0 h-1 bg-red-600"></div>
    </header>

    <!-- Faixa Verde de Sucesso do Pedido -->
    <div class="bg-[#178900] text-white py-4 px-4 text-center shadow-inner">
        <div class="max-w-xl mx-auto space-y-1">
            <div class="text-xl flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span id="display-pedido-id" class="font-bold tracking-wider">---</span>
            </div>
            <p class="text-xs text-white/90">Recebemos seu pedido, obrigado.</p>
            <h2 class="text-sm font-black uppercase tracking-wide pt-1">Pague o Pix para garantir seu pedido</h2>
        </div>
    </div>

    <!-- Conteúdo Principal do QR Code -->
    <main class="max-w-xl w-full mx-auto p-4 md:p-6 my-6 flex-grow">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 text-center space-y-5">
            
            <div class="inline-block bg-amber-100 text-amber-800 text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                Pagamento pendente
            </div>

            <!-- QR Code Estático / Ilustrativo para o layout -->
            <div class="flex justify-center">
                <div class="p-3 bg-white border-2 border-gray-200 rounded-xl shadow-sm">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=tudoAkiPagamentoPix" alt="QR Code Pix" class="w-40 h-40 object-contain mx-auto">
                </div>
            </div>

            <!-- Destaque do Valor Total -->
            <div class="space-y-1">
                <span class="text-xs text-gray-500 block">Valor total</span>
                <span class="text-2xl font-black text-blue-cb">R$ <span id="display-valor">19,90</span></span>
                <p class="text-xs text-gray-600 font-semibold"><?php echo htmlspecialchars($servico); ?></p>
            </div>

            <!-- Status em tempo real (Lógica Original Mantida) -->
            <div id="status-pagamento" class="flex items-center justify-center gap-2 text-xs text-blue-700 font-medium bg-blue-50 border border-blue-200 p-3 rounded-xl">
                <i class="fa-solid fa-spinner animate-spin"></i>
                <span>Aguardando identificação do pagamento...</span>
            </div>

            <!-- Código Pix Copia e Cola -->
            <div class="space-y-1 text-left">
                <label class="block text-[11px] font-bold text-gray-700 uppercase">Código PIX Copia e Cola</label>
                <textarea id="pix-code-input" readonly rows="2" class="w-full text-xs bg-gray-50 text-gray-700 p-3 rounded-xl border border-gray-300 outline-none resize-none font-mono select-all"></textarea>
            </div>

            <!-- Botão Copiar (Lógica Original Mantida) -->
            <button id="btn-copiar" onclick="copiarPix()" class="w-full bg-blue-cb hover:bg-blue-900 text-white font-bold py-3.5 px-4 rounded-xl text-sm shadow-md transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-copy"></i>
                <span>Copiar código Pix</span>
            </button>

            <div class="text-[11px] text-gray-500 space-y-1 pt-2 border-t border-gray-100 text-left">
                <p>• O <strong>código Pix</strong> também será enviado para o WhatsApp e e-mail cadastrados.</p>
                <p>• <strong>Importante:</strong> caso seu pagamento não seja efetivado até o prazo informado, seu pedido será cancelado.</p>
            </div>

        </div>
    </main>

    <!-- Rodapé -->
    <footer class="bg-white text-gray-500 text-xs py-4 text-center border-t border-gray-200 mt-8">
        © 2026 tudoAki - Sua Loja de Tudo. Aqui. Todos os direitos reservados.
    </footer>

    <!-- Script Original de Comunicação e Polling Mantido 100% Intacto -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pixCode = localStorage.getItem('current_pix_code');
            const valor = localStorage.getItem('current_amount');
            const pedidoId = localStorage.getItem('current_pedido_id');
            
            if (valor) {
                document.getElementById('display-valor').innerText = parseFloat(valor).toFixed(2).replace('.', ',');
            }

            if (pedidoId) {
                document.getElementById('display-pedido-id').innerText = pedidoId;
            } else {
                document.getElementById('display-pedido-id').innerText = '525158154';
            }

            if (pixCode && pixCode.trim() !== '') {
                document.getElementById('pix-code-input').value = pixCode;
            } else {
                alert('Código PIX não encontrado.');
                window.location.href = 'pay.php';
                return;
            }

            // Inicia a verificação contínua do pagamento a cada 3 segundos (Lógica original)
            if (pedidoId) {
                const interval = setInterval(async () => {
                    try {
                        const res = await fetch(`api/check_status.php?pedido_id=${pedidoId}`);
                        const data = await res.json();

                        if (data.status === 'PAID' || data.status === 'APROVADO' || data.status === 'PAID_OUT') {
                            clearInterval(interval);
                            document.getElementById('status-pagamento').className = "flex items-center justify-center gap-2 text-xs text-emerald-700 font-bold bg-emerald-50 border border-emerald-200 p-3 rounded-xl";
                            document.getElementById('status-pagamento').innerHTML = `
                                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
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
            btn.classList.remove('bg-blue-cb', 'hover:bg-blue-900');
            btn.classList.add('btn-green-cb');

            setTimeout(() => {
                btn.innerHTML = '<i class="fa-solid fa-copy"></i> <span>Copiar código Pix</span>';
                btn.classList.remove('btn-green-cb');
                btn.classList.add('bg-blue-cb', 'hover:bg-blue-900');
            }, 3000);
        }
    </script>
</body>
</html>