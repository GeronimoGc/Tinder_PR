<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tinder Login</title>
    <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/social-media-circle-6/1024/tinder-circle-512.png" type="image/x-icon">
    <?php include("../assets/config/HeadTailwind.php");?>
    <style>
        body {
            background-image: url(https://tinder.com/static/build/590275fec8cbbb0de80caa66c8450906.webp);
            background-size: cover;
            background-position: center; 
            background-repeat: no-repeat;
        }
        
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md p-6 bg-red-100 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6 text-red-500">Iniciar Sesión</h2>

        <form action="op_login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-red-500">Correo Electrónico</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-red-500">Contraseña</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500">
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-red-300 text-white font-semibold rounded-md hover:bg-red-600">
                Iniciar Sesión
            </button>
        </form>

        <p class="mt-4 text-center text-sm text-gray-600">
            ¿No tienes cuenta? <a href="../CreateAcount/" class="text-blue-600 hover:underline">Regístrate aquí</a>
        </p>
    </div>

</body>

</html>