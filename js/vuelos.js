//PETICION AJAX PARA TABLA VUELOS
/*$(document).ready(function () {
    var tabla = $('#tablaVuelos').DataTable({
        "pagingType": "full_numbers",
        "language": {
            "paginate": {
                "first": "Primero",
                "previous": "Anterior",
                "next": "Siguiente",
                "last": "Último"
            }
        },
        "columns": [
            { title: "Vuelo" }, // Reemplaza con nombres reales
            { title: "Origen" },
            { title: "Destino" },
            { title: "Salida" },
            { title: "Llegada" },
            { title: "Estado" },
            { title: "Gestionar" } // La columna del botón
        ]
    });
    $('#tablaVuelos tbody').on('click', 'tr', function () {
        var tr = $(this);
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            table.rows().every(function() {
                if (this.child.isShown()) {
                    this.child.hide();
                    $(this.node()).removeClass('shown');
                }
            });

            row.child('<div>Detalles adicionales sobre ' + tr.children('td').first().text() + '</div>').show();
            tr.addClass('shown');
        }
    });

    $.ajax({
        url: '../src/listaVuelos2.php', // URL del archivo PHP
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data); // Verifica la estructura de los datos
            data.forEach(function (vuelo) {
                console.log(vuelo); // Verifica cada fila


                if (vuelo.length === 6) { // Asegúrate de que hay 7 elementos
                    tabla.row.add([
                        vuelo[0], // Columna 1
                        vuelo[1], // Columna 2
                        vuelo[2], // Columna 3
                        vuelo[3], // Columna 4
                        vuelo[4], // Columna 5
                        vuelo[5], // Columna 6
                        //vuelo[6], // Columna 7
                        '<button class="botonInv btn btn-sm btn-warning text-white" data-id="' + vuelo[0] + '"><i class="fas fa-plane-departure"></i> Gestionar</button>' // Botón
                    ]).draw(false); // 'false' para no reiniciar la paginación
                } else {
                    console.warn("Fila incompleta: ", vuelo); // Mensaje de advertencia si hay una fila incompleta
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar los datos: " + error);
        }
    });

    /*$('#tablaVuelos tbody').on('click', '.btn-accion', function () {
        var id = $(this).data('id');
        alert('Botón clicado para ID: ' + id);
    });
});*/

$(document).ready(function () {
    var tabla = $('#tablaVuelos').DataTable({
        "pagingType": "full_numbers",
        "language": {
            "paginate": {
                "first": "Primero",
                "previous": "Anterior",
                "next": "Siguiente",
                "last": "Último"
            }
        },
        "columns": [
            { title: "Vuelo" },
            { title: "Origen" },
            { title: "Destino" },
            { title: "Salida" },
            { title: "Llegada" },
            { title: "Estado" },
            { title: "Gestionar" }
        ]
    });

    // Manejo de clic en filas para desplegar
    $('#tablaVuelos tbody').on('click', 'tr', function () {
        var tr = $(this);
        var row = tabla.row(tr);

        if (row.child.isShown()) {
            // Si la fila ya está desplegada, la ocultamos
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Ocultar cualquier fila que esté desplegada
            tabla.rows().every(function() {
                if (this.child.isShown()) {
                    this.child.hide();
                    $(this.node()).removeClass('shown');
                }
            });

            // Mostrar la información adicional de la fila seleccionada
            row.child('<div>Detalles adicionales sobre ' + tr.children('td').first().text() + '</div>').show();
            tr.addClass('shown');
        }
    });

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
                        '<button class="botonInv btn btn-sm btn-warning text-white" data-id="' + vuelo[0] + '"><i class="fas fa-plane-departure"></i> Gestionar</button>'
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
});




document.addEventListener('DOMContentLoaded', function () {
    //jQuery para menú desplegable
    $('#sidebarToggle').click(function () {
        $('#sidebar').toggle(350, 'linear');
    });
    //Antes de cerrar la sesión, pide confirmación.
    $('#close').click(function () {
        Swal.fire({
            title: "Estás seguro?",
            text: "Se cerrará tu sesión!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#003262",
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