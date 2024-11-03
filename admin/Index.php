<?php
include('../assets/config/op_conectar.php');
// include('../assets/config/op_validar.php');

$id_usuario = $_POST['id_usuario'];
$url = $_POST['url'];

    if ($url == 'admin') {
        $consulta_Admin = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $consulta_Admin->execute([$id_usuario]);
        $resultado_admin = $consulta_Admin->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "
        <form id='redirectForm' action='../../home/' method='POST'>
            <input type='hidden' name='id_usuario' value='$id_usuario'>
            <input type='hidden' name='url' value='$url'>
        </form>
        <script>
            document.getElementById('redirectForm').submit();
        </script>";
        exit();
    }

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

<body class="bg-gray-100 h-screen overflow-y-hidden">

    <header class="w-full bg-white border-b border-gray-200 fixed top-0 left-0 z-10 flex justify-between items-center h-20 px-6 shadow-sm">
        <div class="flex items-center space-x-4">
            <img src="https://logo-marque.com/wp-content/uploads/2020/09/Tinder-Logo.png" alt="Logo" class="h-8">
            <span class="font-semibold text-lg text-gray-700">Panel de Administración</span>
        </div>

        <div class="flex items-center space-x-20">
            <div class="flex items-center space-x-4">
                <a href="../home/" class="text-gray-600 hover:text-red-500">Home</a>
                <a href="../login/" class="text-gray-600 hover:text-red-500">Cerrar Sesión</a>
            </div>
            <div class="flex items-center space-x-4">

                <?php if (isset($resultado_admin['nombre_usuario']) && !empty($resultado_admin['nombre_usuario'])) : ?>
                    <p><?= $resultado_admin['nombre_usuario']  ?></p>
                <?php else : ?>
                    <p>Usuario Admin</p>
                <?php endif; ?>

                <?php if (isset($resultado_admin['foto_perfil']) && !empty($resultado_admin['foto_perfil'])) : ?>
                    <img src='../assets/img/uploads/<?= $resultado_admin['foto_perfil'] ?>' alt="Imagen de perfil" class="h-12 w-12 rounded-full object-cover" />
                <?php else : ?>
                    <img src='../assets/img/user-default.jpg' alt="Imagen de perfil predeterminada" class="h-12 w-12 rounded-full object-cover" />
                <?php endif; ?>
            </div>
        </div>
    </header>

    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed top-0 left-0 h-screen">

        <nav class="flex-grow p-4 mt-20">
            <ul class="space-y-4">
                <li><a href="#usuarios" class="text-gray-600 hover:text-red-500">Usuarios</a></li>
                <li><a href="#mensajes" class="text-gray-600 hover:text-red-500">Mensajes</a></li>
                <li><a href="#fotos" class="text-gray-600 hover:text-red-500">Fotos</a></li>
                <li><a href="#coincidencias" class="text-gray-600 hover:text-red-500">Coincidencias</a></li>
            </ul>
        </nav>

    </aside>

    <main class="flex-grow p-6 ml-64 mt-16">

        <section id="usuarios" class="">
            <h2 class="text-2xl font-bold mb-4 text-gray-700">Administrar Usuarios</h2>
            <div class="p-4 h-auto rounded-lg">
                <form id='redirectForm' action='usuario/create/' method='POST'>
                    <input type="hidden" name='id_admin' value='<?= $id_usuario ?>'>
                    <input type='hidden' name='url' value='<?= $url ?>'>
                    <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Crear Usuario</button>
                </form>
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
                                    <form id='redirectForm' action='usuario/Update/' method='POST'>
                                        <input type='hidden' name='id_usuario' value='<?= $usuario['id'] ?>'>
                                        <input type='hidden' name='url' value='<?= $url ?>'>
                                        <button type="submit" class="bg-pink-500 text-white px-2 py-1 rounded hover:bg-pink-600 text-xs mb-11">Actualizar</button>
                                    </form>
                                </td>
                                <td class="py-2 px-2">
                                    <form id='redirectForm' action='usuario/drop/' method='POST'>
                                        <input type="hidden" name='id_admin' value='<?= $id_usuario ?>'>
                                        <input type='hidden' name='id_usuario' value='<?= $usuario['id'] ?>'>
                                        <input type='hidden' name='url' value='<?= $url ?>'>
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 text-xs mb-11">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="mensajes" class="">
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

        <section id="fotos" class="">
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

        <section id="coincidencias" class="">
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