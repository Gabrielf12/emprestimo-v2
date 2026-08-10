<?php
session_start();
$nome = $_SESSION['cliente_nome'] ?? 'Cliente';
$endereco = $_SESSION['endereco'] ?? 'Seu endereço cadastrado';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado! - Zé Promoções</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-zinc-950 text-white min-h-screen flex items-center justify-center p-4">

    <div class="bg-zinc-900 border border-zinc-800 rounded-3xl p-8 w-full max-w-md text-center shadow-2xl">
        <div class="w-20 h-20 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
            <i class="fa-solid fa-truck-fast animate-bounce"></i>
        </div>

        <h2 class="text-3xl font-black text-white mb-2">Pedido Confirmado!</h2>
        <p class="text-sm text-zinc-400 mb-6">Obrigado, <span class="text-amber-400 font-bold"><?= htmlspecialchars($nome) ?></span>! Seu pedido já está sendo preparado e a bebida vai trincando de gelada.</p>

        <div class="bg-zinc-800/60 border border-zinc-700/50 rounded-2xl p-4 text-left mb-6 space-y-2">
            <div class="flex items-center gap-2 text-xs text-zinc-400">
                <i class="fa-solid fa-clock text-amber-400"></i>
                <span>Tempo estimado de entrega: <strong>15 a 30 min</strong></span>
            </div>
            <div class="flex items-center gap-2 text-xs text-zinc-400">
                <i class="fa-solid fa-location-dot text-red-500"></i>
                <span class="truncate">Entregar em: <strong><?= htmlspecialchars($endereco) ?></strong></span>
            </div>
        </div>

        <a href="index.php" class="inline-block w-full bg-amber-400 hover:bg-amber-500 text-black font-extrabold py-3.5 rounded-xl text-sm transition">
            FAZER OUTRO PEDIDO
        </a>
    </div>

</body>
</html>