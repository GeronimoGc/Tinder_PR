<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id_foto = $_GET['id'];
    $consulta = $conexion->prepare("SELECT * FROM fotos WHERE id = ?");
    $consulta->execute([$id_foto]);
    $foto = $consulta->fetch();

    if ($foto) {
?>
        <form action="op_update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $foto['id']; ?>">

            <label for="id_usuario">ID Usuario:</label>
            <input type="text" name="id_usuario" value="<?php echo htmlspecialchars($foto['id_usuario']); ?>" required>

            <label for="foto">Actualizar Foto:</label>
            <input type="file" name="foto" required>

            <button type="submit">Actualizar Foto</button>
        </form>
<?php
    } else {
        echo "Foto no encontrada.";
    }
}
?>
