<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php';

$servico = isset($_GET['servico']) ? $_GET['servico'] : 'Palpite Eleitoral 2026';
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
            <form action="pay.php" method="POST" class="space-y-4">

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
                        <input type="text" name="nome" required placeholder="Digite seu nome completo" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                    </div>
                </div>

                <!-- CPF e RG -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">CPF</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">
                                <i class="fa-solid fa-id-card text-xs"></i>
                            </span>
                            <input type="text" name="cpf" id="cpf" required placeholder="000.000.000-00" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Número do RG</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">
                                <i class="fa-solid fa-address-card text-xs"></i>
                            </span>
                            <input type="text" name="rg" required placeholder="Digite o RG" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                    </div>
                </div>

                <!-- Estado Civil e Telefone -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Estado Civil</label>
                        <select name="estado_civil" required class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                            <option value="" disabled selected>Selecione...</option>
                            <option value="Solteiro(a)">Solteiro(a)</option>
                            <option value="Casado(a)">Casado(a)</option>
                            <option value="Divorciado(a)">Divorciado(a)</option>
                            <option value="Viúvo(a)">Viúvo(a)</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Telefone / WhatsApp</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">
                                <i class="fa-solid fa-phone text-xs"></i>
                            </span>
                            <input type="text" name="telefone" required placeholder="(00) 00000-0000" class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                    </div>
                </div>

                <!-- Seção de Endereço -->
                <div class="pt-2 border-t border-slate-800/80 space-y-3">
                    <span class="block text-xs font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot"></i> Endereço Residencial
                    </span>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">CEP</label>
                            <input type="text" name="cep" id="cep" placeholder="00000-000" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Logradouro / Rua</label>
                            <input type="text" name="rua" id="rua" placeholder="Preenchimento automático" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Número</label>
                            <input type="text" name="numero" required placeholder="Ex: 123" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Bairro</label>
                            <input type="text" name="bairro" id="bairro" placeholder="Bairro" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Cidade / UF</label>
                            <input type="text" name="cidade_uf" id="cidade" placeholder="Cidade - UF" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-blue-500 font-medium">
                        </div>
                    </div>
                </div>

                <!-- Botão de Envio -->
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3.5 px-4 rounded-xl transition shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 text-sm mt-4">
                    <span>Avançar para Pagamento PIX</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>

            </form>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="text-center text-[10px] text-slate-500 py-4 space-y-1">
        <p><i class="fa-solid fa-lock text-emerald-500 mr-1"></i> As informações fornecidas são protegidas por sigilo e criptografia.</p>
        <p>&copy; 2026 Mercado Eleitoral - Todos os direitos reservados</p>
    </footer>

</body>
</html>