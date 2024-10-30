<!-- f_create.php -->
<form action="op_create.php" method="POST">
    <label for="id_emisor">ID Emisor:</label>
    <input type="text" name="id_emisor" required>

    <label for="id_receptor">ID Receptor:</label>
    <input type="text" name="id_receptor" required>

    <label for="mensaje">Mensaje:</label>
    <textarea name="mensaje" required></textarea>

    <button type="submit">Enviar Mensaje</button>
</form>
