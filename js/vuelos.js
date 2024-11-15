// Configuración Datatables para Vuelos
const tableOptions = {
    columnDefs: [
        {
            className: "centered", targets: [0, 1, 2, 3, 4, 5, 6, 7],
            targets: [6, 7], searchable: false, orderable: false
        },
    ],
    "columns": [
        { title: "Vuelo" },
        { title: "Origen" },
        { title: "Destino" },
        { title: "Salida" },
        { title: "Llegada" },
        { title: "Estado" },
        { title: "Detalles" },
        { title: "Gestionar" }
    ],
    lengthChange: false,
    destroy: true,
    language: {
        paginate: {
            first: '<button class="btn btn-sm">Primero</button>',
            previous: '<button class="btn btn-sm">Anterior</button>',
            next: '<button class="btn btn-sm">Siguiente</button>',
            last: '<button class="btn btn-sm">Último</button>'
        },
        search: "Buscar: ",
        zeroRecords: "Ningún producto encontrado",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",

    },
};

// Cargar la lista de vuelos pendientes de gestionar
$(document).ready(function () {
    var tabla = $('#tablaVuelos').DataTable(tableOptions);

    $.ajax({
        url: '../src/listaVuelos2.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            data.forEach(function (vuelo) {
                console.log(vuelo);

                if (vuelo.length === 6) {
                    tabla.row.add([
                        vuelo[0],
                        vuelo[1],
                        vuelo[2],
                        vuelo[3],
                        vuelo[4],
                        vuelo[5],
                        '<button class="details btn btn-sm btn-primary text-white" data-id="' + vuelo[0] + '"><i class="fas fa-circle-info"></i> Detalles Vuelo</button>',
                        '<button class="btn btn-sm btn-success text-white" data-id="' + vuelo[0] + '"><i class="fas fa-plane-departure"></i> Gestionar Vuelo</button>'
                    ]).draw(false);
                } else {
                    console.warn("Fila incompleta: ", vuelo);
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar los datos: " + error);
        }
    });

    // Manejador de clic para el botón "detalles del vuelo"
    $('#tablaVuelos tbody').on('click', 'button.details', function () {
        // Obtener la fila actual
        var tr = $(this).closest('tr');
        // Obtener la instancia de la fila
        var row = tabla.row(tr);
        // Obtener los datos de la fila
        var dataRow = tabla.row(row).data();
        // Almacenar el valor de la columna "Vuelo"
        var numVuelo = dataRow[0];

        if (row.child.isShown()) {
            // Si ya está desplegada, ocultamos
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Si no está desplegada, la mostramos
            row.child(format(dataRow)).show();
            tr.addClass('shown');

            // Realizar la consulta AJAX
            $.ajax({
                url: '../src/detalleVuelos.php',
                method: 'POST',
                data: {
                    vuelo: numVuelo,
                },
                success: function (data) {
                    // Procesar y mostrar la data recibida
                    // Actualiza el contenido en la fila desplegada
                    var content = format(dataRow) + '<div class="mb-2"><p> Total pasajeros: ' + JSON.stringify(data['pasajeros'], null, 2) + ' <br>Pasajeros con intolerancias: ' + JSON.stringify(data['intolerancias'], null, 2) + '</p></div>';
                    row.child(content).show();
                },
                error: function (xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        }
    });
});

    // Función para formatear el título del contenido que se mostrará al desplegar la fila
    function format(dataRow) {
        return '<div><strong>Información adicional para el vuelo ' + dataRow[0] + '</strong></div>';
    }


    document.addEventListener('DOMContentLoaded', function () {
        //jQuery para menú desplegable
        $('#sidebarToggle').click(function () {
            $('#sidebar').toggle(350, 'linear');
        });

        $(document).ready(function() {
            // Detectamos la URL actual de la página
            var currentPath = window.location.pathname;
        
            // Recorremos todos los enlaces del menú
            $('.nav-item .nav-link').each(function() {
                var linkPath = $(this).attr('href');  // Obtenemos el href del enlace
        
                // Si la URL actual coincide con el enlace, agregamos la clase 'active' al item
                if (currentPath.indexOf(linkPath) !== -1) {
                    $(this).parent('.nav-item').addClass('active'); // Añadimos 'active' al elemento <li> correspondiente
                }
            });
        
            // Cuando el usuario haga clic en un enlace del menú
            $('.nav-item .nav-link').click(function() {
                // Eliminamos la clase 'active' de todos los elementos
                $('.nav-item').removeClass('active');
        
                // Agregamos la clase 'active' solo al item que fue clickeado
                $(this).parent('.nav-item').addClass('active');
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