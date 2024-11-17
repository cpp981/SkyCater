<?php
require_once './include/Pedido.php';
require_once './include/Messages.php';
header('Content-Type: application/json');
session_start();

try{
    $pedido = new Pedido();
    $result = $pedido->getAllPedidos();
    //var_dump($result);

    // Nuevo array para almacenar los valores y enviarlos a la tabla
    $pedidos = [];

    foreach ($result as $p) {
        $pedidos[] = array_values($p);
    }
    echo json_encode($pedidos);
}catch(Exception $e){
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
