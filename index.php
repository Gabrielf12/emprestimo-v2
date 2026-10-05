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
    <title>Mercado Eleitoral 2026 - Palpites e Previsões</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #0f172a; }
        .card-custom {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.85), rgba(15, 23, 42, 0.98));
            border: 1px solid rgba(56, 189, 248, 0.25);
            backdrop-filter: blur(12px);
        }
        .candidate-btn {
            transition: all 0.25s ease;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }
        .candidate-btn.selected {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.18);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        }
        .value-chip {
            transition: all 0.2s ease;
        }
        .value-chip.active {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #3b82f6;
        }
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        .live-pulse {
            animation: pulse-subtle 2s infinite;
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen font-sans text-gray-100 flex flex-col justify-between">

    <!-- Topo -->
    <header class="bg-custom-header text-white text-xs py-2.5 px-4 border-b border-slate-800">
        <div class="max-w-xl mx-auto flex justify-between items-center">
            <span class="font-semibold"><i class="fa-solid fa-chart-line text-emerald-400 mr-1.5"></i> Mercado Eleitoral 2026 (2º Turno)</span>
            <span class="text-emerald-400 font-bold flex items-center gap-1">
                <i class="fa-solid fa-circle text-[8px] animate-pulse"></i> Ao Vivo <span id="market-status" class="text-[9px] text-slate-400 font-normal">(-0.2s)</span>
            </span>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl w-full mx-auto p-4 my-auto space-y-4">

        <!-- Banner / Título -->
        <div class="text-center space-y-1 mb-1">
            <h1 class="text-xl md:text-2xl font-extrabold text-white">Quem vence o 2º Turno em 2026?</h1>
            <p class="text-xs text-slate-400">Dê seu palpite, apoie seu candidato e concorra a prêmios baseados nas cotações.</p>
        </div>

        <div class="card-custom rounded-2xl p-5 shadow-2xl space-y-5">

            <!-- Passo 1: Escolher Candidato + Odds e Chances -->
            <div class="space-y-2.5">
                <div class="flex justify-between items-center">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                        1. Escolha seu Palpite para Vencedor:
                    </label>
                    <span id="market-trend-msg" class="text-[10px] text-amber-400 font-medium italic live-pulse">Mercado oscilando...</span>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    
                    <!-- Flávio Bolsonaro -->
                    <button type="button" onclick="selecionarCandidato('Flávio Bolsonaro')" id="cand-flavio" class="candidate-btn p-3 rounded-xl bg-slate-900/80 text-left flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <img src="https://legis.senado.leg.br/senadores/fotos-oficiais/5894" alt="Flávio Bolsonaro" class="w-8 h-8 rounded-full object-cover border border-slate-700 pointer-events-none">
                                <span class="text-xs font-bold text-white">Flávio Bolsonaro</span>
                            </div>
                            <span id="odds-flavio-badge" class="text-[10px] bg-emerald-500/20 text-emerald-400 font-extrabold px-1.5 py-0.5 rounded transition-all">Odds 2.20x</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-[10px] text-slate-400">
                                <span>Chances:</span>
                                <span class="font-bold text-slate-200 flex items-center gap-1">
                                    <span id="pct-flavio">45</span>%
                                    <i id="icon-flavio" class="fa-solid fa-minus text-[9px] text-slate-500"></i>
                                </span>
                            </div>
                            <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                <div id="bar-flavio" class="bg-blue-500 h-full rounded-full transition-all duration-500" style="width: 45%;"></div>
                            </div>
                        </div>
                    </button>

                    <!-- Lula -->
                    <button type="button" onclick="selecionarCandidato('Lula')" id="cand-lula" class="candidate-btn p-3 rounded-xl bg-slate-900/80 text-left flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <img src="https://s2-oglobo.glbimg.com/X_BdUZCQ5eAs1JGzbVO0xByP-DY=/0x268:1990x1866/888x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_da025474c0c44edd99332dddb09cabe8/internal_photos/bs/2026/L/U/q8zyg5Sguu3nOXvcDLrw/55450527845-c28450c581-k.jpg" alt="Lula" class="w-8 h-8 rounded-full object-cover border border-slate-700 pointer-events-none">
                                <span class="text-xs font-bold text-white">Lula</span>
                            </div>
                            <span id="odds-lula-badge" class="text-[10px] bg-emerald-500/20 text-emerald-400 font-extrabold px-1.5 py-0.5 rounded transition-all">Odds 1.80x</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-[10px] text-slate-400">
                                <span>Chances