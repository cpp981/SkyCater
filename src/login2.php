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
        echo json_encode(['status' => 'error']);
    }
}catch(Exception $e){
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

/*try {
    // Crear una instancia de la clase Conexion y obtener el objeto PDO
    $conexion = new Conexion();
    $pdo = $conexion->getPDO();

    // Recoger datos del formulario
    $username = $_POST['username']; //?? ''
    $password = $_POST['password']; //?? ''

    if (empty($username) || empty($password)) {
        throw new Exception('Username or password is empty');
    }

    // Preparar y ejecutar la consulta
    $stmt = $pdo->prepare("SELECT pass FROM Usuario WHERE nombre = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result['pass'])) {
        // Credenciales correctas
        echo json_encode(['status' => 'success']);
        session_start();
        $_SESSION['nombre'] = $username;
    } else {
        // Credenciales incorrectas
        echo json_encode(['status' => 'error']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}*/