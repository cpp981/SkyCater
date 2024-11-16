$(document).ready(function () {
    // Configuración de DataTable con AJAX
    const tableOptions = {
        responsive: true, // Habilita la respuesta a diferentes tamaños de pantalla
        "ajax": {
            "url": "../src/listaPedidos.php",  // URL del archivo PHP que devuelve los datos en JSON
            "type": "GET",
            "dataSrc": ""  // Si el JSON contiene un array de objetos en el nivel raíz
        },
        "columnDefs": [
            {
                className: "centered",
                targets: [0, 1, 2, 3, 4, 5],
                targets: 5,
                searchable: false,
                orderable: false,
            },
        ],
        "columns": [
            { title: "Nº Pedido" },
            { title: "Estado" },
            { title: "Coste" },
            { title: "Proveedor" },
            { title: "Fecha",
                render: function(data, type, row) {
                    if (data) {
                        // Formatear la fecha (suponiendo que está en formato ISO 8601 o YYYY-MM-DD HH:MM:SS)
                        const date = new Date(data);
                        const day = String(date.getDate()).padStart(2, '0'); // Día con dos dígitos
                        const month = String(date.getMonth() + 1).padStart(2, '0'); // Mes con dos dígitos
                        const year = date.getFullYear(); // Año completo
                        const hours = String(date.getHours()).padStart(2, '0'); // Hora con dos dígitos
                        const minutes = String(date.getMinutes()).padStart(2, '0'); // Minutos con dos dígitos
                        
                        return `${day}-${month}-${year} ${hours}:${minutes}`;
                    }
                    return ""; // Si no hay fecha, devuelve vacío
                }
            },
            { 
                title: "Acciones",
                orderable: false, // Deshabilitamos el orden en esta columna
                searchable: false, // Deshabilitamos la búsqueda en esta columna
                render: function(data, type, row) {
                    // Botón con icono de Font Awesome
                    return `<button class="btn btn-danger btn-sm delete-row" data-id="${row[0]}">
                                <i class="fas fa-trash-can"></i>
                            </button>
                            <button class="btn btn-warning btn-sm text-white" data-id="${row[0]}">
                                <i class="fas fa-pencil"></i>
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
            zeroRecords: "Ningún producto encontrado",
            info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
            infoFiltered: "(filtrados desde _MAX_ registros totales)",
        },
    };

    // Inicializar DataTable con la configuración definida
    var table = $('#tablaPedidos').DataTable(tableOptions);

     // Vincular botón de Exportar PDF al Datatables
     $('#exportPdf').on('click', function () {
        console.log("Exportando a PDF...");
        table.button(0).trigger(); // Usa el índice del botón PDF configurado en el array de botones
    });
    // Event listener para el botón de refresco
    $('#refrescarTabla').click(function () {
        table.ajax.reload(); // Refrescar la tabla al hacer clic en el botón
    });
});

// Función para traer los nombres e ids de los proveedores
document.addEventListener('DOMContentLoaded', function () {
    $.ajax({
        url: '../src/proveedores.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
           // console.log(data);
            // Recuperamos la data que viene en un array de arrays
            const selectElement = $("#proveedor");
            // Recorremos la data y creamos las opciones.
            $.each(data, function (index, item) {
                const nombre = item[0]; // Nombre del elemento (primer valor del array).
                const id = item[1];     // ID del elemento (segundo valor del array).
                
                // Creamos y añadimos la opción al select.
                selectElement.append(`<option value="${id}">${nombre}</option>`);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar los datos: " + error);
        }
    });

    // Detectar cuando se selecciona un proveedor
    $("#proveedor").on('change', function () {
        const proveedorId = $(this).val(); // Obtener el ID del proveedor seleccionado

        if (proveedorId) { // Validar que haya un proveedor seleccionado
            // Hacer la petición AJAX con el ID del proveedor
            $.ajax({
                url: '../src/productosByProv.php', // Cambia esta URL a la ruta adecuada
                method: 'POST',
                data: { idProveedor: proveedorId },
                dataType: 'json',
                success: function (data) {
                    console.log(data); // Verificar la estructura de la data recibida
                    
                    const selectProductos = $("#producto"); // Select para los productos
                    selectProductos.empty(); // Vaciar el select de productos
                    selectProductos.append('<option value="" selected>Seleccione un producto</option>'); // Opción vacía
                    
                    // Iterar sobre la data y añadir las opciones
                    $.each(data, function (index, item) {
                        const nombre = item[0]; // El nombre del producto está en el primer índice del array
                        selectProductos.append(`<option value="${index}">${nombre}</option>`);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error al cargar los productos: " + error);
                }
            });
        } else {
            console.log("No se seleccionó ningún proveedor.");
        }
    });
});

$(document).ready(function () {
    $('#addPedido').click(function () {
        $('#modalPedido').modal('show');
    });
});

