document.addEventListener('DOMContentLoaded', function() {
    
    console.log('Landing page de tienda cargada (JS Puro)');

    // Instancias de los modales Bootstrap
    const cartModal = new bootstrap.Modal(document.getElementById('carritoModal'));
    const subModal = new bootstrap.Modal(document.getElementById('suscripcionModal'));
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

    // BOTONES DE AÑADIR AL CARRITO =====
    const addButtons = document.querySelectorAll('.btn-add-to-cart');
    
    addButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Obtener datos del producto
            const product = this.getAttribute('data-product');
            const price = this.getAttribute('data-price');
            
            // Actualizar modal
            document.getElementById('modalProductName').textContent = product;
            document.getElementById('modalProductPrice').textContent = '$' + price;
            
            // Mostrar modal
            cartModal.show();
        });
    });

    // BOTÓN DE SUSCRIPCIÓN =====
    const subscribeBtn = document.getElementById('btnSubscribe');
    const emailInput = document.getElementById('emailInput');
    
    subscribeBtn.addEventListener('click', function() {
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && emailRegex.test(email)) {
            document.getElementById('modalEmailSubscription').textContent = email;
            subModal.show();
            emailInput.value = '';
        } else {
            errorModal.show();
        }
    });

    // BUSCADOR Y FILTROS EN TIEMPO REAL CON jQuery =====
    const $searchInput = $('#productSearch');
    const $filterButtons = $('.filter-btn');
    const $productItems = $('.product-card-item');
    const $emptyProducts = $('#emptyProducts');
    let activeFilter = 'todos';

    function filterProducts() {
        const searchText = $searchInput.val().toLowerCase().trim();
        let visibleItems = 0;

        $productItems.each(function() {
            const $item = $(this);
            const category = $item.data('category');
            const name = ($item.data('name') || '').toLowerCase();
            const description = ($item.data('description') || '').toLowerCase();
            const keywords = ($item.data('keywords') || '').toLowerCase();

            const matchesCategory = activeFilter === 'todos' || category === activeFilter;
            const matchesSearch = !searchText || name.includes(searchText) || description.includes(searchText) || keywords.includes(searchText);
            const shouldShow = matchesCategory && matchesSearch;

            $item.toggle(shouldShow);

            if (shouldShow) {
                visibleItems++;
            }
        });

        $emptyProducts.toggleClass('d-none', visibleItems !== 0);
    }

    $searchInput.on('input', function() {
        filterProducts();
    });

    $filterButtons.on('click', function() {
        activeFilter = $(this).data('filter');

        $filterButtons.removeClass('active');
        $(this).addClass('active');

        filterProducts();
    });

    filterProducts();

    // SCROLL SUAVE PARA ENLACES DEL NAVBAR =====
    const navLinks = document.querySelectorAll('a[href^="#"]');
    
    navLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            const target = document.querySelector(targetId);
            
            if (target) {
                e.preventDefault();
                const targetPosition = target.offsetTop - 70;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // EVENTOS DE CIERRE DE MODALES =====
    document.getElementById('carritoModal').addEventListener('hidden.bs.modal', function() {
        console.log('Modal de carrito cerrado (JS Puro)');
    });

    document.getElementById('suscripcionModal').addEventListener('hidden.bs.modal', function() {
        console.log('Modal de suscripción cerrado (JS Puro)');
    });

    console.log('Todos los modales están listos (JS Puro)');
});