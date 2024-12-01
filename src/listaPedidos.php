<?php
require_once './include/Pedido.php';
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
    $pedido = new Pedido();

    switch ($action) {
        case 'obtener_pedidos':
            $result = $pedido->getAllPedidos();
            //var_dump($result);

            // Nuevo array para almacenar los valores y enviarlos a la tabla
            $pedidos = [];

            foreach ($result as $p) {
                $pedidos[] = array_values($p);
            }
            echo json_encode($pedidos);
            break;
        
        case 'indicadores':
            // Obtenemos los datos de la consulta
            $arrayPedidosCompletos = $pedido->getTotalPedidosCompletados();
            $arrayPedidosPendientes = $pedido->getTotalPedidosPendientes();
            
            // Preparamos para enviar por JSON
            $pedidosCompletos = $arrayPedidosCompletos[0]['Completos'];
            $pedidosPendientes = $arrayPedidosPendientes[0]['Pendientes'];
            $indicadoresPedidos = [
                'completos' => $pedidosCompletos,
                'pendientes' => $pedidosPendientes
            ];
            echo json_encode(['status' => 'success', $indicadoresPedidos]);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
