<?php
require_once '../src/Conexion.php';

class Usuario
{
    private $pdo;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->pdo = $conexion->getPdo();
    }

    public function registrarUsuario($nombre, $password)
    {
        // Encriptar la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


        // Preparar la sentencia SQL
        $stmt = $this->pdo->prepare("INSERT INTO Usuario_Registrado (nombre, pass) VALUES (:nombre, :pass)");
        if ($stmt->execute([':nombre' => $nombre, ':pass' => $hashedPassword])) {
            echo "Usuario registrado exitosamente.";
        } else {
            echo "Error al registrar el usuario.";
        }

    }
}

$usuario = new Usuario();
$usuario->registrarUsuario('admin', 'Depor2025');

//Usuarios: carlos  admin 
//Pass: Deportivo   Depor2025
