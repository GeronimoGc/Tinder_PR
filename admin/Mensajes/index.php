<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

$id_usuario = $_SESSION['id_usuario']; // ID del usuario en sesión

try {
    $consulta = $conexion->prepare("SELECT * FROM mensajes WHERE id_emisor = ? OR id_receptor = ? ORDER BY fecha_envio DESC");
    $consulta->execute([$id_usuario, $id_usuario]);

    $mensajes = $consulta->fetchAll();

    foreach ($mensajes as $mensaje) {
        echo "<div>";
        echo "<p><strong>De:</strong> " . htmlspecialchars($mensaje['id_emisor']) . "</p>";
        echo "<p><strong>Para:</strong> " . htmlspecialchars($mensaje['id_receptor']) . "</p>";
        echo "<p><strong>Mensaje:</strong> " . htmlspecialchars($mensaje['mensaje']) . "</p>";
        echo "<p><strong>Fecha:</strong> " . htmlspecialchars($mensaje['fecha_envio']) . "</p>";
        echo "<a href='../update/f_update.php?id=" . $mensaje['id'] . "'>Editar</a> | ";
        echo "<a href='../drop/op_drop.php?id=" . $mensaje['id'] . "'>Eliminar</a>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
