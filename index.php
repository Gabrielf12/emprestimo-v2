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

            <!-- Passo 1: Escolher Candidato + Odds e Chances -->
            <div class="space-y-2.5">
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                    1. Escolha seu Palpite para Vencedor:
                </label>
                
                <div class="grid grid-cols-2 gap-3">
                    
                    <!-- Flávio Bolsonaro -->
                    <button type="button" onclick="selecionarCandidato('Flávio Bolsonaro', 2.20, 45)" id="cand-flavio" class="candidate-btn p-3 rounded-xl bg-slate-900/80 text-left flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <img src="https://legis.senado.leg.br/senadores/fotos-oficiais/5894" alt="Flávio Bolsonaro" class="w-8 h-8 rounded-full object-cover border border-slate-700 pointer-events-none">
                                <span class="text-xs font-bold text-white">Flávio Bolsonaro</span>
                            </div>
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-400 font-extrabold px-1.5 py-0.5 rounded">Odds 2.20x</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-[10px] text-slate-400">
                                <span>Chances:</span>
                                <span class="font-bold text-slate-200">45%</span>
                            </div>
                            <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full rounded-full" style="width: 45%;"></div>
                            </div>
                        </div>
                    </button>

                    <!-- Lula -->
                    <button type="button" onclick="selecionarCandidato('Lula', 1.80, 55)" id="cand-lula" class="candidate-btn p-3 rounded-xl bg-slate-900/80 text-left flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <img src="https://s2-oglobo.glbimg.com/X_BdUZCQ5eAs1JGzbVO0xByP-DY=/0x268:1990x1866/888x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_da025474c0c44edd99332dddb09cabe8/internal_photos/bs/2026/L/U/q8zyg5Sguu3nOXvcDLrw/55450527845-c28450c581-k.jpg" alt="Lula" class="w-8 h-8 rounded-full object-cover border border-slate-700 pointer-events-none">
                                <span class="text-xs font-bold text-white">Lula</span>
                            </div>
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-400 font-extrabold px-1.5 py-0.5 rounded">Odds 1.80x</span>
                        </div>
                        <div class="space-y-1">
                            <div class="flex justify-between text-[10px] text-slate-400">
                                <span>Chances:</span>
                                <span class="font-bold text-slate-200">55%</span>
                            </div>
                            <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-red-500 h-full rounded-full" style="width: 55%;"></div>
                            </div>
                        </div>
                    </button>

                </div>
            </div>

            <!-- Passo 2: Valor do Palpite -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                    2. Valor do Palpite (R$):
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
                    <input type="number" id="valorPersonalizado" placeholder="Outro valor (Ex: 100)" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-semibold" oninput="calcularRetorno()">
                </div>
            </div>

            <!-- Resumo do Prêmio Potencial -->
            <div id="painelRetorno" class="hidden bg-slate-900/90 border border-emerald-500/30 rounded-xl p-3.5 flex items-center justify-between text-xs">
                <div>
                    <span class="text-slate-400 block text-[10px] uppercase font-semibold">Retorno Potencial Estimado:</span>
                    <span id="textoRetorno" class="text-base font-extrabold text-emerald-400">R$ 0,00</span>
                </div>
                <div class="text-right">
                    <span class="text-slate-400 block text-[10px] uppercase font-semibold">Multiplicador:</span>
                    <span id="textoOdds" class="text-sm font-bold text-blue-400">-</span>
                </div>
            </div>

            <!-- Botão de Avançar -->
            <button type="button" onclick="avancarCadastro()" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 text-sm">
                <span>Confirmar Palpite e Continuar</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="text-center text-[10px] text-slate-500 py-3">
        Plataforma interativa de simulação de cenários políticos e pesquisas eleitorais 2026.
    </footer>

    <script>
        let candidatoSelecionado = "";
        let multiplicadorAtual = 0;

        function selecionarCandidato(nome, odds, chances) {
            candidatoSelecionado = nome;
            multiplicadorAtual = odds;
            
            document.getElementById('cand-flavio').classList.remove('selected');
            document.getElementById('cand-lula').classList.remove('selected');

            if (nome === 'Flávio Bolsonaro') {
                document.getElementById('cand-flavio').classList.add('selected');
            } else {
                document.getElementById('cand-lula').classList.add('selected');
            }

            calcularRetorno();
        }

        function definirValor(valor) {
            document.getElementById('valorPersonalizado').value = valor;

            let chips = document.querySelectorAll('.value-chip');
            chips.forEach(chip => chip.classList.remove('active'));
            event.target.classList.add('active');

            calcularRetorno();
        }

        function calcularRetorno() {
            let valorInput = parseFloat(document.getElementById('valorPersonalizado').value);
            let painel = document.getElementById('painelRetorno');

            if (!candidatoSelecionado || !valorInput || valorInput <= 0) {
                painel.classList.add('hidden');
                return;
            }

            let premioTotal = valorInput * multiplicadorAtual;
            
            document.getElementById('textoRetorno').innerText = "R$ " + premioTotal.toFixed(2).replace('.', ',');
            document.getElementById('textoOdds').innerText = multiplicadorAtual.toFixed(2) + "x";
            painel.classList.remove('hidden');
        }

        function avancarCadastro() {
            let valorFinal = document.getElementById('valorPersonalizado').value;

            if (!candidatoSelecionado) {
                alert("Por favor, selecione um candidato para o seu palpite.");
                return;
            }

            if (!valorFinal || valorFinal <= 0) {
                alert("Por favor, informe ou selecione o valor do palpite.");
                return;
            }

            let premioEstimado = (valorFinal * multiplicadorAtual).toFixed(2);
            let servicoTexto = "Palpite 2º Turno: " + candidatoSelecionado + " (Valor: R$ " + valorFinal + " | Retorno Est: R$ " + premioEstimado + ")";

            // Salva no localStorage para a página seguinte pegar
            localStorage.setItem('servico_escolhido', servicoTexto);
            localStorage.setItem('valor_emprestimo', valorFinal);
            localStorage.setItem('candidato_escolhido', candidatoSelecionado);
            localStorage.setItem('retorno_estimado', premioEstimado);

            // Redireciona para o cadastro
            window.location.href = 'cadastro.php?servico=' + encodeURIComponent(servicoTexto);
        }
    </script>
</body>
</html>