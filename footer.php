<footer class="bg-zinc-800 text-white mt-16">
    <div class="bg-zinc-700 text-center py-3 text-xs text-zinc-300 font-semibold cursor-pointer" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
        Voltar ao topo
    </div>
    <div class="max-w-7xl mx-auto px-6 py-8 text-center text-xs text-zinc-400">
        ZE SOLUCOES TECNOLOGICAS DE COMERCIO DE BEBIDAS LTDA.
    </div>
</footer>

<!-- Modal Lateral SACOLA -->
<div id="cart-drawer" class="fixed inset-0 bg-black/50 z-50 hidden flex justify-end">
    <div class="bg-white w-full max-w-md h-full flex flex-col justify-between shadow-2xl">
        <div class="p-4 border-b border-zinc-200 flex justify-between items-center">
            <h3 class="font-bold text-sm text-zinc-800 tracking-wider">SACOLA</h3>
            <button onclick="toggleCart()" class="text-zinc-500 hover:text-black"><i class="fa-solid fa-xmark text-lg"></i></button>
        </div>

        <div class="p-4 flex-1 overflow-y-auto" id="drawer-items"></div>

        <div class="border-t border-zinc-200 p-4 bg-white">
            <div class="space-y-1 text-xs text-zinc-600 mb-3">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span id="drawer-subtotal">R$ 0,00</span>
                </div>
                <div class="flex justify-between">
                    <span>Taxa de entrega</span>
                    <span id="drawer-taxa">R$ 8,49</span>
                </div>
                <div class="flex justify-between font-bold text-sm text-zinc-900 pt-2 border-t border-zinc-100">
                    <span>Total a pagar</span>
                    <span id="drawer-total">R$ 0,00</span>
                </div>
            </div>

            <button onclick="goToCheckout()" class="w-full ze-yellow py-3 rounded-lg font-bold text-xs uppercase tracking-wider">
                ENTRAR PARA CONTINUAR
            </button>
        </div>
    </div>
</div>

<script>
    let cart = [];
    let currentSelectedProduct = null;
    let modalQty = 1;

    // Toggle da Sacola Lateral
    function toggleCart(forceOpen = false) {
        const drawer = document.getElementById('cart-drawer');
        if(!drawer) return;
        
        if (forceOpen) {
            drawer.classList.remove('hidden');
        } else {
            drawer.classList.toggle('hidden');
        }
        renderCart();
    }

    // Modal Interno do Produto
    function openProductModal(prod) {
        currentSelectedProduct = prod;
        modalQty = 1;
        
        document.getElementById('modal-img').src = prod.img;
        document.getElementById('modal-title').innerText = prod.nome;
        document.getElementById('modal-price').innerText = `R$ ${prod.preco.toFixed(2).replace('.', ',')}`;
        
        updateModalDisplay();
        document.getElementById('product-detail-modal').classList.remove('hidden');
    }

    function closeProductModal() {
        document.getElementById('product-detail-modal').classList.add('hidden');
    }

    function updateModalQty(delta) {
        modalQty += delta;
        if(modalQty < 1) modalQty = 1;
        updateModalDisplay();
    }

    function setModalQty(qty) {
        modalQty = qty;
        updateModalDisplay();
    }

    function updateModalDisplay() {
        document.getElementById('modal-qty').innerText = modalQty < 10 ? '0' + modalQty : modalQty;
        if(currentSelectedProduct) {
            const totalPrice = currentSelectedProduct.preco * modalQty;
            document.getElementById('btn-text-qty').innerText = `ADICIONAR (${modalQty})`;
            document.getElementById('btn-text-price').innerText = `R$ ${totalPrice.toFixed(2).replace('.', ',')}`;
        }
    }

    function confirmAddFromModal() {
        if(!currentSelectedProduct) return;
        
        const index = cart.findIndex(item => item.id === currentSelectedProduct.id);
        if (index > -1) {
            cart[index].qty += modalQty;
        } else {
            cart.push({ ...currentSelectedProduct, qty: modalQty });
        }

        closeProductModal();
        toggleCart(true);
    }

    // Renderizar Carrinho Lateral
    function renderCart() {
        const container = document.getElementById('drawer-items');
        const countHeader = document.getElementById('cart-count');
        const subtotalEl = document.getElementById('drawer-subtotal');
        const totalEl = document.getElementById('drawer-total');
        const taxaEntrega = 8.49;

        let subtotal = 0;
        let totalItems = 0;

        cart.forEach(item => {
            subtotal += item.preco * item.qty;
            totalItems += item.qty;
        });

        if(countHeader) countHeader.innerText = totalItems;
        if(!container) return;

        if(cart.length === 0) {
            container.innerHTML = '<p class="text-center text-zinc-400 text-xs py-12">Sua sacola está vazia</p>';
            if(subtotalEl) subtotalEl.innerText = 'R$ 0,00';
            if(totalEl) totalEl.innerText = 'R$ 0,00';
            return;
        }

        container.innerHTML = cart.map(item => `
            <div class="flex items-center justify-between py-3 border-b border-zinc-100">
                <img src="${item.img}" class="w-12 h-12 object-contain">
                <div class="flex-1 px-3">
                    <h4 class="text-xs text-zinc-800 font-medium">${item.nome}</h4>
                    <span class="text-xs font-bold text-zinc-900 block mt-0.5">R$ ${(item.preco * item.qty).toFixed(2).replace('.', ',')}</span>
                </div>
                <div class="flex items-center border border-zinc-200 rounded px-2 py-1 gap-3">
                    <button onclick="changeQty(${item.id}, -1)" class="text-zinc-400 font-bold text-xs px-1">-</button>
                    <span class="text-xs font-bold text-zinc-700">${item.qty < 10 ? '0'+item.qty : item.qty}</span>
                    <button onclick="changeQty(${item.id}, 1)" class="text-amber-500 font-bold text-xs px-1">+</button>
                </div>
            </div>
        `).join('');

        const totalFinal = subtotal + taxaEntrega;
        if(subtotalEl) subtotalEl.innerText = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
        if(totalEl) totalEl.innerText = `R$ ${totalFinal.toFixed(2).replace('.', ',')}`;
    }

    function changeQty(id, delta) {
        const item = cart.find(i => i.id === id);
        if(item) {
            item.qty += delta;
            if(item.qty <= 0) cart = cart.filter(i => i.id !== id);
        }
        renderCart();
    }

    function goToCheckout() {
        if (cart.length === 0) return alert('Adicione produtos na sacola primeiro!');
        window.location.href = 'process_cpf.php';
    }
</script>

</body>
</html>