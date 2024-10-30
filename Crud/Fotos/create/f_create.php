<!-- f_create.php -->
<form action="op_create.php" method="POST" enctype="multipart/form-data">
    <label for="id_usuario">ID Usuario:</label>
    <input type="text" name="id_usuario" required>

    <label for="foto">Seleccionar Foto:</label>
    <input type="file" name="foto" required>

    <button type="submit">Subir Foto</button>
</form>
