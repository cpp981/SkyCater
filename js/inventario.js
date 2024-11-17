$(document).ready(function () {
    // Configuración de DataTable con AJAX
    const tableOptions = {
        dom: 'frtip', // Esto define la estructura y dónde se mostrarán los botones
        buttons: [
            {
                extend: 'pdfHtml5',  // Definimos el tipo de exportación como PDF
                text: 'Exportar a PDF', // Este texto no se usará porque lo controlamos manualmente
                className: 'btn btn-danger',  // Estilo del botón
                orientation: 'landscape',  // Orientación del PDF
                pageSize: 'A4',  // Tamaño de página
                exportOptions: {
                    columns: ':not(:last-child)', // Excluye la última columna
                    columns: [0, 1, 2, 3, 4, 5, 6]
                },
                customize: function (doc) {
                    // Personaliza el PDF aquí
                    doc.content[1].table.widths = ['*', 'auto', 'auto', 'auto', 'auto', 'auto', '*'];  // Ajusta la cantidad de columnas exportadas
                    doc.styles.tableHeader.fontSize = 12;
                },
                // No mostramos este botón
                visible: false
            }
        ],
        responsive: true, // Habilita la respuesta a diferentes tamaños de pantalla
        "ajax": {
            "url": "../src/producto2.php",  // URL del archivo PHP que devuelve los datos en JSON
            "type": "GET",
            "dataSrc": ""  // Si el JSON contiene un array de objetos en el nivel raíz
        },
        "columnDefs": [
            {
                className: "centered",
                targets: [0, 1, 2, 3, 4, 5, 6],
                targets: 6,
                searchable: false,
                orderable: false,
            },
        ],
        "columns": [
            { title: "Nombre" },
            { title: "Categoría" },
            { title: "Alérgenos" },
            { title: "Stock" },
            {
                title: "Fecha últ. actualización",
                render: function (data, type, row) {
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
            { title: "Valor Nutricional" },
            { title: "Descripción" },
            {
                title: "Acciones",
                orderable: false, // Deshabilitamos el orden en esta columna
                searchable: false, // Deshabilitamos la búsqueda en esta columna
                render: function (data, type, row) {
                    // Botón con icono de Font Awesome
                    return `<button id="borraProd" class="btn btn-danger btn-sm delete-row icon-button" data-id="${row[0]}" data-tooltip="Borrar Producto">
                                <i class="fas fa-trash-can"></i>
                            </button>
                            <button id="editProd" class="btn btn-warning btn-sm text-white icon-button" data-id="${row[0]}" data-tooltip="Editar Producto">
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
    var table = $('#tablaProductos').DataTable(tableOptions);
    
        // Usamos delegación de eventos para el botón que se genera dentro de DataTable
        $(document).on('click', '#borraProd', function () {
            // Obtener los datos de la fila donde se hizo clic
            var rowData = table.row($(this).parents('tr')).data(); // Obtiene los datos de la fila
    
            // Obtener el nombre del producto desde el objeto de datos de la fila
            var productoNombre = rowData[0];
            
            Swal.fire({
                title:'AVISO',
                html: '¡Se va a eliminar el producto "<strong>' + productoNombre + '</strong>" de manera definitiva!<br><br>¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Acción después de la confirmación (por ejemplo, eliminar la fila en DataTable)
                    console.log('Producto eliminado: ' + productoNombre);
    
                    // Aquí puedes hacer la eliminación real (en este ejemplo, eliminamos la fila de la tabla)
                    // Por ejemplo, eliminamos la fila correspondiente en DataTable:
                    //table.row($(this).parents('tr')).remove().draw();
    
                    // O realizar alguna otra acción, como hacer una petición AJAX para eliminar en el servidor
                    // $.ajax({
                    //     url: 'eliminarProducto.php',
                    //     method: 'POST',
                    //     data: { id: productoId },
                    //     success: function(response) {
                    //         // Manejo de la respuesta del servidor
                    //     }
                    // });
                }
            });
        });

    // Vincular botón de Exportar PDF al Datatables
    $('#exportPdf').on('click', function () {
        console.log("Exportando a PDF...");
        table.button(0).trigger(); // Usa el índice del botón PDF configurado en el array de botones
    });
    // Event listener para el botón de refresco
    $('#refrescarTabla').on('click', function () {
        table.ajax.reload(); // Refrescar la tabla al hacer clic en el botón
    });
});

$(document).ready(function () {
    const $tooltip = $('#tooltip');

    $('#tablaProductos').on('mouseenter', '.icon-button', function (event) {
        const tooltipText = $(this).data('tooltip');
        if (tooltipText) {
            console.log("Mostrando tooltip:", tooltipText);
            $tooltip.text(tooltipText)
                .appendTo('body') // Mueve el tooltip al body para evitar recortes
                .css({ display: 'block' })
                .fadeIn(200);
        }
    });

    $('#tablaProductos').on('mousemove', '.icon-button', function (event) {
        let tooltipX = event.pageX + 15;
        let tooltipY = event.pageY + 15;

        // Evitar que el tooltip se desborde por el lado derecho o inferior de la ventana
        const windowWidth = $(window).width();
        const windowHeight = $(window).height();
        const tooltipWidth = $tooltip.outerWidth();
        const tooltipHeight = $tooltip.outerHeight();

        if (tooltipX + tooltipWidth > windowWidth) {
            tooltipX = windowWidth - tooltipWidth - 15; // Ajustar a la derecha
        }
        if (tooltipY + tooltipHeight > windowHeight) {
            tooltipY = windowHeight - tooltipHeight - 15; // Ajustar hacia abajo
        }

        $tooltip.css({
            top: tooltipY + 'px',
            left: tooltipX + 'px',
        });
    });

    $('#tablaProductos').on('mouseleave', '.icon-button', function () {
        $tooltip.fadeOut(200);
    });
});

// Preparación y envío datos del Modal de Añadir Producto
// Hacemos petición por AJAX para recuperar nombres de proveedores
document.addEventListener('DOMContentLoaded', function () {
    $.ajax({
        url: '../src/proveedores.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            // Recuperamos la data que viene en un array de arrays
            const selectElement = $("#nombreProvs");
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
});

$(document).ready(function () {
    const notyf = new Notyf({
        position: {
            x: 'right',  // Alineación horizontal
            y: 'top'      // Alineación vertical en la parte superior
        },
    });

    $("#guardarProducto").on('click', function (event) {
        //console.log('CLICK GUARDAR PRODUCTO');
        event.preventDefault();
        // Recoger los datos del formulario
        var nombre = $("#nombreProducto").val();
        var descripcion = $("#descripcionProducto").val();
        var categoria = $("#categoriaProducto").val();
        var alergenos = $("#alergenosProducto").val();
        var valorNutricional = $("#valorNutricional").val();
        var idProveedor = $('#nombreProvs').val();
        console.log(idProveedor);
        // Preparar los datos a enviar en formato POST
        var datos = {
            nombre: nombre,
            descripcion: descripcion,
            categoria: categoria,
            alergenos: alergenos,
            valorNutricional: valorNutricional + " kcal"
        };

        // Enviar los datos al servidor mediante AJAX
        $.ajax({
            url: '../src/insertaProducto.php',  // URL del archivo PHP que manejará la inserción
            type: 'POST',  // Método POST
            data: datos,  // Enviar los datos del formulario
            success: function (response) {
                // Si la respuesta es exitosa, mostramos la notificación de éxito
                if (response.status == 'success') {
                    notyf.success(response.message);  // Notificación de éxito

                    // Cerrar el modal y resetear el formulario
                    $("#exampleModal").modal('hide');
                    $("#formularioProducto")[0].reset();
                } else {
                    // Si hubo un error, mostramos la notificación de error
                    $("#formularioProducto")[0].reset();
                    notyf.error(response.message);  // Notificación de error
                }
            },
            error: function () {
                // Si la petición AJAX falla, mostramos la notificación de error
                notyf.error('Hubo un problema al guardar el producto.');  // Notificación de error
            }
        });
    });
});