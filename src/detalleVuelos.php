<?php
require_once './include/Vuelo.php';
require_once './include/Pasajero.php';  
require_once './include/Messages.php';
header('Content-Type: application/json');
session_start();

try {
    // Verificar si se recibe el parámetro 'action' y si contiene la acción esperada
    if (!isset($_POST['action'])) {
        echo json_encode(['status' => 'error', 'message' => 'Acción no especificada']);
        exit;
    }

    $action = $_POST['action'];  // Obtener la acción

    // Instanciar las clases necesarias
    $vuelo = new Vuelo();
    $pasajero = new Pasajero();

    // Verificar qué acción se solicita
    switch ($action) {
        case 'obtener_detalles_vuelo':
            // Verificar si se reciben los datos necesarios para los detalles del vuelo
            if (!isset($_POST['numeroVuelo']) || !isset($_POST['idVuelo'])) {
                echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
                exit;
            }

            $numVuelo = $_POST['numeroVuelo'];
            $idVuelo = $_POST['idVuelo'];
            $capacidad_max = 70;

            // Obtener datos del vuelo
            $resultNumPasajeros = $vuelo->contadorPasajerosVuelo($numVuelo);
            $resultNumPasajerosIntolerancias = $vuelo->contadorPasajerosIntolerancias($numVuelo);
            $resulGrafica = $vuelo->getCountAsientoById($idVuelo);
            // Calculamos el % de ocupación en los Vuelos.
            $porcentaje = ($resultNumPasajeros[0]['Num_Pasajeros'] / $capacidad_max) * 100;
            $resulPorcentaje = round($porcentaje, 2); 
            // Crear el array con los detalles del vuelo
            $detalle_vuelos_tabla = [
                'pasajeros' => $resulPorcentaje,
                'intolerancias' => $resultNumPasajerosIntolerancias[0]['Intolerancias'],
                'asientos' => $resulGrafica
            ];

            // Enviar los datos del vuelo como JSON
            echo json_encode($detalle_vuelos_tabla);
            break;

        case 'obtener_pasajero':
            // Verificar si se recibe el ID del pasajero
            if (!isset($_POST['idVuelo'])) {
                echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
                exit;
            }

            $idVuelo = $_POST['idVuelo'];

            // Obtener datos del pasajero
            $datosPasajero = $pasajero->getPasajerosVueloById($idVuelo);

            // Verificar si se obtuvo algún dato
            if (empty($datosPasajero)) {
                echo json_encode(['status' => 'error', 'message' => Messages::PASSENGER_LIST_LOAD_ERROR]);
            } else {
                // Enviar los datos del pasajero como JSON
                echo json_encode(['status' => 'success', 'data' => $datosPasajero]);
            }
            break;

        default:
            // Si la acción no es válida
            echo json_encode(['status' => 'error', 'message' => Messages::INVALID_PARAMS]);
            break;
    }

} catch (Exception $e) {
    // Manejar cualquier excepción y enviar error
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
