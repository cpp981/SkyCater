<?php
// Clave de API de Bing Maps
$bingMapsApiKey = "AuclIH7tjOOM0U1sN23KcivEu101gRo9PTWX5wv-CoUYf7G-ujoaBZ7bPIWy9D49";

// Función para obtener las coordenadas de una ciudad
function getCoordinates($location) {
    global $bingMapsApiKey;
    $url = "http://dev.virtualearth.net/REST/v1/Locations?q=" . urlencode($location) . "&key=" . $bingMapsApiKey;

    // Realizamos la llamada a la API de Bing Maps
    $response = file_get_contents($url);

    // Convertimos la respuesta en un array
    $data = json_decode($response, true);

    // Verificamos si la respuesta contiene resultados
    if (isset($data['resourceSets'][0]['resources'][0]['point']['coordinates'])) {
        // Retornamos las coordenadas (latitud, longitud)
        return $data['resourceSets'][0]['resources'][0]['point']['coordinates'];
    }
    return null;  // Si no se encuentran resultados
}

// Recibimos el origen y destino desde el frontend
$origen = isset($_GET['origen']) ? $_GET['origen'] : '';
$destino = isset($_GET['destino']) ? $_GET['destino'] : '';

// Obtenemos las coordenadas para origen y destino
$coordenadasOrigen = getCoordinates($origen);
$coordenadasDestino = getCoordinates($destino);

// Respondemos con las coordenadas en formato JSON
echo json_encode([
    'origen' => $coordenadasOrigen,
    'destino' => $coordenadasDestino
]);


