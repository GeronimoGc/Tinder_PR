<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

try {
    $consulta = $conexion->prepare("SELECT * FROM coincidencias ORDER BY id DESC");
    $consulta->execute();

    $coincidencias = $consulta->fetchAll();

    foreach ($coincidencias as $coincidencia) {
        echo "<div>";
        echo "<p><strong>ID Usuario:</strong> " . htmlspecialchars($coincidencia['id_usuario']) . "</p>";
        echo "<p><strong>ID Coincidencia:</strong> " . htmlspecialchars($coincidencia['id_coincidencia']) . "</p>";
        echo "<a href='../Update/f_update.php?id=" . $coincidencia['id'] . "'>Editar</a> | ";
        echo "<a href='../Drop/op_drop.php?id=" . $coincidencia['id'] . "'>Eliminar</a>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
