<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tinder</title>
    <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/social-media-circle-6/1024/tinder-circle-512.png" type="image/x-icon">
    <?php include("../assets/config/HeadTailwind.php"); ?>
    <style>
        #video_background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
            filter: brightness(0.7);
        }
    </style>
</head>

<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100 relative overflow-hidden">
    <!-- Video de fondo -->
    <video autoplay loop muted id="video_background">
        <source src="../assets/movie/background.mp4" type="video/mp4">
        Tu navegador no soporta el formato de video.
    </video>

    <!-- Logo de Tinder en la esquina superior izquierda -->
    <div class="w-full flex justify-start p-4 absolute top-0 left-0">
        <a href="index.php" class="py-2 px-4">
            <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Tinder Logo" class="h-10">
        </a>
    </div>

    <!-- Botón de Iniciar Sesión en la esquina superior derecha -->
    <div class="w-full flex justify-end p-4 absolute top-0 right-0">
        <a href="login.php" class="py-2 px-4 border-2 border-white text-white font-semibold rounded-md hover:bg-red-300 transition duration-300">
            Iniciar Sesión
        </a>
    </div>

    <!-- Contenedor central -->
    <div class="text-center mt-24 bg-transparent">
        <h2 class="text-5xl font-bold mb-8 text-white">Desliza a la derecha</h2>
        <a href="../CreateAcount/" class="block py-3 px-10 bg-red-500 text-white font-semibold text-lg rounded-full hover:bg-red-600 transition duration-300">
            Crear Cuenta
        </a>
    </div>
</body>

</html>
