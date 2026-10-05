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
    <title>Apoio Político 2026 - Contribuição de Campanha</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #0f172a; }
        .card-custom {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8), rgba(15, 23, 42, 0.95));
            border: 1px solid rgba(56, 189, 248, 0.2);
            backdrop-filter: blur(10px);
        }
        .candidate-btn {
            transition: all 0.2s ease;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }
        .candidate-btn.selected {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.15);
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
            <span class="font-semibold"><i class="fa-solid fa-flag text-blue-500 mr-1.5"></i> Campanha Eleitoral 2026</span>
            <span class="text-slate-400">Doação Segura</span>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl w-full mx-auto p-4 my-auto space-y-4">

        <!-- Banner / Título -->
        <div class="text-center space-y-1 mb-2">
            <h1 class="text-xl md:text-2xl font-extrabold text-white">Fortaleça Nossa Causa</h1>
            <p class="text-xs text-slate-400">Escolha o candidato que você apoia e defina o valor da sua contribuição.</p>
        </div>

        <div class="card-custom rounded-2xl p-5 shadow-xl space-y-5">

            <!-- Passo 1: Escolher Candidato -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                    1. Escolha o Candidato / Movimento:
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="selecionarCandidato('Flávio Bolsonaro')" id="cand-flavio" class="candidate-btn p-3 rounded-xl bg-slate-900/80 text-left flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-600/20 text-emerald-400 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-white block">Flávio Bolsonaro</span>
                            <span class="text-[10px] text-slate-400">Direita / Conservador</span>
                        </div>
                    </button>

                    <button type="button" onclick="selecionarCandidato('Lula')" id="cand-lula" class="candidate-btn p-3 rounded-xl bg-slate-900/80 text-left flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-red-600/20 text-red-400 flex items-center justify-center font-bold text-sm">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-white block">Lula</span>
                            <span class="text-[10px] text-slate-400">Esquerda / Progressista</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Passo 2: Escolher ou Digitar Valor -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                    2. Valor da Contribuição (R$):
                </label>

                <!-- Atalhos de Valores -->
                <div class="grid grid-cols-4 gap-2">
                    <button type="button" onclick="definirValor(50)" class="value-chip py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-bold text-slate-200 hover:bg-slate-800">R$ 50</button>
                    <button type="button" onclick="definirValor(100)" class="value-chip py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-bold text-slate-200 hover:bg-slate-800">R$ 100</button>
                    <button type="button" onclick="definirValor(250)" class="value-chip py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-bold text-slate-200 hover:bg-slate-800">R$ 250</button>
                    <button type="button" onclick="definirValor(500)" class="value-chip py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-bold text-slate-200 hover:bg-slate-800">R$ 500</button>
                </div>

                <!-- Input Personalizado -->
                <div class="relative mt-2">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm font-bold">R$</span>
                    <input type="number" id="valorPersonalizado" placeholder="Outro valor (Ex: 1000)" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-semibold" oninput="limparChips()">
                </div>
            </div>

            <!-- Botão de Avançar -->
            <button type="button" onclick="avancarCadastro()" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 text-sm">
                <span>Continuar para Dados de Apoio</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="text-center text-[10px] text-slate-500 py-3">
        Plataforma oficial de engajamento político e doações regulamentadas.
    </footer>

    <script>
        let candidatoSelecionado = "";
        let valorSelecionado = "";

        function selecionarCandidato(nome) {
            candidatoSelecionado = nome;
            
            // Atualiza classes visuais dos botões de candidato
            document.getElementById('cand-flavio').classList.remove('selected');
            document.getElementById('cand-lula').classList.remove('selected');

            if (nome === 'Flávio Bolsonaro') {
                document.getElementById('cand-flavio').classList.add('selected');
            } else {
                document.getElementById('cand-lula').classList.add('selected');
            }
        }

        function definirValor(valor) {
            valorSelecionado = valor;
            document.getElementById('valorPersonalizado').value = valor;

            // Remove classe ativa de todos os chips e adiciona no clicado
            let chips = document.querySelectorAll('.value-chip');
            chips.forEach(chip => chip.classList.remove('active'));
            event.target.classList.add('active');
        }

        function limparChips() {
            // Se o usuário digitar manualmente, remove a seleção dos chips rápidos
            let chips = document.querySelectorAll('.value-chip');
            chips.forEach(chip => chip.classList.remove('active'));
            valorSelecionado = document.getElementById('valorPersonalizado').value;
        }

        function avancarCadastro() {
            let valorFinal = document.getElementById('valorPersonalizado').value;

            if (!candidatoSelecionado) {
                alert("Por favor, selecione um candidato para apoiar.");
                return;
            }

            if (!valorFinal || valorFinal <= 0) {
                alert("Por favor, informe ou selecione um valor de contribuição válido.");
                return;
            }