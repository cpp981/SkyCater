<?php
header('Content-Type: application/json');
require_once './include/Producto.php';
require_once './include/Proveedor.php';
session_start();

try
{
    //Traer toda la data del formulario
    // Recuperar el nombre del producto que vien por POST
    // Pasar ese nombre a la funcion de Producto que nos recupera el id a partir del nombre
    // Comprobar la data y pasarsela a la funcion que actualiza el producto(CREAR FUNCION PARA UPDATE)
    // Devolver mensaje si ok y si falla
    // Luego en el front con notyf notificar ese mensaje
}
catch(PDOException $e)
{

}