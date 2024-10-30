<?php
include("../assets/config/op_conectar.php");


$id_usuario = $_POST['id_usuario'];

echo "$id_usuario";

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
    <title>Tinder - Match</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/social-media-circle-6/1024/tinder-circle-512.png" type="image/x-icon">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto mt-10">

        <h1 class="text-3xl font-bold text-center">Encuentra tu match</h1>

        <!-- Mostrar la imagen y datos del próximo usuario -->
        <div class="flex justify-center items-center mt-10">
            <?php if ($siguiente_usuario): ?>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <img src="<?php echo $siguiente_usuario['foto_perfil']; ?>" alt="Foto de perfil" class="w-48 h-48 rounded-full mx-auto">
                    <h2 class="text-2xl mt-4"><?php echo $siguiente_usuario['nombre_usuario']; ?></h2>

                    <div class="mt-6">
                        <button id="me_gusta" class="bg-green-500 text-white px-6 py-2 rounded-md">Me gusta</button>
                        <button id="no_me_gusta" class="bg-red-500 text-white px-6 py-2 rounded-md">No me gusta</button>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-xl">No hay más usuarios disponibles.</p>
            <?php endif; ?>
        </div>

        <!-- Mostrar la lista de usuarios aceptados -->
        <h2 class="text-2xl font-bold mt-10">Usuarios aceptados:</h2>
        <div class="grid grid-cols-3 gap-4 mt-6">
            <?php foreach ($usuarios_aceptados as $aceptado): ?>
                <div class="bg-white shadow-md rounded-lg p-4 text-center">
                    <img src="<?php echo $aceptado['foto_perfil']; ?>" alt="Foto de perfil" class="w-24 h-24 rounded-full mx-auto">
                    <p class="mt-2"><?php echo $aceptado['nombre_usuario']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Script para manejar el "me gusta" o "no me gusta" con AJAX -->
    <script>
        $(document).ready(function() {
            $('#me_gusta, #no_me_gusta').click(function() {
                var accion = $(this).attr('id'); // me_gusta o no_me_gusta
                $.ajax({
                    url: 'procesar_accion.php',
                    type: 'POST',
                    data: {
                        id_usuario: <?php echo $id_usuario; ?>,
                        id_usuario_objetivo: <?php echo $siguiente_usuario['id']; ?>,
                        accion: accion
                    },
                    success: function(response) {
                        location.reload(); // Recargar la página para mostrar el siguiente usuario
                    }
                });
            });
        });
    </script>
</body>

</html>