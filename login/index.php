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
        /* body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.1)), url(https://tinder.com/static/build/590275fec8cbbb0de80caa66c8450906.webp);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        } */

        #video_background {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            background-size: cover;
            overflow: hidden;
        }
    </style>
</head>

<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
    <video autoplay loop muted id="video_background">
        <source src="../assets/movie/background.mp4" type="video/mp4">
        Tu navegador no soporta el formato de video.
    </video>

    <div class="w-full flex justify-end p-4 absolute top-0 right-0">
        <a href="login.php" class="py-2 px-4 bg-transparent border-2 border-radius text-white font-semibold rounded-md hover:bg-red-300"> Iniciar Sesión </a>
    </div>
    <div class="w-full flex justify-star p-4 absolute tip-0 right-0">
        <a href="" class="py-2 px-4">
            <img class="py-2 px-4 flex"  src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="" />
        </a>
    </div>

    <div class="w-full max-w-md p-6 rounded-lg shadow-lg text-center mt-24 w-1/2 bg-black">
        <h2 class="text-2xl font-bold mb-6 text-white">Desliza a la derecha</h2>

        <div class="space-y-4">
            <a href="../CreateAcount/" class="block py-2 px-4 bg-red-300 text-white font-semibold border-2 border-red-300 rounded-l-full rounded-r-full hover:bg-red-500"> Crear Cuenta </a>
        </div>
    </div>
</body>

</body>

</html>