document.addEventListener('DOMContentLoaded', function () {
    // Llamada AJAX para rellenar los  indicadores
    $.ajax({
        url: '../src/listaPedidos.php',  // URL de la petición
        method: 'POST',
        data: {
            action: 'indicadores'
        },
        success: function (response) {
            if (response && response.status === 'success' && response['0']) {
                // Accedemos a los datos dentro de la clave "0"
                const data = response['0'];
                // Actualizamos los valores de los indicadores
                $('#card-entregados').text(data.completos);  // Pedidos completados
                $('#card-sin-entregar').text(data.pendientes);  // Pedidos pendientes
            } else {
                // Manejo de error si la respuesta no tiene el formato esperado
                console.error("Error: La respuesta no tiene los datos esperados.");
            }
        },
        error: function (xhr, status, error) {
            // Manejo de errores de la petición AJAX
            console.error("Error en la petición AJAX:", error);
        }
    });

    // Configuración de DataTable con AJAX
    const tableOptions = {
        responsive: true,
        ajax: {
            url: "../src/listaPedidos.php",
            type: "POST",
            dataSrc: "",
            pageLength: 6,
            data: function (d) {
                d.action = "obtener_pedidos";
            }
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
            {
                title: "Estado",
                render: function (data, type, row) {
                    // Comprobamos el valor de "Estado" y devolvemos el badge correspondiente
                    let badgeClass = '';
                    let badgeText = '';

                    switch (data) {
                        case 'Pendiente':
                            badgeClass = 'badge-warning';
                            badgeText = 'Pendiente';
                            break;
                        case 'Entregado':
                            badgeClass = 'badge-success';
                            badgeText = 'Entregado';
                            break;
                        case 'Cancelado':
                            badgeClass = 'badge-danger';
                            badgeText = 'Cancelado';
                            break;
                        default:
                            badgeClass = 'badge-secondary'; // En caso de que haya un valor inesperado
                            badgeText = 'Desconocido';
                            break;
                    }

                    // Retorna el HTML del span con la clase adecuada
                    return `<span class="badge ${badgeClass}">${badgeText}</span>`;
                }
            },
            { title: "Coste" },
            { title: "Proveedor" },
            {
                title: "Fecha Pedido",
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
            {
                title: "Fecha Entrega",
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
            {
                title: "Acciones",
                orderable: false, // Deshabilitamos el orden en esta columna
                searchable: false, // Deshabilitamos la búsqueda en esta columna
                render: function (data, type, row) {
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

    // Función para traer los nombres e ids de los proveedores

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

                    // Iteramos sobre la data y añadimos las opciones
                    $.each(data.productos, function (index, item) {
                        const nombre = item.Nombre;  // Nombre del producto
                        const idProducto = item.Id_Producto; // ID del producto
                        const categoria = item.Categoria; // Categoría del producto

                        // Añadimos el option con el ID del producto como value y la categoría como data-attribute
                        selectProductos.append(`<option value="${idProducto}" data-categoria="${categoria}">${nombre}</option>`);
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



    $(document).ready(function () {
        // Iniciamos Notyf para notificar el resultado al usuario
        const notyf = new Notyf({
            position: {
                x: 'right',  // Alineación horizontal
                y: 'top'      // Alineación vertical en la parte superior
            },
        });

        // Arreglo para almacenar números de pedido únicos
        let numerosDePedido = [];

        // Función para generar un número de pedido único y ordenado de menor a mayor
        function generarNumeroDePedidoUnico() {
            let numeroPedido;

            // Generar un número aleatorio entre 100000 y 999999
            do {
                numeroPedido = faker.random.number({ min: 100000, max: 999999 });
            } while (numerosDePedido.includes(numeroPedido) || (numerosDePedido.length > 0 && numeroPedido <= numerosDePedido[numerosDePedido.length - 1]));

            // Agregar el número generado al arreglo para futuras verificaciones
            numerosDePedido.push(numeroPedido);

            // Ordenar el arreglo de números de pedido de menor a mayor
            numerosDePedido.sort((a, b) => a - b);

            return numeroPedido;
        }

        // Obtener el precio del producto usando Faker con faker.commerce.price()
        function obtenerPrecioProducto(categoria) {
            let precio = 0;

            console.log("Categoría del producto:", categoria);

            // Usamos faker.commerce.price() para obtener un número aleatorio dentro de un rango
            if (categoria === 'Primer Plato') {
                precio = faker.commerce.price(1, 4);  // Genera un precio entre 1 y 4
            } else if (categoria === 'Segundo Plato') {
                precio = faker.commerce.price(3, 8);  // Genera un precio entre 3 y 8
            } else if (categoria === 'Bebida') {
                precio = faker.commerce.price(1, 3);  // Genera un precio entre 1 y 3
            }

            console.log('Precio generado:', precio);  // Verificar que el precio generado no sea 0

            // Convertir el precio a un número flotante
            precio = parseFloat(precio);  // Parsear a float

            // Verificar si el precio es válido
            if (isNaN(precio) || precio <= 0) {
                console.error("Error: El precio generado no es válido o es cero: " + precio);
                return 0;  // Retorna 0 si el precio no es válido
            }

            return precio;  // Retorna el precio válido
        }


        // Evento para abrir el modal de añadir pedido
        $('#addPedido').click(function () {
            $('#modalPedido').modal('show'); // Abrir el modal
            var numPedido = generarNumeroDePedidoUnico(); // Generamos un nuevo número de pedido único
            console.log(numPedido); // Para ver el número en la consola

            // Mostramos el número de pedido en el input correspondiente
            $('#pedidoNum').val(numPedido);

        });

        // Cuando se haga el submit del formulario
        $('form').on('submit', function (event) {
            event.preventDefault();

            // Obtener los datos del formulario
            const numeroDePedido = $('#pedidoNum').val();
            const fechaEntrega = $('#pedidoFecha').val();
            const productoId = $('#producto').val();
            const cantidad = parseInt($('#pedidoCantidad').val(), 10); // Asegurarnos de que es un número
            const observaciones = $('#pedidoObservaciones').val();
            const proveedorId = $('#proveedor').val();

            // Verificación de campos obligatorios (sin contar las observaciones)
            if (!numeroDePedido || !fechaEntrega || !productoId || !cantidad || !proveedorId) {
                notyf.error("Por favor, completa todos los campos obligatorios.");
                return; // Detenemos el proceso si falta algún campo obligatorio
            }

            // Verificamos si se ha seleccionado un producto
            if (!productoId) {
                notyf.error("Por favor, selecciona un producto.");
                return; // Detenemos el proceso si no hay producto seleccionado
            }

            // Obtener el producto seleccionado y su categoría
            const productoSeleccionado = $('#producto option:selected');
            const nombreProducto = productoSeleccionado.text(); // Obtener el nombre del producto seleccionado
            const categoriaProducto = productoSeleccionado.data('categoria'); // Obtener la categoría del producto seleccionado

            // Obtener el precio del producto basándonos en la categoría
            const precioProducto = obtenerPrecioProducto(categoriaProducto);

            // Almacenamos el precio del producto para enviarlo luego al backend
            $('#producto').data('precio', precioProducto); // Guardamos el precio en el select como data-attribute

            // Calcular el coste total
            const costeTotal = (precioProducto * cantidad).toFixed(2); // Multiplicamos cantidad por precio y redondeamos a 2 decimales

            // Mostrar el spinner con SweetAlert
            Swal.fire({
                title: 'Generando pedido...',
                html: 'Estamos procesando tu solicitud',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading(); // Iniciamos el spinner
                }
            });
            // Añadir retraso para simular el proceso de generación del pedido
            setTimeout(() => {
                $.ajax({
                    url: '../src/insertaPedido.php',
                    method: 'POST',
                    data: {
                        numeroDePedido: numeroDePedido,
                        fechaEntrega: fechaEntrega,
                        productoId: productoId,
                        nombreProducto: nombreProducto,
                        cantidad: cantidad,
                        precioProducto: precioProducto,
                        costeTotal: costeTotal,
                        proveedorId: proveedorId,
                        observaciones: observaciones
                    },
                    success: function (response) {
                        console.log(response); // Verificar el contenido de la respuesta
                        Swal.close(); // Cerramos el spinner

                        if (response.status === 'success') {
                            notyf.success(response.message);
                            $('#tablaPedidos').DataTable().ajax.reload();
                            $('form')[0].reset();
                            $('#formPedido').modal('hide');
                        } else {
                            notyf.error(response.message || "Error al guardar el pedido.");
                        }
                    },
                    error: function (xhr, status, response) {
                        Swal.close(); // Cerramos el spinner
                        notyf.error("Error al guardar el pedido");
                    }
                });
            }, 1000);
        });
    });
});
