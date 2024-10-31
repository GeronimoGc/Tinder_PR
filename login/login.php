<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tinder Login</title>
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

<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full flex justify-start p- absolute top-0 left-0">
        <a href="index.php" class="py-1 px-4">
            <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Tinder Logo" class="h-10">
        </a>
        <a href="index.php" class="absolute top-4 right-4 bg-pink-500 p-2 rounded-full shadow-md hover:bg-pink-600 transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 22V12h6v10" />
            </svg>
        </a>
    </div>
    <div class="w-full max-w-md p-8 bg-white bg-opacity-80 rounded-2xl shadow-2xl backdrop-blur-md shadow-lg transform transition duration-500 hover:scale-105">
        <h2 class="text-3xl font-extrabold text-center mb-6 text-pink-600">Iniciar Sesión</h2>

        <form action="op_login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-pink-500">Correo Electrónico</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent placeholder-gray-400" placeholder="ejemplo@correo.com">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-pink-500">Contraseña</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent placeholder-gray-400" placeholder="********">
            </div>

            <button type="submit"
                class="w-full py-3 px-4 bg-pink-500 text-white font-bold rounded-lg shadow-md hover:bg-pink-600 hover:shadow-lg transform hover:scale-105 transition duration-300">
                Iniciar Sesión
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            ¿No tienes cuenta? <a href="../CreateAcount/" class="text-pink-600 font-semibold hover:underline">Regístrate aquí</a>
        </p>
    </div>

</body>

</html>