<?php
session_start();
include("../assets/config/op_conectar.php");

// Verificar que el usuario está autenticado
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] == 0) {
    header("Location: ../login/");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

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
    <title>Swipe Card</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.2.4/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen space-y-10">

    <!-- Tarjeta del siguiente usuario -->
    <div class="max-w-sm w-full bg-white rounded-lg shadow-lg p-6 relative" x-data="{ show: true }" x-show="show">
        <?php if ($siguiente_usuario): ?>
            <div class="relative h-64 w-full rounded-lg overflow-hidden mb-4">
                <img class="w-full h-full object-cover" src="<?php echo $siguiente_usuario['foto_perfil']; ?>" alt="Foto de perfil">
            </div>
            <div class="text-center">
                <h2 class="text-2xl font-semibold text-gray-800"><?php echo $siguiente_usuario['nombre_usuario']; ?></h2>
            </div>
            <div class="flex items-center justify-between mt-6 space-x-4">
                <button @click="likeOrDislike('no_me_gusta')" class="bg-red-500 text-white p-4 rounded-full shadow-lg transform transition duration-300 hover:bg-red-600 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <button @click="likeOrDislike('me_gusta')" class="bg-green-500 text-white p-4 rounded-full shadow-lg transform transition duration-300 hover:bg-green-600 hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>
        <?php else: ?>
            <p class="text-center text-xl">No hay más usuarios disponibles.</p>
        <?php endif; ?>
    </div>

    <!-- Lista de usuarios aceptados -->
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Usuarios aceptados:</h2>
        <div class="grid grid-cols-3 gap-4">
            <?php foreach ($usuarios_aceptados as $aceptado): ?>
                <div class="text-center">
                    <img class="w-16 h-16 rounded-full object-cover mx-auto" src="<?php echo $aceptado['foto_perfil']; ?>" alt="Foto de perfil">
                    <p class="text-gray-700 mt-2"><?php echo $aceptado['nombre_usuario']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function likeOrDislike(action) {
            $.ajax({
                url: 'procesar_accion.php',
                type: 'POST',
                data: {
                    id_usuario: <?php echo $id_usuario; ?>,
                    id_usuario_objetivo: <?php echo $siguiente_usuario ? $siguiente_usuario['id'] : 0; ?>,
                    accion: action
                },
                success: function(response) {
                    // Recargar la tarjeta del siguiente usuario
                    location.reload();
                }
            });
        }
    </script>

</body>
</html>
