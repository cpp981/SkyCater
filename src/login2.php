<?php
require_once './include/Messages.php';

// Incluir el archivo de la clase Usuario
require_once './include/Usuario.php';

// Establecer la cabecera para JSON
header('Content-Type: application/json');

// Recoger datos del formulario
$username = $_POST['username']; //?? ''
$password = $_POST['password']; //?? ''

try{
    if (empty($username) || empty($password)) {
        throw new Exception(Messages::USER_OR_PASS_EMPTY);
    }
    $valid_user = new Usuario($username,$password);
    $resultado = $valid_user->comprobarCredenciales();
    if($resultado){
        //Credenciales correctas
        echo json_encode(['status' => 'success']);
        session_start();
        $_SESSION['nombre'] = $username;
    }else{
        //Credenciales erróneas
        //Aquí hay que contemplar devolver un error personalizado por si el JS está desactivado en el Front.
        echo json_encode(['status' => Messages::UNAUTHORIZED_ACCESS]);
    }
}catch(PDOException $e){
    //Aquí hay que contemplar devolver un error personalizado por si el JS está desactivado en el Front.
    echo json_encode(['status' => 'error', 'message' => Messages::CONNECTION_FAILED]);
}