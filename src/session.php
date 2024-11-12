<?php
// config/session.php
if (session_status() == PHP_SESSION_NONE) 
{
    session_start(
        [
                    'cookie_lifetime' => 21600,  // Duración de la cookie (6 horas)
                    'cookie_secure' => true,     // Solo se enviará la cookie por HTTPS
                    'cookie_httponly' => true,   // Evita el acceso mediante JavaScript
                    'cookie_samesite' => 'Strict', // Previene CSRF
    ]);
}

// Regenerar el ID de sesión después de que el usuario inicie sesión
if (isset($_SESSION['nombre']) && !isset($_SESSION['session_regenerated'])) 
{
    session_regenerate_id(true); // Regenerar el ID de sesión
    $_SESSION['session_regenerated'] = true; // Marca la sesión como regenerada
}
