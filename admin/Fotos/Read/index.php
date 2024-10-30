<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

try {
    $consulta = $conexion->prepare("SELECT * FROM fotos ORDER BY fecha_subida DESC");
    $consulta->execute();

    $fotos = $consulta->fetchAll();

    foreach ($fotos as $foto) {
        echo "<div>";
        echo "<img src='" . htmlspecialchars($foto['url_foto']) . "' alt='Foto' style='width: 150px; height: 150px;'><br>";
        echo "<p><strong>ID Usuario:</strong> " . htmlspecialchars($foto['id_usuario']) . "</p>";
        echo "<p><strong>Fecha de Subida:</strong> " . htmlspecialchars($foto['fecha_subida']) . "</p>";
        echo "<a href='../Update/f_update.php?id=" . $foto['id'] . "'>Editar</a> | ";
        echo "<a href='../Drop/op_drop.php?id=" . $foto['id'] . "'>Eliminar</a>";
        echo "</div>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
