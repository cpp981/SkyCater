<?php
require_once './include/Conexion.php';
require_once './include/Dashboard.php';
require_once './include/Producto.php';
require_once './include/Pedido.php';
require_once './include/Vuelo.php';
require_once './include/Messages.php';
require_once '../src/session.php';

header('Content-Type: application/json');

try {
    if (!isset($_POST['action'])) {
        echo json_encode(['status' => 'error', 'message' => Messages::ACTION_NOT_FOUND]);
        exit;
    } else {
        $action = $_POST['action'];
    }
    switch ($action) {
        case 'contador_tipoClase':
            $data = [];
            $dash = new Dashboard();


            $result = $dash->ContadorPrimeraClase();
            $index = 1;
            foreach ($result as $item) {
                $data[$index] = $item['count(*)'];
                $index++;
            }
            echo json_encode($data);
            break;

        case 'contador_tipoComida':
            $producto = new Producto();
            $result = $producto->contadorCategoriasProductos();
            // Recorremos el array y preparamos un nuevo array con los resultados
            $response = [];
            foreach ($result as $item) {
                if (isset($item['COUNT(Categoria)'])) {
                    $response[] = [
                        'Categoria' => $item['Categoria'],
                        'Count' => $item['COUNT(Categoria)']
                    ];
                }
            }
            // Devuelves los datos en formato JSON para ser utilizados en el frontend
            echo json_encode($response);

            break;

        case 'evolucion_pedidos':
            $pedido = new Pedido();
            $result = $pedido->contadorPedidosPorMes();
            // Preparamos los datos para el gráfico en arrays
            $labels = [];
            $data = [];

            foreach ($result as $row) {
                $labels[] = $row['mes'];        // Meses
                $data[] = $row['total_pedidos']; // Cantidad de pedidos
            }

            echo json_encode([
                'labels' => $labels,
                'data' => $data
            ]);
            break;

        case 'evolucion_vuelos':
           $vuelo = new Vuelo();
           $result = $vuelo->evolucionNumVuelos();
           echo json_encode($result);
           break; 
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}