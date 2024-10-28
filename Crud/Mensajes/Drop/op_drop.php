<?php
include('../../../assets/config/op_conectar.php');; // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_estudiante = $_GET['id'];

    try {
        // Preparar la consulta de eliminación
        $consulta = $conexion->prepare("DELETE FROM estudiante WHERE id = ?");

        // Ejecutar la consulta de eliminación
        $consulta->execute([$id_estudiante]);

        // Redirigir a listar_estudiantes.php después de la eliminación
        header("Location: listar_estudiantes.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este script sin un ID de estudiante válido por GET, redireccionar a otra página (opcional)
    header("Location: index.php");
    exit();
}
