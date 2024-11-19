<?php
session_start();
include("../assets/config/op_conectar.php");

$id_usuario = $_POST['id_usuario'];


// Verificar que el usuario está autenticado
if (!isset($_POST['id_usuario']) || $_POST['id_usuario'] == 0) {
    header("Location: ../login/");
    exit();
}


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

$consulta_match = $pdo->prepare('select coincidencias.id, coincidencias.id_usuario, user1.nombre_usuario as usuario, coincidencias.id_usuario_objetivo, user2.nombre_usuario as usuario_objetivo, coincidencias.accion, coincidencias.fecha_coincidencia, user2.foto_perfil from coincidencias
inner join usuarios user1 on coincidencias.id_usuario = user1.id
inner join usuarios user2 on coincidencias.id_usuario_objetivo = user2.id
where coincidencias.id_usuario = ? and coincidencias.accion = "me_gusta"');
$consulta_match->execute([$id_usuario]);
$consulta_match_enviados = $consulta_match->fetch(PDO::FETCH_ASSOC);










?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tinder | Pagina de Citas</title>
    <?php include("../assets/config/HeadTailwind.php"); ?>
    <style>
        body {
            position: relative;
            background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="%23d3d3d3" d="M97.2 96.2c10.4-10.7 16-17.1 16-21.9 0-2.8-1.9-5.5-3.8-7.4A14.8 14.8 0 0 0 101 64.1c-8.5 0-20.9 8.8-35.8 25.7C23.7 137 2.5 182.8 3.4 250.3s17.5 117 54.1 161.9C76.2 435.9 90.6 448 100.9 448a13.6 13.6 0 0 0 8.4-3.8c1.9-2.8 3.8-5.6 3.8-8.4 0-5.6-3.9-12.2-13.2-20.6-44.5-42.3-67.3-97-67.5-165C32.3 188.8 54 137.8 97.2 96.2zM239.5 420.1c.6 .4 .9 .6 .9 .6zm93.8 .6 .2-.1C333.2 420.6 333.2 420.7 333.3 420.6zm3.1-158.2c-16.2-4.2 50.4-82.9-68.1-177.2 0 0 15.5 49.4-62.8 159.6-74.3 104.4 23.5 168.7 34 175.2-6.7-4.4-47.4-35.7 9.6-128.6 11-18.3 25.5-34.9 43.5-72.2 0 0 15.9 22.5 7.6 71.1C287.7 364 354 342.9 355 343.9c22.8 26.8-17.7 73.5-21.6 76.6 5.5-3.7 117.7-78 33-188.1C360.4 238.4 352.6 266.6 336.4 262.4zM510.9 89.7C496 72.8 483.5 64 475 64a14.8 14.8 0 0 0 -8.4 2.8c-1.9 1.9-3.8 4.7-3.8 7.4 0 4.8 5.6 11.3 16 21.9 43.2 41.6 65 92.6 64.8 154.1-.2 68-23 122.6-67.5 165-9.3 8.4-13.2 14.9-13.2 20.6 0 2.8 1.9 5.6 3.8 8.4A13.6 13.6 0 0 0 475.1 448c10.3 0 24.7-12.1 43.5-35.8 36.6-44.9 53.1-94.4 54.1-161.9S552.3 137 510.9 89.7z"/></svg>');
            background-size: 50px;
            overflow: hidden;
        }

        .modal {
            display: none;


        }
    </style>
</head>

<body class="bg-pink-100 min-h-screen flex flex-col items-center" x-data="{ sidebarOpen: false }">

    <!-- Encabezado -->
    <header class="w-full bg-pink-600 p-4 flex items-center justify-between relative">
        <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Tinder Logo" class="h-10">

        <form action="../usuario/Perfil/" method="post">
            <input type='hidden' name='id_usuario' value='<?= $id_usuario ?>'>
            <input type='hidden' name='url' value='<?= $url ?>'>
            <button href="../Usuario/Perfil/">
                <div class="flex items-center space-x-4 p-4 bg-black-400 rounded-lg shadow-lg h-14">
                    <!-- Icono de fuego antes de la foto -->
                    <img src="https://static.vecteezy.com/system/resources/previews/023/986/672/non_2x/tinder-app-logo-tinder-app-logo-transparent-tinder-app-icon-transparent-free-free-png.png" alt="Tinder Logo" class="h-10">

                    <!-- Imagen y nombre dentro del cuadro blando -->
                    <div class="flex items-center space-x-4">
                        <img class="w-14 h-14 rounded-full border-2 border-gray-600" src="../assets/img/uploads/<?= $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil">
                        <p class="text-lg font-semibold text-white"><?= $usuario_actual['nombre_usuario']; ?></p>
                    </div>
                </div>
            </button>
        </form>

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
                    <img class="w-10 h-20 w-auto rounded-full mx-auto mb-1" src="../assets/img/uploads/<?= $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil">
                    <p class="text-lg font-semibold text-black"><?= $usuario_actual['nombre_usuario']; ?></p>
                </div>


                <!-- Opcion es de navegación -->
                <nav class="space-y-4">
                    <form action="../usuario/Perfil/" method="post">
                        <input type='hidden' name='id_usuario' value='<?= $id_usuario ?>'>
                        <input type='hidden' name='url' value='<?= $url ?>'>
                        <button href="../Usuario/Perfil/" class="flex items-center space-x-3 text-gray-600 hover:bg-gray-200 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z" />
                            </svg>
                            <span>Perfil</span>
                        </button>
                    </form>


                    <form action="../usuario/chat/" method="post">
                        <input type='hidden' name='id_usuario' value='<?= htmlspecialchars($id_usuario) ?>'>
                        <input type="hidden" name="id_receptor" value="0">
                        <input type='hidden' name='url' value='<?= htmlspecialchars($url) ?>'>
                        <button href="../Usuario/Perfil/" class="flex items-center space-x-3 text-gray-600 hover:bg-gray-200 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" fill="currentcolor" viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path d="M208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 38.6 14.7 74.3 39.6 103.4c-3.5 9.4-8.7 17.7-14.2 24.7c-4.8 6.2-9.7 11-13.3 14.3c-1.8 1.6-3.3 2.9-4.3 3.7c-.5 .4-.9 .7-1.1 .8l-.2 .2s0 0 0 0s0 0 0 0C1 327.2-1.4 334.4 .8 340.9S9.1 352 16 352c21.8 0 43.8-5.6 62.1-12.5c9.2-3.5 17.8-7.4 25.2-11.4C134.1 343.3 169.8 352 208 352zM448 176c0 112.3-99.1 196.9-216.5 207C255.8 457.4 336.4 512 432 512c38.2 0 73.9-8.7 104.7-23.9c7.5 4 16 7.9 25.2 11.4c18.3 6.9 40.3 12.5 62.1 12.5c6.9 0 13.1-4.5 15.2-11.1c2.1-6.6-.2-13.8-5.8-17.9c0 0 0 0 0 0s0 0 0 0l-.2-.2c-.2-.2-.6-.4-1.1-.8c-1-.8-2.5-2-4.3-3.7c-3.6-3.3-8.5-8.1-13.3-14.3c-5.5-7-10.7-15.4-14.2-24.7c24.9-29 39.6-64.7 39.6-103.4c0-92.8-84.9-168.9-192.6-175.5c.4 5.1 .6 10.3 .6 15.5z" />
                            </svg>
                            <span>chat</span>
                        </button>
                    </form>

                    <button onclick="closeModal()" class="flex items-center space-x-3 text-gray-600 hover:bg-gray-200 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" fill="currentcolor" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                        </svg>
                        Ver Mis Matches
                    </button>

                    <button id="openModalBtn" class="px-4 py-2 bg-pink-500 text-white rounded-md hover:bg-pink-600 transition duration-300">
                        Ver Mis Matches
                    </button>



                    <a href="../" class="flex items-center space-x-3 text-gray-600 hover:bg-gray-200 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 13v-2H7V9l-5 5 5 5v-3h9z" />
                        </svg>
                        <span class="text-red-500">Cerrar sesión</span>
                    </a>


                </nav>

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
                        <img class="w-full h-full object-cover" src="../assets/img/uploads/<?= $siguiente_usuario['foto_perfil']; ?>" alt="Foto de perfil">
                    </div>
                    <div class="text-center">
                        <h2 class="text-2xl font-semibold text-gray-800"><?= $siguiente_usuario['nombre_usuario']; ?></h2>
                    </div>
                    <div class="flex items-center justify-between mt-6 space-x-4">
                        <!-- Botón "No me gusta" con icono de "X" -->
                        <form action="../admin/Coincidencia/create/op_create.php" method="post">
                            <input type='hidden' name='id_usuario' value='<?= htmlspecialchars($id_usuario) ?>'>
                            <input type="hidden" name="id_usuario_objetivo" value="<?= htmlspecialchars($siguiente_usuario['id']); ?>">
                            <input type="hidden" name="accion" value="no_me_gusta">
                            <input type='hidden' name='url' value='usuario'>
                            <button @click="show = false; setTimeout(() => { show = true }, 500)" class="bg-red-500 text-white p-4 rounded-full shadow-lg transform transition-transform duration-300 hover:bg-red-600 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>


                        <form action="../usuario/chat/" method="post">
                            <input type='hidden' name='id_usuario' value='<?= htmlspecialchars($id_usuario) ?>'>
                            <input type="hidden" name="id_receptor" value="<?= htmlspecialchars($siguiente_usuario['id']); ?>">
                            <input type='hidden' name='url' value='<?= htmlspecialchars($url) ?>'>
                            <button @click="show = false; setTimeout(() => { show = true }, 500)" class="bg-blue-500 text-white p-4 rounded-full shadow-lg transform transition-transform duration-300 hover:bg-blue-600 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                                    <path d="M20 2H4a2 2 0 00-2 2v14l4-4h14a2 2 0 002-2V4a2 2 0 00-2-2zM4 0h16a4 4 0 014 4v10a4 4 0 01-4 4H7l-7 7V4a4 4 0 014-4z"></path>
                                </svg>
                            </button>
                        </form>


                        <form action="../admin/Coincidencia/create/op_create.php" method="post">
                            <input type='hidden' name='id_usuario' value='<?= htmlspecialchars($id_usuario) ?>'>
                            <input type="hidden" name="id_usuario_objetivo" value="<?= htmlspecialchars($siguiente_usuario['id']); ?>">
                            <input type="hidden" name="accion" value="me_gusta">
                            <input type='hidden' name='url' value='usuario'>
                            <button @click="show = false; setTimeout(() => { show = true }, 500)" class="bg-green-500 text-white p-4 rounded-full shadow-lg transform transition-transform duration-300 hover:bg-green-600 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 6.364l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </form>

                    </div>
                <?php else: ?>
                    <p class="text-center text-gray-600">No hay más usuarios disponibles en este momento.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full bg-gray-900 text-white text-center p-4 mt-auto">
        <p>&copy; <?= date("Y"); ?> Tinder Clone. Todos los derechos reservados.</p>
    </footer>


</body>

</html>