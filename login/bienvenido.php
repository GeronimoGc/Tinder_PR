<?php
include("sesion.php"); // Incluye el archivo de sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido</h2>
        <p>¡Has iniciado sesión correctamente, <?php echo $_SESSION['usuario']; ?>!</p>
        <a href="logout.php">Cerrar sesión</a> <!-- Agregamos enlace para cerrar sesión -->
        <br>
        <a href="index.php">Volver al inicio</a>
    </div>
</body>
</html>
