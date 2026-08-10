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
    <title>Atendimento ao Cidadão</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #102a43; }
        .bg-custom-blue { background-color: #183b56; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <!-- Topo -->
    <header class="bg-custom-header text-white text-xs py-2 px-4">
        <div class="max-w-2xl mx-auto flex justify-between">
            <span>Portal de Serviços</span>
            <span>Acessibilidade | Transparência</span>
        </div>
    </header>

    <!-- Banner Principal -->
    <div class="bg-custom-blue text-white p-4 border-b-4 border-blue-600">
        <div class="max-w-2xl mx-auto flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center font-bold">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg">Autoatendimento</h1>
                <p class="text-xs text-blue-200">Selecione o serviço desejado</p>
            </div>
        </div>
    </div>

    <!-- Conteúdo -->
    <main class="max-w-md mx-auto p-4">

        <!-- Aviso em Rosa/Vermelho -->
        <div class="bg-red-100 border border-red-300 rounded-lg p-3 mb-4 flex items-start gap-3 text-red-800 text-xs">
            <i class="fa-solid fa-bullhorn text-red-600 text-base mt-0.5"></i>
            <div>
                <strong class="block mb-1">Atenção aos prazos:</strong>
                Selecione o serviço abaixo para dar início ao processo de solicitação e atualização de dados.
            </div>
        </div>

        <!-- Box de Opções -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <h2 class="font-bold text-gray-800 text-lg">Eleitora/Eleitor</h2>
            <p class="text-xs text-gray-500 mb-4">Solicite serviços para o seu documento</p>

            <div class="space-y-2">

                <button onclick="selecionarServico('Tirar primeiro título')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Tirar primeiro título</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                </button>

                <button onclick="selecionarServico('Transferir título eleitoral')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center">
                            <i class="fa-solid fa-right-left"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Transferir título eleitoral</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                </button>

                <button onclick="selecionarServico('Atualizar dados pessoais')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center">
                            <i class="fa-solid fa-pen"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Atualizar dados pessoais, endereço ou local de votação</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                </button>

                <button onclick="selecionarServico('Regularizar título cancelado')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Regularizar título cancelado</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                </button>

                <button onclick="selecionarServico('Emitir 2ª via')" class="w-full flex items-center justify-between p-3.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-blue-50 transition text-left">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded flex items-center justify-center">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Emitir 2ª via do título eleitoral</span>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-gray-400"></i>
                </button>

            </div>
        </div>

    </main>

    <script>
        function selecionarServico(nomeServico) {
            // Guarda o serviço escolhido
            localStorage.setItem('servico_escolhido', nomeServico);
            
            // Redireciona para a tela de CADASTRO que criamos
            window.location.href = 'cadastro.php?servico=' + encodeURIComponent(nomeServico);
        }
    </script>
</body>
</html>