<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_emisor = $_POST['id_emisor'];
    $id_receptor = $_POST['id_receptor'];
    $mensaje = $_POST['mensaje'];
    $fecha_envio = date("Y-m-d H:i:s"); // Fecha y hora actual
    $url = $_GET['url'];

    try {
        $consulta = $conexion->prepare("INSERT INTO mensajes (id_emisor, id_receptor, mensaje, fecha_envio) VALUES (?, ?, ?, ?)");
        $consulta->execute([$id_emisor, $id_receptor, $mensaje, $fecha_envio]);

        if ($consulta->rowCount() > 0) {
            echo "Mensaje enviado con éxito.";
            header("Location: ../list/index.php");
            exit();
        } else {
            echo "Error al enviar el mensaje.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../list/index.php");
    exit();
}
?>
