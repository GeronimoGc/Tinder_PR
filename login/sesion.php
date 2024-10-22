<?php
session_start(); // Inicia la sesión si no está iniciada

// Verifica si el usuario no está autenticado
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] === "") {
    $nombre_archivo = basename($_SERVER['PHP_SELF']);
    if ($nombre_archivo != 'index.php') {
        // Si no está en index.php, redirige a la página de inicio de sesión
        header("Location: index.php");
        exit();
    }
} else {
    // Si el usuario está autenticado, pero está en index.php, redirige a la página de bienvenida
    $nombre_archivo = basename($_SERVER['PHP_SELF']);
    if ($nombre_archivo == 'index.php') {
        // Redirige a la página de bienvenida
        header("Location: bienvenido.php");
        exit();
    }
}

