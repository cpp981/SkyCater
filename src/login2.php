<?php
// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir el archivo de la clase Usuario
require_once './include/Usuario.php';

// Establecer la cabecera para JSON
header('Content-Type: application/json');

// Recoger datos del formulario
$username = $_POST['username']; //?? ''
$password = $_POST['password']; //?? ''

try{
    if (empty($username) || empty($password)) {
        throw new Exception('Username or password is empty');
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
        echo json_encode(['status' => 'error']);
    }
}catch(Exception $e){
    //Aquí hay que contemplar devolver un error personalizado por si el JS está desactivado en el Front.
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}