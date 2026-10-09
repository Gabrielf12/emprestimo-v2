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
    <title>tudoAki - Sua Loja de Tudo. Aqui.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-navy { background-color: #0b192c; }
        .bg-navy-dark { background-color: #060e18; }
        .text-gold { color: #d4af37; }
        .bg-gold { background-color: #d4af37; color: #0b192c; }
        .border-gold { border-color: #d4af37; }
        
        .product-card {
            transition: all 0.25s ease;
            background: #0f2238;
            border: 1px solid rgba(212, 175, 55, 0.25);
        }
        .product-card:hover {
            transform: translateY(-3px);
            border-color: #d4af37;
            box-shadow: 0 10px 25px -5px rgba(212, 175, 55, 0.2);
        }
        @keyframes pulse-gold {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .gold-pulse {
            animation: pulse-gold 2s infinite;
        }
    </style>
</head>
<body class="bg-navy min-h-screen font-sans text-gray-100 flex flex-col justify-between">

    <!-- Topo / Header tudoAki -->
    <header class="bg-navy-dark border-b border-gold/30 shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex flex-col md:flex-row items-center justify-between gap-3">
            
            <!-- Logomarca Local -->
            <div class="flex items-center justify-between w-full md:w-auto">
                <a href="index.php" class="flex items-center gap-3">
                    <img src="logo.jpg" alt="tudoAki Logo" class="h-12 md:h-14 object-contain rounded-lg border border-gold/40 shadow-md bg-navy">
                </a>
                <div class="md:hidden flex items-center gap-3">
                    <button onclick="toggleCart()" class="relative text-gold text-lg">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span id="cart-count-mobile" class="absolute -top-2 -right-2 bg-gold text-navy text-[10px] font-black rounded-full w-4 h-4 flex items-center justify-center">0</span>
                    </button>
                </div>
            </div>

            <!-- Barra de Pesquisa -->
            <div class="w-full md:w-1/2 relative">
                <input type="text" placeholder="Pesquisar ofertas, produtos, prêmios..." class="w-full bg-navy border border-gold/40 text-white rounded-full py-2 px-4 pl-10 text-sm focus:outline-none focus:border-gold">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-gold/60 text-sm"></i>
            </div>

            <!-- Ações e Carrinho Desktop -->
            <div class="hidden md:flex items-center gap-5 text-sm font-bold">
                <a href="#" class="hover:text-gold flex items-center gap-1.5 transition"><i class="fa-solid fa-user text-gold"></i> Minha Conta</a>
                <button onclick="toggleCart()" class="relative bg-navy-dark hover:bg-navy px-4 py-2 rounded-full flex items-center gap-2 border border-gold/60 transition shadow-md">
                    <i class="fa-solid fa-cart-shopping text-gold"></i>
                    <span>Carrinho</span>
                    <span id="cart-count" class="bg-gold text-navy text-xs font-black rounded-full px-1.5 py-0.2">0</span>
                </button>
            </div>
        </div>

        <!-- Menu de Departamentos -->
        <nav class="bg-navy border-t border-gold/20 text-xs font-bold py-2.5 px-4">
            <div class="max-w-6xl mx-auto flex items-center gap-6 overflow-x-auto whitespace-nowrap text-gray-300">
                <a href="#" class="hover:text-gold flex items-center gap-1 text-gold"><i class="fa-solid fa-bars"></i> Todos os Departamentos</a>
                <a href="#" class="hover:text-gold">Tecnologia & Celulares</a>
                <a href="#" class="hover:text-gold">Eletrodomésticos</a>
                <a href="#" class="hover:text-gold">Sorteios & Prêmios</a>
                <a href="#" class="hover:text-gold">Utilidades</a>
                <a href="#" class="hover:text-gold text-gold font-black">🔥 Ofertas Imperdíveis</a>
            </div>
        </nav>
    </header>

    <!-- Conteúdo Principal -->
    <main class="max-w-6xl w-full mx-auto p-4 my-4 space-y-6 flex-grow">

        <!-- Banner Promocional Local -->
        <div class="rounded-2xl overflow-hidden shadow-2xl border-2 border-gold/50 relative bg-navy-dark">
            <img src="banner.jpg" alt="Sorteio Nivus ou 60 Mil no Pix" class="w-full h-auto object-cover max-h-[480px]">
            <div class="absolute bottom-4 right-4 z-10">
                <a href="#vitrine" class="bg-gold hover:opacity-90 text-navy font-black px-6 py-3 rounded-xl shadow-lg inline-block uppercase text-xs tracking-wider transition gold-pulse">
                    Participar do Sorteio
                </a>
            </div>
        </div>

        <!-- Título da Vitrine -->
        <div id="vitrine" class="flex justify-between items-center border-b border-gold/30 pb-2">
            <h2 class="text-lg md:text-xl font-black text-gold uppercase tracking-wide flex items-center gap-2">
                <i class="fa-solid fa-star"></i> Produtos em Destaque
            </h2>
            <span class="text-xs text-gold/80 font-bold cursor-pointer hover:underline">Ver catálogo completo</span>
        </div>

        <!-- Grade de Produtos -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            
            <!-- Produto 1 -->
            <div class="product-card rounded-xl p-4 flex flex-col justify-between">
                <div>
                    <div class="h-36 bg-navy-dark rounded-lg mb-3 flex items-center justify-center text-gold/50 font-semibold relative overflow-hidden border border-gold/20">
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded">Ganha Cupom</span>
                        <i class="fa-solid fa-box-open text-3xl text-gold"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-200 line-clamp-2 mb-2">Kit Especial tudoAki 2026 + Número da Sorte</h3>
                </div>
                <div>
                    <div class="text-[10px] text-gray-400 line-through">R$ 149,00</div>
                    <div class="text-base font-black text-gold">R$ 100,00</div>
                    <div class="text-[10px] text-gray-300 mb-3">Dá direito a 1 Cupom p/ Sorteio</div>
                    <button onclick="adicionarAoCarrinho('Kit Especial tudoAki', 100.00)" class="w-full bg-gold hover:opacity-90 text-navy font-black py-2 rounded-lg text-xs uppercase transition shadow-sm">
                        Comprar Agora
                    </button>
                </div>
            </div>

            <!-- Produto 2 -->
            <div class="product-card rounded-xl p-4 flex flex-col justify-between">
                <div>
                    <div class="h-36 bg-navy-dark rounded-lg mb-3 flex items-center justify-center text-gold/50 font-semibold relative overflow-hidden border border-gold/20">
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded">Frete Grátis</span>
                        <i class="fa-solid fa-mobile-screen text-3xl text-gold"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-200 line-clamp-2 mb-2">Smartphone Premium 128GB + Sorteio em Dobro</h3>
                </div>
                <div>
                    <div class="text-[10px] text-gray-400 line-through">R$ 1.599,00</div>
                    <div class="text-base font-black text-gold">R$ 1.299,00</div>
                    <div class="text-[10px] text-gray-300 mb-3">ou 10x de R$ 129,90 sem juros</div>
                    <button onclick="adicionarAoCarrinho('Smartphone Premium', 1299.00)" class="w-full bg-gold hover:opacity-90 text-navy font-black py-2 rounded-lg text-xs uppercase transition shadow-sm">
                        Comprar Agora
                    </button>
                </div>
            </div>

            <!-- Produto 3 -->
            <div class="product-card rounded-xl p-4 flex flex-col justify-between">
                <div>
                    <div class="h-36 bg-navy-dark rounded-lg mb-3 flex items-center justify-center text-gold/50 font-semibold relative overflow-hidden border border-gold/20">
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded">Oferta Relâmpago</span>
                        <i class="fa-solid fa-tv text-3xl text-gold"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-200 line-clamp-2 mb-2">Smart TV 50" 4K UHD com Comando de Voz</h3>
                </div>
                <div>
                    <div class="text-[10px] text-gray-400 line-through">R$ 2.699,00</div>
                    <div class="text-base font-black text-gold">R$ 2.299,00</div>
                    <div class="text-[10px] text-gray-300 mb-3">ou 10x de R$ 229,90 sem juros</div>
                    <button onclick="adicionarAoCarrinho('Smart TV 50', 2299.00)" class="w-full bg-gold hover:opacity-90 text-navy font-black py-2 rounded-lg text-xs uppercase transition shadow-sm">
                        Comprar Agora
                    </button>
                </div>
            </div>

            <!-- Produto 4 -->
            <div class="product-card rounded-xl p-4 flex flex-col justify-between">
                <div>
                    <div class="h-36 bg-navy-dark rounded-lg mb-3 flex items-center justify-center text-gold/50 font-semibold relative overflow-hidden border border-gold/20">
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-black px-2 py-0.5 rounded">Mais Vendido</span>
                        <i class="fa-solid fa-headphones text-3xl text-gold"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-200 line-clamp-2 mb-2">Fone Bluetooth Gamer Sem Fio de Alta Performance</h3>
                </div>
                <div>
                    <div class="text-[10px] text-gray-400 line-through">R$ 299,00</div>
                    <div class="text-base font-black text-gold">R$ 199,00</div>
                    <div class="text-[10px] text-gray-300 mb-3">ou 4x de R$ 49,75 sem juros</div>
                    <button onclick="adicionarAoCarrinho('Fone Bluetooth Gamer', 199.00)" class="w-full bg-gold hover:opacity-90 text-navy font-black py-2 rounded-lg text-xs uppercase transition shadow-sm">
                        Comprar Agora
                    </button>
                </div>
            </div>

        </div>

    </main>

    <!-- Rodapé tudoAki -->
    <footer class="bg-navy-dark text-gray-400 text-xs py-6 border-t border-gold/30 mt-8">
        <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 text-center md:text-left">
            <div>
                <h4 class="font-bold text-gold mb-2">Atendimento tudoAki</h4>
                <p>Suporte e Relacionamento com o Cliente</p>
                <p>Fale Conosco pelo WhatsApp oficial</p>
            </div>
            <div>
                <h4 class="font-bold text-gold mb-2">Formas de Pagamento</h4>
                <p>Pix • Cartão de Crédito • Boleto Bancário</p>
            </div>
            <div>
                <h4 class="font-bold text-gold mb-2">Sorteios Autorizados</h4>
                <p><i class="fa-solid fa-shield-halved text-gold"></i> Regulamento autorizado conforme SEAE/ME</p>
            </div>
        </div>
        <div class="text-center text-[10px] text-gray-500 border-t border-gold/10 pt-4">
            © 2026 tudoAki - Sua Loja de Tudo. Aqui. Todos os direitos reservados.
        </div>
    </footer>

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