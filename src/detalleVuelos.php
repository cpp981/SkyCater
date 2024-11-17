<?php
require_once './include/Vuelo.php';
require_once './include/Messages.php';
header('Content-Type: application/json');
//session_start();

try{
    if (isset($_POST['vuelo'])) {
        $numVuelo = $_POST['vuelo'];
    }

    $vuelo = new Vuelo();
    $resultNumPasajeros = $vuelo->contadorPasajerosVuelo($numVuelo);
    $resultNumPasajerosIntolerancias = $vuelo->contadorPasajerosIntolerancias($numVuelo);
    //var_dump($result);

    // Nuevo array para almacenar los valores y enviarlos a la tabla
    $detalle_vuelos_tabla = [
        'pasajeros' => $resultNumPasajeros[0]['Num_Pasajeros'],
        'intolerancias' => $resultNumPasajerosIntolerancias[0]['Intolerancias']
    ];

    /*foreach ($resultNumPasajeros as $vuelo) {
        $detalle_vuelos_tabla[] = array_values($vuelo);
    }*/

    echo json_encode($detalle_vuelos_tabla);
}catch(Exception $e){
    //Aquí hay que contemplar devolver un error personalizado por si el JS está desactivado en el Front.
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
