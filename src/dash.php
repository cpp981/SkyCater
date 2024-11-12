<?php
require_once './include/Conexion.php';
require_once './include/Dashboard.php';
header('Content-Type: application/json');
require_once '../src/session.php';

//Enviamos datos de las Clases en las que viajan los pasajeros
//Se envia al JS para que lo muestre en la gráfica del dashboard
$data = [];
$dash = new Dashboard();
try{
    $result = $dash->ContadorPrimeraClase();
    $index = 1;
foreach($result as $item){
    $data[$index]  = $item['count(*)'];
    $index++;
}
echo json_encode($data);
}catch(Exception $e){
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}
