<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id_coincidencia = $_GET['id'];
    $consulta = $conexion->prepare("SELECT * FROM coincidencias WHERE id = ?");
    $consulta->execute([$id_coincidencia]);
    $coincidencia = $consulta->fetch();

    if ($coincidencia) {
?>
        <form action="op_update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $coincidencia['id']; ?>">
            
            <label for="id_usuario">ID Usuario:</label>
            <input type="text" name="id_usuario" value="<?php echo htmlspecialchars($coincidencia['id_usuario']); ?>" required>

            <label for="id_coincidencia">ID Coincidencia:</label>
            <input type="text" name="id_coincidencia" value="<?php echo htmlspecialchars($coincidencia['id_coincidencia']); ?>" required>

            <button type="submit">Actualizar Coincidencia</button>
        </form>
<?php
    } else {
        echo "Coincidencia no encontrada.";
    }
}
?>
