<?php
session_start();  // Inicia la sesión si no está iniciada

// Eliminar variables de sesión
unset($_SESSION['nombre']);
session_unset();    // Elimina todas las variables de sesión

// Destruir la sesión
session_destroy();  

// Eliminar la cookie de la sesión
setcookie(session_name(), '', time() - 3600, '/'); 

// Redirigir al login
header('Location: ../public/login.html');
exit();
