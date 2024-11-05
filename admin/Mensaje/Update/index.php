<?php
// Conexión a la base de datos
include("../../../assets/config/op_conectar.php");

// Verifica que las variables de entrada estén presentes
$url = $_POST['url'] ?? null;
$id_admin = $_POST['id_admin'] ?? null;
$id_mensaje = $_POST['id_mensaje'] ?? null;

// Consulta para obtener información de los usuarios
$consulta_mensaje = $pdo->prepare('SELECT id, nombre_usuario, rol, foto_perfil FROM usuarios');
$consulta_mensaje->execute();
$resultado_mensaje = $consulta_mensaje->fetchAll(PDO::FETCH_ASSOC);

// Verifica que se haya pasado un ID de mensaje
if ($id_mensaje) {
    // Consulta para obtener el mensaje específico
    $consulta = $pdo->prepare("SELECT * FROM mensajes WHERE id = :id");
    $consulta->execute(['id' => $id_mensaje]);
    $mensaje = $consulta->fetch(PDO::FETCH_ASSOC);

    // Redirige si no se encuentra el mensaje
    if (!$mensaje) {
        header("Location: ../");
        exit();
    }

    // Consulta para obtener el nombre del emisor
    $consulta_emisor = $pdo->prepare("SELECT nombre_usuario FROM usuarios WHERE id = :id");
    $consulta_emisor->execute(['id' => $mensaje['id_emisor']]);
    $emisor = $consulta_emisor->fetch(PDO::FETCH_ASSOC);

    // Consulta para obtener el nombre del receptor
    $consulta_receptor = $pdo->prepare("SELECT nombre_usuario FROM usuarios WHERE id = :id");
    $consulta_receptor->execute(['id' => $mensaje['id_receptor']]);
    $receptor = $consulta_receptor->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirige si no se pasa el ID de mensaje
    header("Location: ../");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Mensaje - Tinder</title>
    <?php include("../../../assets/config/HeadTailwind.php"); ?>
</head>

<body class="flex items-center justify-center min-h-screen bg-pink-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">Enviar Mensaje</h2>

        <form action="op_update.php" method="POST">
            <input type="hidden" name="url" value="<?= htmlspecialchars($url); ?>">
            <input type="hidden" name="id_admin" value="<?= htmlspecialchars($id_admin); ?>">
            <input type="hidden" name="id_mensaje" value="<?= htmlspecialchars($id_mensaje); ?>">

            <label for="id_emisor" class="block text-sm font-semibold text-gray-700">Emisor</label>
            <select name="id_emisor" id="id_emisor" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>
                <option value="<?= htmlspecialchars($mensaje['id_emisor']); ?>" selected><?= htmlspecialchars($mensaje['id_emisor']); ?> - <?= htmlspecialchars($emisor['nombre_usuario']); ?></option>
                <?php foreach ($resultado_mensaje as $usuario): ?>
                    <option value="<?= htmlspecialchars($usuario['id']); ?>"><?= htmlspecialchars($usuario['id']); ?> - <?= htmlspecialchars($usuario['nombre_usuario']); ?> - <?= htmlspecialchars($usuario['rol']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="id_receptor" class="block text-sm font-semibold text-gray-700">Receptor</label>
            <select name="id_receptor" id="id_receptor" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>
                <option value="<?= htmlspecialchars($mensaje['id_receptor']); ?>" selected><?= htmlspecialchars($mensaje['id_receptor']); ?> - <?= htmlspecialchars($receptor['nombre_usuario']); ?></option>
                <?php foreach ($resultado_mensaje as $usuario): ?>
                    <option value="<?= htmlspecialchars($usuario['id']); ?>"><?= htmlspecialchars($usuario['id']); ?> - <?= htmlspecialchars($usuario['nombre_usuario']); ?> - <?= htmlspecialchars($usuario['rol']); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="mensaje" class="block text-sm font-semibold text-gray-700">Mensaje</label>
            <textarea name="mensaje" id="mensaje" rows="3" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" placeholder="Escribe tu mensaje aquí..." required><?= htmlspecialchars($mensaje['mensaje']); ?></textarea>

            <button type="submit" class="w-full py-2 text-white bg-pink-600 rounded-lg hover:bg-pink-700">Enviar Mensaje</button>
        </form>
    </div>
</body>

</html>