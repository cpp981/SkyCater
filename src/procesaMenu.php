<?php
require_once './include/Vuelo.php';
require_once './include/Pasajero.php';
require_once './include/Messages.php';
require_once './include/Producto.php';

header('Content-Type: application/json');
session_start();

try {
    // Obtener los datos enviados por POST
    $idVuelo = isset($_POST['idVuelo']) ? $_POST['idVuelo'] : null;
    $dniPasajero = isset($_POST['dniPasajero']) ? $_POST['dniPasajero'] : null;
    $primerPlato = isset($_POST['primerPlato']) ? $_POST['primerPlato'] : null;
    $segundoPlato = isset($_POST['segundoPlato']) ? $_POST['segundoPlato'] : null;
    $bebida = isset($_POST['bebida']) ? $_POST['bebida'] : null;

    // Validación: Verificar que todos los parámetros estén presentes
    if (is_null($idVuelo) || is_null($dniPasajero) || is_null($primerPlato) || is_null($segundoPlato) || is_null($bebida)) {
        echo json_encode(['status' => 'error', 'message' => Messages::MISSING_ARGUMENTS]);
        exit; // Terminar el script para que no se ejecute más código
    }

    // Necesitamos obtener el Id del Pasajero a partir de su DNI.
    $pasajero = new Pasajero();
    $producto = new Producto();
    $data = $pasajero->getIdPasajeroByDni($dniPasajero);
    // Almacenamos el Id del Pasajero
    $idPasajero = $data[0]['Id_Pasajero'];
    // Despues necesitamos obtener el Id de cada Producto a insertar a partir de su nombre.
    $dataProd = [];
    $dataProd['primerPlato'] = $producto->getIdProductoByName($primerPlato);
    $dataProd['segundoPlato'] = $producto->getIdProductoByName($segundoPlato);
    $dataProd['bebida'] = $producto->getIdProductoByName($bebida);
    //var_dump($dataProd);
    // Crear un nuevo array solo con los valores de $dataProd
    $dataIdProd = [];
    $dataIdProd['primerPlato'] = $dataProd['primerPlato'][0]['Id_Producto']; // Extraer solo el ID
    $dataIdProd['segundoPlato'] = $dataProd['segundoPlato'][0]['Id_Producto']; // Extraer solo el ID
    $dataIdProd['bebida'] = $dataProd['bebida'][0]['Id_Producto']; // Extraer solo el ID

    //var_dump($dataIdProd);
    // Llamamos a la función de Producto que hace la transaccion.
    $transaccion = $producto->asignarProductos($idVuelo, $idPasajero, $dataIdProd);
    // Devolvemos el resultado, true o false con mensaje personalizado al front desde Messages.
    if ($transaccion) {
        // Enviar una respuesta exitosa
        echo json_encode(['status' => 'success', 'message' => Messages::MENU_SUCCESS]);
    } else {
        // Indicamos respuesta fallida
        echo json_encode(['status' => 'error', 'message' => Messages::MENU_ERROR]);
    }

} catch (Exception $e) {
    // Manejar cualquier excepción y enviar error
    echo json_encode(['status' => 'error', 'message' => Messages::LOAD_DATA_ERROR]);
}