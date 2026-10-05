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
    </style>
</head>
<body class="bg-slate-950 min-h-screen font-sans text-gray-100 flex flex-col justify-between">

    <!-- Topo -->
    <header class="bg-custom-header text-white text-xs py-2.5 px-4 border-b border-slate-800">
        <div class="max-w-xl mx-auto flex justify-between items-center">
            <span class="font-semibold"><i class="fa-solid fa-chart-line text-emerald-400 mr-1.5"></i> Mercado Eleitoral 2026 (2º Turno)</span>
            <span class="text-emerald-400 font-bold"><i class="fa-solid fa-circle text-[8px] animate-pulse mr-1"></i> Ao Vivo</span>
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

            <!-- Passo 1: Escolher Candidato + Fotos, Odds e Chances -->
            <div class="space-y-2.5">
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                    1. Escolha seu Palpite para Vencedor:
                </label>
                
                <div class="grid grid-cols-2 gap-3">
                    
                    <!-- Flávio Bolsonaro -->
                    <button type="button" onclick="selecionarCandidato('Flávio Bolsonaro', 2.20, 45)" id="cand-flavio" class="candidate-btn p-3 rounded-xl bg-slate-900/80 text-left flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cb/Fl%C3%A1vio_Bolsonaro_em_2023.jpg/220px-Fl%C3%A1vio_Bolsonaro_em_2023.jpg" alt="Flávio Bolsonaro" class="w-9 h-9 rounded-full object-cover border border-slate-700">
                                <span class="text-xs font-bold text-white leading-tight">Flávio Bolsonaro</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-[10px] text-slate-400">Chances: <strong class="text-slate-200">45%</strong></span>
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-400 font-extrabold px-1.5 py-0.5 rounded">2.20x</span>
                        </div>
                        <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 45%;"></div>
                        </div>
                    </button>

                    <!-- Lula -->
                    <button type="button" onclick="selecionarCandidato('Lula', 1.80, 55)" id="cand-lula" class="candidate-btn p-3 rounded-xl bg-slate-900/80 text-left flex flex-col justify-between">
                        <div class="flex items-