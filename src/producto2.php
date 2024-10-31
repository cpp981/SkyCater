<?php
require_once './include/Producto.php';
header('Content-Type: application/json');
//session_start();

try{
    $producto = new Producto();
    $result = $producto->ObtenerProductos();
    //var_dump($result);

    // Nuevo array para almacenar los valores y enviarlos a la tabla
    $platos_tabla = [];

    foreach ($result as $plato) {
        $platos_tabla[] = array_values($plato);
    }
    echo json_encode($platos_tabla);
}catch(Exception $e){
    //Aquí hay que contemplar devolver un error personalizado por si el JS está desactivado en el Front.
    echo json_encode($e->getMessage());
}
