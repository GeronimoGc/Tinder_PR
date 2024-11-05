<?php
include("../../../assets/config/op_conectar.php");
$url = $_POST['url'];
$id_admin = $_POST['id_admin'];

$consulta_mensaje = $pdo->prepare('SELECT id, nombre_usuario, rol, foto_perfil FROM usuarios');
$consulta_mensaje->execute();
$resultado_mensaje = $consulta_mensaje->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Mensaje - Tinder</title>
    <?php include("../../../assets/config/HeadTailwind.php"); ?>
</head>

<body class="flex items-center justify-center min-h-screen bg-pink-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">Enviar Mensaje</h2>

        <form action="op_create.php" method="POST">
            <input type="hidden" name="url" value="<?= $url; ?>">
            <input type="hidden" name="id_admin" value="<?= $id_admin; ?>">


            <label for="id_emisor" class="block text-sm font-semibold text-gray-700">Emisor</label>
            <select name="id_emisor" id="id_emisor" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>
                <option value="" disabled selected>elige</option>
                <?php foreach ($resultado_mensaje as $mensaje): ?>
                    <option value="<?= $mensaje['id'];  ?>"><?= $mensaje['id'];  ?> - <?= $mensaje['nombre_usuario']; ?> - <?= $mensaje['rol']; ?></option>
                <?php endforeach; ?>
            </select>


            <label for="id_receptor" class="block text-sm font-semibold text-gray-700">ID Receptor</label>
            <select name="id_receptor" id="id_receptor" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>
                <option value="" disabled selected>elige</option>
                <?php foreach ($resultado_mensaje as $mensaje): ?>
                    <option value="<?= $mensaje['id'];  ?>"><?= $mensaje['id'];  ?> - <?= $mensaje['nombre_usuario']; ?> - <?= $mensaje['rol']; ?></option>
                <?php endforeach; ?>
            </select>



            <label for="mensaje" class="block text-sm font-semibold text-gray-700">Mensaje</label>
            <textarea name="mensaje" id="mensaje" rows="3" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" placeholder="Escribe tu mensaje aquí..." required></textarea>

            <button type="submit" class="w-full py-2 text-white bg-pink-600 rounded-lg hover:bg-pink-700">Enviar Mensaje</button>
        </form>
    </div>

</body>

</html>