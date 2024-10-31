<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tinder</title>
    <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/social-media-circle-6/1024/tinder-circle-512.png" type="image/x-icon">
    <?php include("../assets/config/HeadTailwind.php"); ?>
    <style>
        body {
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)), url(https://tinder.com/static/build/590275fec8cbbb0de80caa66c8450906.webp);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-pink-100 bg-opacity-50 relative">
    <div class="w-full flex justify-start p-4 absolute top-0 left-0">
        <a href="../login" class="py-2 px-4">
            <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Tinder Logo" class="h-10">
        </a>
        <a href="../" class="absolute top-4 right-4 bg-pink-500 p-2 rounded-full shadow-md hover:bg-pink-600 transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10" />
            </svg>
        </a>
    </div>
    <div class="w-full max-w-md p-8 bg-white bg-opacity-80 rounded-2xl shadow-2xl backdrop-blur-md transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-extrabold text-center text-pink-600 mb-6">Crea tu cuenta en Tinder</h2>

        <form action="../admin/Usuario/create/op_create.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" value="usuario" name="url">
            <input type="hidden" value="2" name="rol">

            <!-- Nombre -->
            <label for="nombre" class="block text-sm font-semibold text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>

            <!-- Correo Electrónico -->
            <label for="email" class="block text-sm font-semibold text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>

            <!-- Contraseña -->
            <label for="password" class="block text-sm font-semibold text-gray-700">Contraseña</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>

            <!-- Género -->
            <label for="genero" class="block text-sm font-semibold text-gray-700">Género</label>
            <select name="genero" id="genero" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                <option value="-1">Elige</option>
                <option value="1">Masculino</option>
                <option value="2">Femenino</option>
                <option value="3">Otro</option>
            </select>

            <!-- Biografía -->
            <label for="biografia" class="block text-sm font-semibold text-gray-700">Biografía</label>
            <textarea name="biografia" id="biografia" rows="3" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500" placeholder="Cuenta un poco sobre ti..."></textarea>

            <!-- Foto de Perfil -->
            <label for="foto_perfil_usuario" class="block text-sm font-semibold text-gray-700">Foto de Perfil</label>
            <input type="file" name="foto_perfil_usuario" id="foto_perfil_usuario" class="w-full px-4 py-2 mb-6 text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-pink-500">

            <!-- Botón de Registro -->
            <button type="submit" class="w-full py-3 mt-2 text-white font-semibold bg-pink-600 rounded-lg shadow-lg hover:bg-pink-700 transition duration-300">
                Registrarse
            </button>
        </form>
    </div>
</body>

</html>