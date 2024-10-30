<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $id_coincidencia = $_POST['id_coincidencia'];

    try {
        $consulta = $conexion->prepare("INSERT INTO coincidencias (id_usuario, id_coincidencia) VALUES (?, ?)");
        $consulta->execute([$id_usuario, $id_coincidencia]);

        if ($consulta->rowCount() > 0) {
            echo "Coincidencia registrada exitosamente.";
            header("Location: ../read/index.php");
            exit();
        } else {
            echo "Error al registrar la coincidencia.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../read/index.php");
    exit();
}
?>
