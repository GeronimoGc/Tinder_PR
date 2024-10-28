<?php
include('../../../assets/config/op_conectar.php');; // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_estudiante = $_POST['id_estudiante'];
    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $fecha_nacimiento = $_POST['f_nac'];
    $altura = $_POST['altura'];
    $ciudad = $_POST['ciudad'];
    $estrato = $_POST['estrato'];
    $area = $_POST['area'];
    $id_genero = $_POST['genero'];
    $id_tipo_documento = $_POST['tipo_documento'];
    $id_rrhh = $_POST['rrhh'];

    try {
        // Preparar la consulta de actualización
        $consulta = $conexion->prepare("UPDATE estudiante SET nombre=?, documento=?, fecha_nacimiento=?, altura=?, ciudad=?, estrato=?, area=?, id_genero=?, id_tipo_documento=?, id_rrhh=? WHERE id=?");

        // Ejecutar la consulta de actualización
        $consulta->execute([$nombre, $documento, $fecha_nacimiento, $altura, $ciudad, $estrato, $area, $id_genero, $id_tipo_documento, $id_rrhh, $id_estudiante]);

        // Redirigir a listar_estudiante.php después de la actualización
        header("Location: listar_estudiantes.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este script sin un envío de formulario POST, redireccionar a otra página (opcional)
    header("Location: index.php");
    exit();
}
