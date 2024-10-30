<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $mensaje = $_POST['mensaje'];

    try {
        $consulta = $conexion->prepare("UPDATE mensajes SET mensaje = ? WHERE id = ?");
        $consulta->execute([$mensaje, $id]);

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
