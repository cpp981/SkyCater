<?php
require_once './include/Pedido.php';


$pedido = new Pedido();

// Llamamos al método para actualizar los pedidos pendientes
$pedido->actualizarPedidosPendientes();