<?php
include("../../../assets/config/op_conectar.php"); // Incluye la conexión

// Verificar si se ha pasado un ID de usuario para actualizar
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Obtener los datos del usuario de la base de datos
    $consulta = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $consulta->execute([$id_usuario]);
    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
    
    // Si no se encuentra el usuario, redirigir a otra página (opcional)
    if (!$usuario) {
        header("Location: ../");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Perfil - Tinder</title>
    <?php include("../../../assets/config/HeadTailwind.php"); ?>
</head>

<body class="flex items-center justify-center min-h-screen bg-pink-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">Actualizar Perfil</h2>

        <form action="op_update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="url" value="f_update">
            <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
            
            <!-- Nombre -->
            <label for="nombre" class="block text-sm font-semibold text-gray-700">Nombre</label>
            <input type="text" name="nombre_usuario" id="nombre" value="<?= htmlspecialchars($usuario['nombre_usuario']); ?>" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>

            <!-- Correo Electrónico -->
            <label for="email" class="block text-sm font-semibold text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['correo']); ?>" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>

            <!-- Contraseña -->
            <label for="password" class="block text-sm font-semibold text-gray-700">Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500">

            <!-- Género -->
            <label for="genero" class="block text-sm font-semibold text-gray-700">Género</label>
            <select name="genero" id="genero" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>
                <option value="1" <?= $usuario['genero'] == '1' ? 'selected' : ''; ?>>Masculino</option>
                <option value="femenino" <?= $usuario['genero'] == 'femenino' ? 'selected' : ''; ?>>Femenino</option>
                <option value="otro" <?= $usuario['genero'] == 'otro' ? 'selected' : ''; ?>>Otro</option>
            </select>

            <!-- Biografía -->
            <label for="biografia" class="block text-sm font-semibold text-gray-700">Biografía</label>
            <textarea name="biografia" id="biografia" rows="3" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500"><?= htmlspecialchars($usuario['biografia']); ?></textarea>

            <!-- Foto de Perfil -->
            <label for="foto_perfil_usuario" class="block text-sm font-semibold text-gray-700">Foto de Perfil</label>
            <?php if (!empty($usuario['foto_perfil'])): ?>
                <!-- Mostrar la imagen de perfil actual -->
                <img src="../../../assets/img/uploads/<?= htmlspecialchars($usuario['foto_perfil']); ?>" alt="Foto de perfil" class="w-24 h-24 mb-4 rounded-full">
            <?php endif; ?>
            <input type="file" name="foto_perfil_usuario" id="foto_perfil_usuario" class="w-full px-4 py-2 mb-6 text-gray-700 border rounded-lg cursor-pointer focus:outline-none focus:border-pink-500">

            <!-- Botón de Actualizar -->
            <button type="submit" class="w-full py-2 text-white bg-pink-600 rounded-lg hover:bg-pink-700">Actualizar Perfil</button>
        </form>
    </div>
</body>

</html>
