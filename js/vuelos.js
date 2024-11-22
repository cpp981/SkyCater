document.addEventListener('DOMContentLoaded', function () {

    const notyf = new Notyf({
        position: {
            x: 'right',  // Alineación horizontal
            y: 'top'      // Alineación vertical en la parte superior
        }
    });

    const tableOptions = {
        dom: 'frtip',  // Estructura de los elementos (filtro, tabla, paginación)
        responsive: true,
        ajax: {
            url: "../src/listaVuelos2.php",  // URL del archivo que devuelve los datos
            type: "GET",
            dataSrc: ""  // Deja vacío si los datos están directamente en la raíz
        },
        columnDefs: [
            {
                className: "centered",
                targets: [0, 1, 2, 3, 4, 5], // Define qué columnas deben ser centradas
                searchable: true,
                orderable: true
            },
            {
                targets: 6,  // La columna de "Acciones"
                orderable: false,
                searchable: false,
            },
            {
                targets: 0,  // Columna del `id` (oculta)
                visible: false, // Oculta la columna de `id`
                searchable: false,
                orderable: false
            }
        ],
        columns: [
            { title: "Id" },               // Columna oculta (id)
            { title: "Vuelo" },
            { title: "Origen" },
            { title: "Destino" },
            { title: "Salida" },
            { title: "Llegada" },
            {
                title: "Estado",
                render: function (data, type, row) {
                    const estado = row[6]; // Valor de la columna "Estado"
                    const isPendiente = estado === "Pendiente";
                    const badgeClass = isPendiente ? "badge badge-warning text-dark" : "badge badge-success text-white"; // Añadir texto visible
                    return `<span class="badge ${badgeClass}" style="font-size: 0.9em;">${estado}</span>`;
                }
            },
            {
                title: "Acciones",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="manage btn btn-sm btn-success text-white" 
                                data-id="${row[0]}" 
                                data-vuelo="${row[1]}">
                            <i class="fas fa-plane-departure"></i> Gestionar
                        </button>`;
                }
            }
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
            zeroRecords: "Ningún vuelo encontrado",
            info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
            infoFiltered: "(filtrados desde _MAX_ registros totales)"
        },
    };

    const tablaVuelos = $('#tablaVuelos').DataTable(tableOptions);
  
    document.addEventListener('click', function (event) {
        if (event.target.closest('.manage')) {
            const button = event.target.closest('.manage');
            const id = button.dataset.id; // Obtén el id del vuelo desde el atributo data-id
            const vuelo = button.dataset.vuelo; // Obtén el número de vuelo desde el atributo data-vuelo
    
            // Guarda el número de vuelo en sessionStorage
            sessionStorage.setItem('numeroVuelo', vuelo);
    
            // Redirige a la página con solo el ID como parámetro GET
            window.location.href = `detallesVuelo.php?id=${id}`;
        }
    });
    
    

    // Petición para los valores cards
    $.ajax({
        url: '../src/indiVuelos.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Accedemos a los datos que necesitamos desde la respuesta
                const gestionados = response.data.vuelos_gestionados[0].Num_Vuelos_Gestionados;
                const sinGestionar = response.data.vuelos_sin_gestionar[0].Num_Vuelos_Gestionados;

                // Actualizar las cards en el frontend con los datos recibidos
                $('#card-gestionados').text(gestionados);
                $('#card-sin-gestionar').text(sinGestionar);

            } else {
                notyf.error('Error en la respuesta:', response.error);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Manejar errores en la solicitud AJAX
            notyf.error('Error en la solicitud AJAX:', textStatus, errorThrown);
        }
    });

    // Manejador para el botón "Gestionar Vuelo"
    $('#tablaVuelos tbody').on('click', 'button.manage', function () {
        const vueloId = $(this).data('id');
        console.log('Gestionar vuelo ID:', vueloId);
    });

    // Función para formatear los detalles del vuelo
    function format(dataRow) {
        return `<div class="indi text-center"><strong>INFORMACIÓN ADICIONAL PARA EL VUELO ${dataRow[0]}</strong></div>`;
    }
});

