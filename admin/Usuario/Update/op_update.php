<?php
include('../../../assets/config/op_conectar.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id_usuario"];
    $nombre_usuario = $_POST["nombre_usuario"];
    $correo_usuario = $_POST["email"];
    $contrasena_usuario = $_POST["password"];
    $genero_usuario = $_POST["genero"];
    $biografia_usuario = $_POST["biografia"];
    $page = $_POST["url"];

    try {
        $consulta = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
        $consulta->execute([$id_usuario]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
        $ruta_imagen_actual = $usuario['foto_perfil'];

        if (isset($_FILES['foto_perfil_usuario']) && $_FILES['foto_perfil_usuario']['error'] == 0) {
            $destino = "../../../assets/img/uploads/";
            $nombre_archivo = basename($_FILES['foto_perfil_usuario']['name']);
            $ruta_foto_nueva = $destino . $id_usuario . "_" . $nombre_archivo;
            $img = $id_usuario . "_" . $nombre_archivo;

            // Mover el archivo subido al directorio destino
            if (move_uploaded_file($_FILES['foto_perfil_usuario']['tmp_name'], $ruta_foto_nueva)) {
                // Eliminar la imagen anterior si existe y es diferente de la nueva
                if (!empty($destino . $ruta_imagen_actual) && file_exists($destino . $ruta_imagen_actual)) {
                    unlink($destino . $ruta_imagen_actual);
                }
            } else {
                echo "Error al subir la nueva imagen de perfil.";
                exit();
            }
        } else {
            // Si no se subió una nueva imagen, conservar la imagen actual
            $img = $ruta_imagen_actual;
        }

        // Preparar consulta de actualización
        $consulta = $pdo->prepare("UPDATE usuarios SET nombre_usuario = ?, correo = ?, genero = ?, biografia = ?, foto_perfil = ? WHERE id = ?");

        // Encriptar la contraseña si se proporciona una nueva
        if (!empty($contrasena_usuario)) {
            $consulta_contrasena = $pdo->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
            $consulta_contrasena->execute([$contrasena_usuario, $id_usuario]);
        }

        // Ejecutar la consulta de actualización para otros datos
        $consulta->execute([$nombre_usuario, $correo_usuario, $genero_usuario, $biografia_usuario, $img, $id_usuario]);

        // Redirigir después de la actualización
        if ($page == 'admin') {
            header("Location: ../../");
        } elseif ($page == "usuario") {
            header("Location: ../../../");
        }
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../../../");
    exit();
}
