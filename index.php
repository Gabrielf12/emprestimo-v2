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
    <title>Campanha Eleitoral 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #0b1329; }
        .card-custom {
            background-color: #111c38;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .candidate-btn {
            transition: all 0.2s ease;
            border: 1px solid #1e293b;
        }
        .candidate-btn.selected {
            border-color: #3b82f6;
            background-color: #1e293b;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
        }
        .value-btn {
            transition: all 0.2s ease;
            border: 1px solid #1e293b;
        }
        .value-btn.selected {
            border-color: #3b82f6;
            background-color: #1e293b;
            color: #ffffff;
        }
    </style>
</head>
<body class="bg-[#070b19] min-h-screen font-sans text-gray-100 flex flex-col justify-between">

    <!-- Topo -->
    <header class="bg-custom-header text-white text-xs py-3 px-4 border-b border-slate-800">
        <div class="max-w-xl mx-auto flex justify-between items-center">
            <span class="font-semibold flex items-center gap-2">
                <i class="fa-solid fa-flag text-blue-500"></i> Campanha Eleitoral 2026
            </span>
            <span class="text-slate-300 font-medium hover:text-white cursor-pointer">Doação Segura</span>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl w-full mx-auto p-4 my-auto space-y-4">

        <!-- Banner / Título -->
        <div class="text-center space-y-1 mb-2">
            <h1 class="text-2xl font-bold text-white">Fortaleça Nossa Causa</h1>
            <p class="text-xs text-slate-400">Escolha o candidato que você apoia e defina o valor da sua contribuição.</p>
        </div>

        <div class="card-custom rounded-xl p-6 shadow-2xl space-y-6">

            <!-- Passo 1: Escolher Candidato -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                    1. ESCOLHA O CANDIDATO / MOVIMENTO:
                </label>
                
                <div class="grid grid-cols-2 gap-3">
                    
                    <!-- Flávio Bolsonaro -->
                    <button type="button" onclick="selecionarCandidato('Flávio Bolsonaro', 50)" id="cand-flavio" class="candidate-btn p-3.5 rounded-lg bg-[#0d152c] text-left flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-600/20 flex items-center justify-center text-emerald-400 flex-shrink-0 overflow-hidden border border-slate-700">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cb/Fl%C3%A1vio_Bolsonaro_em_2023.jpg/220px-Fl%C3%A1vio_Bolsonaro_em_2023.jpg" alt="Flávio" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-white leading-tight">Flávio Bolsonaro</span>
                                <span class="text-[10px] text-slate-400">Direita / Conservador</span>
                            </div>
                        </div>
                    </button>

                    <!-- Lula -->
                    <button type="button" onclick="selecionarCandidato('Lula', 50)" id="cand-lula" class="candidate-btn p-3.5 rounded-lg bg-[#0d152c] text-left flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-red-600/20 flex items-center justify-center text-red-400 flex-shrink-0 overflow-hidden border border-slate-700">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Luiz_In%C3%A1cio_Lula_da_Silva_in_2023_%28cropped%29.jpg/220px-Luiz_In%C3%A1cio_Lula_da_Silva_in_2023_%28cropped%29.jpg" alt="Lula" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-white leading-tight">Lula</span>
                                <span class="text-[10px] text-slate-400">Esquerda / Progressista</span>
                            </div>
                        </div>
                    </button>

                </div>
            </div>

            <!-- Passo 2: Valor da Contribuição -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                    2. VALOR DA CONTRIBUIÇÃO (R$):
                </label>

                <!-- Botões de Valores Rápidos -->
                <div class="grid grid-cols-4 gap-2">
                    <button type="button" onclick="definirValor(50)" id="val-50" class="value-btn py-2.5 bg-[#0d152c] rounded-lg text-xs font-bold text-slate-200">R$ 50</button>
                    <button type="button" onclick="definirValor(100)" id="val-100" class="value-btn py-2.5 bg-[#0d152c] rounded-lg text-xs font-bold text-slate-200">R$ 100</button>
                    <button type="button" onclick="definirValor(250)" id="val-250" class="value-btn py-2.5 bg-[#0d152c] rounded-lg text-xs font-bold text-slate-200">R$ 250</button>
                    <button type="button" onclick="definirValor(500)" id="val-500" class="value-btn py-2.5 bg-[#0d152c] rounded-lg text-xs font-bold text-slate-200">R$ 500</button>
                </div>

                <!-- Input Personalizado -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm font-bold">R$</span>
                    <input type="number" id="valorPersonalizado" value="34" class="w-full bg-[#0d152c] border border-slate-800 rounded-lg pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-semibold">
                </div>
            </div>

            <!-- Botão de Avançar -->
            <button type="button" onclick="avancarCadastro()" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2 text-sm">
                <span>Continuar para Dados de Apoio</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="text-center text-[10px] text-slate-500 py-4">
        &nbsp;
    </footer>

    <script>
        let candidatoSelecionado = "";

        function selecionarCandidato(nome) {
            candidatoSelecionado = nome;
            
            document.getElementById('cand-flavio').classList.remove('selected');
            document.getElementById('cand-lula').classList.remove('selected');

            if (nome === 'Flávio Bolsonaro') {
                document.getElementById('cand-flavio').classList.add('selected');
            } else {
                document.getElementById('cand-lula').classList.add('selected');
            }
        }

        function definirValor(valor) {
            document.getElementById('valorPersonalizado').value = valor;

            let botoesValor = [50, 100, 250, 500];
            botoesValor.forEach(v => {
                let btn = document.getElementById('val-' + v);
                if (btn) btn.classList.remove('selected');
            });

            let ativo = document.getElementById('val-' + valor);
            if (ativo) ativo.classList.add('selected');
        }

        function avancarCadastro() {
            let valorFinal = document.getElementById('valorPersonalizado').value;

            if (!candidatoSelecionado) {
                alert("Por favor, selecione um candidato/movimento.");
                return;
            }

            if (!valorFinal || valorFinal <= 0) {
                alert("Por favor, informe o valor da contribuição.");
                return;
            }

            let servicoTexto = "Contribuição para " + candidatoSelecionado + " (R$ " + valorFinal + ")";

            // Salva no localStorage para a página seguinte pegar
            localStorage.setItem('servico_escolhido', servicoTexto);
            localStorage.setItem('valor_emprestimo', valorFinal);
            localStorage.setItem('candidato_escolhido', candidatoSelecionado);

            // Redireciona para o cadastro
            window.location.href = 'cadastro.php?servico=' + encodeURIComponent(servicoTexto);
        }
    </script>
</body>
</html>