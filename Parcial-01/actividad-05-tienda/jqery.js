$(document).ready(function () {

    console.log('Landing page de tienda cargada (jQuery)');

    // Instancias de los modales Bootstrap
    const cartModal = new bootstrap.Modal(document.getElementById('carritoModal'));
    const subModal = new bootstrap.Modal(document.getElementById('suscripcionModal'));
    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

    // BOTONES DE AÑADIR AL CARRITO =====
    $('.btn-add-to-cart').on('click', function (e) {
        e.preventDefault();

        // Obtener datos del producto
        const product = $(this).data('product');
        const price = $(this).data('price');

        // Actualizar modal
        $('#modalProductName').text(product);
        $('#modalProductPrice').text('$' + price);

        // Mostrar modal
        cartModal.show();
    });

    // BOTÓN DE SUSCRIPCIÓN =====
    $('#btnSubscribe').on('click', function () {
        const email = $('#emailInput').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email && emailRegex.test(email)) {
            $('#modalEmailSubscription').text(email);
            subModal.show();
            $('#emailInput').val('');
        } else {
            errorModal.show();
        }
    });

    // SCROLL SUAVE PARA ENLACES DEL NAVBAR =====
    $('a[href^="#"]').on('click', function (e) {
        const target = $($(this).attr('href'));

        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 70
            }, 600);
        }
    });

    // EVENTOS DE CIERRE DE MODALES =====
    $('#carritoModal').on('hidden.bs.modal', function () {
        console.log('Modal de carrito cerrado (jQuery)');
    });

    $('#suscripcionModal').on('hidden.bs.modal', function () {
        console.log('Modal de suscripción cerrado (jQuery)');
    });

    console.log('Todos los modales están listos (jQuery)');
});