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
    <title>Estratégia Eleitoral 2026 - Sistema de Progressão e Vantagens</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #0f172a; }
        
        /* Estilos da Pirâmide Imersiva */
        .pyramid-wrapper {
            background: radial-gradient(circle at center, #1e1b4b 0%, #09090b 100%);
            padding: 30px 16px;
            border-radius: 20px;
            box-shadow: inset 0 0 30px rgba(56, 189, 248, 0.15), 0 15px 30px rgba(0,0,0,0.5);
            max-width: 650px;
            margin: 20px auto;
            color: #fff;
            text-align: center;
        }

        .pyramid-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
        }

        .pyramid-tier {
            position: relative;
            padding: 20px;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(10px);
            text-align: left;
            width: 100%;
        }

        .pyramid-tier:hover {
            transform: translateY(-4px) scale(1.02);
            filter: brightness(1.2);
        }

        /* Larguras progressivas da pirâmide */
        .tier-top {
            width: 60%;
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.3), rgba(217, 119, 6, 0.5));
            border: 2px solid #f59e0b;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.3);
        }

        .tier-mid {
            width: 80%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(29, 78, 216, 0.5));
            border: 2px solid #3b82f6;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }

        .tier-base {
            width: 100%;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.3), rgba(4, 120, 87, 0.5));
            border: 2px solid #10b981;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.3);
        }

        .tier-action {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        @media (max-width: 640px) {
            .tier-top { width: 75%; }
            .tier-mid { width: 90%; }
            .tier-base { width: 100%; }
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen font-sans text-gray-100">

    <!-- Topo -->
    <header class="bg-custom-header text-white text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-xl mx-auto flex justify-between">
            <span>Comitê Estratégico 2026</span>
            <span>Segurança Total | Vantagens Exclusivas</span>
        </div>
    </header>

    <!-- Banner Principal -->
    <div class="bg-gradient-to-r from-blue-900 to-indigo-950 text-white p-4 border-b-2 border-blue-500 shadow-lg">
        <div class="max-w-xl mx-auto flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center font-bold text-slate-950 shadow-md">
                <i class="fa-solid fa-crown text-base"></i>
            </div>
            <div>
                <h1 class="font-bold text-base md:text-lg">Estrutura de Poder e Vantagens</h1>
                <p class="text-xs text-blue-200">Garanta seu patamar na campanha e libere benefícios imediatos</p>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl mx-auto p-4">

        <!-- Aviso de Oportunidade -->
        <div class="bg-amber-950/40 border border-amber-500/40 rounded-xl p-3 mb-4 flex items-start gap-3 text-amber-200 text-xs shadow-inner backdrop-blur-sm">
            <i class="fa-solid fa-triangle-exclamation text-amber-400 text-base mt-0.5 animate-pulse"></i>
            <div>
                <strong class="block mb-1 text-amber-300 font-semibold">Oportunidade por Tempo Limitado:</strong>
                Identificamos seu perfil para alavancagem de campanha. Escolha sua posição na pirâmide abaixo para ativar sua vantagem estratégica.
            </div>
        </div>

        <!-- Estrutura em Pirâmide Imersiva -->
        <div class="pyramid-wrapper">
            <h2 class="text-xl md:text-2xl font-extrabold tracking-wide text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-blue-400 to-emerald-400 uppercase">
                Pirâmide de Conquistas
            </h2>
            <p class="text-xs text-slate-400 mb-2">Selecione o nível em que deseja entrar para iniciar:</p>

            <div class="pyramid-container">
                
                <!-- Topo: Nível 1 -->
                <div onclick="selecionarValor('Topo da Hierarquia (R$ 10.000,00)', '10.000')" class="pyramid-tier tier-top">
                    <div>
                        <span class="text-[10px] font-bold text-amber-300 uppercase tracking-wider block">👑 Topo (Nível Máximo)</span>
                        <h4 class="text-sm md:text-base font-bold text-white">Liderança / R$ 10.000,00</h4>
                        <p class="text-[11px] text-amber-100/80">Retorno máximo e privilégios totais de comando.</p>
                    </div>
                    <div class="tier-action text-amber-300">Garantir</div>
                </div>

                <!-- Meio: Nível 2 -->
                <div onclick="selecionarValor('Nível Estratégico (R$ 5.000,00)', '5.000')" class="pyramid-tier tier-mid">
                    <div>
                        <span class="text-[10px] font-bold text-blue-300 uppercase tracking-wider block">⚡ Intermediário</span>
                        <h4 class="text-sm md:text-base font-bold text-white">Coordenador / R$ 5.000,00</h4>
                        <p class="text-[11px] text-blue-100/80">Suporte prioritário e bônus escalonados.</p>
                    </div>
                    <div class="tier-action text-blue-300">Selecionar</div>
                </div>

                <!-- Base: Nível 3 -->
                <div onclick="selecionarValor('Base de Expansão (R$ 1.500,00)', '1.500')" class="pyramid-tier tier-base">
                    <div>
                        <span class="text-[10px] font-bold text-emerald-300 uppercase tracking-wider block">🚀 Base de Entrada</span>
                        <h4 class="text-sm md:text-base font-bold text-white">Militante / R$ 1.500,00</h4>
                        <p class="text-[11px] text-emerald-100/80">O ponto de partida para escalar rapidamente.</p>
                    </div>
                    <div class="tier-action text-emerald-300">Entrar</div>
                </div>

            </div>
        </div>

        <!-- Opção de Simulação Personalizada -->
        <div class="mt-4">
            <button onclick="selecionarValor('Outro valor personalizado', 'personalizado')" class="w-full flex items-center justify-between p-3 bg-slate-900 border border-slate-800 rounded-xl hover:bg-slate-800 transition text-left shadow