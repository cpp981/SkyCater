<?php
require_once './include/Vuelo.php';
require_once './include/Messages.php';
header('Content-Type: application/json');
//session_start();

try{
    $vuelo = new Vuelo();
    $result = $vuelo->ObtenerVuelos();
    //var_dump($result);

    // Nuevo array para almacenar los valores y enviarlos a la tabla
    $vuelos_tabla = [];

    foreach ($result as $vuelo) {
        $vuelos_tabla[] = array_values($vuelo);
    }
    echo json_encode($vuelos_tabla);
}catch(Exception $e){
    //Aquí hay que contemplar devolver un error personalizado por si el JS está desactivado en el Front.
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
