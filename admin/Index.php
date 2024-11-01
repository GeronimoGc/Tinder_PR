<?php
include('../assets/config/op_conectar.php'); // Incluye el archivo de conexión

try {
    $listar_usuario = $pdo->prepare("SELECT * FROM usuarios");
    $listar_usuario->execute();
    $resultado_usuario = $listar_usuario->fetchAll(PDO::FETCH_ASSOC);

    $listar_mensaje = $pdo->prepare("SELECT * FROM mensajes");
    $listar_mensaje->execute();
    $resultado_mensaje = $listar_mensaje->fetchAll(PDO::FETCH_ASSOC);

    $listar_foto = $pdo->prepare("SELECT * FROM fotos");
    $listar_foto->execute();
    $resultado_foto = $listar_foto->fetchAll(PDO::FETCH_ASSOC);

    $listar_coincidencia = $pdo->prepare("SELECT * FROM coincidencias");
    $listar_coincidencia->execute();
    $resultado_coincidencia = $listar_coincidencia->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Panel de Administración</title>
    <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/social-media-circle-6/1024/tinder-circle-512.png" type="image/x-icon">
    <?php include("../assets/config/HeadTailwind.php"); ?>
    <script>
        // Función para mostrar la sección según el hash de la URL
        function mostrarSeccion() {
            // Ocultar todas las secciones
            document.querySelectorAll('section').forEach(seccion => seccion.style.display = 'none');

            // Obtener el hash de la URL
            const hash = window.location.hash || '#usuarios';

            // Mostrar la sección correspondiente al hash
            const seccion = document.querySelector(hash);
            if (seccion) {
                seccion.style.display = 'block';
            }
        }

        // Escuchar cambios en el hash
        window.addEventListener('hashchange', mostrarSeccion);

        // Ejecutar al cargar la página
        window.addEventListener('load', mostrarSeccion);
    </script>
</head>

<body class="bg-gray-100 h-screen">

    <!-- Sidebar de navegación -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed top-0 left-0 h-screen">
        <div class="flex items-center justify-center py-4 border-b">
            <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Logo" class="h-12">
            <span class="ml-2 font-semibold text-xl text-gray-700">Admin Panel</span>
        </div>
        <nav class="flex-grow p-4">
            <ul class="space-y-4">
                <li><a href="#usuarios" class="text-gray-600 hover:text-red-500">Usuarios</a></li>
                <li><a href="#mensajes" class="text-gray-600 hover:text-red-500">Mensajes</a></li>
                <li><a href="#fotos" class="text-gray-600 hover:text-red-500">Fotos</a></li>
                <li><a href="#coincidencias" class="text-gray-600 hover:text-red-500">Coincidencias</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="flex-grow p-6 ml-64">

        <section id="usuarios" class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-700">Administrar Usuarios</h2>
            <div class="p-4 h-auto rounded-lg">
                <a href="usuario/create/" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Crear Usuario</a>
            </div>
            <div class="bg-white shadow rounded-lg p-4 max-h-96 overflow-y-auto overflow-x-auto">
                <table class="min-w-full text-xs text-gray-700">
                    <thead class="border-b bg-white">
                        <tr>
                            <th class="py-2 px-2 w-1/12">ID</th>
                            <th class="py-2 px-2 w-2/12">Nombre</th>
                            <th class="py-2 px-2 w-2/12">Correo</th>
                            <th class="py-2 px-2 w-2/12">Contraseña</th>
                            <th class="py-2 px-2 w-1/12">Género</th>
                            <th class="py-2 px-2 w-1/12">Rol</th>
                            <th class="py-2 px-2 w-2/12">Biografía</th>
                            <th class="py-2 px-2 w-1/12">Foto</th>
                            <th class="py-2 px-2 w-2/12">Creación</th>
                            <th class="py-2 px-2 w-1/12" colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado_usuario as $usuario): ?>
                            <tr class="border-b">
                                <td class="py-2 px-2"><?= $usuario['id'] ?></td>
                                <td class="py-2 px-2"><?= $usuario['nombre_usuario'] ?></td>
                                <td class="py-2 px-2"><?= $usuario['correo'] ?></td>
                                <td class="py-2 px-2"><?= $usuario['contrasena'] ?></td>
                                <td class="py-2 px-2"><?= $usuario['genero'] ?></td>
                                <td class="py-2 px-2"><?= $usuario['rol'] ?></td>
                                <td class="py-2 px-2"><?= $usuario['biografia'] ?></td>
                                <td class="py-2 px-2">
                                    <img src="../assets/img/uploads/<?= $usuario['foto_perfil'] ?>" alt="Foto de Perfil" class="w-12 h-12 rounded-full">
                                </td>
                                <td class="py-2 px-2"><?= $usuario['fecha_creacion'] ?></td>
                                <td class="py-2 px-2">
                                    <a href="usuario/update/?id_usuario=<?= $usuario['id'] ?>&url=admin" class="bg-pink-500 text-white px-2 py-1 rounded hover:bg-pink-600 text-xs mb-11">Actualizar</a>
                                </td>
                                <td class="py-2 px-2">
                                    <a href="usuario/drop/?id_usuario=<?= $usuario['id'] ?>&url=admin" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs mb-11">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="mensajes" class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-700">Administrar Mensaje</h2>
            <div class="p-4 h-auto rounded-lg">
                <a href="mensaje/create/" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Crear Mensaje</a>
            </div>
            <div class="bg-white shadow rounded-lg p-4 max-h-96 overflow-y-auto overflow-x-auto">
                <table class="min-w-full text-xs text-gray-700">
                    <thead class="border-b bg-white">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">ID Emisor</th>
                            <th class="px-4 py-2 text-left">ID Receptor</th>
                            <th class="px-4 py-2 text-left">Mensaje</th>
                            <th class="px-4 py-2 text-left">Fecha envio</th>
                            <th class="py-2 px-4" colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado_mensaje as $mensaje): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"><?= $resultado_mensaje["id"] ?></td>
                                <td class="px-4 py-2"><?= $resultado_mensaje["id_emisor"] ?></td>
                                <td class="px-4 py-2"><?= $resultado_mensaje["id_receptor"] ?></td>
                                <td class="px-4 py-2"><?= $resultado_mensaje["mensaje"] ?></td>
                                <td class="px-4 py-2"><?= $resultado_mensaje["fecha_envio"] ?></td>
                                <td class="py-2 px-4">
                                    <a href="mensaje/update/?id_mensaje=<?= $usuario['id'] ?>&url=admin" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Actualizar</a>
                                </td>
                                <td class="py-2 px-4">
                                    <a href="mensaje/Drop/?id_mensaje=<?= $usuario['id'] ?>&url=admin" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="fotos" class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-700">Administrar Fotos</h2>
            <div class="p-4 h-auto rounded-lg">
                <a href="foto/create/" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Crear Fotos</a>
            </div>
            <div class="bg-white shadow rounded-lg p-4 max-h-96 overflow-y-auto overflow-x-auto">
                <table class="min-w-full text-xs text-gray-700">
                    <thead class="border-b bg-white">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">ID Usuario</th>
                            <th class="px-4 py-2 text-left">Nombre Foto</th>
                            <th class="px-4 py-2 text-left">Foto</th>
                            <th class="px-4 py-2 text-left">Fecha subida</th>
                            <th class="py-2 px-4" colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado_foto as $foto): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"><?= $foto["id"] ?></td>
                                <td class="px-4 py-2"><?= $foto["id_usuario"] ?></td>
                                <td class="px-4 py-2"><?= $foto["url_foto"] ?></td>
                                <td class="px-4 py-2">
                                    <img src="../assets/img/uploads/<?= $foto['url_foto'] ?>" alt="Foto" class="w-16 h-16 rounded-full">
                                </td>
                                <td class="px-4 py-2"><?= $foto["fecha_subida"] ?></td>
                                <td class="py-2 px-4">
                                    <a href="foto/update/?id_foto=<?= $foto['id'] ?>&url=admin" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Actualizar</a>
                                </td>
                                <td class="py-2 px-4">
                                    <a href="foto/Drop/?id_foto=<?= $foto['id'] ?>&url=admin" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="coincidencias" class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-gray-700">Administrar Coincidencias</h2>
            <div class="p-4 h-auto rounded-lg">
                <a href="coincidencia/create/" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Crear Coincidencias</a>
            </div>
            <div class="bg-white shadow rounded-lg p-4 max-h-96 overflow-y-auto overflow-x-auto">
                <table class="min-w-full text-xs text-gray-700">
                    <thead class="border-b bg-white">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">ID Usuario</th>
                            <th class="px-4 py-2 text-left">ID Usuario Objetivo</th>
                            <th class="px-4 py-2 text-left">Accion</th>
                            <th class="px-4 py-2 text-left">Fecha Coincidencia</th>
                            <th class="py-2 px-2 w-1/12" colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado_coincidencia as $coincidencia): ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"><?= $coincidencia["id"] ?></td>
                                <td class="px-4 py-2"><?= $coincidencia["id_usuario"] ?></td>
                                <td class="px-4 py-2"><?= $coincidencia["id_usuario_objetivo"] ?></td>
                                <td class="px-4 py-2"><?= $coincidencia["accion"] ?></td>
                                <td class="px-4 py-2"><?= $coincidencia["fecha_coincidencia"] ?></td>
                                <td class="py-2 px-4">
                                    <a href="coincidencia/update/?id_foto=<?= $coincidencia['id'] ?>&url=admin" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Actualizar</a>
                                </td>
                                <td class="py-2 px-4">
                                    <a href="coincidencia/Drop/?id_foto=<?= $coincidencia['id'] ?>&url=admin" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

