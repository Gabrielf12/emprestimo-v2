<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php';

// Captura o produto e valor passados pela vitrine ou define padrão
$nomeProduto = isset($_GET['servico']) ? htmlspecialchars($_GET['servico']) : (isset($_GET['produto']) ? htmlspecialchars($_GET['produto']) : 'Kit Especial tudoAki 2026 + Número da Sorte');
$precoCheio = isset($_GET['valor']) ? floatval($_GET['valor']) : 449.90;
$precoPix = $precoCheio * 0.95; // 5\% de desconto no Pix$descontoPix = $precoCheio -$precoPix;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu carrinho - tudoAki</title>
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

    <!-- Conteúdo Principal -->
    <main class="max-w-7xl w-full mx-auto p-4 md:p-8 my-2 flex-grow">

        <h1 class="text-2xl md:text-3xl font-bold text-blue-cb mb-6">Meu carrinho</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Coluna da Esquerda (Frete dos Correios e Produto) -->
            <div class="lg:col-span-2 space-y-4">
                
                <!-- Caixa de Calcular Frete com Correios (ViaCEP) -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold text-sm text-gray-800 flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-red-600"></i> Calcular frete (Correios)
                        </span>
                        <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank" class="text-xs text-blue-700 font-bold hover:underline flex items-center gap-1">
                            Descobrir CEP <i class="fa-solid fa-circle-question text-xs"></i>
                        </a>
                    </div>
                    <p class="text-xs text-gray-500 mb-3">Digite seu CEP para consultar prazos e valores de entrega via Correios</p>
                    
                    <div class="flex gap-2">
                        <input type="text" id="inputCep" maxlength="9" placeholder="00000-000" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-blue-cb">
                        <button type="button" onclick="calcularFreteCorreios()" class="bg-blue-cb hover:bg-blue-900 text-white font-bold px-6 py-2.5 rounded-lg text-sm transition">
                            Calcular
                        </button>
                    </div>

                    <!-- Resultado da consulta dos Correios / Opções de Frete -->
                    <div id="resultadoFrete" class="mt-4 hidden space-y-2 border-t border-gray-100 pt-3">
                        <div class="text-xs font-bold text-gray-700" id="enderecoInfo"></div>
                        <div class="space-y-1.5" id="opcoesFreteLista">
                            <!-- Inserido via JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- Card do Produto -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200 space-y-4">
                    <div class="text-xs text-gray-600 font-medium border-b border-gray-100 pb-3 flex justify-between items-center">
                        <span>Vendido por <strong class="text-blue-cb font-bold">TUDOAKI OFICIAL</strong></span>
                    </div>

                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <input type="checkbox" checked class="mt-1.5 accent-blue-cb w-4 h-4 rounded">
                            <div class="w-20 h-20 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center p-2 text-blue-cb">
                                <i class="fa-solid fa-box-open text-3xl"></i>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-xs md:text-sm font-bold text-gray-900 leading-snug"><?php echo $nomeProduto; ?></h3>
                                <div class="text-xs text-gray-500 pt-1">
                                    R$ <span id="valProdBase"><?php echo number_format($precoCheio, 2, ',', '.'); ?></span> ou 
                                    <div class="text-sm font-black text-blue-cb mt-0.5">
                                        R$ <span id="valProdPix"><?php echo number_format($precoPix, 2, ',', '.'); ?></span> <span class="text-[10px] font-normal text-gray-500">no PIX</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-end justify-between h-20">
                            <button onclick="window.location.href='index.php'" class="text-gray-400 hover:text-red-600 transition" title="Remover">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                            <div class="text-xs font-bold text-gray-700 bg-gray-100 px-3 py-1.5 rounded-md border border-gray-200 flex items-center gap-2">
                                01 un <i class="fa-solid fa-chevron-down text-[10px] text-gray-500"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bloco de Informações -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200 text-xs text-gray-600 space-y-2">
                    <h4 class="font-bold text-gray-900 mb-1 text-sm">Informações sobre preço e estoque</h4>
                    <p class="flex items-center gap-2"><span class="w-1 h-1 bg-gray-500 rounded-full"></span> Produtos no carrinho não são reservados. Realize o pagamento e garanta sua compra.</p>
                    <p class="flex items-center gap-2"><span class="w-1 h-1 bg-gray-500 rounded-full"></span> Itens promocionais possuem estoque limitado.</p>
                    <p class="flex items-center gap-2"><span class="w-1 h-1 bg-gray-500 rounded-full"></span> Valores podem ser alterados conforme opção de pagamento escolhida.</p>
                </div>

            </div>

            <!-- Coluna da Direita (Resumo do Pedido) -->
            <div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 space-y-4 sticky top-6">
                    <h2 class="text-lg font-bold text-blue-cb border-b border-gray-100 pb-3">Resumo do pedido</h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>01 Produto</span>
                            <span class="font-bold text-gray-900">R$ <span id="resumoProd"><?php echo number_format($precoCheio, 2, ',', '.'); ?></span></span>
                        </div>
                        <div class="flex justify-between text-gray-600 pb-3 border-b border-gray-100">
                            <span>Entrega (Correios)</span>
                            <span class="font-bold text-gray-700" id="resumoFreteValor">R$ 0,00</span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-gray-900 pt-1">
                            <span>Total</span>
                            <span class="text-blue-cb font-black text-lg" id="resumoTotal">R$<?php echo number_format($precoCheio, 2, ',', '.'); ?></span>
                        </div>
                        <div class="text-[11px] text-gray-500 text-right -mt-2">No cartão de crédito</div>

                        <div class="pt-3 border-t border-gray-100 flex justify-between items-center bg-blue-50/50 p-3 rounded-lg">
                            <div>
                                <span class="text-xs font-bold text-gray-900 block">Total no PIX</span>
                                <span class="text-[10px] text-emerald-700 font-bold">Com 5% de desconto</span>
                            </div>
                            <span class="text-xl font-black text-emerald-700" id="resumoTotalPix">R$<?php echo number_format($precoPix, 2, ',', '.'); ?></span>
                        </div>
                    </div>

                    <div id="avisoCep" class="bg-sky-50 border border-sky-200 rounded-lg p-3 text-[11px] text-sky-900 flex items-start gap-2">
                        <i class="fa-solid fa-circle-info text-blue-cb mt-0.5"></i>
                        <span>Informe seu CEP acima para calcular o frete dos Correios e atualizar o valor final.</span>
                    </div>

                    <!-- Formulário de Envio -->
                    <form action="endereco.php" method="POST" class="space-y-3 pt-2">
                        <input type="hidden" name="produto" value="<?php echo htmlspecialchars($nomeProduto); ?>">
                        <input type="hidden" id="inputValorFinal" name="valor" value="<?php echo $precoPix; ?>">
                        <input type="hidden" id="inputFreteValor" name="frete" value="0.00">

                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-gray-700 uppercase">Seu Nome / WhatsApp</label>
                            <input type="text" name="nome" required placeholder="Digite seu nome" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-blue-cb">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-gray-700 uppercase">CPF</label>
                            <input type="text" name="cpf" required placeholder="000.000.000-00" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-blue-cb">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[11px] font-bold text-gray-700 uppercase">Endereço de Entrega (CEP)</label>
                            <input type="text" id="inputEnderecoCompleto" name="endereco" required placeholder="Rua, Número, Bairro, Cidade" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-blue-cb">
                        </div>

                        <div class="space-y-2 pt-2">
                            <a href="index.php" class="block text-center w-full bg-white hover:bg-gray-50 text-blue-cb border-2 border-blue-cb font-bold py-3 rounded-xl text-xs uppercase transition shadow-sm">
                                Comprar mais produtos
                            </a>
                            <button type="submit" class="w-full btn-green-cb text-white font-black py-3.5 rounded-xl text-xs uppercase transition shadow-md flex items-center justify-center gap-2">
                                <span>Continuar a compra</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>

                    <div class="text-center text-[11px] text-gray-500 pt-2 border-t border-gray-100">
                        <span class="font-bold text-gray-700">Possui cupom ou vale?</span><br>
                        Você vai poder usar na etapa de pagamento.
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="bg-white text-gray-500 text-xs py-4 text-center border-t border-gray-200 mt-8">
        © 2026 tudoAki - Sua Loja de Tudo. Aqui. Todos os direitos reservados.
    </footer>

    <!-- Script de Consulta dos Correios via ViaCEP -->
    <script>
        const precoBaseOriginal = <?php echo $precoCheio; ?>;
        let freteSelecionadoValor = 0;

        function calcularFreteCorreios() {
            let cep = document.getElementById('inputCep').value.replace(/\D/g, '');
            if(cep.length !== 8) {
                alert('Por favor, digite um CEP válido com 8 dígitos.');
                return;
            }

            // Consulta API ViaCEP gratuita
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if(data.erro) {
                        alert('CEP não encontrado nos Correios.');
                        return;
                    }

                    // Exibe endereço encontrado
                    document.getElementById('enderecoInfo').innerText = `📍 ${data.logradouro}, ${data.bairro} - ${data.localidade}/${data.uf}`;
                    document.getElementById('inputEnderecoCompleto').value = `${data.logradouro}, - ${data.bairro}, ${data.localidade} - ${data.uf} (CEP: ${cep})`;

                    // Simula valores dos Correios com base na região (PAC e SEDEX)
                    let valorPac = 18.90;
                    let valorSedex = 32.50;
                    if(data.uf === 'SP') { // Frete mais em conta para São Paulo
                        valorPac = 14.50;
                        valorSedex = 22.00;
                    }

                    let htmlOpcoes = `
                        <label class="flex items-center justify-between p-2.5 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 text-xs">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="opcaoFrete" checked onchange="atualizarFrete(${valorPac}, 'PAC (5 a 8 dias)')" class="accent-blue-cb">
                                <div><strong>Correios PAC</strong> <span class="text-gray-500 block text-[10px]">5 a 8 dias úteis</span></div>
                            </div>
                            <span class="font-bold text-gray-800">R$ ${valorPac.toFixed(2).replace('.', ',')}</span>
                        </label>
                        <label class="flex items-center justify-between p-2.5 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 text-xs">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="opcaoFrete" onchange="atualizarFrete(${valorSedex}, 'SEDEX (2 a 3 dias)')" class="accent-blue-cb">
                                <div><strong>Correios SEDEX</strong> <span class="text-gray-500 block text-[10px]">2 a 3 dias úteis</span></div>
                            </div>
                            <span class="font-bold text-gray-800">R$ ${valorSedex.toFixed(2).replace('.', ',')}</span>
                        </label>
                    `;

                    document.getElementById('opcoesFreteLista').innerHTML = htmlOpcoes;
                    document.getElementById('resultadoFrete').classList.remove('hidden');
                    document.getElementById('avisoCep').classList.add('hidden');

                    // Seleciona PAC por padrão
                    atualizarFrete(valorPac, 'PAC');
                })
                .catch(error => {
                    alert('Erro ao consultar CEP. Tente novamente.');
                });
        }

        function atualizarFrete(valorFrete, tipo) {
            freteSelecionadoValor = valorFrete;
            let totalCredito = precoBaseOriginal + freteSelecionadoValor;
            let totalPix = (precoBaseOriginal * 0.95) + freteSelecionadoValor;

            document.getElementById('resumoFreteValor').innerText = 'R$ ' + valorFrete.toFixed(2).replace('.', ',');
            document.getElementById('resumoTotal').innerText = 'R$ ' + totalCredito.toFixed(2).replace('.', ',');
            document.getElementById('resumoTotalPix').innerText = 'R$ ' + totalPix.toFixed(2).replace('.', ',');
            document.getElementById('inputValorFinal').value = totalPix.toFixed(2);
            document.getElementById('inputFreteValor').value = valorFrete.toFixed(2);
        }
    </script>
</body>
</html>