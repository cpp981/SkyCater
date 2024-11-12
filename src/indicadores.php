<?php
require_once './include/Conexion.php';
require_once './include/Dashboard.php';
header('Content-Type: application/json');
require_once '../src/session.php';


$data = [];
$dash = new Dashboard();
try{
 
    $productosSinAlergenos = $dash->getProductosSinAlergenos();
    $personasConIntolerancias = $dash->PersonasConIntolerancias();

 // Asignamos los valores a los resultados de $data
    $data['prod'] = $productosSinAlergenos[0]['count(*)'];
    $data['intolerancias'] = $personasConIntolerancias[0]['count(*)'];
    echo json_encode($data);
}
catch(Exception $e)
{
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}