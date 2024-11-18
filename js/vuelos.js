document.addEventListener('DOMContentLoaded', function () {
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
                targets: [0, 1, 2, 3, 4, 5], // Definir qué columnas deben ser centradas
                searchable: true, // Deshabilita búsqueda en estas columnas
                orderable: true   // Deshabilita el orden en estas columnas
            },
            {
                targets: 6,  // La columna de "Acciones"
                orderable: false,
                searchable: false  // Deshabilita búsqueda en esta columna
            }
        ],
        columns: [
            { title: "Vuelo" },
            { title: "Origen" },
            { title: "Destino" },
            { title: "Salida" },
            { title: "Llegada" },
            { title: "Estado" },
            {
                title: "Acciones",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="details btn btn-sm btn-primary text-white" data-id="${row[0]}">
                            <i class="fas fa-circle-info"></i> Detalles
                        </button>
                        <button class="manage btn btn-sm btn-success text-white" data-id="${row[0]}">
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
    

    let expandedRow = null; // Rastrea la fila actualmente desplegada

    // Manejador para el botón "Detalles"
    $('#tablaVuelos tbody').on('click', 'button.details', function () {
        const tr = $(this).closest('tr');
        const row = tablaVuelos.row(tr);
        const dataRow = row.data();

        if (row.child.isShown()) {
            // Si la fila actual ya está desplegada, la ocultamos
            row.child.hide();
            tr.removeClass('shown');
            expandedRow = null; // Resetear la fila desplegada
        } else {
            // Si hay otra fila desplegada, la ocultamos
            if (expandedRow && expandedRow !== row) {
                expandedRow.child.hide();
                $(expandedRow.node()).removeClass('shown');
            }

            // Desplegamos la fila actual
            row.child(format(dataRow)).show();
            tr.addClass('shown');
            expandedRow = row;

            // Cargar detalles del vuelo
            $.ajax({
                url: '../src/detalleVuelos.php',
                method: 'POST',
                data: { vuelo: dataRow[0] },
                success: function (data) {
                    const content = `
                        <div class="details-row d-flex justify-content-center align-items-center" style="background-color:#003262;">
                            <div class="detail-item">
                                <div class="card card-details1 shadow w-50">
                                    <p class="text-center"><strong>Total pasajeros</strong></p>
                                    <p class="text-center"><strong>${data.pasajeros}</strong></p>
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="card shadow w-50">
                                    <p class="text-center"><strong>Pasajeros con intolerancias</strong></p>
                                    <p class="text-center"><strong>${data.intolerancias}</strong></p>
                                </div>
                            </div>
                        </div>`;
                    row.child(format(dataRow) + content).show();
                },
                error: function (xhr, status, error) {
                    console.error('Error al cargar detalles:', error);
                }
            });
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

