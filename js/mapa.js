$(document).ready(function () {
    // Recogemos los datos de sessionStorage
    var datosVuelo = JSON.parse(sessionStorage.getItem('datosVuelo'));
    var origen = datosVuelo.origen;
    var destino = datosVuelo.destino;

    // Si tanto origen como destino están disponibles en sessionStorage, los enviamos al backend
    if (origen && destino) {
        $.ajax({
            url: '../src/apiBing.php', 
            type: 'GET',
            data: { origen: origen, destino: destino },
            success: function (data) {
                var coordenadas = JSON.parse(data);

                if (coordenadas.origen && coordenadas.destino) {
                    // Asegurarse de que la API de Bing Maps se ha cargado
                    if (typeof Microsoft !== 'undefined' && Microsoft.Maps) {
                        // Cargar el módulo de direcciones
                        Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
                            // Inicializamos el mapa de Bing Maps
                            var mapa = new Microsoft.Maps.Map('#mapa', {
                                credentials: 'Tu_Bing_Maps_Key',
                                center: new Microsoft.Maps.Location(coordenadas.origen[0], coordenadas.origen[1]),
                                zoom: 4
                            });

                            // Marcadores de origen y destino
                            var marcadorOrigen = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(coordenadas.origen[0], coordenadas.origen[1]), {
                                title: 'Origen',
                                subTitle: origen
                            });
                            var marcadorDestino = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(coordenadas.destino[0], coordenadas.destino[1]), {
                                title: 'Destino',
                                subTitle: destino
                            });

                            // Agregar marcadores al mapa
                            mapa.entities.push(marcadorOrigen);
                            mapa.entities.push(marcadorDestino);

                            // Ajustamos la vista del mapa para que incluya ambos puntos
                            mapa.setView({ bounds: Microsoft.Maps.LocationRect.fromCorners(
                                new Microsoft.Maps.Location(coordenadas.origen[0], coordenadas.origen[1]),
                                new Microsoft.Maps.Location(coordenadas.destino[0], coordenadas.destino[1])
                            ) });

                            // Crear el objeto DirectionsManager para calcular y mostrar la ruta
                            var directionsManager = new Microsoft.Maps.Directions.DirectionsManager(mapa);
                            var routeRequest = new Microsoft.Maps.Directions.DirectionsRequest();
                            routeRequest.setRequestOptions({
                                routeMode: Microsoft.Maps.Directions.RouteMode.driving,
                                waypoints: [
                                    new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(coordenadas.origen[0], coordenadas.origen[1]) }),
                                    new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(coordenadas.destino[0], coordenadas.destino[1]) })
                                ]
                            });
                            directionsManager.calculateDirections(routeRequest);
                        });
                    } else {
                        console.error("La API de Bing Maps no se cargó correctamente.");
                    }
                } else {
                    console.error("No se pudieron obtener las coordenadas.");
                }
            },
            error: function () {
                console.error("Error al hacer la llamada AJAX.");
            }
        });
    } else {
        console.error("No se encontró origen o destino en sessionStorage.");
    }
});