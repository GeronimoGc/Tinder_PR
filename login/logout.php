<?php
session_start(); // Inicia la sesión si no está iniciada

// Destruye todas las variables de sesión
$_SESSION = array();

// Si se desea eliminar la cookie de sesión, es necesario destruirla también.
// Nota: Esto destruirá la sesión y no solo los datos de sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruye la sesión
session_destroy();

// Muestra un mensaje de cierre de sesión
echo "Cerrando sesión...";

// Redirige a index.php después de unos segundos
header("refresh:2; url=index.php");
exit();

