<?php
require_once './include/Conexion.php';
require_once './include/Dashboard.php';
require_once './include/Producto.php';
require_once './include/Vuelo.php';
require_once './include/Messages.php';
header('Content-Type: application/json');
require_once '../src/session.php';

try {
    if (!isset($_POST['action'])) {
        echo json_encode(['status' => 'error', 'message' => Messages::ACTION_NOT_FOUND]);
        exit;
    } else {
        $action = $_POST['action'];
    }

    switch ($action) {
        case 'indi_1_4':
            $data = [];
            $dash = new Dashboard();


            $productosSinAlergenos = $dash->getProductosSinAlergenos();
            $personasConIntolerancias = $dash->PersonasConIntolerancias();

            // Asignamos los valores a los resultados de $data
            $data['prod'] = $productosSinAlergenos[0]['count(*)'];
            $data['intolerancias'] = $personasConIntolerancias[0]['count(*)'];
            echo json_encode($data);
            break;

        case 'indi_total_productos':
            $data = [];
            $producto = new Producto();

            // Obtener el total de productos (platos) disponibles
            $platosDisponibles = $producto->getTotalProductos();

            // Asignar el valor al resultado de $data
            $data['totalProductos'] = $platosDisponibles[0]['Platos_Disponibles'];
            echo json_encode($data);
            break;

        case 'contador_vuelos_mes_actual':
            $data = [];
            $vuelo = new Vuelo();

            // Obtener el contador de vuelos para el mes actual
            $vuelosMesActual = $vuelo->contadorVuelosMesActual();

            $data['vuelosMesActual'] = $vuelosMesActual[0]['Vuelos_Mes_Actual'];
            echo json_encode($data);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}