<?php
// Conexión a la base de datos con PDO
$host = 'localhost';
$nombre_bd = 'tinder';
$usuario_bd = 'root';
$contrasena_bd = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$nombre_bd", $usuario_bd, $contrasena_bd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}