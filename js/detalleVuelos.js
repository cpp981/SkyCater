document.addEventListener('DOMContentLoaded', function () {
    const numeroVuelo = sessionStorage.getItem('numeroVuelo'); // Recupera el número de vuelo
    // Recupera los datos del vuelo almacenados en sessionStorage
    const datosVuelo = JSON.parse(sessionStorage.getItem('datosVuelo'));

    // Verifica si los datos existen y luego actualiza el HTML
    if (datosVuelo) {
        $('#numVuelo').html(`<strong>Número de Vuelo:</strong> ${datosVuelo.vueloNumero}`);
        $('#origen').html(`<strong>Origen:</strong> ${datosVuelo.origen}`);
        $('#destino').html(`<strong>Destino:</strong> ${datosVuelo.destino}`);

        // Formatear la fecha de salida
        const horaSalida = formatDate(datosVuelo.salida);
        $('#horaSalida').html(`<strong>Hora de salida:</strong> ${horaSalida}`);

        // Formatear la fecha de llegada
        const horaLlegada = formatDate(datosVuelo.llegada);
        $('#horaLlegada').html(`<strong>Hora de llegada:</strong> ${horaLlegada}`);

        // Lógica para asignar el estado y las clases de color
        let estadoClass = '';
        let estadoTexto = datosVuelo.estado;

        if (estadoTexto === 'Pendiente') {
            estadoClass = 'badge badge-warning';
        } else if (estadoTexto === 'Gestionado') {
            estadoClass = 'badge badge-success';
        }

        // Actualiza el estado con la clase correspondiente
        $('#estado').html(`<strong>Estado:</strong> <span class="${estadoClass}">${estadoTexto}</span>`);
    } else {
        console.error("No se encontraron los datos del vuelo en sessionStorage.");
    }
    const urlParams = new URLSearchParams(window.location.search);
    const vueloId = urlParams.get('id'); // Recupera el id

    if (numeroVuelo) {
        // Petición AJAX
        $.ajax({
            url: '../src/detalleVuelos.php',
            type: 'POST',
            data: {
                action: 'obtener_detalles_vuelo',
                numeroVuelo: numeroVuelo,
                idVuelo: vueloId
            },
            success: function (response) {
                try {
                    let data = response;  // No hace falta JSON.parse() porque ya es un objeto
                    console.log("Respuesta del servidor:", data);

                    // Validar que las claves existan antes de usarlas
                    if (data.pasajeros !== undefined && data.intolerancias !== undefined && Array.isArray(data.asientos)) {
                        // Actualizar los indicadores
                        $('.card:nth-child(1) .card-text.fs-4').text(`${data.pasajeros} %`);
                        $('.card:nth-child(2) .card-text.fs-4').text(data.intolerancias);

                        let asientos = data.asientos;
                        let economica = 0, primeraClase = 0, bussiness = 0;

                        // Recorremos el array de asientos para asignar las cantidades correspondientes
                        asientos.forEach(function (asiento) {
                            if (asiento.Asiento === 'Económica') {
                                economica = asiento.Cantidad_Pasajeros;
                            } else if (asiento.Asiento === 'Primera Clase') {
                                primeraClase = asiento.Cantidad_Pasajeros;
                            } else if (asiento.Asiento === 'Bussiness') {
                                bussiness = asiento.Cantidad_Pasajeros;
                            }
                        });

                        console.log("Económica: " + economica);
                        console.log("Primera Clase: " + primeraClase);
                        console.log("Bussiness: " + bussiness);

                        // Crear y actualizar la gráfica después de tener los datos
                        const ctx = document.getElementById('flightChart').getContext('2d');

                        // Inicializa o actualiza el gráfico
                        const flightChart = new Chart(ctx, {
                            type: 'bar', // Tipo de gráfico
                            data: {
                                labels: ['Económica', 'Primera Clase', 'Bussiness'], // Etiquetas de los asientos
                                datasets: [{
                                    label: 'Nº Pasajeros',
                                    data: [economica, primeraClase, bussiness], // Datos de los asientos
                                    backgroundColor: [
                                        'rgba(54, 162, 235, 0.6)', // Azul
                                        'rgba(255, 99, 132, 0.6)', // Rojo
                                        'rgba(75, 192, 192, 0.6)'  // Verde
                                    ],
                                    borderColor: [
                                        'rgba(54, 162, 235, 1)', // Azul
                                        'rgba(255, 99, 132, 1)', // Rojo
                                        'rgba(75, 192, 192, 1)'  // Verde
                                    ],
                                    borderWidth: 2, // Grosor de las barras
                                    barThickness: 95
                                }]
                            },
                            options: {
                                responsive: true, // Ajustar tamaño automáticamente
                                plugins: {
                                    legend: {
                                        display: false,
                                        position: 'top'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true // Comenzar desde cero en el eje Y
                                    }
                                }
                            }
                        });

                    } else {
                        console.error("Los datos recibidos no son válidos:", data);
                    }
                } catch (e) {
                    console.error("Error al procesar los datos de la gráfica:", e);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la petición AJAX:', error);
            }
        });
    } else {
        console.error("Número de vuelo no encontrado en sessionStorage.");
    }

    // Función para formatear la fecha al formato dd-mm-yyyy HH:mm
    function formatDate(dateString) {
        // Verifica que el formato sea correcto antes de convertirlo
        const date = new Date(dateString);

        // Verifica si la fecha es válida
        if (isNaN(date)) {
            console.error('Fecha inválida:', dateString);
            return '';
        }

        // Obtiene el día, mes y año
        const day = String(date.getDate()).padStart(2, '0'); // Agrega 0 al principio si es un solo dígito
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Los meses empiezan desde 0, por eso sumamos 1
        const year = date.getFullYear();

        // Obtiene las horas y minutos
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');

        // Devuelve el formato deseado: dd-mm-yyyy HH:mm
        return `${day}-${month}-${year} ${hours}:${minutes}`;
    }

    // Control de los botones superiores
    $('#detallesBtn').addClass('active');

    // Maneja el clic en los botones
    $('.btn-group .btn').on('click', function () {
        // Quita la clase 'active' de todos los botones
        $('.btn-group .btn').removeClass('active');

        // Agrega la clase 'active' al botón pulsado
        $(this).addClass('active');
    });

    // Redirección al pulsar el botón Pasajeros
    $('#pasajerosBtn').on('click', function () {
        // Obtiene el id desde sessionStorage
        const detallesVuelo = JSON.parse(sessionStorage.getItem('datosVuelo'));
        const vueloId = detallesVuelo.idVuelo;
        if (vueloId) {
            // Redirige a la URL deseada con el parámetro id
            window.location.href = `http://localhost/SkyCater/public/pasajerosVuelo.php?id=${vueloId}`;
        } else {
            alert("El ID del vuelo no está disponible en sessionStorage.");
        }
    });

    // Redirección al pulsar el botón Detalles
    $('#detallesBtn').on('click', function () {
        // Obtiene el parámetro 'id' desde la URL actual
        const currentUrl = window.location.href;
        const url = new URL(currentUrl);
        const idVuelo = url.searchParams.get("id");  // Obtiene el parámetro 'id' de la URL

        if (idVuelo) {
            // Si el parámetro 'id' está presente, redirige a 'detallesVuelo.php' con el parámetro
            window.location.href = `http://localhost/SkyCater/public/detallesVuelo.php?id=${idVuelo}`;
        } else {
            // Si no hay parámetro 'id', no se agrega y simplemente se redirige sin él
            // window.location.href = 'http://localhost/SkyCater/public/detallesVuelo.php';
        }
    });
});
