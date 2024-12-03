<?php
require_once './include/Messages.php';
require_once './include/Usuario.php'; // Clase Usuario

// Establecer la cabecera para JSON
header('Content-Type: application/json');

// Recoger datos del formulario sanitizando para evitar ataques
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
            'cookie_lifetime' => 86400,
            'cookie_secure' => true,
            'cookie_httponly' => true,
            'cookie_samesite' => 'Strict',
        ]);
        
        $_SESSION['nombre'] = $username;

        // Obtener el ID del usuario y almacenarlo en la sesión
        $userId = $valid_user->getIdUsuarioByName();
        
        if ($userId) {
            $_SESSION['user_id'] = $userId;

            // Registrar el log del inicio de sesión
            try {
                $valid_user->addLogRegistro($userId); // Llamada al método dentro de Usuario
            } catch (Exception $e) {
                // Registrar un error en el log del servidor si algo falla
                error_log("Error al registrar log de sesión: " . $e->getMessage());
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Usuario no encontrado']);
            exit();
        }

        if (!isset($_SESSION['session_start_time'])) {
            $_SESSION['session_start_time'] = time();
        }
        
        if (isset($_SESSION['nombre']) && !isset($_SESSION['session_regenerated'])) {
            session_regenerate_id(true);
            $_SESSION['session_regenerated'] = true;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => Messages::INVALID_CREDENTIALS]);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => Messages::CONNECTION_FAILED]);
}