</body>

</html>

<!-- 
<section id="usuarios" class="mb-8">
    <h2 class="text-2xl font-bold mb-4 text-gray-700">Administrar Usuarios</h2>
    <div class="p-4 h-auto rounded-lg">
        <a href="usuario/create/" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Crear Usuario</a>
    </div>
    <div class="bg-white shadow rounded-lg p-4 max-h-96 overflow-y-auto">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="border-b">
                <tr>
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">Nombre</th>
                    <th class="py-2 px-4">Correo</th>
                    <th class="py-2 px-4">Contraseña</th>
                    <th class="py-2 px-4">Género</th>
                    <th class="py-2 px-4">Rol</th>
                    <th class="py-2 px-4">Biografía</th>
                    <th class="py-2 px-4">Foto de Perfil</th>
                    <th class="py-2 px-4">Fecha de Creación</th>
                    <th class="py-2 px-4" colspan="2">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="bg-white shadow rounded-lg p-4 max-h-96 overflow-y-auto">
        <table class="min-w-full text-sm text-gray-700">
            <tbody>
                <?php foreach ($resultado_usuario as $usuario): ?>
                    <tr class="border-b">
                        <td class="py-2 px-4"><?= $usuario['id'] ?></td>
                        <td class="py-2 px-4"><?= $usuario['nombre_usuario'] ?></td>
                        <td class="py-2 px-4"><?= $usuario['correo'] ?></td>
                        <td class="py-2 px-4"><?= $usuario['contrasena'] ?></td>
                        <td class="py-2 px-4"><?= $usuario['genero'] ?></td>
                        <td class="py-2 px-4"><?= $usuario['rol'] ?></td>
                        <td class="py-2 px-4"><?= $usuario['biografia'] ?></td>
                        <td class="py-2 px-4">
                            <img src="../assets/img/uploads/<?= $usuario['foto_perfil'] ?>" alt="Foto de Perfil" class="w-12 h-12 rounded-full">
                        </td>
                        <td class="py-2 px-4"><?= $usuario['fecha_creacion'] ?></td>
                        <td class="py-2 px-4">
                            <a href="usuario/update/?id_usuario=<?= $usuario['id'] ?>&url=admin" class="bg-pink-500 text-white px-3 py-1 rounded hover:bg-pink-600">Actualizar</a>
                            <a href="usuario/Drop/index.php?id_usuario=<?= $usuario['id'] ?>&url=admin" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section> -->