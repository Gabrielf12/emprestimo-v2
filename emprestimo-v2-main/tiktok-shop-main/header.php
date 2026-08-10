<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zé Delivery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #ffffff; color: #333333; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .ze-bg-dark { background-color: #212121; }
        .ze-yellow { background-color: #ffcc00; color: #000000; }
        .ze-yellow:hover { background-color: #e6b800; }
    </style>
</head>
<body class="bg-white text-zinc-800 antialiased">

<header class="ze-bg-dark text-white sticky top-0 z-40 px-4 py-3 shadow-md">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
        
        <div class="flex items-center gap-3 cursor-pointer">
            <div class="w-9 h-9 ze-yellow rounded-full flex items-center justify-center font-black text-xl">
                ⚡
            </div>
            <div class="hidden sm:block text-xs">
                <span class="text-zinc-400 block text-[10px]">Receber em</span>
                <span class="font-bold flex items-center gap-1 text-white">
                    Rua Maporé, 16 - Ja... <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </span>
            </div>
        </div>

        <div class="flex-1 max-w-xl">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 text-sm"></i>
                <input type="text" placeholder="Pesquise sua bebida favorita" class="w-full bg-white text-black pl-9 pr-4 py-2 rounded-lg text-sm outline-none">
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button class="bg-white text-black px-5 py-1.5 rounded-full font-bold text-xs hover:bg-zinc-200 transition">
                Entrar
            </button>
            
            <!-- Botão do Carrinho Corrigido -->
            <button type="button" onclick="toggleCart()" class="relative p-2 text-white hover:text-amber-400 cursor-pointer">
                <i class="fa-solid fa-bag-shopping text-xl"></i>
                <span id="cart-count" class="absolute top-0 right-0 bg-amber-400 text-black text-[10px] font-black w-4 h-4 rounded-full flex items-center justify-center">0</span>
            </button>
        </div>
    </div>
</header>