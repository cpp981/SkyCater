//Chart.js
document.addEventListener('DOMContentLoaded', function () {
    //Enviamos petición mediante AJAX para traer los datos
    $.ajax({
        type: 'POST',
        url: '../src/dash.php',
        dataType: 'json',
        data: { action: 'contador_tipoClase' },
        success: function (response) {
            var bgColor = ['#FF00FF', '#1CA9C9', '#E6A817'];
            var colorClaro = lightenColor(bgColor, 0.4);
            var ctx2 = document.getElementById('chart2').getContext('2d');
            var chart2 = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['1ª Clase', 'Business', 'Económica'],
                    datasets: [{
                        data: [response[1], response[3], response[2]],
                        backgroundColor: colorClaro,
                        borderColor: bgColor
                    }]
                },
                options: {
                    font: {
                        size: 10,
                        responsive: true
                    }
                }
            });
        }
    });

    // Gráfica Donut para tipos de comida
    $.ajax({
        type: 'POST',
        url: '../src/dash.php',
        dataType: 'json',
        data: { action: 'contador_tipoComida' },
        success: function (response) {
            // Inicializa los arrays para las etiquetas y los datos
            var labels = [];
            var data = [];

            // Recorre el array de la respuesta y llena los arrays labels y data
            response.forEach(function (item) {
                labels.push(item.Categoria);
                data.push(item.Count);
            });

            // Colores para el gráfico
            var bgColor = ['#209b6a', '#ef476f', '#07beb8'];
            var colorClaro = lightenColor(bgColor, 0.4);  // Suponiendo que tienes una función para aclarar colores

            // Configuración del gráfico
            var ctx2 = document.getElementById('chart1').getContext('2d');
            var chart2 = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colorClaro,
                        borderColor: bgColor
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        }
    });

    //Petición Ajax para los indicadores
    $.ajax({
        url: '../src/indicadores.php',
        type: 'POST',
        dataType: 'json',
        data:{action: 'indi_1_4'},
        success: function (data) {
            // Data indicador productos sin alérgenos
            $('#prodNoAlergenos').html(data['prod']);
            if (data['prod'] >= 15) {
                $('#prodNoAlergenos').addClass('text-success');
            }
            else {
                $('#prodNoAlergenos').addClass('text-danger');
            }
            // Data indicador personas con intolerancias
            $('#intolerancias').html(data['intolerancias']);
            if (data['intolerancias'] <= 50) {
                $('#intolerancias').addClass('text-success');
            }
            else {
                $('#intolerancias').addClass('text-danger');
            }
        },
        error: function (error) {
            // Si ocurre un error con la petición AJAX
            console.error('Error al hacer la petición:', error);

        }
    });

    $.ajax({
        url: '../src/indicadores.php', 
        method: 'POST', 
        dataType: 'json',
        data: {
            action: 'indi_total_productos'  // Acción para obtener el total de productos
        },
        success: function(response) {
            if (response.totalProductos !== undefined) {
                var totalProductos = response.totalProductos;
    
                // Actualizar el contenido del indicador
                $('#totalProd').html(totalProductos);
    
                // Condición para cambiar la clase del indicador según el valor
                if (totalProductos < 25) {
                    $('#totalProd').removeClass('text-success').addClass('text-danger');
                } else {
                    $('#totalProd').removeClass('text-danger').addClass('text-success');
                }
            } else {
                $('#totalProd').text('Error al obtener datos');
            }
        },
        error: function(error) {
            console.error('Error al hacer la petición:', error);
            $('#totalProd').text('Error en la conexión');
        }
    });
    
    $.ajax({
        url: '../src/indicadores.php', 
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'contador_vuelos_mes_actual'  // Acción que llamará al contador de vuelos
        },
        success: function(response) {
            if (response.vuelosMesActual !== undefined) {
                var vuelosMesActual = response.vuelosMesActual;
    
                // Actualizar el contenido del indicador con el número de vuelos
                $('#indicadorVuelosMes').html(vuelosMesActual);
    
                // Condición para cambiar la clase dependiendo del número de vuelos
                if (vuelosMesActual < 100) {
                    $('#indicadorVuelosMes').removeClass('text-success').addClass('text-danger');
                } else {
                    $('#indicadorVuelosMes').removeClass('text-danger').addClass('text-success');
                }
            } else {
                console.error('Error al obtener datos');
            }
        },
        error: function(error) {
            console.error('Error al hacer la petición:', error);
        }
    });
    

    // Petición AJAX gráfica de Barras
    $.ajax({
        type: 'POST',
        url: '../src/dash.php',
        dataType: 'json',
        data: { action: 'evolucion_pedidos' },
        success: function (response) {
            var ctx = document.getElementById('chart6').getContext('2d');
            var bgColor = '#f18701';
            var colorClaro = lightenColor(bgColor, 0.4);
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: response.labels,   // Etiquetas con los meses
                    datasets: [{
                        label: 'Pedidos por mes',
                        data: response.data,    // Cantidad de pedidos por mes
                        backgroundColor: colorClaro,
                        borderColor: bgColor,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });

    // Gráfica línea de evolución
    $.ajax({
        type: 'POST',
        url: '../src/dash.php', // Ruta al archivo PHP que maneja la solicitud
        dataType: 'json',
        data: { action: 'evolucion_vuelos' }, // Acción que ejecuta el método evolucionNumVuelos
        success: function (response) {
            // Prepara los datos para la gráfica
            var meses = response.map(function (item) {
                return item.mes;
            });
            var vuelos = response.map(function (item) {
                return item.Total_Vuelos;
            });

            var ctx = document.getElementById('chart5').getContext('2d');
            var bgColor = '#80D0B8';
            var colorClaro = lightenColor(bgColor, 0.4);
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: meses, // Etiquetas de los meses
                    datasets: [{
                        label: 'Número de vuelos por mes',
                        data: vuelos, // Datos de vuelos por mes
                        borderColor: bgColor,
                        backgroundColor: colorClaro,
                        fill: true,
                        lineTension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Meses'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Número de vuelos'
                            }
                        }
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}); 