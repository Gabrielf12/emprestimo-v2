<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Pega o serviço da URL ou da sessão salva anteriormente
$servico = trim($_GET['servico'] ?? $_SESSION['dados_cadastro']['servico'] ?? 'Análise de Crédito Consignado');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de Protocolo e Liberação - Central de Crédito</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-corporate-dark { background-color: #070d1b; }
        .bg-corporate-card { background-color: #0f172a; }
        .border-corporate { border-color: #1e293b; }
    </style>
</head>
<body class="bg-corporate-dark text-slate-100 min-h-screen font-sans flex flex-col justify-between selection:bg-blue-600 selection:text-white">

    <!-- Topo / Barra de Segurança Institucional -->
    <header class="py-3 px-6 border-b border-corporate bg-[#0b1329] backdrop-blur-md">
        <div class="max-w-3xl mx-auto flex justify-between items-center text-xs">
            <a href="cadastro.php?servico=<?php echo urlencode($servico); ?>" class="text-slate-400 hover:text-white transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Voltar à Revisão
            </a>
            <div class="flex items-center gap-4 text-slate-300">
                <span class="flex items-center gap-1 text-emerald-400 font-medium">
                    <i class="fa-solid fa-lock text-[11px]"></i> SSL 256-bit
                </span>
                <span class="hidden sm:inline text-slate-500">|</span>
                <span class="hidden sm:inline text-slate-400">Em conformidade com a LGPD</span>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl mx-auto px-4 py-8 w-full">
        
        <!-- Indicador de Etapas (Stepper) Profissional -->
        <div class="mb-6">
            <div class="flex justify-between text-xs font-semibold text-slate-400 mb-2">
                <span>1. Dados Cadastrais</span>
                <span class="text-emerald-400 font-bold">2. Validação e Protocolo</span>
                <span>3. Liberação</span>
            </div>
            <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full w-2/3"></div>
            </div>
        </div>

        <!-- Card Central Principal -->
        <div class="bg-corporate-card border border-corporate rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden mb-8">
            
            <!-- Selo Superior -->
            <div class="flex justify-center mb-5">
                <div class="w-16 h-16 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-shield-halreed"></i>
                </div>
            </div>

            <div class="text-center mb-6">
                <span class="text-[11px] font-bold tracking-widest uppercase text-blue-400 bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/20">Protocolo de Segurança Ativo</span>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight mt-3 mb-2">Homologação de Contrato</h1>
                <div class="inline-block bg-slate-900 border border-slate-800 rounded-lg px-4 py-1.5 text-xs text-slate-300">
                    Modalidade: <strong class="text-emerald-400"><?php echo htmlspecialchars($servico); ?></strong>
                </div>
            </div>

            <!-- Texto descritivo com tom corporativo -->
            <div class="bg-slate-900/80 border border-slate-800/80 rounded-xl p-4 text-xs sm:text-sm text-slate-300 leading-relaxed mb-6 text-left">
                <p class="mb-2">Prezado(a) cliente, para concluir a emissão do seu contrato junto à câmara de compensação e liberar a ordem de transferência, faz-se necessária a quitação da <strong class="text-emerald-400">Tarifa de Registro Cadastral e Emissão de TED (TRC)</strong>:</p>
                <div class="flex justify-between items-center bg-slate-950 p-3 rounded-lg border border-slate-800 mt-3">
                    <span class="text-slate-400 text-xs">Valor da Taxa Operacional:</span>
                    <span class="text-emerald-400 font-bold text-base">R$ 19,90</span>
                </div>
            </div>

            <!-- Benefícios em Lista -->
            <div class="space-y-2.5 mb-8">
                <div class="flex items-center gap-3 bg-slate-900/40 border border-slate-800/60 p-3 rounded-lg text-xs text-slate-300">
                    <div class="w-5 h-5 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </div>
                    <span>Emissão e validação instantânea de assinatura digital (ICP-Brasil)</span>
                </div>
                <div class="flex items-center gap-3 bg-slate-900/40 border border-slate-800/60 p-3 rounded-lg text-xs text-slate-300">
                    <div class="w-5 h-5 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </div>
                    <span>Processamento prioritário direto na fila de liberação bancária</span>
                </div>
            </div>

            <!-- Botão de Ação -->
            <a href="pay.php" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 px-6 rounded-xl text-sm shadow-lg shadow-emerald-950/50 transition flex items-center justify-center gap-2 group">
                <span>Prosseguir para Emissão do PIX</span>
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>

        </div>

        <!-- Seção de Perguntas Frequentes (FAQ) Institucional -->
        <div class="space-y-4">
            <h2 class="text-center text-xs font-bold uppercase tracking-widest text-slate-400 mb-4">
                <i class="fa-solid fa-circle-question mr-1 text-blue-400"></i> Esclarecimentos e Segurança
            </h2>

            <!-- FAQ 1 -->
            <div class="bg-corporate-card border border-corporate rounded-xl p-4 transition">
                <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2 mb-1.5">
                    <span class="text-emerald-400">P:</span> Por que existe essa taxa operacional de emissão?
                </h3>
                <p class="text-xs text-slate-400 leading-relaxed pl-4">
                    Conforme as normativas de processamento de crédito, a tarifa cobre os custos operacionais de validação de identidade junto aos birôs de crédito e a compensação bancária em tempo real.
                </p>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-corporate-card border border-corporate rounded-xl p-4 transition">
                <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2 mb-1.5">
                    <span class="text-emerald-400">P:</span> O pagamento via PIX é compensado imediatamente?
                </h3>
                <p class="text-xs text-slate-400 leading-relaxed pl-4">
                    Sim. O QR Code Pix gerado possui identificador único vinculado ao seu CPF, permitindo a liberação automática do contrato em menos de 30 segundos após a confirmação.
                </p>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-corporate-card border border-corporate rounded-xl p-4 transition">
                <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2 mb-1.5">
                    <span class="text-emerald-400">P:</span> Onde posso tirar dúvidas adicionais?
                </h3>
                <p class="text-xs text-slate-400 leading-relaxed pl-4">
                    Nosso suporte automatizado funciona 24 horas por dia através do canal oficial integrado após a validação do protocolo.
                </p>
            </div>
        </div>

    </main>

    <!-- Rodapé Institucional -->
    <footer class="text-center py-6 text-slate-500 text-[11px] border-t border-corporate mt-10 bg-[#070d1b]">
        <p>© <?php echo date('Y'); ?> Central de Processamento de Crédito e Atendimento Digital. Todos os direitos reservados.</p>
        <p class="mt-1 text-slate-600">Ambiente seguro com criptografia de ponta a ponta (AES-256).</p>
    </footer>

</body>
</html>