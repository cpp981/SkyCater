$(document).ready(function () {
    //Iniciamos Notyf para notificar el resultado al usuario
    const notyf = new Notyf({
        position: {
            x: 'right',  // Alineación horizontal
            y: 'top'      // Alineación vertical en la parte superior
        },
    });

    let primerPlato = [];
    let segundoPlato = [];
    let postre = [];

    // Realizar la llamada AJAX al cargar la página
    $.ajax({
        url: '../src/menuPasajeros.php', // Cambia esta URL a la ruta de tu archivo PHP
        method: 'GET',
        success: function (response) {
            console.log('Respuesta de la API:', response);

            // Verificamos la estructura de la respuesta
            if (response.status === 'success' && response.data) {
                primerPlato = response.data.primerPlato;
                segundoPlato = response.data.segundoPlato;
                postre = response.data.postre;

            } else {
                console.error('Estructura inesperada en la respuesta de la API:', response);
                alert('Error al cargar los datos. Por favor, inténtelo más tarde.');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error de comunicación con el servidor:', error);
            alert('No se pudo conectar al servidor. Por favor, verifique su conexión.');
        }
    });

    // Función para rellenar los selects con opciones
    function llenarSelect(idSelect, opciones) {
        const select = $(`#${idSelect}`);

        if (!select.length) {
            console.error(`No se encontró el select con ID ${idSelect}`);
            return;
        }

        select.empty(); // Limpiar opciones existentes

        if (!opciones || opciones.length === 0) {
            select.append('<option value="" disabled>No hay opciones disponibles</option>');
            return;
        }

        select.append('<option value="" disabled selected>Seleccione...</option>'); // Opción por defecto

        opciones.forEach(opcion => {
            const nombre = opcion.Nombre || 'Sin nombre';
            const alergenos = opcion.Alergenos || 'Ninguno';

            // Si no hay alérgenos, mostrar "Ninguno", si hay, mostrar los alérgenos
            const alergenosTexto = alergenos !== 'Ninguno'
                ? alergenos.split(',').map(a => a.trim()).join(', ')
                : 'Ninguno';  // Cuando no hay alérgenos

            // Agregar cada opción como un <option> dentro del <select>
            select.append(`
            <option value="${nombre}" data-alergenos="${alergenos}">
                ${nombre} (${alergenosTexto})
            </option>
        `);
        });
    }




    // Configura el botón "Detalles" como activo al cargar la página
    $('#pasajerosBtn').addClass('active');

    // Maneja el clic en los botones
    $('.btn-group .btn').on('click', function () {
        $('.btn-group .btn').removeClass('active');
        $(this).addClass('active');
    });

    // Redirección al pulsar el botón Pasajeros
    $('#pasajerosBtn').on('click', function () {
        const vueloId = sessionStorage.getItem('idVuelo');
        if (vueloId) {
            window.location.href = `http://localhost/SkyCater/public/pasajerosVuelo.php?id=${vueloId}`;
        } else {
            alert("El ID del vuelo no está disponible en sessionStorage.");
        }
    });

    // Redirección al pulsar el botón Detalles
    const currentUrl = window.location.href;
    const url = new URL(currentUrl);
    const idVuelo = url.searchParams.get("id");

    $('#detallesBtn').on('click', function () {
        if (idVuelo) {
            window.location.href = `http://localhost/SkyCater/public/detallesVuelo.php?id=${idVuelo}`;
        }
    });

    // Redirección al pulsar el botón Volver
    $('#volverBtn').on('click', function () {
        window.location.href = 'http://localhost/SkyCater/public/listaVuelos.php';
    });

    // Definimos la DataTable de Pasajeros
    const tableOptions = {
        dom: 'rtip',
        responsive: true,
        autoWidth: false,
        pageLength: 5,
        ajax: {
            url: "../src/detalleVuelos.php",
            type: "POST",
            dataSrc: function (json) {
                if (json.status === "success") {
                    return json.data;
                } else {
                    return [];
                }
            },
            data: function (d) {
                d.idVuelo = idVuelo;
                d.action = "obtener_pasajero";
            }
        },
        columns: [
            {
                title: "Pasajero",
                render: function (data, type, row) {
                    return `${row.Nombre} ${row.Apellido}`;
                }
            },
            {
                title: "Intolerancias",
                render: function (data, type, row) {
                    let intolerancias = row.Intolerancias;
                    if (!intolerancias || intolerancias === "Ninguna") {
                        return '<span class="badge badge-success">Ninguna</span>';
                    } else {
                        const intoleranciasArray = intolerancias.split(',');
                        return intoleranciasArray.map(function (intolerancia) {
                            return `<span class="badge badge-warning">${intolerancia.trim()}</span>`;
                        }).join(' ');
                    }
                }
            },
            { title: "Preferencias", data: "Preferencias_Comida" },
            { title: "Asiento", data: "Asiento" },
            { title: "Plato 1", data: "Plato1" },
            { title: "Plato 2", data: "Plato2" },
            { title: "Bebida", data: "Plato3" },
            {
                title: "Acción",
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    // Verificamos si los campos Plato1, Plato2 y Bebida están completos
                    if (row.Plato1 && row.Plato2 && row.Plato3) {
                        // Si ya están completos, mostramos un check verde
                        return `<i class="fas fa-check-circle text-success fa-2x"></i>`;
                    } else {
                        // Si no están completos, mostramos el botón de edición
                        return `<button class="edit btn btn-sm btn-primary" data-dni="${row.Dni}"><i class="fas fa-gear"></i></button>`;
                    }
                }
            }
        ],
        columnDefs: [
            { width: "15%", targets: [1, 2] },
            { width: "20%", targets: 0 },
            { width: "25%", targets: [4, 5, 6] },
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
            zeroRecords: "No se encontraron pasajeros",
            info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
            infoFiltered: "(filtrados desde _MAX_ registros totales)"
        }
    };


    const tablaPasajeros = $('#tablaPasajeros').DataTable(tableOptions);

    // Clic en el botón "Editar" de la tabla para abrir los selects
    $('#tablaPasajeros').on('click', '.edit', function () {
        $('#gestionMenuPasajero .loading-message').show();

        const row = $(this).closest('tr');
        const nombre = row.find('td').eq(0).text();
        const intolerancias = row.find('td').eq(1).text();
        // Obtener el DNI del pasajero desde el atributo data-dni
        const dni = $(this).data('dni');
        // Almacenar el DNI en sessionStorage
        sessionStorage.setItem('dniPasajero', dni);

        let intoleranciasHTML = '';
        if (intolerancias && intolerancias !== "Ninguna") {
            const intoleranciasArray = intolerancias.split(',');
            intoleranciasHTML = intoleranciasArray.map(function (intolerancia) {
                return `<span class="badge badge-warning">${intolerancia.trim()}</span>`;
            }).join(' ');
        } else {
            intoleranciasHTML = '<span class="badge badge-success">Ninguna</span>';
        }

        setTimeout(function () {
            $('#gestionMenuPasajero .loading-message').hide();

            $('#fichaPasajero').addClass('card shadow rounded text-center');
            $('#fichaPasajero').html(`
                <div class="mb-3 div-arriba-abajo">
                    <strong>Pasajero: </strong>${nombre}
                </div>
                <div class="mb-3 div-arriba-abajo">
                    <strong>Intolerancias: </strong>${intoleranciasHTML}
                </div>
            `);

            $('#gestionMenuPasajero').addClass('card shadow rounded menu-pasajero');
            $('#gestionMenuPasajero').html(`
                <form id="gestionForm" class="p-3">
                    <div class="mb-3">
                        <label for="selectPrimerPlato" class="form-label w-100"><strong>Primer Plato</strong></label>
                        <select id="selectPrimerPlato" class="form-select w-100" name="primerPlato"></select>
                    </div>
                    <div class="mb-3">
                        <label for="selectSegundoPlato" class="form-label w-100"><strong>Segundo Plato</strong></label>
                        <select id="selectSegundoPlato" class="form-select w-100" name="segundoPlato"></select>
                    </div>
                    <div class="mb-3">
                        <label for="selectPostre" class="form-label w-100"><strong>Bebida</strong></label>
                        <select id="selectPostre" class="form-select w-100" name="postre"></select>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-primary w-100" id="enviarMenu"><i class="fas fa-plus me-1"></i>Añadir Menú</button>
                    </div>
                </form>
            `);

            // Llenar los selects después de generar el contenido
            llenarSelect('selectPrimerPlato', primerPlato);
            llenarSelect('selectSegundoPlato', segundoPlato);
            llenarSelect('selectPostre', postre);

            $('#enviarMenu').on('click', function () {
                const primerPlato = $('#selectPrimerPlato').val();
                const segundoPlato = $('#selectSegundoPlato').val();
                const bebida = $('#selectPostre').val();
                const currentUrl = window.location.href;
                const url = new URL(currentUrl);
                const idVuelo = url.searchParams.get("id");
                const dniPasajero = sessionStorage.dniPasajero;

                // Validación de campos
                if (!dniPasajero || !primerPlato || !segundoPlato || !bebida) {
                    notyf.error('Por favor, asegúrese de que todos los campos están completos.');
                    return;
                }

                // Mostrar mensaje de confirmación con Swal
                Swal.fire({
                    title: '¿Confirmar acción?',
                    text: 'Va a añadir el menú al pasajero y no podrá editarlo posteriormente. ¿Desea continuar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#5cb85c',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../src/procesaMenu.php',
                            method: 'POST',
                            data: {
                                idVuelo: idVuelo,
                                dniPasajero: dniPasajero,
                                primerPlato: primerPlato,
                                segundoPlato: segundoPlato,
                                bebida: bebida
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    notyf.success(response.message);
                                    $('#gestionMenuPasajero').hide();
                                    $('#fichaPasajero').hide();
                    
                                    //$('#gestionMenuPasajero .loading-message').show();
                                    tablaPasajeros.ajax.reload();
                                } else {
                                    notyf.error(response.message);
                                }
                            },
                            error: function (xhr, status, error) {
                                notyf.error('Error de comunicación con el servidor:', error);
                                notyf.error('No se pudo enviar el menú. Por favor, intente más tarde.');
                            }
                        });
                    } else {
                        Swal.fire('Cancelado', 'El menú no se ha añadido.', 'info');
                    }
                });
            });
        }, 1000);
    });
    // Botón para Guardar el Vuelo completo
    $('#guardarVueloBtn').on('click', function () {
        let camposCompletos = true; // Variable para controlar si todos los campos están completos
        let mensajeError = ""; // Para guardar los mensajes de error

        // Recorremos todas las filas del DataTable
        tablaPasajeros.rows().every(function (rowIdx, tableLoop, rowLoop) {
            const data = this.data(); // Obtener los datos de la fila actual
            const plato1 = data.Plato1;
            const plato2 = data.Plato2;
            const bebida = data.Plato3;

            // Verificamos si alguno de los campos está vacío
            if (!plato1 || !plato2 || !bebida) {
                camposCompletos = false;
                mensajeError += `La fila del pasajero ${data.Nombre} ${data.Apellido} no tiene el menú completo.\n`;
            }
        });

        // Si algún campo está vacío, mostramos un mensaje de error
        if (!camposCompletos) {
            Swal.fire({
                title: 'Error',
                text: mensajeError,
                icon: 'error',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#5cb85c'
            });
            return; // Salimos de la función si hay errores
        }

        // Mostrar spinner de carga mientras se procesa el vuelo
        Swal.fire({
            title: 'Procesando...',
            text: 'El vuelo se está gestionando, por favor espere.',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Simulamos un delay con setTimeout para la carga
        setTimeout(function () {
            // Realizamos la petición AJAX después del delay
            $.ajax({
                url: '../src/guardarVuelo.php',  // URL de la petición
                method: 'POST',
                data: { idVuelo: idVuelo },  // Datos que necesitas enviar
                success: function (response) {
                    console.log('Respuesta del servidor:', response);

                    // Cerrar el popup de carga
                    Swal.close();

                    if (response.status === 'success') {
                        // Mostrar SweetAlert de éxito
                        Swal.fire({
                            title: 'Éxito',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#5cb85c',
                            cancelButtonColor: '#d33'
                        }).then(() => {
                            // Redirigir al usuario a la página de detalles del vuelo
                            window.location.href = `listaVuelos.php`;
                        });
                    } else {
                        // Informamos del error con mensaje del Back
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#5cb85c',
                            cancelButtonColor: '#d33'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Cerrar el popup de carga si hubo un error
                    Swal.close();

                    // Mostrar Notyf de error en caso de fallo en la comunicación con el servidor
                    notyf.error('Error de comunicación con el servidor:', error);
                    notyf.error('No se pudo guardar el vuelo. Por favor, intente más tarde.');
                }
            });
        }, 1000);
    });
});