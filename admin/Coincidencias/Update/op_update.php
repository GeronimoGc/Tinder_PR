<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $id_usuario = $_POST['id_usuario'];
    $id_coincidencia = $_POST['id_coincidencia'];

    try {
        $consulta = $conexion->prepare("UPDATE coincidencias SET id_usuario = ?, id_coincidencia = ? WHERE id = ?");
        $consulta->execute([$id_usuario, $id_coincidencia, $id]);

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
