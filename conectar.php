<?php
$servidor = "localhost";
$usuario_bd = "root";
$contrasena_bd = "root";
$nombre_bd = "tinder";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$nombre_bd", $usuario_bd, $contrasena_bd);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

