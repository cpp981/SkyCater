<?php
require_once './include/Vuelo.php'; 
require_once './include/Messages.php';
// Establecer los encabezados de respuesta para JSON
header('Content-Type: application/json');
session_start();

// Verificar si se recibió el idVuelo por POST
if (isset($_POST['idVuelo']) && !empty($_POST['idVuelo'])) {
    $idVuelo = (int)$_POST['idVuelo'];  // Asegurarse de que sea un número entero

    try {
        // Instanciar la clase Vuelo y llamar al método para actualizar el estado
        $vuelo = new Vuelo();
        $resultado = $vuelo->updateEstadoVueloById($idVuelo);

        // Preparar la respuesta en formato JSON
        if ($resultado) {
            // Si la actualización fue exitosa
            echo json_encode([
                'status' => 'success',
                'message' => Messages::FLIGHT_MANAGEMENT_SUCCESS
            ]);
        } else {
            // Si la actualización no afectó ninguna fila
            echo json_encode([
                'status' => 'error',
                'message' => Messages::FLIGHT_MANAGEMENT_ERROR
            ]);
        }
    } catch (Exception $e) {
        // En caso de que ocurra un error
        echo json_encode([
            'status' => 'error',
            'message' => Messages::LOAD_DATA_ERROR
        ]);
    }
} else {
    // Si no se recibe el idVuelo correctamente
    echo json_encode([
        'status' => 'error',
        'message' => Messages::FLIGHT_ID_REQUIRED
    ]);
}