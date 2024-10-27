$(document).ready(function () {
    //PETICION AJAX PARA TABLA INVENTARIO
    $.ajax({
        url: '../src/producto2.php', // URL del archivo PHP
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Rellenar la tabla con los datos
            var tablaBody = $('#tablaProductos tbody');
            data.forEach(function (plato) {
                var fila = '<tr>';
                plato.forEach(function (valor) {
                    fila += '<td class="custom-table-size">' + valor + '</td>';
                });
                fila += '</tr>';
                tablaBody.append(fila);
            });
            // Configuración Datatables
            const tableOptions = {
                columnDefs: [
                    {
                        className: "centered", targets: [0, 1, 2, 3, 4, 5, 6],
                        targets: 6, searchable: false, orderable: false
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

            $(document).ready(function () {
                var table = $('#tablaProductos').DataTable(tableOptions);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error en la petición AJAX:', textStatus, errorThrown);
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    //jQuery para menú desplegable
    $('#sidebarToggle').click(function () {
        $('#sidebar').toggle(350, 'linear');
    });
    //Alerta en la parte superior cuando se añade producto
    // Inicializa Notyf
    $(document).ready(function () {
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