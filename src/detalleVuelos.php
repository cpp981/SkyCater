<?php
require_once './include/Vuelo.php';
require_once './include/Messages.php';
header('Content-Type: application/json');
session_start();

try {
    // Verificar si se reciben los datos necesarios
    if (!isset($_POST['numeroVuelo']) || !isset($_POST['idVuelo'])) {
        echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
        exit;
    }

    $numVuelo = $_POST['numeroVuelo'];
    $idVuelo = $_POST['idVuelo'];

    // Instanciar el objeto Vuelo y obtener los resultados
    $vuelo = new Vuelo();
    $resultNumPasajeros = $vuelo->contadorPasajerosVuelo($numVuelo);
    $resultNumPasajerosIntolerancias = $vuelo->contadorPasajerosIntolerancias($numVuelo);
    $resulGrafica = $vuelo->getCountAsientoById($idVuelo);

    // Crear el array con los datos
    $detalle_vuelos_tabla = [
        'pasajeros' => $resultNumPasajeros[0]['Num_Pasajeros'],
        'intolerancias' => $resultNumPasajerosIntolerancias[0]['Intolerancias'],
        'asientos' => $resulGrafica
    ];

    // Enviar los datos como JSON
    echo json_encode($detalle_vuelos_tabla);

} catch (Exception $e) {
    // Manejar cualquier excepción y enviar error
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}