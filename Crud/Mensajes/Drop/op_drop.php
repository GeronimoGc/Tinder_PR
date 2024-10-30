<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_mensaje = $_GET['id'];

    try {
        $consulta = $conexion->prepare("DELETE FROM mensajes WHERE id = ?");
        $consulta->execute([$id_mensaje]);

        header("Location: ../list/index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../list/index.php");
    exit();
}
?>
