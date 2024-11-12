$(document).ready(function () {
    // Configuración de DataTable con AJAX
    const tableOptions = {
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
                orderable: false
            },
        ],
        "columns": [
            { title: "Nombre" },
            { title: "Categoría" },
            { title: "Alérgenos" },
            { title: "Stock" },
            { title: "Fecha última actualización" },
            { title: "Valor Nutricional" },
            { title: "Descripción" }
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
        $('#sidebar').toggle(350, 'linear');
    });
    //Alerta en la parte superior cuando se añade producto
    // Inicializa Notyf
    /*$(document).ready(function () {
        const notyf = new Notyf({
            position: {
                x: 'right',  // Alineación horizontal
                y: 'top'      // Alineación vertical en la parte superior
            },
        });
        $('#addProd').click(function () {
            // Muestra una notificación de éxito
            notyf.success('Producto añadido correctamente');
        });
    });*/

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