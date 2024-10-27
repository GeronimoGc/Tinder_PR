<?php
include('../conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['f_nacimiento'];
    $id_genero = $_POST['genero'];

    try {
        $consulta = $conexion->prepare("INSERT INTO estudiante(nickname, nombre, apellido, f_nacimiento, genero) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $consulta->execute([$nickname, $nombre, $apellido, $f_nacimiento, $id_genero]);

        $filas_afectadas = $consulta->rowCount();

        if ($filas_afectadas > 0) {
            echo "EXITOSA";
            // Redirigir a una página de éxito
            header("Location: listar_estudiantes.php");
            exit(); // Asegura que el script se detenga después de la redirección
        } else {
            echo "Algo salio mal";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este script sin un envío de formulario POST, redireccionar a otra página (opcional)
    header("login.php");
    exit();
}
