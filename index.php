<?php
// Ficheiro: index.php - Página Principal com Gráfico de Fundo e Oscilação
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado Eleitoral 2026 - 2º Turno</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-custom {
            position: relative;
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.90), rgba(15, 23, 42, 0.98));
            border: 1px solid rgba(56, 189, 248, 0.25);
            backdrop-filter: blur(12px);
            overflow: hidden;
        }
        /* Gráfico de fundo canvas */
        #bg-chart {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40%;
            opacity: 0.15;
            pointer-events: none;
        }
        .candidate-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .candidate-card.selected {
            border-color: #3b82f6;
            background-color: rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen font-sans text-gray-100 flex flex-col items-center justify-center p-4">

    <div class="text-center mb-6">
        <h1 class="text-3xl font-extrabold tracking-tight text-white mb-1">Quem vence o 2º Turno em 2026?</h1>
        <p class="text-xs text-slate-400">Dê seu palpite, apoie seu candidato e concorra a prêmios baseados nas cotações.</p>
    </div>

    <div class="card-custom rounded-2xl shadow-2xl p-6 w-full max-w-xl">
        <!-- Canvas do Gráfico ao Fundo -->
        <canvas id="bg-chart"></canvas>

        <div class="relative z-10">
            <div class="flex justify-between items-center mb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-300">1. Escolha seu palpite para vencedor:</span>
                <span class="text-[10px] text-amber-400 font-semibold animate-pulse flex items-center gap-1">
                    <i class="fa-solid fa-chart-line"></i> Mercado oscilando...
                </span>
            </div>

            <!-- Candidatos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                <!-- Flávio Bolsonaro -->
                <div id="candidate-1" onclick="selectCandidate(1)" class="candidate-card bg-slate-900/80 border border-slate-700 rounded-xl p-3.5 relative">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center font-bold text-xs text-slate-300 overflow-hidden border border-slate-600">
                                <i class="fa-solid fa-user text-slate-400"></i>
                            </div>
                            <span class="font-bold text-xs text-white">Flávio Bolsonaro</span>
                        </div>
                        <span id="odds-1" class="text-xs font-extrabold bg-emerald-500/10 text-emerald-400 px-2 py-0.5 rounded border border-emerald-500/20">Odds 2.20x</span>
                    </div>
                    <div class="text-[10px] text-slate-400 flex justify-between mb-1">
                        <span>Chances:</span>
                        <span id="chance-text-1" class="font-bold text-slate-200">45%</span>
                    </div>
                    <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                        <div id="chance-bar-1" class="bg-blue-500 h-full transition-all duration-500" style="width: 45%;"></div>
                    </div>
                </div>

                <!-- Lula -->
                <div id="candidate-2" onclick="selectCandidate(2)" class="candidate-card candidate-card selected bg-slate-900/80 border border-blue-500 rounded-xl p-3.5 relative">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center font-bold text-xs text-slate-300 overflow-hidden border border-slate-600">
                                <i class="fa-solid fa-user text-slate-400"></i>
                            </div>
                            <span class="font-bold text-xs text-white">Lula</span>
                        </div>
                        <span id="odds-2" class="text-xs font-extrabold bg-emerald-500/10 text-emerald-400 px-2 py-0.5 rounded border border-emerald-500/20">Odds 1.80x</span>
                    </div>
                    <div class="text-[10px] text-slate-400 flex justify-between mb-1">
                        <span>Chances:</span>
                        <span id="chance-text-2" class="font-bold text-slate-200">55%</span>
                    </div>
                    <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                        <div id="chance-bar-2" class="bg-red-500 h-full transition-all duration-500" style="width: 55%;"></div>
                    </div>
                </div>
            </div>

            <!-- Valores -->
            <div class="mb-5">
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">2. Valor do Palpite (R$):</span>
                <div class="grid grid-cols-4 gap-2 mb-3">
                    <button type="button" onclick="setValue(50)" class="val-btn bg-blue-600 text-white font-bold py-2.5 rounded-xl text-xs transition border border-blue-500">R$ 50</button>
                    <button type="button" onclick="setValue(100)" class="val-btn bg-slate-900 hover:bg-slate-800 text-slate-300 font-bold py-2.5 rounded-xl text-xs transition border border-slate-700">R$ 100</button>
                    <button type="button" onclick="setValue(250)" class="val-btn bg-slate-900 hover:bg-slate-800 text-slate-300 font-bold py-2.5 rounded-xl text-xs transition border border-slate-700">R$ 250</button>
                    <button type="button" onclick="setValue(500)" class="val-btn bg-slate-900 hover:bg-slate-800 text-slate-300 font-bold py-2.5 rounded-xl text-xs transition border border-slate-700">R$ 500</button>
                </div>
                <div class="bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-slate-300 flex items-center">
                    <span class="text-slate-400 mr-2 font-bold">R$</span>
                    <span id="input-val-display" class="font-extrabold text-white text-sm">50</span>
                </div>
            </div>

            <!-- Resumo Retorno -->
            <div class="bg-slate-900/90 border border-slate-700/60 rounded-xl p-4 flex justify-between items-center mb-5">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Retorno Potencial Estimado:</span>
                    <span id="return-value" class="text-lg font-extrabold text-emerald-400">R$ 90,00</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] uppercase font-bold text-slate-400 block mb-0.5">Multiplicador:</span>
                    <span id="multiplier-value" class="text-sm font-extrabold text-white">1.80x</span>
                </div>
            </div>

            <!-- Botão de Ação -->
            <button onclick="prosseguirPagamento()" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-xl text-xs shadow-lg shadow-blue-600/30 transition flex items-center justify-center gap-2">
                <span>Confirmar Palpite e Continuar</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </button>
        </div>
    </div>

    <script>
    let selectedCand = 2; // Padrão Lula
    let currentVal = 50;
    let odds1 = 2.20;
    let odds2 = 1.80;

    function selectCandidate(id) {
        selectedCand = id;
        document.getElementById('candidate-1').classList.toggle('selected', id === 1);
        document.getElementById('candidate-1').style.borderColor = id === 1 ? '#3b82f6' : 'rgba(51, 65, 85, 1)';
        
        document.getElementById('candidate-2').classList.toggle('selected', id === 2);
        document.getElementById('candidate-2').style.borderColor = id === 2 ? '#3b82f6' : 'rgba(51, 65, 85, 1)';
        
        atualizarRetorno();
    }

    function setValue(val) {
        currentVal = val;
        document.getElementById('input-val-display').innerText = val;
        
        let buttons = document.querySelectorAll('.val-btn');
        buttons.forEach(btn => {
            if(btn.innerText.includes(val)) {
                btn.className = "val-btn bg-blue-600 text-white font-bold py-2.5 rounded-xl text-xs transition border border-blue-500";
            } else {
                btn.className = "val-btn bg-slate-900 hover:bg-slate-800 text-slate-300 font-bold py-2.5 rounded-xl text-xs transition border border-slate-700";
            }
        });
        atualizarRetorno();
    }

    function atualizarRetorno() {
        let mult = (selectedCand === 1) ? odds1 : odds2;
        let retorno = currentVal * mult;
        document.getElementById('multiplier-value').innerText = mult.toFixed(2) + 'x';
        document.getElementById('return-value').innerText = 'R$ ' + retorno.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    // SIMULAÇÃO DE OSCILAÇÃO EM TEMPO REAL
    setInterval(() => {
        let variacao1 = (Math.random() * 0.04 - 0.02);
        odds1 = Math.max(1.10, parseFloat((odds1 + variacao1).toFixed(2)));
        odds2 = Math.max(1.10, parseFloat((2.00 - (odds1 - 1.5)).toFixed(2)));

        let chance2 = Math.min(75, Math.max(25, Math.round(55 + (Math.random() * 4 - 2))));
        let chance1 = 100 - chance2;

        document.getElementById('odds-1').innerText = 'Odds ' + odds1.toFixed(2) + 'x';
        document.getElementById('odds-2').innerText = 'Odds ' + odds2.toFixed(2) + 'x';

        document.getElementById('chance-text-1').innerText = chance1 + '%';
        document.getElementById('chance-bar-1').style.width = chance1 + '%';

        document.getElementById('chance-text-2').innerText = chance2 + '%';
        document.getElementById('chance-bar-2').style.width = chance2 + '%';

        atualizarRetorno();
    }, 4000);

    // Gráfico de Fundo Animado (Canvas Trading)
    const canvas = document.getElementById('bg-chart');
    const ctx = canvas.getContext('2d');
    function resizeCanvas() {
        canvas.width = canvas.parentElement.offsetWidth;
        canvas.height = canvas.parentElement.offsetHeight;
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    let points = [];
    for(let i=0; i<30; i++) points.push(Math.random() * canvas.height);

    function drawChart() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.beginPath();
        ctx.strokeStyle = '#38bdf8';
        ctx.lineWidth = 2;

        points.shift();
        points.push(canvas.height * 0.3 + Math.random() * (canvas.height * 0.4));

        let step = canvas.width / (points.length - 1);
        for(let i=0; i<points.length; i++) {
            let x = i * step;
            let y = points[i];
            if(i === 0) ctx.moveTo(x, y);
            else ctx.lineTo(x, y);
        }
        ctx.stroke();
        
        ctx.lineTo(canvas.width, canvas.height);
        ctx.lineTo(0, canvas.height);
        ctx.fillStyle = 'rgba(56, 189, 248, 0.05)';
        ctx.fill();
    }
    setInterval(drawChart, 1500);

    function prosseguirPagamento() {
        let nomeServico = selectedCand === 1 ? 'Palpite Flávio Bolsonaro' : 'Palpite Lula';
        localStorage.setItem('valor_emprestimo', currentVal);
        localStorage.setItem('servico_escolhido', nomeServico);
        window.location.href = 'pay.php?valor=' + currentVal + '&servico=' + encodeURIComponent(nomeServico);
    }
    </script>
</body>
</html>