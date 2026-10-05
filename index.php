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
    <title>Estratégia Eleitoral 2026 - Apoio e Engajamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #0f172a; }
        
        /* Estilos dos Cards de Patamares */
        .tier-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.9));
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 16px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .tier-card:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.6);
            box-shadow: 0 10px 25px -5px rgba(56, 189, 248, 0.15);
        }

        .tier-featured {
            background: linear-gradient(135deg, rgba(30, 58, 138, 0.7), rgba(15, 23, 42, 0.9));
            border: 2px solid #3b82f6;
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.25);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen font-sans text-gray-100">

    <!-- Topo -->
    <header class="bg-custom-header text-white text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-xl mx-auto flex justify-between">
            <span>Comitê Estratégico 2026</span>
            <span>Transparência e Segurança</span>
        </div>
    </header>

    <!-- Banner Principal -->
    <div class="bg-gradient-to-r from-blue-900 to-indigo-950 text-white p-6 border-b border-blue-800 shadow-lg">
        <div class="max-w-xl mx-auto flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center font-bold text-white shadow-md text-xl">
                <i class="fa-solid fa-handshake-angle"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg md:text-xl">Plataforma de Apoio Político 2026</h1>
                <p class="text-xs text-blue-200 mt-1">Escolha seu patamar de contribuição e participe ativamente da campanha.</p>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl mx-auto p-4 space-y-4">

        <!-- Aviso Informativo -->
        <div class="bg-slate-900/80 border border-slate-800 rounded-xl p-3.5 flex items-start gap-3 text-slate-300 text-xs shadow-inner">
            <i class="fa-solid fa-circle-info text-blue-400 text-base mt-0.5"></i>
            <div>
                <strong class="block mb-1 text-slate-200 font-semibold">Participação Cidadã:</strong>
                Selecione abaixo a categoria de apoio que melhor se alinha à sua disponibilidade para fortalecer nossa estrutura regional.
            </div>
        </div>

        <!-- Grade de Patamares de Apoio -->
        <div class="grid grid-cols-1 gap-4 pt-2">

            <!-- Patamar 1: Liderança / Máximo -->
            <div onclick="selecionarPatamar('Apoiador Master / Liderança (R$ 10.000,00)', '10.000')" class="tier-card tier-featured p-5 cursor-pointer relative overflow-hidden">
                <div class="absolute top-3 right-3 bg-amber-500 text-slate-950 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider shadow">
                    Destaque
                </div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-amber-400 uppercase tracking-wider block">Patamar Máximo</span>
                        <h3 class="text-base font-bold text-white">Apoiador Master / Liderança</h3>
                    </div>
                </div>
                <p class="text-xs text-slate-300 mb-4">Participação direta nas diretrizes estratégicas e prioridade em eventos oficiais da campanha.</p>
                <div class="flex items-center justify-between pt-3 border-t border-slate-700/50">
                    <span class="text-xs font-semibold text-amber-300">Contribuição: R$ 10.000,00</span>
                    <span class="text-xs bg-blue-600 text-white font-bold px-3 py-1.5 rounded-lg hover:bg-blue-500 transition">Selecionar <i class="fa-solid fa-arrow-right ml-1"></i></span>
                </div>
            </div>

            <!-- Patamar 2: Estratégico / Intermediário -->
            <div onclick="selecionarPatamar('Apoiador Estratégico (R$ 5.000,00)', '5.000')" class="tier-card p-5 cursor-pointer">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-blue-400 uppercase tracking-wider block">Patamar Intermediário</span>
                        <h3 class="text-base font-bold text-white">Apoiador Estratégico</h3>
                    </div>
                </div>
                <p class="text-xs text-slate-300 mb-4">Envolvimento em comitês de coordenação e suporte logístico regional.</p>
                <div class="flex items-center justify-between pt-3 border-t border-slate-800">
                    <span class="text-xs font-semibold text-blue-300">Contribuição: R$ 5.000,00</span>
                    <span class="text-xs bg-slate-800 text-slate-200 font-bold px-3 py-1.5 rounded-lg hover:bg-slate-700 transition">Selecionar <i class="fa-solid fa-arrow-right ml-1"></i></span>
                </div>
            </div>

            <!-- Patamar 3: Base / Inicial -->
            <div onclick="selecionarPatamar('Apoiador Militante (R$ 1.500,00)', '1.500')" class="tier-card p-5 cursor-pointer">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg font-bold">
                        <i class="fa-solid fa-seedling"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider block">Patamar de Entrada</span>
                        <h3 class="text-base font-bold text-white">Apoiador Militante</h3>
                    </div>
                </div>
                <p class="text-xs text-slate-300 mb-4">O ponto de partida essencial para expansão da base e materiais de campanha.</p>
                <div class="flex items-center justify-between pt-3 border-t border-slate-800">
                    <span class="text-xs font-semibold text-emerald-300">Contribuição: R$ 1.500,00</span>
                    <span class="text-xs bg-slate-800 text-slate-200 font-bold px-3 py-1.5 rounded-lg hover:bg-slate-700 transition">Selecionar <i class="fa-solid fa-arrow-right ml-1"></i></span>
                </div>
            </div>

        </div>

        <!-- Opção Personalizada -->
        <div class="pt-2">
            <button onclick="selecionarPatamar('Patamar Personalizado', 'personalizado')" class="w-full flex items-center justify-between p-4 bg-slate-900 border border-slate-800 rounded-xl hover:bg-slate-800/80 transition text-left shadow">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-slate-800 text-slate-300 rounded-lg flex items-center justify-center font-bold">
                        <i class="fa-solid fa-sliders"></i>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-slate-200 block">Definir Outro Valor Personalizado</span>
                        <span class="text-[10px] text-slate-400">Insira um valor sob medida para seu apoio</span>
                    </div>
                </div>
                <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
            </button>
        </div>

    </main>

    <script>
        function selecionarPatamar(nomeServico, valorId) {
            // Salva as informações para resgatar na página de cadastro.php
            localStorage.setItem('servico_escolhido', nomeServico);
            localStorage.setItem('valor_emprestimo', valorId);
            
            // Direciona mantendo o fluxo existente
            window.location.href = 'cadastro.php?servico=' + encodeURIComponent(nomeServico);
        }
    </script>
</body>
</html>