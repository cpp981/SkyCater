document.addEventListener('DOMContentLoaded', function () {
    // jQuery para menú desplegable
    $('#sidebarToggle').on('click', function () {
        $('#sidebar').toggleClass('sidebar-collapsed');
        // Verificar si la sidebar está colapsada y activar/desactivar tooltips
        toggleTooltips();
    });

    // Inicializamos o desactivamos los tooltips manualmente dependiendo del estado de la sidebar
    function toggleTooltips() {
        if ($('#sidebar').hasClass('sidebar-collapsed')) {
            // Solo inicializar los tooltips si la sidebar está colapsada
            $('[data-bs-toggle="tooltip"]').each(function() {
                new bootstrap.Tooltip(this); // Crear la instancia del tooltip solo si la sidebar está colapsada
                // Restauramos el atributo title al tooltip para evitar que se vea el tooltip nativo
                $(this).attr('title', $(this).data('bs-original-title'));
            });
        } else {
            // Desactivamos los tooltips si la sidebar no está colapsada
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                var tooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl); // Obtener instancia del tooltip
                if (tooltip) {
                    tooltip.dispose(); // Eliminar tooltip si ya está inicializado
                }
                // Guardamos el title original antes de eliminarlo y lo removemos para evitar el tooltip nativo
                var title = $(tooltipTriggerEl).attr('title');
                $(tooltipTriggerEl).data('bs-original-title', title).removeAttr('title');
            });
        }
    }

    // Ejecutar al cargar la página para manejar el estado inicial de la sidebar
    toggleTooltips();

    // Al cambiar de página, volvemos a verificar si la sidebar está colapsada
    $(window).on('beforeunload', function () {
        toggleTooltips(); // Llamar a la función para asegurarse de que los tooltips están correctamente gestionados.
    });

    $(document).ready(function () {
        // Detectamos la URL actual de la página
        var currentUrl = window.location.href;  // URL completa

        // Recorremos todos los enlaces del menú
        $('.nav-item .nav-link').each(function () {
            var linkPath = $(this).attr('href');  // Obtenemos el href del enlace

            // Si la URL actual coincide con el enlace, agregamos la clase 'active' al item
            if (currentUrl.indexOf(linkPath) !== -1) {
                $(this).parent('.nav-item').addClass('active'); // Añadimos 'active' al elemento <li> correspondiente
            }
        });

        // Si estamos en detallesVuelo.php con cualquier parámetro id, cambiamos los estilos de "Vuelos" y "Detalles"
        if (currentUrl.indexOf('detallesVuelo.php') !== -1 && currentUrl.includes('?id=')) {
            // Establecer el fondo blanco, el texto negro y el ícono negro para el "Vuelos"
            $('.nav-item .nav-link[href="listaVuelos.php"]').css({
                'background-color': '',  // Eliminar fondo blanco de "Vuelos"
                'color': ''  // Restaurar el color de texto de "Vuelos"
            }).find('i').css('color', '');  // Restaurar color del ícono de "Vuelos"

            // Asegurar que el subenlace "Detalles" esté activo
            $('.nav-item .active .nav-link[href="detallesVuelo.php"]').css({
                'background-color': 'white',  // Fondo blanco para "Detalles"
                'color': 'black'  // Texto negro para "Detalles"
            }).find('i').css('color', 'black');  // Ícono negro para "Detalles"
        }

        // Cuando el usuario haga clic en un enlace del menú
        $('.nav-item .nav-link').click(function () {
            // Eliminamos la clase 'active' de todos los elementos
            $('.nav-item').removeClass('active');

            // Agregamos la clase 'active' solo al item que fue clickeado
            $(this).parent('.nav-item').addClass('active');
        });

        // Solo mostrar el tooltip cuando la sidebar esté colapsada
        $('.user-icon').hover(function () {
            if ($('#sidebar').hasClass('sidebar-collapsed')) {
                // Mostrar el tooltip cuando la sidebar está colapsada
                $(this).tooltip('show');
            }
        }, function () {
            // Ocultar el tooltip cuando el ratón se va
            $(this).tooltip('hide');
        });
    });

    //Antes de cerrar la sesión, pide confirmación.
    $('#close').click(function () {
        Swal.fire({
            title: "Estás seguro?",
            text: "Se cerrará tu sesión!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5cb85c",
            cancelButtonColor: "#d33",
            cancelButtonText: 'Cancelar',
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../src/cerrar.php';
            }
        });
    });
});