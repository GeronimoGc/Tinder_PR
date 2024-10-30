<?php
include('../../assets/config/op_conectar.php'); // Incluye el archivo de conexión

try {
    $listar_usuario = $pdo->prepare("SELECT * FROM usuarios");
    $listar_usuario->execute();
    $resultado = $listar_usuario->fetchAll(PDO::FETCH_ASSOC);

    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Lista de Usuarios</title>
        <script src='https://cdn.tailwindcss.com'></script>
    </head>
    <body class='bg-pink-100 flex items-center justify-center min-h-screen'>
        <div class='w-full max-w-5xl p-6 bg-white rounded-lg shadow-lg'>
            <h1 class='text-3xl font-bold text-pink-600 text-center mb-6'>Lista de Usuarios</h1>
            <a href='create/f_create.php' class='text-white bg-pink-600 hover:bg-pink-700 px-4 py-2 rounded-md mb-4 inline-block'>Crear Usuario</a>
            <div class='overflow-x-auto'>
                <table class='w-full text-left border border-gray-200 rounded-lg'>
                    <thead class='bg-pink-500 text-white'>
                        <tr>
                            <th class='py-2 px-4'>ID</th>
                            <th class='py-2 px-4'>Nombre</th>
                            <th class='py-2 px-4'>Correo</th>
                            <th class='py-2 px-4'>Género</th>
                            <th class='py-2 px-4'>Biografía</th>
                            <th class='py-2 px-4'>Foto de Perfil</th>
                            <th class='py-2 px-4'>Fecha de Creación</th>
                            <th class='py-2 px-4' colspan='2'>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class='bg-white divide-y divide-gray-200'>";

    foreach ($resultado as $usuario) {
        echo "<tr class='hover:bg-pink-100'>";
                echo "<td class='py-2 px-4'>" . $usuario['id'] . "</td>";
                echo "<td class='py-2 px-4'>" . $usuario['nombre_usuario'] . "</td>";
                echo "<td class='py-2 px-4'>" . $usuario['correo'] . "</td>";
                echo "<td class='py-2 px-4'>" . $usuario['genero'] . "</td>";
                echo "<td class='py-2 px-4'>" . $usuario['biografia'] . "</td>";
        echo "<td class='py-2 px-4'>
                    <img src='../../assets/img/uploads/" . $usuario['foto_perfil'] . "' alt='Foto de Perfil' class='w-16 h-16 rounded-full'>
                </td>";
        echo " <td class='py-2 px-4'>" . $usuario['fecha_creacion'] . "</td>";
        echo "<td class='py-2 px-4'>
                    <a href='update/f_update.php?id_usuario=" . $usuario['id'] . "' class='text-pink-600 hover:underline'>Actualizar</a>
                </td>";
        echo "<td class='py-2 px-4'>
                    <a href='Drop/op_drop.php?id_usuario=" . $usuario['id'] . "&url=drop_usuario' class='text-red-600 hover:underline'>Eliminar</a>
                </td>";
        echo "</tr>";
    }

    echo "</tbody>
                </table>
            </div>
        </div>
    </body>
    </html>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

