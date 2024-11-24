$(document).ready(function () {
    // Configura el botón "Detalles" como activo al cargar la página
    $('#pasajerosBtn').addClass('active');

    // Maneja el clic en los botones
    $('.btn-group .btn').on('click', function () {
        $('.btn-group .btn').removeClass('active');
        $(this).addClass('active');
    });

    // Redirección al pulsar el botón Pasajeros
    $('#pasajerosBtn').on('click', function () {
        const vueloId = sessionStorage.getItem('idVuelo');
        if (vueloId) {
            window.location.href = `http://localhost/SkyCater/public/pasajerosVuelo.php?id=${vueloId}`;
        } else {
            alert("El ID del vuelo no está disponible en sessionStorage.");
        }
    });

    // Redirección al pulsar el botón Detalles
    const currentUrl = window.location.href;
    const url = new URL(currentUrl);
    const idVuelo = url.searchParams.get("id");

    $('#detallesBtn').on('click', function () {
        if (idVuelo) {
            window.location.href = `http://localhost/SkyCater/public/detallesVuelo.php?id=${idVuelo}`;
        }
    });

    // Redirección al pulsar el botón Volver
    $('#volverBtn').on('click', function () {
        window.location.href = 'http://localhost/SkyCater/public/listaVuelos.php';
    });
    
    // Definimos la DataTable de Pasajeros
    const tableOptions = {
        dom: 'frtip',
        responsive: true,
        autoWidth: false,
        pageLength: 7,
        ajax: {
            url: "../src/detalleVuelos.php",  // URL que devuelve los datos
            type: "POST",
            dataSrc: function (json) {
                // Verificar si la respuesta fue exitosa
                if (json.status === "success") {
                    return json.data;  // Retornar solo el array de datos
                } else {
                    return [];  // Retornar vacío si hay error
                }
            },
            data: function (d) {
                d.idVuelo = idVuelo;  // Agregar parámetro idVuelo
                d.action = "obtener_pasajero";  // Agregar acción
            }
        },
        columns: [
            {
                title: "Pasajero",
                render: function (data, type, row) {
                    // Combina Nombre y Apellido
                    return `${row.Nombre} ${row.Apellido}`;
                }
            },
            { title: "Intolerancias", 
                render: function (data, type, row) {
                    // Verificar si el campo 'Intolerancias' tiene algún valor
                    let intolerancias = row.Intolerancias;
    
                    if (!intolerancias || intolerancias === "Ninguna") {
                        // Si no hay intolerancias o es "Ninguna", asignar un badge verde
                        return '<span class="badge badge-success">Ninguna</span>';
                    } else {
                        // Si tiene más de una intolerancia, las separamos por coma y las convertimos en badges
                        const intoleranciasArray = intolerancias.split(',');  // Separa las intolerancias
                        return intoleranciasArray.map(function(intolerancia) {
                            return `<span class="badge badge-warning">${intolerancia.trim()}</span>`; // Genera un badge por cada intolerancia
                        }).join(' '); // Unir todos los badges en un string
                    }
                }
            },
            { title: "Preferencias", data: "Preferencias_Comida" },
            { title: "Asiento", data: "Asiento" },
            { title: "Plato 1", defaultContent: "" },
            { title: "Plato 2", defaultContent: "" },
            { title: "Bebida", defaultContent: "" },
            {
                title: "Acción",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="edit btn btn-sm btn-primary" 
                                data-dni="${row.Dni}" 
                                data-nombre="${row.Nombre}">
                            <i class="fas fa-gear"></i></button>`;
                }
            }
        ],
        columnDefs: [
            {
                width: "15%",
                targets: [1,2]
            },
            {
                width: "20%",
                targets: 0
            },
            {
                width: "25%",
                targets: [4,5,6]
            },
        ],
        lengthChange: false,  // No mostrar opción para cambiar la cantidad de registros visibles
        destroy: true,  // Permitir reinicializar la tabla
        language: {
            paginate: {
               // first: '<button class="btn btn-sm">Primero</button>',
               // previous: '<button class="btn btn-sm">Anterior</button>',
               // next: '<button class="btn btn-sm">Siguiente</button>',
               // last: '<button class="btn btn-sm">Último</button>'
            },
            search: "Buscar: ",
            zeroRecords: "No se encontraron pasajeros",
            info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
            infoFiltered: "(filtrados desde _MAX_ registros totales)"
        }
    };
    
    const tablaPasajeros = $('#tablaPasajeros').DataTable(tableOptions);
    
    

    $('#tablaPasajeros').on('click', 'tr', function () {
        // Muestra el spinner
        $('#gestionMenuPasajero .loading-message').show();
    
        // Lógica para cargar el contenido de gestión del menú
        const pasajeroId = $(this).data('id'); // O cualquier otro atributo para identificar al pasajero
    
        // Simulamos un retraso en la carga para mostrar el spinner
        setTimeout(function() {
            // Ocultamos el spinner
            $('#gestionMenuPasajero .loading-message').hide();
            
            // Aquí puedes insertar el contenido real de la gestión del menú
            $('#gestionMenuPasajero').html('<p>Contenido de gestión del menú del pasajero ' + pasajeroId + '</p>');
        }, 2000);  // Simulando un retraso de 2 segundos, puedes ajustarlo según sea necesario
    });
    
});
