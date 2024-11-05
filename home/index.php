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
        <div class="text-center">
            <img class="w-10 h-10 rounded-full mx-auto mb-1" src=" ../assets/img/uploads/<?php echo $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil">
            <p class="text-lg font-semibold text-white"><?php echo $usuario_actual['nombre_usuario']; ?></p>
        </div>
        <!-- Icono de hamburguesa para abrir la barra lateral -->
        <button @click="sidebarOpen = true" class="text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </header>

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
                <img class="w-20 h-20 rounded-full mx-auto mb-2" src=" ../assets/img/uploads/Junior_2_1.jpg"<?php echo $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil">
                <p class="text-lg font-semibold text-gray-800"><?php echo $usuario_actual['nombre_usuario']; ?></p>
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
</body>
<footer class="w-full bg-gray-900 text-white text-center p-4">
    <p>&copy; <?php echo date("Y"); ?> Tinder Clone. Todos los derechos reservados.</p>
</footer>

</html>