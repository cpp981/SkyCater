<?php

require_once './include/Pedido.php';

// Instanciamos la clase Pedido
$pedido = new Pedido();

// Llamamos al método que borra los pedidos cancelados
$pedido->borraPedidosCancelados();