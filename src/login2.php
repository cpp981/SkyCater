<?php
require_once './include/Messages.php';

// Incluir el archivo de la clase Usuario
require_once './include/Usuario.php';

// Establecer la cabecera para JSON
header('Content-Type: application/json');

// Recoger datos del formulario sanitizando para evitar ataques.
$username = htmlspecialchars(trim($_POST['username'])); //?? ''
$password = htmlspecialchars(trim($_POST['password'])); //?? ''

try {
    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => Messages::USER_OR_PASS_EMPTY]);
        exit();
    }
    $valid_user = new Usuario($username, $password);
    $resultado = $valid_user->comprobarCredenciales();
    if ($resultado) {
        //Credenciales correctas
        echo json_encode(['status' => 'success']);
        session_start([
            'cookie_lifetime' => 86400,  // Duración de la cookie en segundos
            'cookie_secure' => true,     // Solo se enviará la cookie por HTTPS
            'cookie_httponly' => true,   // No accesible mediante JavaScript (protege contra XSS)
            'cookie_samesite' => 'Strict', // Previene CSRF
        ]);
        $_SESSION['nombre'] = $username;
        // Al iniciar sesión
        if (!isset($_SESSION['session_start_time'])) {
            $_SESSION['session_start_time'] = time(); // Guarda el tiempo de inicio
        }
        // Regenerar el ID de sesión después de que el usuario inicie sesión
        if (isset($_SESSION['nombre']) && !isset($_SESSION['session_regenerated'])) {
            session_regenerate_id(true); // Regenerar el ID de sesión
            $_SESSION['session_regenerated'] = true; // Marca la sesión como regenerada
        }
    } else {
        //Credenciales erróneas
        //Aquí hay que contemplar devolver un error personalizado por si el JS está desactivado en el Front.
        echo json_encode(['status' => 'error', 'message' => Messages::INVALID_CREDENTIALS]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => Messages::CONNECTION_FAILED]);
}