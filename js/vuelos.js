// Configuración Datatables
const tableOptions = {
    columnDefs: [
        { className: "centered", targets: [0, 1, 2, 3, 4, 5, 6, 7],
          targets: [6, 7],searchable: false, orderable: false
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
        { title: "Gestionar"}
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

    // Manejador de clic para el botón "details"
    $('#tablaVuelos tbody').on('click', 'button.details', function() {
        var tr = $(this).closest('tr'); // Obtener la fila actual
        var row = tabla.row(tr); // Obtener la instancia de la fila

        if (row.child.isShown()) {
            // Si ya está desplegada, la colapsamos
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Si no está desplegada, la mostramos
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    // Función para formatear el contenido que se mostrará
    function format(data) {
        return '<div>Información adicional para: ' + data[0] + '</div>';
    }
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