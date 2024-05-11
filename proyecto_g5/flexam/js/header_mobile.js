document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menu-toggle');
    var nav = document.querySelector('nav ul');

    // Función para manejar la visibilidad del menú basada en el tamaño de pantalla
    function handleMenuVisibility() {
        if (window.matchMedia("(max-width: 768px)").matches) {
            nav.style.display = 'none';
        } else {
            nav.style.display = 'flex';
        }
    }

    // Llamar a la función al cargar la página
    handleMenuVisibility();

    window.addEventListener('resize', handleMenuVisibility);

    menuToggle.addEventListener('click', function() {
        // Alternar la visibilidad del menú solo en dispositivos móviles
        if (window.matchMedia("(max-width: 768px)").matches) {
            if (nav.style.display === 'none') {
                nav.style.display = 'flex';
            } else {
                nav.style.display = 'none';
            }
        }
    });
});
