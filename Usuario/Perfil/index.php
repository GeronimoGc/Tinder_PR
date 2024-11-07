<?php
session_start();
include("../../assets/config/op_conectar.php");

// Verificar que el usuario está autenticado
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] == 0) {
    header("Location: ../login/");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener toda la información del usuario autenticado
$consulta_usuario = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id_usuario");
$consulta_usuario->execute([':id_usuario' => $id_usuario]);
$usuario_actual = $consulta_usuario->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <?php include("../../assets/config/HeadTailwind.php"); ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Encabezado -->
    <header class="bg-pink-600 text-white p-4 flex items-center justify-between">
        <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Tinder Logo" class="h-10">
        <h1 class="text-2xl font-bold">Perfil de Usuario</h1>

        <form action="../../home/" method="post">
            <input type='hidden' name='id_usuario' value='<?= $id_usuario ?>'>
            <input type='hidden' name='url' value='<?= $url ?>'>
            <button class"absolute top-4 right-4 bg-pink-500 p-2 rounded-full shadow-md hover:bg-pink-600 transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 fill-white">
                    <!-- Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free -->
                    <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
                </svg>
            </button>
        </form>


    </header>

    <!-- Contenedor de perfil -->
    <div class="max-w-4xl mx-auto my-8 bg-white shadow-lg rounded-lg p-8">
        <div class="flex flex-col items-center">
            <img src="../../assets/img/uploads/<?= $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil" class="w-32 h-32 rounded-full mb-4">
            <h2 class="text-2xl font-semibold mb-4"><?= $usuario_actual['nombre_usuario']; ?></h2>
        </div>

        <!-- Formulario de edición -->
        <form action="procesar_edicion.php" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <input type="hidden">
                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-gray-700">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario_actual['nombre_usuario']); ?>" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500">
                </div>
                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700">Correo electrónico:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario_actual['email']); ?>" class="w-full border border-gray-300 rounded p-2w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500">
                </div>
                <!-- Edad -->
                <div>
                    <label for="edad" class="block text-gray-700">contraseña:</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" value="<?= htmlspecialchars($usuario_actual['contrasena']); ?>">
                </div>
                <!-- Género -->
                <div>
                    <label for="genero" class="block text-gray-700">Género:</label>
                    <select id="genero" name="genero" class=w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500">
                        <option value="Masculino" <?= ($usuario_actual['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Femenino" <?= ($usuario_actual['genero'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                        <option value="Otro" <?= ($usuario_actual['genero'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                    </select>
                </div>
            </div>

            <!-- Biografía -->
            <div>
                <label for="biografia" class="block text-gray-700">Biografía:</label>
                <textarea id="biografia" name="biografia" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500"><?= htmlspecialchars($usuario_actual['biografia']); ?></textarea>
            </div>

            <!-- Foto perfil -->
            <div class="mb-4">
                <img src="../../assets/img/uploads/<?= htmlspecialchars($usuario_actual['foto_perfil']); ?>" alt="Foto de perfil actual" class="mt-2 h-20 w-20 rounded-full">
                <label for="foto_perfil" class="block text-gray-700">Foto de perfil:</label>
                <input type="file" name="foto_perfil" id="foto_perfil" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500">
            </div>

            <!-- Botón de guardar cambios -->
            <div class="text-center">
                <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</body>

<footer class="bg-gray-900 text-white text-center p-4">
    <p>&copy; <?= date("Y"); ?> Tinder Clone. Todos los derechos reservados.</p>
</footer>

</html>