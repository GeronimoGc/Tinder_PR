<?php
session_start(); // Inicia la sesión
include("conectar.php"); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    try {
        $consulta = $conexion->prepare("SELECT COUNT(*) AS existe FROM usuarios WHERE nombre = ? AND clave = ?");
        $consulta->execute([$usuario, $clave]);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado['existe'] > 0) {
            // Inicia la sesión con el nombre de usuario
            $_SESSION['usuario'] = $usuario;
            // Redirige al usuario a la página de bienvenida
            header("Location: inicio.php");
            exit();
        } else {
            echo "<script>alert('Usuario y/o contraseña incorrectos');</script>";
            header("refresh:5;url=login.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

