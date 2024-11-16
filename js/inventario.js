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
                customize: function(doc) {
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
            { title: "Fecha últ. actualización",
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
            { title: "Valor Nutricional" },
            { title: "Descripción" },
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
    var table = $('#tablaProductos').DataTable(tableOptions);

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

// Preparación y envío datos del Modal de Añadir Producto

$(document).ready(function () {
    const notyf = new Notyf({
        position: {
            x: 'right',  // Alineación horizontal
            y: 'top'      // Alineación vertical en la parte superior
        },
    });

    $("#guardarProducto").click(function (event) {
        //console.log('CLICK GUARDAR PRODUCTO');
        event.preventDefault();
        // Recoger los datos del formulario
        var nombre = $("#nombreProducto").val();
        var descripcion = $("#descripcionProducto").val();
        var categoria = $("#categoriaProducto").val();
        var alergenos = $("#alergenosProducto").val();
        var valorNutricional = $("#valorNutricional").val();
        var idProveedor = $('#idProveedor').val();

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




document.addEventListener('DOMContentLoaded', function () {
    //jQuery para menú desplegable
    $('#sidebarToggle').click(function () {
        //$('#sidebar').toggle(350, 'linear');
        $('#sidebar').toggleClass('sidebar-collapsed');
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