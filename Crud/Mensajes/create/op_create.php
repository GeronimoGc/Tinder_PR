<?php
include('conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $fecha_nacimiento = $_POST['f_nac'];    
    $altura = $_POST['altura'];
    $ciudad = $_POST['ciudad'];
    $estrato = $_POST['estrato'];
    $area = $_POST['area'];
    $id_genero = $_POST['genero'];
    $tipo_documento = $_POST['tipo_documento'];
    $rrhh = $_POST['rrhh'];

    try {
        $consulta = $conexion->prepare("INSERT INTO estudiante(documento, nombre, fecha_nacimiento, altura, ciudad, estrato, area, id_genero, id_tipo_documento, id_rrhh) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $consulta->execute([$documento, $nombre, $fecha_nacimiento, $altura, $ciudad, $estrato, $area, $id_genero, $tipo_documento, $rrhh]);
        
        $filas_afectadas = $consulta->rowCount();
        
        if ($filas_afectadas > 0) {
            echo "Inserción exitosa";
            // Redirigir a una página de éxito
            header("Location: listar_estudiantes.php");
            exit(); // Asegura que el script se detenga después de la redirección
        } else {
            echo "No se pudo insertar el estudiante";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este script sin un envío de formulario POST, redireccionar a otra página (opcional)
    header("Location: listar_estudiantes.php");
    exit();
}

