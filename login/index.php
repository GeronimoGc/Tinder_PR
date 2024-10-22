<?php
include("sesion.php"); // Incluye el archivo de sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form action="op_validar.php" method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" required><br><br>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" required><br><br>
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>
