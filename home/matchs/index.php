<?php
session_start();
include("../../assets/config/op_conectar.php");

$id_usuario = $_POST['id_usuario'];


// Verificar que el usuario está autenticado
if (!isset($_POST['id_usuario']) || $_POST['id_usuario'] == 0) {
    header("Location: ../../login/");
    exit();
}


// Obtener información del usuario autenticado para mostrar en el encabezado
$consulta_usuario = $pdo->prepare("SELECT nombre_usuario, foto_perfil FROM usuarios WHERE id = :id_usuario");
$consulta_usuario->execute([':id_usuario' => $id_usuario]);
$usuario_actual = $consulta_usuario->fetch(PDO::FETCH_ASSOC);

// Obtener Match Completado (coincidencias mutuas)
$sql_match_completado = "
    SELECT u.id, u.nombre_usuario, u.biografia, u.foto_perfil
    FROM coincidencias c1
    INNER JOIN coincidencias c2 ON c1.id_usuario = c2.id_usuario_objetivo AND c1.id_usuario_objetivo = c2.id_usuario
    INNER JOIN usuarios u ON u.id = c1.id_usuario_objetivo
    WHERE c1.id_usuario = :id_usuario_actual AND c1.accion = 'me_gusta' AND c2.accion = 'me_gusta'
";
$stmt = $pdo->prepare($sql_match_completado);
$stmt->execute(['id_usuario_actual' => $id_usuario]);
$matches_completados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener Match Enviado (gente a la que este usuario dio "me gusta")
$sql_match_enviado = "
    SELECT c.id as id_coincidencia, u.id, u.nombre_usuario, u.biografia, u.foto_perfil
    FROM coincidencias c
    INNER JOIN usuarios u ON u.id = c.id_usuario_objetivo
    WHERE c.id_usuario = :id_usuario_actual AND c.accion = 'me_gusta'
";
$stmt = $pdo->prepare($sql_match_enviado);
$stmt->execute(['id_usuario_actual' => $id_usuario]);
$matches_enviados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener Match Recibido (gente que dio "me gusta" a este usuario)
$sql_match_recibido = "
    SELECT u.id, u.nombre_usuario, u.biografia, u.foto_perfil
    FROM coincidencias c
    INNER JOIN usuarios u ON u.id = c.id_usuario
    WHERE c.id_usuario_objetivo = :id_usuario_actual AND c.accion = 'me_gusta'
";
$stmt = $pdo->prepare($sql_match_recibido);
$stmt->execute(['id_usuario_actual' => $id_usuario]);
$matches_recibidos = $stmt->fetchAll(PDO::FETCH_ASSOC);









?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tinder | Pagina Matchs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php include("../../assets/config/HeadTailwind.php"); ?>
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

