<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Iniciar Sesion</title>
    <?php include("../assets/config/HeadTailwind.php"); ?>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md text-center">
        <h2 class="text-2xl font-bold mb-6">Bienvenido</h2>

        <div class="space-y-4">
            <a href="login.php"
                class="block py-2 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                Iniciar Sesión
            </a>
            <a href="register.php"
                class="block py-2 px-4 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700">
                Crear Cuenta
            </a>
        </div>
    </div>

</body>

</html>