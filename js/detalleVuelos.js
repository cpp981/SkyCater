document.addEventListener('DOMContentLoaded', function () {
    const numeroVuelo = sessionStorage.getItem('numeroVuelo'); // Recupera el número de vuelo
    const urlParams = new URLSearchParams(window.location.search);
    const vueloId = urlParams.get('id'); // Recupera el id

    if (numeroVuelo) {
        // Petición AJAX
        $.ajax({
            url: '../src/detalleVuelos.php',
            type: 'POST',
            data: {
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
                        $('.card:nth-child(1) .card-text.fs-4').text(data.pasajeros);
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
});
