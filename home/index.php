<?php
session_start();
include("../assets/config/op_conectar.php");

// Verificar que el usuario está autenticado
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] == 0) {
    header("Location: ../login/");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener información del usuario autenticado para mostrar en el encabezado
$consulta_usuario = $pdo->prepare("SELECT nombre_usuario, foto_perfil FROM usuarios WHERE id = :id_usuario");
$consulta_usuario->execute([':id_usuario' => $id_usuario]);
$usuario_actual = $consulta_usuario->fetch(PDO::FETCH_ASSOC);

// Obtener el siguiente usuario al que no se ha dado "me gusta" ni "no me gusta"
$consulta_siguiente = $pdo->prepare("
    SELECT u.id, u.nombre_usuario, u.foto_perfil 
    FROM usuarios u
    LEFT JOIN coincidencias c ON u.id = c.id_usuario_objetivo AND c.id_usuario = :id_usuario
    WHERE u.id != :id_usuario AND c.id IS NULL
    LIMIT 1
");
$consulta_siguiente->execute([':id_usuario' => $id_usuario]);
$siguiente_usuario = $consulta_siguiente->fetch(PDO::FETCH_ASSOC);

// Obtener la lista de usuarios aceptados por el usuario autenticado
$consulta_aceptados = $pdo->prepare("
    SELECT u.nombre_usuario, u.foto_perfil 
    FROM usuarios u
    INNER JOIN coincidencias c ON u.id = c.id_usuario_objetivo 
    WHERE c.id_usuario = :id_usuario AND c.accion = 'me_gusta'
");
$consulta_aceptados->execute([':id_usuario' => $id_usuario]);
$usuarios_aceptados = $consulta_aceptados->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<style>
    body{
    position: relative;
    background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="%23d3d3d3" d="M97.2 96.2c10.4-10.7 16-17.1 16-21.9 0-2.8-1.9-5.5-3.8-7.4A14.8 14.8 0 0 0 101 64.1c-8.5 0-20.9 8.8-35.8 25.7C23.7 137 2.5 182.8 3.4 250.3s17.5 117 54.1 161.9C76.2 435.9 90.6 448 100.9 448a13.6 13.6 0 0 0 8.4-3.8c1.9-2.8 3.8-5.6 3.8-8.4 0-5.6-3.9-12.2-13.2-20.6-44.5-42.3-67.3-97-67.5-165C32.3 188.8 54 137.8 97.2 96.2zM239.5 420.1c.6 .4 .9 .6 .9 .6zm93.8 .6 .2-.1C333.2 420.6 333.2 420.7 333.3 420.6zm3.1-158.2c-16.2-4.2 50.4-82.9-68.1-177.2 0 0 15.5 49.4-62.8 159.6-74.3 104.4 23.5 168.7 34 175.2-6.7-4.4-47.4-35.7 9.6-128.6 11-18.3 25.5-34.9 43.5-72.2 0 0 15.9 22.5 7.6 71.1C287.7 364 354 342.9 355 343.9c22.8 26.8-17.7 73.5-21.6 76.6 5.5-3.7 117.7-78 33-188.1C360.4 238.4 352.6 266.6 336.4 262.4zM510.9 89.7C496 72.8 483.5 64 475 64a14.8 14.8 0 0 0 -8.4 2.8c-1.9 1.9-3.8 4.7-3.8 7.4 0 4.8 5.6 11.3 16 21.9 43.2 41.6 65 92.6 64.8 154.1-.2 68-23 122.6-67.5 165-9.3 8.4-13.2 14.9-13.2 20.6 0 2.8 1.9 5.6 3.8 8.4A13.6 13.6 0 0 0 475.1 448c10.3 0 24.7-12.1 43.5-35.8 36.6-44.9 53.1-94.4 54.1-161.9S552.3 137 510.9 89.7z"/></svg>');
    background-size: 50px;
    overflow: hidden;
    gra

}

    </style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tinder | Pagina de Citas</title>
    <?php include("../assets/config/HeadTailwind.php"); ?>
</head>

<body class="bg-pink-100 min-h-screen flex flex-col items-center" x-data="{ sidebarOpen: false }">

    <!-- Encabezado -->
    <header class="w-full bg-pink-600 p-4 flex items-center justify-between relative">
        <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Tinder Logo" class="h-10">
        
        <div class="flex items-center space-x-4 p-4 bg-black-400 rounded-lg shadow-lg">
    <!-- Icono de fuego antes de la foto -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-yellow-400">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3C14.328 3 15 3.672 15 4.5S14.328 6 13.5 6 12 5.328 12 4.5 12.672 3 13.5 3zM18.5 3C19.328 3 20 3.672 20 4.5S19.328 6 18.5 6 17 5.328 17 4.5 17.672 3 18.5 3zM4.5 3C5.328 3 6 3.672 6 4.5S5.328 6 4.5 6 3 5.328 3 4.5 3.672 3 4.5 3zM12 8C8.69 8 6 10.69 6 14C6 16.07 7.3 17.93 9.21 19.34C8.56 19.76 8 20.52 8 21.5C8 22.88 9.12 24 10.5 24C11.49 24 12.42 23.36 12.87 22.5C13.87 21.29 14.88 18.61 14.88 15.34C14.88 14.21 14.4 13.2 13.68 12.73C13.14 12.33 13 11.61 13 11.05C13 9.24 12.24 8 12 8zM9.21 16.34C9.49 16.08 9.89 15.87 10.26 15.95C10.58 16.02 10.88 16.28 11.02 16.61C11.15 16.94 11.12 17.33 10.91 17.63C10.69 17.93 10.31 18.14 9.96 18.07C9.64 18.01 9.35 17.74 9.21 17.47C9.08 17.2 9.06 16.91 9.21 16.34zM12 15.5C12 15.5 11.5 16 11 16C10.5 16 10 15.5 10 15C10 14.5 10.5 14 11 14C11.5 14 12 14.5 12 15C12 15.5 12.5 15 13 15C13.5 15 14 14.5 14 14C14 13.5 13.5 13 13 13C12.5 13 12 13.5 12 14C12 14.5 12.5 15 12 15.5z" />
    </svg>

    <!-- Imagen y nombre dentro del cuadro blando -->
    <div class="flex items-center space-x-4">
        <img class="w-14 h-14 rounded-full border-2 border-gray-600" src="../assets/img/uploads/<?php echo $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil">
        <p class="text-lg font-semibold text-white"><?php echo $usuario_actual['nombre_usuario']; ?></p>
    </div>
</div>


        
        <!-- Icono de hamburguesa para abrir la barra lateral -->
        <button @click="sidebarOpen = true" class="text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </header>

<main>
        <!-- Barra lateral -->
        <div x-show="sidebarOpen" @click.away="sidebarOpen = false" class="fixed inset-0 flex justify-end z-50">
        <div @click="sidebarOpen = false" class="w-full h-full bg-black opacity-50 absolute"></div>
        <div class="relative bg-white w-64 h-full shadow-lg p-6 z-50 flex flex-col">
            <!-- Logo dentro de la barra lateral -->
            <div class="flex items-center justify-center mb-6">
                <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Tinder Logo" class="h-10">
            </div>

            <!-- Información del perfil -->
            <div class="text-center mb-8">
                <img class="w-10 h-10 rounded-full mx-auto mb-1" src="../assets/img/uploads/<?php echo $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil">
                <p class="text-lg font-semibold text-black"><?php echo $usuario_actual['nombre_usuario']; ?></p>
            </div>


            <!-- Opcion es de navegación -->
            <nav class="space-y-4">
                <a href="../Usuario/Perfil/" class="flex items-center space-x-3 text-gray-600 hover:bg-gray-200 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" />
                    </svg>
                    <span>Perfil</span>
                </a>
                <a href="../" class="flex items-center space-x-3 text-gray-600 hover:bg-gray-200 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16 13v-2H7V9l-5 5 5 5v-3h9z" />
                    </svg>
                    <span class="text-red-500">Cerrar sesión</span>
                </a>
            </nav>

            <div class="flex-grow"></div>

            <!-- Botón de ayuda -->
            <button class="w-full text-center bg-pink-500 text-white py-2 rounded-lg hover:bg-pink-600">
                Ayuda
            </button>
        </div>
    </div>

    <div class="flex-grow">
<!-- Contenido de la página -->
    <!-- Tarjeta del siguiente usuario -->
    <div class="max-w-sm w-full bg-white rounded-lg shadow-lg p-6 relative mt-10" x-data="{ show: true }" x-show="show">
        <?php if ($siguiente_usuario): ?>
            <div class="relative h-64 w-full rounded-lg overflow-hidden mb-4">
                <img class="w-full h-full object-cover" src="../assets/img/uploads/17_loli1.jpg"<?php echo $siguiente_usuario['foto_perfil']; ?>" alt="Foto de perfil">
            </div>
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-gray-800"><?php echo $siguiente_usuario['nombre_usuario']; ?></h2>
            </div>
            <div class="flex items-center justify-between mt-6 space-x-4">
                <!-- Botón "No me gusta" con icono de "X" -->
                <button @click="show = false; setTimeout(() => { show = true }, 500)" class="bg-red-500 text-white p-4 rounded-full shadow-lg transform transition-transform duration-300 hover:bg-red-600 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <!-- Botón de Mensaje con ícono SVG -->
                <button @click="show = false; setTimeout(() => { show = true }, 500)" class="bg-blue-500 text-white p-4 rounded-full shadow-lg transform transition-transform duration-300 hover:bg-blue-600 hover:scale-110">
                    <a href="../usuario/chat/index.php"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                        <path d="M20 2H4a2 2 0 00-2 2v14l4-4h14a2 2 0 002-2V4a2 2 0 00-2-2zM4 0h16a4 4 0 014 4v10a4 4 0 01-4 4H7l-7 7V4a4 4 0 014-4z"></path>
                    </svg></a>
                </button>

 
                <!-- Botón "Me gusta" con icono de corazón -->
                <button @click="show = false; setTimeout(() => { show = true }, 500)" class="bg-green-500 text-white p-4 rounded-full shadow-lg transform transition-transform duration-300 hover:bg-green-600 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 6.364l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-600">No hay más usuarios disponibles en este momento.</p>
        <?php endif; ?>
    </div>
    </div>
</main>
<footer class="w-full bg-gray-900 text-white text-center p-4">
        <p>&copy; <?php echo date("Y"); ?> Tinder Clone. Todos los derechos reservados.</p>
    </footer>
</body>

</body>

</html>