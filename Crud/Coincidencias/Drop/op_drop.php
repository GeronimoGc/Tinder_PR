<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_coincidencia = $_GET['id'];

    try {
        $consulta = $conexion->prepare("DELETE FROM coincidencias WHERE id = ?");
        $consulta->execute([$id_coincidencia]);

        header("Location: ../read/index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../read/index.php");
    exit();
}
?>
