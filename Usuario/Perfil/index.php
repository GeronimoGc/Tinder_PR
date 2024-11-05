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
    <?php include("../assets/config/HeadTailwind.php"); ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Encabezado -->
    <header class="bg-pink-600 text-white p-4 flex items-center justify-between">
        <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Tinder Logo" class="h-10">
        <h1 class="text-2xl font-bold">Perfil de Usuario</h1>
        <a href="../" class="text-white text-sm underline">Volver</a>


        <a href="../" class="absolute top-4 right-4 bg-pink-500 p-2 rounded-full shadow-md hover:bg-pink-600 transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10"></path>
            </svg>
        </a>


    </header>

    <!-- Contenedor de perfil -->
    <div class="max-w-4xl mx-auto my-8 bg-white shadow-lg rounded-lg p-8">
        <div class="flex flex-col items-center">
            <img src="../../assets/img/uploads//<?php echo $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil" class="w-32 h-32 rounded-full mb-4">
            <h2 class="text-2xl font-semibold mb-4"><?php echo $usuario_actual['nombre_usuario']; ?></h2>
        </div>

        <!-- Formulario de edición -->
        <form action="procesar_edicion.php" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block text-gray-700">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $usuario_actual['nombre_usuario']; ?>" class="w-full border border-gray-300 rounded p-2">
                </div>
                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700">Correo electrónico:</label>
                    <input type="email" id="email" name="email" value="<?php echo $usuario_actual['email']; ?>" class="w-full border border-gray-300 rounded p-2">
                </div>
                <!-- Edad -->
                <div>
                    <label for="edad" class="block text-gray-700">Edad:</label>
                    <input type="number" id="edad" name="edad" value="<?php echo $usuario_actual['edad']; ?>" class="w-full border border-gray-300 rounded p-2">
                </div>
                <!-- Género -->
                <div>
                    <label for="genero" class="block text-gray-700">Género:</label>
                    <select id="genero" name="genero" class="w-full border border-gray-300 rounded p-2">
                        <option value="Masculino" <?php echo ($usuario_actual['genero'] == 'Masculino') ? 'selected' : ''; ?>>Masculino</option>
                        <option value="Femenino" <?php echo ($usuario_actual['genero'] == 'Femenino') ? 'selected' : ''; ?>>Femenino</option>
                        <option value="Otro" <?php echo ($usuario_actual['genero'] == 'Otro') ? 'selected' : ''; ?>>Otro</option>
                    </select>
                </div>
            </div>

            <!-- Biografía -->
            <div>
                <label for="biografia" class="block text-gray-700">Biografía:</label>
                <textarea id="biografia" name="biografia" class="w-full border border-gray-300 rounded p-2"><?php echo $usuario_actual['biografia']; ?></textarea>
            </div>

            <!-- Foto perfil -->
            <div class="mb-4">
                <label for="foto_perfil" class="block text-gray-700">Foto de perfil:</label>
                <input type="file" name="foto_perfil" id="foto_perfil" class="w-full border-gray-300 rounded-md shadow-sm">
                <img src="../../assets/img/uploads/<?php echo htmlspecialchars($usuario_actual['foto_perfil']); ?>" alt="Foto de perfil actual" class="mt-2 h-20 w-20 rounded-full">
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
    <p>&copy; <?php echo date("Y"); ?> Tinder Clone. Todos los derechos reservados.</p>
</footer>

</html>