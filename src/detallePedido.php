<?php
require_once './include/Pedido.php';
require_once './include/Messages.php';
header('Content-Type: application/json');
session_start();

try {
    // Verificar si se recibió el parámetro 'action'
    if (!isset($_POST['action'])) {
        echo json_encode(['status' => 'error', 'message' => Messages::ACTION_NOT_FOUND]);
        exit;
    }

    $action = $_POST['action'];
    $pedido = new Pedido();

    if ($action === 'cancelar') {
        // Verificar si se recibió el número de pedido
        if (!isset($_POST['numPedido'])) {
            echo json_encode(['status' => 'error', 'message' => Messages::MISSING_ARGUMENTS]);
            exit;
        }

        $numPedido = $_POST['numPedido'];
        // Llamar al método para cancelar el pedido
        $result = $pedido->cancelPedidoByNumPedido($numPedido);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => Messages::ORDER_CANCELLED]);
        } else {
            echo json_encode(['status' => 'error', 'message' => Messages::ORDER_CANCEL_FAILURE]);
        }
    } elseif ($action === 'detalles') {
        // Verificar si se recibió el número de pedido
        if (!isset($_POST['numPedido'])) {
            echo json_encode(['status' => 'error', 'message' => Messages::MISSING_ARGUMENTS]);
            exit;
        }

        $numPedido = $_POST['numPedido'];
        // Llamar al método para obtener los detalles del pedido
        $detalles = $pedido->getDetallesPedidoByNumPedido($numPedido);

        if ($detalles) {
            echo json_encode(['status' => 'success', 'data' => $detalles]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontraron detalles para el pedido.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Acción no válida.']);
    }
} catch (Exception $e) {
    // Manejar cualquier excepción y enviar un error genérico
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}


