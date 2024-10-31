<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id_mensaje = $_GET['id'];
    $consulta = $conexion->prepare("SELECT * FROM mensajes WHERE id = ?");
    $consulta->execute([$id_mensaje]);
    $mensaje = $consulta->fetch();

    if ($mensaje) {
?>
        <form action="op_update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $mensaje['id']; ?>">
            <label for="mensaje">Mensaje:</label>
            <textarea name="mensaje" required><?php echo htmlspecialchars($mensaje['mensaje']); ?></textarea>
            <button type="submit">Actualizar Mensaje</button>
        </form>
<?php
    } else {
        echo "Mensaje no encontrado.";
    }
}
?>
