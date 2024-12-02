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
    
    // Crear una instancia de la clase Usuario con las credenciales proporcionadas
    $valid_user = new Usuario($username, $password);
    
    // Comprobar las credenciales del usuario
    $resultado = $valid_user->comprobarCredenciales();
    
    if ($resultado) {
        // Credenciales correctas
        echo json_encode(['status' => 'success']);
        
        // Iniciar sesión
        session_start([
            'cookie_lifetime' => 86400,  // Duración de la cookie en segundos
            'cookie_secure' => true,     // Solo se enviará la cookie por HTTPS
            'cookie_httponly' => true,   // No accesible mediante JavaScript (protege contra XSS)
            'cookie_samesite' => 'Strict', // Previene CSRF
        ]);
        
        // Al iniciar sesión, almacenamos el nombre de usuario
        $_SESSION['nombre'] = $username;
        
        // Obtener el ID del usuario y almacenarlo en la sesión
        $userId = $valid_user->getIdUsuarioByName();  // Método que devuelve el ID del usuario
        
        if ($userId) {
            $_SESSION['user_id'] = $userId; // Guardamos el ID en la sesión
            //$valid_user->addLogRegistro($_SESSION['user_id']);
        } else {
            // Si no se encuentra el usuario, muestra un mensaje de error
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
            exit();
        }

        // Al iniciar sesión, si no se ha almacenado el tiempo de inicio de sesión, lo guardamos
        if (!isset($_SESSION['session_start_time'])) {
            $_SESSION['session_start_time'] = time(); // Guarda el tiempo de inicio
        }
        
        // Regenerar el ID de sesión después de que el usuario inicie sesión
        if (isset($_SESSION['nombre']) && !isset($_SESSION['session_regenerated'])) {
            session_regenerate_id(true); // Regenerar el ID de sesión
            $_SESSION['session_regenerated'] = true; // Marca la sesión como regenerada
        }
    } else {
        // Credenciales erróneas
        echo json_encode(['status' => 'error', 'message' => Messages::INVALID_CREDENTIALS]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => Messages::CONNECTION_FAILED]);
}
?>
