//Chart.js
document.addEventListener('DOMContentLoaded', function () {
    var ctx1 = document.getElementById('chart1').getContext('2d');
    var bgColor = ['#DC143C', '#1CA9C9', '#29AB87'];
    var colorClaro = lightenColor(bgColor, 0.4);
    var chart1 = new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Comida', 'Bebida', 'Otros'],
            datasets: [{
                data: [60, 30, 10],
                backgroundColor: colorClaro,
                borderColor: bgColor
            }]
        }
    });

    //Enviamos petición mediante AJAX para traer los datos de las reversas (Clases).
    $.ajax({
        type: 'POST',
        url: '../src/dash.php',
        dataType: 'json',
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

      //Petición Ajax para los indicadores
      $.ajax({
        url: '../src/indicadores.php',
        type: 'POST',
        dataType: 'json',
        success: function(data) 
        {
            // Data indicador productos sin alérgenos
            $('#prodNoAlergenos').html(data['prod']);
            if(data['prod'] >= 15)
            {
                $('#prodNoAlergenos').addClass('text-success');
            }
            else
            {
                $('#prodNoAlergenos').addClass('text-danger');
            }
            // Data indicador personas con intolerancias
            $('#intolerancias').html(data['intolerancias']);
            if(data['intolerancias'] <= 50)
            {
                $('#intolerancias').addClass('text-success');
            }
            else
            {
                $('#intolerancias').addClass('text-danger');
            }
        },
        error: function(xhr, status, error) {
            // Si ocurre un error con la petición AJAX
            console.error('Error al hacer la petición:', error);
            
        }
    });

    var bgColor = '#E6A817';
    var colorClaro = lightenColor(bgColor, 0.4);
    var ctx3 = document.getElementById('chart3').getContext('2d');
    var chart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
            datasets: [{
                label: 'Pedidos',
                data: [50, 60, 70, 80],
                backgroundColor: colorClaro,
                borderColor: bgColor,
                borderWidth: 2 
            }]
        }
    });

    var bgColor = '#711865';
    var colorClaro = lightenColor(bgColor, 0.4);
    var ctx4 = document.getElementById('chart4').getContext('2d');
    var chart4 = new Chart(ctx4, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
                label: 'Ingresos',
                data: [2000, 2500, 2350, 3000, 4150],
                backgroundColor: colorClaro,
                borderColor: bgColor,
                fill: true
            }]
        }
    });

    var bgColor = '#80D0B8';
    var colorClaro = lightenColor(bgColor, 0.4);
    var ctx5 = document.getElementById('chart5').getContext('2d');
    var chart5 = new Chart(ctx5, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
                label: 'Ingresos',
                data: [2000, 2500, 2350, 3000, 4150],
                backgroundColor: colorClaro,
                borderColor: bgColor,
                fill: true
            }]
        }
    });

    var bgColor = '#E6A817';
    var colorClaro = lightenColor(bgColor, 0.4);
    var ctx6 = document.getElementById('chart6').getContext('2d');
    var chart6 = new Chart(ctx6, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
            datasets: [{
                label: 'Pedidos',
                data: [50, 60, 70, 80],
                borderColor: bgColor,
                backgroundColor: colorClaro,
                borderWidth: 2
            }]
        }
    });
}); 