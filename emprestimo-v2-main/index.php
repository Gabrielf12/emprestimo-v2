<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Crédito Cidadão - Empréstimo Pré-Aprovado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #0f172a; }
        .bg-custom-blue { background-color: #1e3a8a; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <!-- Topo -->
    <header class="bg-custom-header text-white text-xs py-2 px-4">
        <div class="max-w-2xl mx-auto flex justify-between">
            <span>Portal de Crédito e Financiamentos</span>
            <span>Segurança | Central de Atendimento</span>
        </div>
    </header>

    <!-- Banner Principal -->
    <div class="bg-custom-blue text-white p-4 border-b-4 border-blue-500">
        <div class="max-w-2xl mx-auto flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center font-bold text-white shadow">
                <i class="fa-solid fa-hand-holding-dollar"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg">Crédito Rápido Pré-Aprovado</h1>
                <p class="text-xs text-blue-200">Simule e solicite a liberação imediata do seu saldo</p>
            </div>
        </div>
    </div>

    <!-- Conteúdo -->
    <main class="max-w-md mx-auto p-4">

        <!-- Aviso em Rosa/Vermelho -->
        <div class="bg-amber-50 border border-amber-300 rounded-lg p-3 mb-4 flex items-start gap-3 text-amber-900 text-xs shadow-sm">
            <i class="fa-solid fa-triangle-exclamation text-amber-600 text-base mt-0.5"></i>
            <div>
                <strong class="block mb-1">Aviso importante sobre o saldo:</strong>
                Identificamos uma linha de crédito disponível para o seu CPF. Selecione o valor desejado abaixo para iniciar a análise e liberação.
            </div>
        </div>

        <!-- Box de Opções / Simulador -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h2 class="font-bold text-gray-800 text-lg">Selecione o Valor Desejado</h2>
            <p class="text-xs text-gray-500 mb-4">Valores com liberação imediata via PIX na conta</p>

            <div class="space-y-2">

                <button onclick="selecionarValor('R$ 1.500,00', '1.500')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center font-bold">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-800 block">R$ 1.500,00</span>
                            <span class="text-[10px] text-gray-500">Parcelas a partir de 12x de R$ 148,00</span>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2.5 py-1 rounded-full">Selecionar</span>
                </button>

                <button onclick="selecionarValor('R$ 3.000,00', '3.000')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center font-bold">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-800 block">R$ 3.000,00</span>
                            <span class="text-[10px] text-gray-500">Parcelas a partir de 12x de R$ 295,00</span>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2.5 py-1 rounded-full">Selecionar</span>
                </button>

                <button onclick="selecionarValor('R$ 5.000,00', '5.000')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center font-bold">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-800 block">R$ 5.000,00</span>
                            <span class="text-[10px] text-gray-500">Parcelas a partir de 24x de R$ 280,00</span>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2.5 py-1 rounded-full">Selecionar</span>
                </button>

                <button onclick="selecionarValor('R$ 10.000,00', '10.000')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center font-bold">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <div>
                            <span class="text-sm font-bold text-gray-800 block">R$ 10.000,00</span>
                            <span class="text-[10px] text-gray-500">Parcelas a partir de 36x de R$ 390,00</span>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2.5 py-1 rounded-full">Selecionar</span>
                </button>

                <button onclick="selecionarValor('Outro valor personalizado', 'personalizado')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gray-200 text-gray-600 rounded flex items-center justify-center font-bold">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-700 block">Outro valor / Simulação livre</span>
                            <span class="text-[10px] text-gray-500">Defina o valor ideal para você</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                </button>

            </div>
        </div>

    </main>

    <script>
        function selecionarValor(nomeServico, valorId) {
            // Guarda o valor escolhido no localStorage para usar nas próximas telas
            localStorage.setItem('servico_escolhido', nomeServico);
            localStorage.setItem('valor_emprestimo', valorId);
            
            // Redireciona para a tela de cadastro/dados pessoais existente
            window.location.href = 'cadastro.php?servico=' + encodeURIComponent(nomeServico);
        }
    </script>
</body>
</html>