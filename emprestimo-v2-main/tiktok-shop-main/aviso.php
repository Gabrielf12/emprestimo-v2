<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Pega o serviço da URL ou da sessão salva anteriormente
$servico = trim($_GET['servico'] ?? $_SESSION['dados_cadastro']['servico'] ?? 'Atendimento Geral');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso Importante - Processamento de Atendimento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-dark-main { background-color: #0b1329; }
        .bg-card-dark { background-color: #111c3a; }
        .border-card-dark { border-color: #1e2d5a; }
    </style>
</head>
<body class="bg-dark-main text-slate-100 min-h-screen font-sans flex flex-col justify-between selection:bg-emerald-500 selection:text-white">

    <!-- Topo / Barra de Segurança -->
    <header class="py-3 px-6 border-b border-card-dark bg-[#0f172a]/50 backdrop-blur-md">
        <div class="max-w-2xl mx-auto flex justify-between items-center text-xs">
            <a href="cadastro.php?servico=<?php echo urlencode($servico); ?>" class="text-slate-400 hover:text-white transition flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Voltar
            </a>
            <div class="flex items-center gap-1.5 text-emerald-400 font-medium">
                <i class="fa-solid fa-shield-check"></i>
                <span>Verificação Segura</span>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl mx-auto px-4 py-8 w-full">
        
        <!-- Card Central Principal -->
        <div class="bg-card-dark border border-card-dark rounded-2xl p-6 sm:p-8 shadow-2xl relative overflow-hidden mb-8">
            
            <!-- Ícone de Destaque Superior -->
            <div class="flex justify-center mb-5">
                <div class="w-14 h-14 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
            </div>

            <div class="text-center mb-6">
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight mb-2">Aviso Importante</h1>
                <div class="inline-block bg-slate-800/80 border border-slate-700/60 rounded-full px-4 py-1 text-xs text-slate-300">
                    Serviço selecionado: <strong class="text-emerald-400"><?php echo htmlspecialchars($servico); ?></strong>
                </div>
            </div>

            <!-- Texto descritivo -->
            <div class="bg-slate-900/50 border border-slate-800/80 rounded-xl p-4 text-sm text-slate-300 leading-relaxed mb-6 text-center">
                Para concluir e liberar o seu <strong>atendimento prioritário</strong> em nossa plataforma automatizada, é necessária a confirmação e o pagamento de uma <span class="text-emerald-400 font-semibold">taxa de processamento operacional</span> no valor de <strong class="text-white text-base">R$ 19,90</strong>.
            </div>

            <!-- Benefícios em Lista -->
            <div class="space-y-2.5 mb-8">
                <div class="flex items-center gap-3 bg-slate-900/30 border border-slate-800/50 p-3 rounded-lg text-xs text-slate-300">
                    <div class="w-5 h-5 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </div>
                    <span>Atendimento automatizado e imediato sem filas de espera</span>
                </div>
                <div class="flex items-center gap-3 bg-slate-900/30 border border-slate-800/50 p-3 rounded-lg text-xs text-slate-300">
                    <div class="w-5 h-5 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </div>
                    <span>Ambiente criptografado e seguro com emissão instantânea</span>
                </div>
            </div>

            <!-- Botão de Ação -->
            <a href="pay.php" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-4 px-6 rounded-xl text-sm shadow-lg shadow-emerald-900/30 transition flex items-center justify-center gap-2 group">
                <span>Desejo Prosseguir para o Pagamento</span>
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>

        </div>

        <!-- Seção de Perguntas Frequentes (FAQ) para Passar Credibilidade -->
        <div class="space-y-4">
            <h2 class="text-center text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">
                <i class="fa-solid fa-circle-question mr-1 text-blue-400"></i> Perguntas Frequentes
            </h2>

            <!-- FAQ 1 -->
            <div class="bg-card-dark border border-card-dark rounded-xl p-4 transition">
                <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2 mb-1.5">
                    <span class="text-emerald-400">P:</span> Por que é cobrada esta taxa de processamento?
                </h3>
                <p class="text-xs text-slate-400 leading-relaxed pl-4">
                    Esta taxa operacional é destinada exclusivamente à manutenção da infraestrutura de tecnologia, servidores seguros, validação instantânea de dados cadastrais e suporte automatizado 24 horas.
                </p>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-card-dark border border-card-dark rounded-xl p-4 transition">
                <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2 mb-1.5">
                    <span class="text-emerald-400">P:</span> O pagamento é seguro? Como é feito?
                </h3>
                <p class="text-xs text-slate-400 leading-relaxed pl-4">
                    Sim, totalmente seguro. O pagamento é processado via QR Code Pix instantâneo através de instituições financeiras regulamentadas, garantindo criptografia ponta a ponta e compensação na mesma hora.
                </p>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-card-dark border border-card-dark rounded-xl p-4 transition">
                <h3 class="text-xs font-bold text-slate-200 flex items-center gap-2 mb-1.5">
                    <span class="text-emerald-400">P:</span> Após o pagamento, o que acontece?
                </h3>
                <p class="text-xs text-slate-400 leading-relaxed pl-4">
                    Assim que o pagamento for confirmado pelo sistema (o que leva apenas alguns segundos), o seu protocolo de atendimento prioritário é gerado e liberado automaticamente na tela.
                </p>
            </div>
        </div>

    </main>

    <!-- Rodapé -->
    <footer class="text-center py-6 text-slate-500 text-[11px] border-t border-card-dark mt-10">
        <p>© <?php echo date('Y'); ?> Central de Atendimento Digital. Todos os direitos reservados.</p>
    </footer>

</body>
</html>