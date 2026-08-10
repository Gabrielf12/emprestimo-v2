<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$servico = trim($_GET['servico'] ?? $_POST['servico'] ?? 'Atendimento Geral');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identificação do Cidadão - Portal de Serviços</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-gov-dark { background-color: #1351b4; }
        .bg-gov-header { background-color: #0c326f; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans flex flex-col justify-between">

    <div>
        <!-- Barra Superior Gov -->
        <header class="bg-gov-header text-white text-[11px] py-2 px-4 shadow-inner">
            <div class="max-w-xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="font-bold tracking-wider">PORTAL DE SERVIÇOS DO ELEITOR</span>
                </div>
                <div class="flex items-center gap-3 text-slate-300">
                    <span><i class="fa-solid fa-lock text-[10px] mr-1 text-emerald-400"></i>Ambiente Seguro</span>
                </div>
            </div>
        </header>

        <!-- Faixa de Identificação do Órgão -->
        <div class="bg-gov-dark text-white py-4 px-4 shadow-md">
            <div class="max-w-xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center border border-white/20">
                        <i class="fa-solid fa-file-shield text-lg text-white"></i>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-widest text-blue-200 block font-semibold">Identificação Obrigatória</span>
                        <h1 class="font-bold text-base leading-tight">Validação Cadastral</h1>
                    </div>
                </div>
                <div class="text-right hidden sm:block">
                    <span class="text-xs bg-blue-700/60 px-2.5 py-1 rounded-full border border-blue-400/30 text-blue-100 font-medium">Passo 1 de 2</span>
                </div>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <main class="max-w-xl mx-auto px-4 py-6">

            <!-- Card do Formulário -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-6 md:p-8">
                
                <!-- Informação do Serviço Selecionado -->
                <div class="mb-6 p-3.5 bg-blue-50/70 border border-blue-100 rounded-lg flex items-start gap-3">
                    <div class="text-blue-600 mt-0.5">
                        <i class="fa-solid fa-circle-info text-base"></i>
                    </div>
                    <div class="text-xs">
                        <span class="text-slate-500 block">Serviço selecionado:</span>
                        <strong class="text-blue-900 font-semibold text-sm"><?php echo htmlspecialchars($servico); ?></strong>
                    </div>
                </div>

                <form action="salvar_cadastro.php" method="POST" class="space-y-4">
                    <input type="hidden" name="servico" value="<?php echo htmlspecialchars($servico); ?>">

                    <!-- Nome -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Nome Completo (Conforme Documento)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="fa-solid fa-user text-xs"></i></span>
                            <input type="text" name="nome" required placeholder="Digite seu nome completo" class="w-full pl-9 pr-3 py-2.5 bg-slate-50/50 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                        </div>
                    </div>

                    <!-- Grid CPF e RG -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">CPF</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="fa-solid fa-id-card text-xs"></i></span>
                                <input type="text" name="cpf" id="cpf-input" required placeholder="000.000.000-00" class="w-full pl-9 pr-3 py-2.5 bg-slate-50/50 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Número do RG</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="fa-solid fa-address-card text-xs"></i></span>
                                <input type="text" name="rg" required placeholder="Digite o RG" class="w-full pl-9 pr-3 py-2.5 bg-slate-50/50 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Grid Estado Civil e Telefone -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Estado Civil</label>
                            <div class="relative">
                                <select name="estado_civil" required class="w-full px-3 py-2.5 bg-slate-50/50 border border-slate-300 rounded-lg text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition appearance-none">
                                    <option value="">Selecione...</option>
                                    <option value="Solteiro(a)">Solteiro(a)</option>
                                    <option value="Casado(a)">Casado(a)</option>
                                    <option value="Divorciado(a)">Divorciado(a)</option>
                                    <option value="Viúvo(a)">Viúvo(a)</option>
                                    <option value="União Estável">União Estável</option>
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400 text-xs"><i class="fa-solid fa-chevron-down"></i></span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Telefone / WhatsApp</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="fa-solid fa-phone text-xs"></i></span>
                                <input type="text" name="telefone" id="phone-input" required placeholder="(00) 00000-0000" class="w-full pl-9 pr-3 py-2.5 bg-slate-50/50 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                            </div>
                        </div>
                    </div>

                    <!-- BLOCO DE ENDEREÇO AUTOMÁTICO (CEP EM PRIMEIRO) -->
                    <div class="border-t border-slate-100 pt-3 mt-2">
                        <span class="block text-xs font-bold text-blue-900 mb-3 uppercase tracking-wider"><i class="fa-solid fa-location-dot mr-1"></i> Endereço Residencial</span>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wide">CEP</label>
                                <input type="text" name="cep" id="cep-input" required placeholder="00000-000" maxlength="9" class="w-full px-3 py-2.5 bg-slate-50/50 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wide">Logradouro / Rua</label>
                                <input type="text" name="rua" id="rua-input" required placeholder="Preenchimento automático" class="w-full px-3 py-2.5 bg-slate-100 border border-slate-300 rounded-lg text-sm text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wide">Número</label>
                                <input type="text" name="numero" id="numero-input" required placeholder="Ex: 123" class="w-full px-3 py-2.5 bg-slate-50/50 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wide">Bairro</label>
                                <input type="text" name="bairro" id="bairro-input" required placeholder="Automático" class="w-full px-3 py-2.5 bg-slate-100 border border-slate-300 rounded-lg text-sm text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wide">Cidade / UF</label>
                                <input type="text" name="cidade_uf" id="cidade-input" required placeholder="Cidade - UF" class="w-full px-3 py-2.5 bg-slate-100 border border-slate-300 rounded-lg text-sm text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Campo oculto para enviar o endereço montado completo para o banco/sessão -->
                    <input type="hidden" name="endereco" id="endereco-completo">

                    <!-- Botão de Ação -->
                    <div class="pt-3">
                        <button type="submit" onclick="montarEnderecoCompleto()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-4 rounded-xl text-sm shadow-sm transition flex items-center justify-center gap-2">
                            <span>Avançar para Análise de Dados</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Rodapé de Confiança / Segurança -->
            <div class="mt-6 text-center text-slate-400 text-xs space-y-1">
                <p><i class="fa-solid fa-shield-halved text-emerald-600 mr-1"></i> As informações fornecidas são protegidas por sigilo e criptografia.</p>
                <p>© <?php echo date('Y'); ?> Central de Atendimento Digital</p>
            </div>
        </main>
    </div>

    <script>
        // Máscaras automáticas para CPF, Telefone e CEP
        document.getElementById('cpf-input').addEventListener('input', e => {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);
            v = v.replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = v;
        });

        document.getElementById('phone-input').addEventListener('input', e => {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);
            v = v.replace(/^(\d{2})(\d)/g, '($1) $2').replace(/(\d)(\d{4})$/, '$1-$2');
            e.target.value = v;
        });

        const cepInput = document.getElementById('cep-input');
        cepInput.addEventListener('input', e => {
            let v = e.target.value.replace(/\D/g, '');
            if (v.length > 8) v = v.slice(0, 8);
            v = v.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = v;

            // Quando completar os 8 dígitos do CEP, busca na API ViaCEP
            if (v.length === 9) {
                let cepLimpo = v.replace(/\D/g, '');
                fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('rua-input').value = data.logradouro;
                            document.getElementById('bairro-input').value = data.bairro;
                            document.getElementById('cidade-input').value = `${data.localidade} - ${data.uf}`;
                            document.getElementById('numero-input').focus(); // Joga o cursor direto pro número
                        }
                    })
                    .catch(err => console.log('Erro ao buscar CEP'));
            }
        });

        // Junta tudo num campo único de endereço antes de enviar para salvar no banco
        function montarEnderecoCompleto() {
            let rua = document.getElementById('rua-input').value;
            let num = document.getElementById('numero-input').value;
            let bairro = document.getElementById('bairro-input').value;
            let cidadeUf = document.getElementById('cidade-input').value;
            let cep = document.getElementById('cep-input').value;

            let enderecoFinal = `${rua}, Nº ${num} - ${bairro}, ${cidadeUf} - CEP: ${cep}`;
            document.getElementById('endereco-completo').value = enderecoFinal;
        }
    </script>
</body>
</html>