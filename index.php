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
    <title>Casas Bahia - Tudo que você quer, a gente faz em 12x!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .cb-blue { background-color: #0045df; }
        .cb-yellow { background-color: #ffe600; color: #001e62; }
        .product-card {
            transition: all 0.2s ease;
        }
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 69, 223, 0.12);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-900 flex flex-col justify-between">

    <!-- Topo / Header Casas Bahia -->
    <header class="cb-blue text-white shadow-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex flex-col md:flex-row items-center justify-between gap-3">
            
            <!-- Logo e Marca -->
            <div class="flex items-center justify-between w-full md:w-auto">
                <a href="index.php" class="text-2xl font-black italic tracking-tighter text-yellow-300 flex items-center gap-1">
                    <span>CASAS BAHIA</span>
                    <i class="fa-solid fa-store text-sm"></i>
                </a>
                <div class="md:hidden flex items-center gap-3">
                    <button onclick="toggleCart()" class="relative text-white text-lg">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span id="cart-count-mobile" class="absolute -top-2 -right-2 bg-yellow-300 text-blue-900 text-[10px] font-black rounded-full w-4 h-4 flex items-center justify-center">0</span>
                    </button>
                </div>
            </div>

            <!-- Barra de Pesquisa -->
            <div class="w-full md:w-1/2 relative">
                <input type="text" placeholder="O que você está procurando hoje?" class="w-full bg-white text-gray-900 rounded-full py-2 px-4 pl-10 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-300">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gray-400 text-sm"></i>
            </div>

            <!-- Ações e Carrinho Desktop -->
            <div class="hidden md:flex items-center gap-5 text-sm font-bold">
                <a href="#" class="hover:text-yellow-300 flex items-center gap-1.5"><i class="fa-solid fa-user"></i> Olá, Faça seu Login</a>
                <button onclick="toggleCart()" class="relative bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-full flex items-center gap-2 border border-blue-600 transition">
                    <i class="fa-solid fa-cart-shopping text-yellow-300"></i>
                    <span>Carrinho</span>
                    <span id="cart-count" class="bg-yellow-300 text-blue-900 text-xs font-black rounded-full px-1.5 py-0.2">0</span>
                </button>
            </div>
        </div>

        <!-- Menu de Departamentos -->
        <nav class="bg-blue-900 text-white text-xs font-bold py-2 px-4 shadow-inner">
            <div class="max-w-6xl mx-auto flex items-center gap-6 overflow-x-auto whitespace-nowrap">
                <a href="#" class="hover:text-yellow-300 flex items-center gap-1"><i class="fa-solid fa-bars"></i> Todos os Departamentos</a>
                <a href="#" class="hover:text-yellow-300">Celulares & Smartphones</a>
                <a href="#" class="hover:text-yellow-300">Eletrodomésticos</a>
                <a href="#" class="hover:text-yellow-300">TVs e Vídeo</a>
                <a href="#" class="hover:text-yellow-300">Móveis</a>
                <a href="#" class="hover:text-yellow-300">Informática</a>
                <a href="#" class="hover:text-yellow-300 text-yellow-300">Ofertas do Dia</a>
            </div>
        </nav>
    </header>

    <!-- Conteúdo Principal / Vitrine -->
    <main class="max-w-6xl w-full mx-auto p-4 my-4 space-y-6 flex-grow">

        <!-- Banner Promocional -->
        <div class="cb-blue rounded-2xl p-6 md:p-10 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
            <div class="space-y-3 z-10 text-center md:text-left">
                <span class="bg-yellow-300 text-blue-900 font-extrabold text-xs uppercase px-3 py-1 rounded-full shadow">Queima de Estoque</span>
                <h1 class="text-2xl md:text-4xl font-black tracking-tight">Tudo em até 12x sem juros no carnê!</h1>
                <p class="text-xs md:text-sm text-blue-100">Aproveite frete grátis para todo o Brasil nas compras acima de R$ 79.</p>
            </div>
            <div class="mt-4 md:mt-0 z-10">
                <a href="#vitrine" class="cb-yellow font-black px-6 py-3 rounded-xl shadow-lg inline-block uppercase text-xs tracking-wider hover:opacity-95 transition">Aproveitar Ofertas</a>
            </div>
        </div>

        <!-- Título da Vitrine -->
        <div id="vitrine" class="flex justify-between items-center border-b border-gray-300 pb-2">
            <h2 class="text-lg md:text-xl font-black text-gray-800 uppercase tracking-wide">🔥 Ofertas em Destaque</h2>
            <span class="text-xs text-blue-600 font-bold cursor-pointer hover:underline">Ver todos os produtos</span>
        </div>

        <!-- Grade de Produtos (Exemplo Padrão Varejo - Prontos para receber o banco de dados) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            
            <!-- Produto Exemplo 1 -->
            <div class="product-card bg-white rounded-xl p-4 border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="h-36 bg-gray-100 rounded-lg mb-3 flex items-center justify-center text-gray-400 font-semibold relative overflow-hidden">
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded">20% OFF</span>
                        <i class="fa-solid fa-box-open text-3xl"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 mb-2">Smartphone Exemplo 128GB Câmera Tripla Tela 6.5"</h3>
                </div>
                <div>
                    <div class="text-[10px] text-gray-400 line-through">R$ 1.499,00</div>
                    <div class="text-base font-black text-blue-700">R$ 1.199,00</div>
                    <div class="text-[10px] text-gray-500 mb-3">ou 10x de R$ 119,90 sem juros</div>
                    <button onclick="adicionarAoCarrinho('Smartphone Exemplo', 1199.00)" class="w-full cb-yellow hover:opacity-90 font-bold py-2 rounded-lg text-xs uppercase transition shadow-sm">
                        Comprar
                    </button>
                </div>
            </div>

            <!-- Produto Exemplo 2 -->
            <div class="product-card bg-white rounded-xl p-4 border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="h-36 bg-gray-100 rounded-lg mb-3 flex items-center justify-center text-gray-400 font-semibold relative overflow-hidden">
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded">15% OFF</span>
                        <i class="fa-solid fa-tv text-3xl"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 mb-2">Smart TV 50" 4K UHD LED Wi-Fi Integrado</h3>
                </div>
                <div>
                    <div class="text-[10px] text-gray-400 line-through">R$ 2.599,00</div>
                    <div class="text-base font-black text-blue-700">R$ 2.199,00</div>
                    <div class="text-[10px] text-gray-500 mb-3">ou 10x de R$ 219,90 sem juros</div>
                    <button onclick="adicionarAoCarrinho('Smart TV 50 4K', 2199.00)" class="w-full cb-yellow hover:opacity-90 font-bold py-2 rounded-lg text-xs uppercase transition shadow-sm">
                        Comprar
                    </button>
                </div>
            </div>

            <!-- Produto Exemplo 3 -->
            <div class="product-card bg-white rounded-xl p-4 border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="h-36 bg-gray-100 rounded-lg mb-3 flex items-center justify-center text-gray-400 font-semibold relative overflow-hidden">
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded">Frete Grátis</span>
                        <i class="fa-solid fa-blender text-3xl"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 mb-2">Liquidificador Turbo 12 Velocidades Copo de Vidro</h3>
                </div>
                <div>
                    <div class="text-[10px] text-gray-400 line-through">R$ 249,00</div>
                    <div class="text-base font-black text-blue-700">R$ 199,00</div>
                    <div class="text-[10px] text-gray-500 mb-3">ou 5x de R$ 39,80 sem juros</div>
                    <button onclick="adicionarAoCarrinho('Liquidificador Turbo', 199.00)" class="w-full cb-yellow hover:opacity-90 font-bold py-2 rounded-lg text-xs uppercase transition shadow-sm">
                        Comprar
                    </button>
                </div>
            </div>

            <!-- Produto Exemplo 4 -->
            <div class="product-card bg-white rounded-xl p-4 border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="h-36 bg-gray-100 rounded-lg mb-3 flex items-center justify-center text-gray-400 font-semibold relative overflow-hidden">
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded">Exclusivo</span>
                        <i class="fa-solid fa-couch text-3xl"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-800 line-clamp-2 mb-2">Sofá 3 Lugares Retrátil e Reclinável Suede</h3>
                </div>
                <div>
                    <div class="text-[10px] text-gray-400 line-through">R$ 1.899,00</div>
                    <div class="text-base font-black text-blue-700">R$ 1.499,00</div>
                    <div class="text-[10px] text-gray-500 mb-3">ou 10x de R$ 149,90 sem juros</div>
                    <button onclick="adicionarAoCarrinho('Sofá Retrátil', 1499.00)" class="w-full cb-yellow hover:opacity-90 font-bold py-2 rounded-lg text-xs uppercase transition shadow-sm">
                        Comprar
                    </button>
                </div>
            </div>

        </div>

    </main>

    <!-- Rodapé Casas Bahia -->
    <footer class="bg-white text-gray-600 text-xs py-6 border-t border-gray-200 mt-8">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 text-center md:text-left">
            <div>
                <h4 class="font-bold text-gray-800 mb-2">Atendimento</h4>
                <p>Central de Relacionamento</p>
                <p>Fale Conosco pelo WhatsApp</p>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 mb-2">Formas de Pagamento</h4>
                <p>Cartão Casas Bahia • Pix • Boleto • Carnê Digital</p>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 mb-2">Segurança</h4>
                <p><i class="fa-solid fa-lock text-green-600"></i> Site 100% Seguro e Protegido</p>
            </div>
        </div>
        <div class="text-center text-[10px] text-gray-400 border-t border-gray-100 pt-4">
            © 2026 Casas Bahia Comercial S.A. Todos os direitos reservados.
        </div>
    </footer>

    <!-- Script de Carrinho Interativo Simples -->
    <script>
        let cartCount = 0;

        function adicionarAoCarrinho(nomeProduto, preco) {
            cartCount++;
            document.getElementById('cart-count').innerText = cartCount;
            document.getElementById('cart-count-mobile').innerText = cartCount;
            alert('Produto "' + nomeProduto + '" adicionado ao carrinho com sucesso!');
        }

        function toggleCart() {
            alert('Seu carrinho possui ' + cartCount + ' item(ns). Redirecionando para o checkout...');
        }
    </script>
</body>
</html>