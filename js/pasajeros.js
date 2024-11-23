$(document).ready(function () {
    // Configura el botón "Detalles" como activo al cargar la página
    $('#pasajerosBtn').addClass('active');

    // Maneja el clic en los botones
    $('.btn-group .btn').on('click', function () {
        // Quita la clase 'active' de todos los botones
        $('.btn-group .btn').removeClass('active');
        
        // Agrega la clase 'active' al botón pulsado
        $(this).addClass('active');
    });

    // Redirección al pulsar el botón Pasajeros
    $('#pasajerosBtn').on('click', function () {
        // Obtiene el id desde sessionStorage
        const vueloId = sessionStorage.getItem('idVuelo'); // Reemplaza 'idVuelo' por la clave correcta

        if (vueloId) {
            // Redirige a la URL deseada con el parámetro id
            window.location.href = `http://localhost/SkyCater/public/pasajerosVuelo.php?id=${vueloId}`;
        } else {
            alert("El ID del vuelo no está disponible en sessionStorage.");
        }
    });

    // Redirección al pulsar el botón Detalles
    $('#detallesBtn').on('click', function () {
        // Obtiene el parámetro 'id' desde la URL actual
        const currentUrl = window.location.href;
        const url = new URL(currentUrl);
        const idVuelo = url.searchParams.get("id");  // Obtiene el parámetro 'id' de la URL

        if (idVuelo) {
            // Si el parámetro 'id' está presente, redirige a 'detallesVuelo.php' con el parámetro
            window.location.href = `http://localhost/SkyCater/public/detallesVuelo.php?id=${idVuelo}`;
        } else {
            // Si no hay parámetro 'id', no se agrega y simplemente se redirige sin él
            //window.location.href = 'http://localhost/SkyCater/public/detallesVuelo.php';
        }
    });

    // Redirección al pulsar el botón Volver
    $('#volverBtn').on('click', function () {
        // Simplemente redirige a listaVuelos.php sin el parámetro 'id'
        window.location.href = 'http://localhost/SkyCater/public/listaVuelos.php';
    });
});