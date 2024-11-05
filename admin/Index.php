<?php
include('../assets/config/op_conectar.php');
// include('../assets/config/op_validar.php');

$id_usuario = $_POST['id_usuario'];
$url = $_POST['url'];

if ($url == 'admin') {
    $consulta_Admin = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $consulta_Admin->execute([$id_usuario]);
    $resultado_admin = $consulta_Admin->fetch(PDO::FETCH_ASSOC);
} elseif ($url == "usuario") { {
        echo "
            <form id='redirectForm' action='../home/' method='POST'>
                <input type='hidden' name='id_usuario' value='$id_usuario'>
                <input type='hidden' name='url' value='$url'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>";
        exit();
    }
} else {
    header("Location: ../");
}

try {
    $listar_usuario = $pdo->prepare("SELECT * FROM usuarios");
    $listar_usuario->execute();
    $resultado_usuario = $listar_usuario->fetchAll(PDO::FETCH_ASSOC);

    $listar_mensaje = $pdo->prepare("SELECT mensajes.id, user_emisor.nombre_usuario AS nombre_emisor, mensajes.id_emisor, user_receptor.nombre_usuario AS nombre_receptor, mensajes.id_receptor, mensajes.mensaje, mensajes.fecha_envio
FROM mensajes 
JOIN usuarios user_emisor ON mensajes.id_emisor = user_emisor.id
JOIN usuarios user_receptor ON mensajes.id_receptor = user_receptor.id;
");
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
                <button id="openModal" class="px-4 py-2 text-white bg-pink-600 rounded-lg hover:bg-pink-700">Crear Cuenta</button>
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
                                        <input type="hidden" name='id_admin' value='<?= $id_usuario ?>'>
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
            <h2 class="text-2xl font-bold mb-4 text-gray-700">Administrar Mensajes</h2>
            <div class="p-4 h-auto rounded-lg">
                <button onclick="abrirModal()" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Crear mensajes modal</button>
            </div>
            <div class="bg-white shadow rounded-lg p-4 max-h-96 overflow-y-auto overflow-x-auto">
                <table class="min-w-full text-xs text-gray-700">
                    <thead class="border-b bg-white">
                        <tr>
                            <th class="py-2 px-2 w-1/12">ID</th>
                            <th class="py-2 px-2 w-2/12">ID Emisor</th>
                            <th class="py-2 px-2 w-2/12">ID Receptor</th>
                            <th class="py-2 px-2 w-2/12">Mensaje</th>
                            <th class="py-2 px-2 w-1/12">Fecha Envio</th>
                            <th class="py-2 px-2 w-1/12" colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado_mensaje as $mensaje): ?>
                            <tr class="border-b">
                                <td class="py-2 px-2"><?= $mensaje['id'] ?></td>
                                <td class="py-2 px-2">
                                    <p class="pl-2"><?= $mensaje['id_emisor'] ?></p>
                                    <p><?= $mensaje['nombre_emisor']; ?></p>
                                </td>
                                <td class="py-2 px-2">
                                    <p><?= $mensaje['id_receptor'] ?></p>
                                    <p><?= $mensaje['nombre_receptor'] ?></p>
                                </td>
                                <td class="py-2 px-2"><?= $mensaje['mensaje'] ?></td>
                                <td class="py-2 px-2"><?= $mensaje['fecha_envio'] ?></td>
                                <td class="py-2 px-2">
                                    <form id='redirectForm' action='mensaje/Update/' method='POST'>
                                        <input type="hidden" name='id_admin' value='<?= $id_usuario ?>'>
                                        <input type='hidden' name='id_mensaje' value='<?= $mensaje['id'] ?>'>
                                        <input type='hidden' name='url' value='<?= $url ?>'>
                                        <button type="submit" class="bg-pink-500 text-white px-2 py-1 rounded hover:bg-pink-600 text-xs mb-11">Actualizar</button>
                                    </form>
                                </td>
                                <td class="py-2 px-2">
                                    <form id='redirectForm' action='mensaje/drop/' method='POST'>
                                        <input type="hidden" name='id_admin' value='<?= $id_usuario ?>'>
                                        <input type='hidden' name='id_mensaje' value='<?= $mensaje['id'] ?>'>
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


    <!-- Modal -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden z-50 ">
        <div>
            <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg h-screen overscroll-contain overflow-auto ">
                <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">Crea tu cuenta en Tinder</h2>

                <form action="op_create.php" method="POST" enctype="multipart/form-data">
                    <div class="flex">
                        <input type="hidden" name="url" value="<?= $url; ?>">
                        <input type="hidden" name="id_admin" value="<?= $id_admin; ?>">
                        <!-- Nombre -->
                        <label for="nombre" class="block text-sm font-semibold text-gray-700">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>
                    </div>
                    <!-- Correo Electrónico -->
                    <label for="email" class="block text-sm font-semibold text-gray-700">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>

                    <!-- Contraseña -->
                    <label for="password" class="block text-sm font-semibold text-gray-700">Contraseña</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>

                    <!-- Género -->
                    <label for="genero" class="block text-sm font-semibold text-gray-700">Género</label>
                    <select name="genero" id="genero" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>
                        <option value="" disabled selected>elige</option>
                        <option value="1">Masculino</option>
                        <option value="2">Femenino</option>
                        <option value="3">Otro</option>
                    </select>

                    <label for="rol" class="block text-sm font-semibold text-gray-700">Rol</label>
                    <select name="rol" id="rol" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>
                        <option value="" disabled selected>elige</option>
                        <option value="admin">Admin</option>
                        <option value="usuario">Usuario</option>
                        <!-- <option value="visita">Visita</option>
                    <option value="otro">Otro</option> -->
                    </select>

                    <!-- Biografía -->
                    <label for="biografia" class="block text-sm font-semibold text-gray-700">Biografía</label>
                    <textarea name="biografia" id="biografia" rows="3" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" placeholder="Cuenta un poco sobre ti..."></textarea>

                    <!-- Foto de Perfil -->
                    <label for="foto_perfil_usuario" class="block text-sm font-semibold text-gray-700">Foto de Perfil</label>
                    <input type="file" name="foto_perfil_usuario" id="foto_perfil_usuario" class="w-full px-4 py-2 mb-6 text-gray-700 border rounded-lg cursor-pointer focus:outline-none focus:border-pink-500" required>

                    <!-- Botón de Registro -->
                    <button type="submit" class="w-full py-2 text-white bg-pink-600 rounded-lg hover:bg-pink-700">Registrarse</button>
                </form>

                <!-- Botón para cerrar el modal -->
                <button id="closeModal" class="mt-4 w-full py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        // Obtener los elementos del modal y los botones
        const modal = document.getElementById('modal');
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');

        // Función para abrir el modal
        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        // Función para cerrar el modal
        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Cerrar el modal al hacer clic fuera de él
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>


</body>

</html>