<body class="bg-gray-100 min-h-screen flex flex-col items-center" x-data="{ sidebarOpen: false }">

    <!-- Encabezado -->
    <header class="w-full bg-pink-600 p-4 flex items-center justify-between relative">
        <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Tinder Logo" class="h-10">

        <form action="../../usuario/Perfil/" method="post">
            <input type='hidden' name='id_usuario' value='<?= $id_usuario ?>'>
            <input type='hidden' name='url' value='<?= $url ?>'>
            <button href="../../Usuario/Perfil/">
                <div class="flex items-center space-x-4 p-4 bg-black-400 rounded-lg shadow-lg h-14">
                    <!-- Icono de fuego antes de la foto -->
                    <img src="https://static.vecteezy.com/system/resources/previews/023/986/672/non_2x/tinder-app-logo-tinder-app-logo-transparent-tinder-app-icon-transparent-free-free-png.png" alt="Tinder Logo" class="h-10">

                    <!-- Imagen y nombre dentro del cuadro blando -->
                    <div class="flex items-center space-x-4">
                        <img class="w-14 h-14 rounded-full border-2 border-gray-600" src="../../assets/img/uploads/<?= $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil">
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

    <main class="flex-grow container mx-auto px-6 py-8">
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
                    <img class="w-10 h-20 w-auto rounded-full mx-auto mb-1" src="../../assets/img/uploads/<?= $usuario_actual['foto_perfil']; ?>" alt="Foto de perfil">
                    <p class="text-lg font-semibold text-black"><?= $usuario_actual['nombre_usuario']; ?></p>
                </div>


                <form action="../" method="post">
                    <input type='hidden' name='id_usuario' value='<?= htmlspecialchars($id_usuario) ?>'>
                    <input type="hidden" name="id_receptor" value="0">
                    <input type='hidden' name='url' value='<?= htmlspecialchars($url) ?>'>
                    <button href="../" class="w-full text-center bg-pink-500 text-white py-2 rounded-lg hover:bg-pink-600">
                        <span>volver</span>
                    </button>


                    <!-- Opcion es de navegación -->
                    <nav class="space-y-4">


                        <a href="../../" class="flex items-center space-x-3 text-gray-600 hover:bg-gray-200 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 13v-2H7V9l-5 5 5 5v-3h9z" />
                            </svg>
                            <span class="text-red-500">Cerrar sesión</span>
                        </a>



                    </nav>

            </div>
        </div>


        <div class="container mx-auto p-4">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Match Completado -->
                <div class="w-full lg:w-1/3">
                    <h2 class="text-xl font-bold mb-4 text-center">Match Completado</h2>
                    <div class="bg-white rounded-lg shadow-md p-4 space-y-4">
                        <?php foreach ($matches_completados as $match): ?>
                            <div class="flex items-center justify-between space-x-4">
                                <div class="flex items-center space-x-4">
                                    <img src="../../assets/img/uploads/<?= htmlspecialchars($match['foto_perfil']) ?>" alt="Foto" class="w-12 h-12 rounded-full">
                                    <div>
                                        <h3 class="font-semibold"><?= htmlspecialchars($match['nombre_usuario']) ?></h3>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($match['biografia']) ?></p>
                                    </div>
                                </div>
                                <form action="../../usuario/chat/" method="post" display="hidden">
                                    <input type='hidden' name='id_usuario' value='<?= htmlspecialchars($id_usuario) ?>'>
                                    <input type="hidden" name="id_receptor" value="<?= htmlspecialchars($match['id']) ?>">
                                </form>
                                <form method="POST" action="../../Usuario/chat/">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
                                    <input type="hidden" name="id_receptor" value="<?= htmlspecialchars($match['id']) ?>">
                                    <button class="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                                            <path d="M20 2H4a2 2 0 00-2 2v14l4-4h14a2 2 0 002-2V4a2 2 0 00-2-2zM4 0h16a4 4 0 014 4v10a4 4 0 01-4 4H7l-7 7V4a4 4 0 014-4z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Match Enviado -->
                <div class="w-full lg:w-1/3">
                    <h2 class="text-xl font-bold mb-4 text-center">Match Enviado</h2>
                    <div class="bg-white rounded-lg shadow-md p-4 space-y-4">
                        <?php foreach ($matches_enviados as $match): ?>
                            <div class="flex items-center justify-between space-x-4">
                                <div class="flex items-center space-x-4">
                                    <img src="../../assets/img/uploads/<?= htmlspecialchars($match['foto_perfil']) ?>" alt="Foto" class="w-12 h-12 rounded-full">
                                    <div>
                                        <h3 class="font-semibold"><?= htmlspecialchars($match['nombre_usuario']) ?></h3>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($match['biografia']) ?></p>
                                    </div>
                                </div>
                                <form method="POST" action="op_drop.php">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
                                    <input type="hidden" name="id" value="<?= $match['id_coincidencia'] ?>">
                                    <input type="hidden" name="accion" value="me_gusta">
                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Eliminar</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Match Recibido -->
                <div class="w-full lg:w-1/3">
                    <h2 class="text-xl font-bold mb-4 text-center">Match Recibido</h2>
                    <div class="bg-white rounded-lg shadow-md p-4 space-y-4">
                        <?php foreach ($matches_recibidos as $match): ?>
                            <div class="flex items-center justify-between space-x-4">
                                <div class="flex items-center space-x-4">
                                    <img src="../../assets/img/uploads/<?= htmlspecialchars($match['foto_perfil']) ?>" alt="Foto" class="w-12 h-12 rounded-full">
                                    <div>
                                        <h3 class="font-semibold"><?= htmlspecialchars($match['nombre_usuario']) ?></h3>
                                        <p class="text-sm text-gray-600"><?= htmlspecialchars($match['biografia']) ?></p>
                                    </div>
                                </div>
                                <form method="POST" action="op_create.php">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
                                    <input type="hidden" name="id_usuario_objetivo" value="<?= $match['id'] ?>">
                                    <input type="hidden" name="accion" value="me_gusta">
                                    <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Me gusta</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>





    </main>
    <!-- Pie de página -->
    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2024 Sistema de Matchs. Todos los derechos reservados.</p>
    </footer>
</body>

</html>