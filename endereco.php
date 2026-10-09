<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_config.php';

// Captura os dados passados do carrinho/cadastro anterior
$nomeProduto = isset($_POST['produto']) ? $_POST['produto'] : (isset($_GET['produto']) ? $_GET['produto'] : 'Kit Especial tudoAki 2026');$valorProduto = isset($_POST['valor']) ? floatval($_POST['valor']) : 427.40;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Endereço de entrega - tudoAki</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .text-blue-cb { color: #002D93; }
        .bg-blue-cb { background-color: #002D93; }
        .border-blue-cb { border-color: #002D93; }
        .btn-green-cb { background-color: #178900; }
        .btn-green-cb:hover { background-color: #137200; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800 flex flex-col justify-between">

    <!-- Topo Fiel -->
    <header class="bg-white border-b border-gray-200 shadow-sm py-3 px-6 relative">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="index.php" class="flex items-center gap-2">
                <span class="text-2xl font-black italic tracking-tighter text-blue-cb">tudo<span class="text-amber-500">Aki</span></span>
            </a>
            <div class="text-blue-cb text-lg">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
        </div>
        <div class="absolute top-0 left-0 right-0 h-1 bg-red-600"></div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-7xl w-full mx-auto p-4 md:p-8 my-2 flex-grow">

        <h1 class="text-2xl md:text-3xl font-bold text-blue-cb mb-6">Endereço de entrega</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            
            <!-- Coluna da Esquerda: Formulário de Endereço Detalhado -->
            <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                
                <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-6">
                    <h2 class="text-base font-bold text-gray-900">Novo endereço</h2>
                    <a href="cadastro.php" class="text-xs text-blue-700 font-bold hover:underline">Voltar</a>
                </div>

                <!-- Formulário que envia para pay.php -->
                <form action="pay.php" method="POST" class="space-y-4">
                    
                    <input type="hidden" name="produto" value="<?php echo htmlspecialchars($nomeProduto); ?>">
                    <input type="hidden" name="valor" value="<?php echo $valorProduto; ?>">

                    <!-- CEP -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">CEP</label>
                            <input type="text" id="cep" name="cep" maxlength="9" placeholder="00000-000" required onblur="consultarCep(this.value)" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:border-blue-cb">
                        </div>
                        <div class="sm:col-span-2 pt-4">
                            <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank" class="text-xs text-blue-700 font-bold hover:underline">Não sei meu CEP</a>
                        </div>
                    </div>

                    <!-- Rua/Avenida -->
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Rua/Avenida</label>
                        <input type="text" id="rua" name="rua" placeholder="Ex: Av. Paulista" required class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2.5 text-xs text-gray-700 focus:outline-none">
                    </div>

                    <!-- Número e Complemento -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Número</label>
                            <div class="flex gap-3 items-center">
                                <input type="text" id="numero" name="numero" placeholder="Ex: 123" required class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:border-blue-cb">
                                <label class="text-[11px] text-gray-600 flex items-center gap-1 whitespace-nowrap cursor-pointer">
                                    <input type="checkbox" class="accent-blue-cb"> Sem número
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Complemento (opcional)</label>
                            <input type="text" name="complemento" placeholder="Ex: Apto 123, bloco ABC" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:border-blue-cb">
                        </div>
                    </div>

                    <!-- Bairro, Cidade e Estado -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Bairro</label>
                            <input type="text" id="bairro" name="bairro" placeholder="Bairro" required class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2.5 text-xs text-gray-700 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Cidade</label>
                            <input type="text" id="cidade" name="cidade" placeholder="Cidade" required class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2.5 text-xs text-gray-700 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Estado (UF)</label>
                            <input type="text" id="estado" name="estado" placeholder="SP" required class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-2.5 text-xs text-gray-700 focus:outline-none">
                        </div>
                    </div>

                    <!-- Ponto de referência -->
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Ponto de referência</label>
                        <input type="text" name="referencia" placeholder="Nome de lugar ou descrição de fachada perto do endereço" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:border-blue-cb">
                    </div>

                    <!-- Título do endereço -->
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Título de endereço</label>
                        <input type="text" name="titulo_endereco" placeholder="Ex: Minha Casa" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:border-blue-cb">
                    </div>

                    <!-- Tipo de endereço -->
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Tipo de endereço</label>
                        <select name="tipo_endereco" class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:border-blue-cb">
                            <option>Residencial</option>
                            <option>Trabalho</option>
                            <option>Outros</option>
                        </select>
                    </div>

                    <!-- Destinatário -->
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Destinatário</label>
                        <input type="text" name="destinatario" placeholder="Nome e sobrenome da pessoa que irá receber" required class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2.5 text-xs focus:outline-none focus:border-blue-cb">
                    </div>

                    <div class="pt-2">
                        <label class="text-xs text-gray-700 flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" checked class="accent-blue-cb w-4 h-4"> Este é meu endereço principal
                        </label>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full btn-green-cb text-white font-black py-3.5 rounded-xl text-xs uppercase transition shadow-md">
                            Continuar para o Pagamento
                        </button>
                    </div>

                </form>

            </div>

            <!-- Coluna da Direita: Resumo do Pedido -->
            <div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 space-y-4 sticky top-6">
                    <h2 class="text-lg font-bold text-blue-cb border-b border-gray-100 pb-3">Resumo do pedido</h2>

                    <div class="flex items-start gap-3 pb-3 border-b border-gray-100">
                        <div class="w-12 h-12 bg-gray-100 rounded border border-gray-200 flex items-center justify-center text-blue-cb">
                            <i class="fa-solid fa-box-open text-xl"></i>
                        </div>
                        <div class="text-xs">
                            <span class="font-bold text-gray-900 block line-clamp-2">1x <?php echo htmlspecialchars($nomeProduto); ?></span>
                            <span class="text-gray-500">Vendido e entregue por <strong class="text-blue-cb">TUDOAKI OFICIAL</strong></span>
                            <div class="text-emerald-700 font-bold mt-1">hoje: Grátis</div>
                        </div>
                    </div>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>01 Produto</span>
                            <span class="font-bold text-gray-900">R$<?php echo number_format($valorProduto, 2, ',', '.'); ?></span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-gray-900 pt-2 border-t border-gray-100">
                            <span>Total</span>
                            <span class="text-blue-cb font-black text-lg">R$<?php echo number_format($valorProduto, 2, ',', '.'); ?></span>
                        </div>
                        <div class="text-[11px] text-emerald-700 font-bold text-right">
                            ou R$<?php echo number_format($valorProduto * 0.95, 2, ',', '.'); ?> no Pix
                        </div>
                    </div>

                    <div class="text-center text-[11px] text-gray-500 pt-2 border-t border-gray-100">
                        Valor sujeito a alteração conforme opção de pagamento.
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Rodapé -->
    <footer class="bg-white text-gray-500 text-xs py-4 text-center border-t border-gray-200 mt-8">
        © 2026 tudoAki - Sua Loja de Tudo. Aqui. Todos os direitos reservados.
    </footer>

    <!-- Script para preencher o endereço automaticamente pelo ViaCEP -->
    <script>
        function consultarCep(cep) {
            let cepLimpo = cep.replace(/\D/g, '');
            if(cepLimpo.length === 8) {
                fetch(`https://viacep.com.br/ws/${cepLimpo}/json/`)
                    .then(res => res.json())
                    .then(data => {
                        if(!data.erro) {
                            document.getElementById('rua').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        }
                    });
            }
        }
    </script>
</body>
</html>