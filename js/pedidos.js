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
        pageLength: 7,
        ajax: {
            url: "../src/listaPedidos.php",
            type: "POST",
            dataSrc: "",
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
            { title: "Nombre Producto" },
            {
                title: "Coste", data: 3, render: function (data, type, row) {
                    // Comprobar si es tipo 'display' para mostrar el simbolo en la tabla
                    if (type === 'display') {
                        return data + ' €';  // Añadir el símbolo de euro
                    }
                    return data;
                }
            },
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

                    return `<button class="btn btn-danger btn-sm delete-row" data-id="${row[0]}"
                              data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="left" title="Cancelar pedido"">
                                <i class="fas fa-xmark"></i>
                            </button>
                            <button class="btn btn-primary btn-sm text-white view-detail" data-id="${row[0]}"
                                data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="left" title="Ver detalles"">
                                <i class="fas fa-eye"></i>
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
    const table = $('#tablaPedidos').DataTable(tableOptions);   

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
                        selectProductos.append(`<option class="prodId" value="${idProducto}" data-categoria="${categoria}">${nombre}</option>`);
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
            //const productoId = $('.prodId').val();
            const cantidad = parseInt($('#pedidoCantidad').val(), 10); // Asegurarnos de que es un número
            const observaciones = $('#pedidoObservaciones').val();
            const proveedorId = $('#proveedor').val();
            //console.log(productoId);
            // Verificación de campos obligatorios (sin contar las observaciones)
            if (!numeroDePedido || !fechaEntrega  || !cantidad || !proveedorId) {
                notyf.error("Por favor, completa todos los campos obligatorios.");
                return; // Detenemos el proceso si falta algún campo obligatorio
            }

            // Verificamos si se ha seleccionado un producto
           /*if (!productoId) {
                notyf.error("Por favor, selecciona un producto.");
                return; // Detenemos el proceso si no hay producto seleccionado
            }*/

            // Obtener el producto seleccionado y su categoría
            const productoSeleccionado = $('#producto option:selected');
            const nombreProducto = productoSeleccionado.text(); // Obtener el nombre del producto seleccionado
            const categoriaProducto = productoSeleccionado.data('categoria'); // Obtener la categoría del producto seleccionado
            const productoId = productoSeleccionado.val();
            //console.log("Id-PROD: " + productoId);
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
                    dataType: 'json', // Especificamos el tipo de dato de la respuesta
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
                            // Notificar que el pedido se ha guardado correctamente
                            notyf.success(response.message);

                            // Mostrar un segundo SweetAlert con el número de pedido
                            Swal.fire({
                                title: 'Pedido creado correctamente',
                                text: 'El número de pedido es: ' + numeroDePedido,
                                icon: 'success',
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor: '#5cb85c'
                            }).then(() => {
                                // Recargar la tabla de pedidos y resetear el formulario
                                $('#tablaPedidos').DataTable().ajax.reload();
                                $('#formPedido')[0].reset();
                                $('#modalPedido').modal('hide');
                            });

                        } else {
                            notyf.error(response.message || "Error al guardar el pedido.");
                        }
                    },
                    error: function (xhr, status, response) {
                        Swal.close(); // Cerramos el spinner
                        notyf.error("Error al guardar el pedido");
                    }
                });
            }, 1000); // Simulamos el proceso de creación del pedido con un retraso

        });

    });

    $(document).on('click', '.delete-row', function () {
        const notyf = new Notyf({
            position: {
                x: 'right',  // Alineación horizontal
                y: 'top'      // Alineación vertical en la parte superior
            },
        });
        // Obtener el número de pedido desde el atributo data-id
        const numPedido = $(this).data('id');

        // Confirmar la acción con el usuario
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Esta acción cancelará el pedido número ${numPedido}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#5cb85c',
            cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                // Realizar la petición AJAX
                $.ajax({
                    url: '../src/detallePedido.php', // Archivo PHP que maneja la cancelación
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'cancelar',
                        numPedido: numPedido
                    },
                    beforeSend: function () {
                        // Mostrar un spinner mientras se procesa
                        Swal.fire({
                            title: 'Procesando...',
                            text: 'Por favor, espera.',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                        });
                    },
                    success: function (response) {
                        Swal.close(); // Cerrar el spinner

                        // Verificar la respuesta y mostrar el mensaje correspondiente
                        if (response.status === 'success') {
                            // Mostrar un mensaje de éxito y recargar la tabla
                            notyf.success(response.message);
                            $('#tablaPedidos').DataTable().ajax.reload(null, false); // Recargar la tabla sin reiniciar la paginación
                        } else {
                            // Mostrar un mensaje de error
                            notyf.error(response.message);
                        }
                    },
                    error: function () {
                        Swal.close(); // Cerrar el spinner
                        // Mostrar un mensaje genérico en caso de error
                        notyf.error('Ocurrió un error al intentar cancelar el pedido.');
                    },
                });
            }
        });
    });

    $(document).on('click', '.view-detail', function () {
        // Obtener el número de pedido desde el atributo data-id
        const numPedido = $(this).data('id');

        $.ajax({
            url: '../src/detallePedido.php', // Archivo PHP que manejará la acción
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'detalles',
                numPedido: numPedido
            },
            success: function (response) {
                if (response.status === 'success' && response.data.length > 0) {
                    // Construir el contenido del pop-up
                    let detalles = response.data[0]; // Acceder al primer (y único) elemento del array
                    let estadoClass = '';

                    // Determinar la clase de estado según el valor de Estado_Pedido
                    switch (detalles.Estado_Pedido) {
                        case 'Entregado':
                            estadoClass = 'badge-success';
                            break;
                        case 'Pendiente':
                            estadoClass = 'badge-warning';
                            break;
                        case 'Cancelado':
                            estadoClass = 'badge-danger';
                            break;
                        default:
                            estadoClass = 'badge-secondary'; // Clase por defecto para estados desconocidos
                            break;
                    }

                    Swal.fire({
                        title: `Detalles del Pedido Nº ${detalles.Numero_Pedido}`,
                        html: `
                            <p><strong>Proveedor:</strong> ${detalles.Nombre_Empresa}</p>
                            <p><strong>Fecha de Pedido:</strong> ${detalles.Fecha_Pedido}</p>
                            <p><strong>Fecha de Entrega:</strong> ${detalles.Fecha_Entrega}</p>
                            <p><strong>Nombre del Producto:</strong> ${detalles.Nombre_Producto}</p>
                            <p><strong>Cantidad:</strong> ${detalles.Cantidad}</p>
                            <p><strong>Precio del Producto:</strong> €${detalles.Precio_Producto.toFixed(2)}</p>
                            <p><strong>Coste Total:</strong> €${detalles.Coste_Total.toFixed(2)}</p>
                            <p><strong>Estado:</strong> <span class="badge ${estadoClass}">${detalles.Estado_Pedido}</span></p>
                        `,
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#d33'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se encontraron detalles para el pedido.',
                        icon: 'error',
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al intentar cargar los detalles del pedido.',
                    icon: 'error',
                    confirmButtonText: 'Cerrar',
                    cancelButtonColor: '#d33'
                });
            }
        });

    });
});