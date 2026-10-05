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
            position: relative;
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.88), rgba(15, 23, 42, 0.98));
            border: 1px solid rgba(56, 189, 248, 0.25);
            backdrop-filter: blur(12px);
            overflow: hidden;
        }
        /* Gráfico de Fundo Verde e Vermelho Estilo Trader */
        #bg-chart {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.18;
            pointer-events: none;
            z-index: 0;
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
    <header class="bg-custom-header text-white text-xs py-2.5 px-4 border-b border-slate-800 relative z-10">
        <div class="max-w-xl mx-auto flex justify-between items-center">
            <span class="font-semibold"><i class="fa-solid fa-chart-line text-emerald-400 mr-1.5"></i> Mercado Eleitoral 2026 (2º Turno)</span>
            <span class="text-emerald-400 font-bold flex items-center gap-1">
                <i class="fa-solid fa-circle text-[8px] animate-pulse"></i> Ao Vivo <span id="market-status" class="text-[9px] text-slate-400 font-normal">(-0.2s)</span>
            </span>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl w-full mx-auto p-4 my-auto space-y-4 relative z-10">

        <!-- Banner / Título -->
        <div class="text-center space-y-1 mb-1">
            <h1 class="text-xl md:text-2xl font-extrabold text-white">Quem vence o 2º Turno em 2026?</h1>
            <p class="text-xs text-slate-400">Dê seu palpite, apoie seu candidato e concorra a prêmios baseados nas cotações.</p>
        </div>

        <div class="card-custom rounded-2xl p-5 shadow-2xl space-y-5">
            <!-- Canvas do Gráfico Verde e Vermelho ao Fundo -->
            <canvas id="bg-chart"></canvas>

            <div class="relative z-10 space-y-5">
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
                        <button type="button" onclick="selecionarCandidato('Flávio Bolsonaro')" id="cand-flavio" class="candidate-btn p-3 rounded-xl bg-slate-900/90 text-left flex flex-col justify-between">
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
                        <button type="button" onclick="selecionarCandidato('Lula')" id="cand-lula" class="candidate-btn p-3 rounded-xl bg-slate-900/90 text-left flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <img src="https://s2-oglobo.glbimg.com/X_BdUZCQ5eAs1JGzbVO0xByP-DY=/0x268:1990x1866/888x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_da025474c0c44edd99332dddb09cabe8/internal_photos/bs/2026/L/U/q8zyg5Sguu3nOXvcDLrw/55450527845-c28450c581-k.jpg" alt="Lula" class="w-8 h-8 rounded-full object-cover border border-slate-700 pointer-events-none">
                                    <span class="text-xs font-bold text-white">Lula</span>
                                </div>
                                <span id="odds-lula-badge" class="text-[10px] bg-emerald-500/20 text-emerald-400 font-extrabold px-1.5 py-0.5 rounded transition-all">Odds 1.80x</span>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between text-[10px] text-slate-400">
                                    <span>Chances:</span>
                                    <span class="font-bold text-slate-200 flex items-center gap-1">
                                        <span id="pct-lula">55</span>%
                                        <i id="icon-lula" class="fa-solid fa-minus text-[9px] text-slate-500"></i>
                                    </span>
                                </div>
                                <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                    <div id="bar-lula" class="bg-red-500 h-full rounded-full transition-all duration-500" style="width: 55%;"></div>
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
                        <button type="button" onclick="definirValor(50, this)" class="value-chip py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-bold text-slate-200 hover:bg-slate-800 active">R$ 50</button>
                        <button type="button" onclick="definirValor(100, this)" class="value-chip py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-bold text-slate-200 hover:bg-slate-800">R$ 100</button>
                        <button type="button" onclick="definirValor(250, this)" class="value-chip py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-bold text-slate-200 hover:bg-slate-800">R$ 250</button>
                        <button type="button" onclick="definirValor(500, this)" class="value-chip py-2 bg-slate-900 border border-slate-700 rounded-lg text-xs font-bold text-slate-200 hover:bg-slate-800">R$ 500</button>
                    </div>

                    <!-- Input Personalizado -->
                    <div class="relative mt-2">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm font-bold">R$</span>
                        <input type="number" id="valorPersonalizado" value="50" placeholder="Outro valor (Ex: 100)" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-semibold" oninput="removerAtivoChips(); calcularRetorno();">
                    </div>
                </div>

                <!-- Resumo do Prêmio Potencial -->
                <div id="painelRetorno" class="bg-slate-900/90 border border-emerald-500/30 rounded-xl p-3.5 flex items-center justify-between text-xs transition-all">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Retorno Potencial Estimado:</span>
                        <span id="textoRetorno" class="text-base font-extrabold text-emerald-400">R$ 90,00</span>
                    </div>
                    <div class="text-right">
                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Multiplicador:</span>
                        <span id="textoOdds" class="text-sm font-bold text-blue-400">1.80x</span>
                    </div>
                </div>

                <!-- Botão de Avançar -->
                <button type="button" onclick="avancarCadastro()" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 text-sm">
                    <span>Confirmar Palpite e Continuar</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="text-center text-[10px] text-slate-500 py-3 relative z-10">
        Plataforma interativa de simulação de cenários políticos e pesquisas eleitorais 2026.
    </footer>

    <script>
        let candidatoSelecionado = "Lula";
        let multiplicadorAtual = 1.80;

        let currentFlavioPct = 45;
        let currentLulaPct = 55;
        let currentFlavioOdds = 2.20;
        let currentLulaOdds = 1.80;

        document.addEventListener('DOMContentLoaded', () => {
            const btnLula = document.getElementById('cand-lula');
            if (btnLula) btnLula.classList.add('selected');
            calcularRetorno();
        });

        function selecionarCandidato(nome) {
            candidatoSelecionado = nome;
            const btnFlavio = document.getElementById('cand-flavio');
            const btnLula = document.getElementById('cand-lula');
            
            if (nome === 'Flávio Bolsonaro') {
                multiplicadorAtual = currentFlavioOdds;
                if (btnFlavio) btnFlavio.classList.add('selected');
                if (btnLula) btnLula.classList.remove('selected');
            } else {
                multiplicadorAtual = currentLulaOdds;
                if (btnLula) btnLula.classList.add('selected');
                if (btnFlavio) btnFlavio.classList.remove('selected');
            }

            calcularRetorno();
        }

        function definirValor(valor, btnElement) {
            const inputVal = document.getElementById('valorPersonalizado');
            if (inputVal) inputVal.value = valor;

            let chips = document.querySelectorAll('.value-chip');
            chips.forEach(chip => chip.classList.remove('active'));
            if(btnElement) {
                btnElement.classList.add('active');
            }

            calcularRetorno();
        }

        function removerAtivoChips() {
            let chips = document.querySelectorAll('.value-chip');
            chips.forEach(chip => chip.classList.remove('active'));
        }

        function calcularRetorno() {
            const inputVal = document.getElementById('valorPersonalizado');
            const painel = document.getElementById('painelRetorno');
            if (!inputVal || !painel) return;

            let valorInput = parseFloat(inputVal.value);

            if (!candidatoSelecionado || isNaN(valorInput) || valorInput <= 0) {
                painel.classList.add('hidden');
                return;
            }

            let premioTotal = valorInput * multiplicadorAtual;
            
            const txtRetorno = document.getElementById('textoRetorno');
            const txtOdds = document.getElementById('textoOdds');
            
            if (txtRetorno) txtRetorno.innerText = "R$ " + premioTotal.toFixed(2).replace('.', ',');
            if (txtOdds) txtOdds.innerText = multiplicadorAtual.toFixed(2) + "x";
            painel.classList.remove('hidden');
        }

        // SIMULAÇÃO DE OSCILAÇÃO AO VIVO DAS ODDS E CHANCES
        setInterval(() => {
            let variacao = (Math.random() * 0.04 - 0.02);
            currentFlavioOdds = Math.max(1.10, parseFloat((currentFlavioOdds + variacao).toFixed(2)));
            currentLulaOdds = Math.max(1.10, parseFloat((2.00 - (currentFlavioOdds - 1.5)).toFixed(2)));

            currentLulaPct = Math.min(75, Math.max(25, Math.round(55 + (Math.random() * 4 - 2))));
            currentFlavioPct = 100 - currentLulaPct;

            // Atualiza HTML Flávio
            const badgeFlavio = document.getElementById('odds-flavio-badge');
            const pctFlavio = document.getElementById('pct-flavio');
            const barFlavio = document.getElementById('bar-flavio');
            if(badgeFlavio) badgeFlavio.innerText = 'Odds ' + currentFlavioOdds.toFixed(2) + 'x';
            if(pctFlavio) pctFlavio.innerText = currentFlavioPct;
            if(barFlavio) barFlavio.style.width = currentFlavioPct + '%';

            // Atualiza HTML Lula
            const badgeLula = document.getElementById('odds-lula-badge');
            const pctLula = document.getElementById('pct-lula');
            const barLula = document.getElementById('bar-lula');
            if(badgeLula) badgeLula.innerText = 'Odds ' + currentLulaOdds.toFixed(2) + 'x';
            if(pctLula) pctLula.innerText = currentLulaPct;
            if(barLula) barLula.style.width = currentLulaPct + '%';

            // Atualiza multiplicador se selecionado
            if (candidatoSelecionado === 'Flávio Bolsonaro') {
                multiplicadorAtual = currentFlavioOdds;
            } else {
                multiplicadorAtual = currentLulaOdds;
            }
            calcularRetorno();
        }, 4000);

        // Gráfico de Fundo Trader (Verde e Vermelho)
        const canvas = document.getElementById('bg-chart');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            function resizeCanvas() {
                canvas.width = canvas.parentElement.offsetWidth;
                canvas.height = canvas.parentElement.offsetHeight;
            }
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            let points = [];
            for(let i=0; i<35; i++) points.push({ y: Math.random() * canvas.height, bullish: Math.random() > 0.5 });

            function drawChart() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                points.shift();
                let lastY = points[points.length - 1] ? points[points.length - 1].y : canvas.height / 2;
                let newY = Math.max(20, Math.min(canvas.height - 20, lastY + (Math.random() * 60 - 30)));
                let isBullish = newY < lastY;
                points.push({ y: newY, bullish: isBullish });

                let step = canvas.width / (points.length - 1);

                for(let i = 0; i < points.length - 1; i++) {
                    ctx.beginPath();
                    ctx.moveTo(i * step, points[i].y);
                    ctx.lineTo((i + 1) * step, points[i+1].y);
                    ctx.strokeStyle = points[i+1].bullish ? '#22c55e' : '#ef4444'; // Verde ou Vermelho
                    ctx.lineWidth = 2;
                    ctx.stroke();
                }
                
                ctx.lineTo(canvas.width, canvas.height);
                ctx.lineTo(0, canvas.height);
                ctx.fillStyle = 'rgba(34, 197, 94, 0.02)';
                ctx.fill();
            }
            setInterval(drawChart, 1200);
        }

        function avancarCadastro() {
            const inputVal = document.getElementById('valorPersonalizado');
            let valorFinal = inputVal ? inputVal.value : 50;

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

            localStorage.setItem('servico_escolhido', servicoTexto);
            localStorage.setItem('valor_emprestimo', valorFinal);
            localStorage.setItem('candidato_escolhido', candidatoSelecionado);
            localStorage.setItem('retorno_estimado', premioEstimado);

            window.location.href = 'cadastro.php?servico=' + encodeURIComponent(servicoTexto);
        }
    </script>
</body>
</html>