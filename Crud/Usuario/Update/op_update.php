<?php
include('../../../assets/config/op_conectar.php');; // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_usuario = $_POST["id_usuario"];
    $nombre_usuario = $_POST["nombre"];
    $correo_usuario = $_POST["email"];
    $contrasena_usuario = $_POST["password"];
    $genero_usuario = $_POST["genero"];
    $biografia_usuario = $_POST["biografia"];
    $page = $_POST["url"];

    try {
        // Obtener la ruta actual de la imagen de perfil
        $consulta = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
        $consulta->execute([$id_usuario]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
        $ruta_imagen_actual = $usuario['foto_perfil'];

        // Verificar si se ha cargado una nueva imagen de perfil
        if (isset($_FILES['foto_perfil_usuario']) && $_FILES['foto_perfil_usuario']['error'] == 0) {
            $directorio_destino = "../../../assets/uploads/"; // Directorio donde se guardarán las imágenes
            $nombre_archivo = basename($_FILES['foto_perfil_usuario']['name']);
            $nueva_ruta_imagen = $directorio_destino . uniqid() . "_" . $nombre_archivo;

            // Mover el archivo subido al directorio destino
            if (move_uploaded_file($_FILES['foto_perfil_usuario']['tmp_name'], $nueva_ruta_imagen)) {
                // Eliminar la imagen anterior si existe y si se ha subido una nueva
                if (!empty($ruta_imagen_actual) && file_exists($ruta_imagen_actual)) {
                    unlink($ruta_imagen_actual);
                }
            } else {
                echo "Error al subir la nueva imagen de perfil.";
                exit();
            }
        } else {
            // Si no se subió una nueva imagen, conservar la imagen actual
            $nueva_ruta_imagen = $ruta_imagen_actual;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    try {
        // Preparar la consulta de actualización
        $consulta = $conexion->prepare("UPDATE usuario SET nombre_usuario=?, correo=?, contrasena=?, genero=?, biografia=?, foto_perfil=? WHERE id=?");

        // Ejecutar la consulta de actualización
        $consulta->execute([$nombre_usuario, $correo_usuario, $contrasena_usuario, $genero_usuario, $biografia_usuario, $nombre_archivo, $id_usuario]);

        if ($page == 'f_update') {
            header("Location: ../index.php");
            exit();
        } elseif ($page == "usuario") {
            header("Location: ../../../index.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este script sin un envío de formulario POST, redireccionar a otra página (opcional)
    header("Location: index.php");
    exit();
}
