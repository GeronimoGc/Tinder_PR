<?php
include('../../../assets/config/op_conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id_usuario"];
    $nombre_usuario = $_POST["nombre"];
    $correo_usuario = $_POST["email"];
    $contrasena_usuario = $_POST["password"];
    $genero_usuario = $_POST["genero"];
    $biografia_usuario = $_POST["biografia"];
    $rol_usuario = $_POST["rol"];
    $url = $_POST['url'];

    $directorio_imagenes = "../../../assets/img/uploads/";
    if (!is_dir($directorio_imagenes)) {
        mkdir($directorio_imagenes, 0777, true); // Crear la carpeta si no existe
    }


    // Procesar la imagen de perfil
    // $foto_perfil_usuario = $_FILES["foto_perfil_usuario"];
    // $nombre_imagen =  $foto_perfil_usuario["name"] . $id_usuario;
    // $ruta_imagen = $directorio_imagenes . basename($nombre_imagen);

    $destino = "../../../assets/img/uploads/";
    $foto_perfil_usuario = basename($_FILES['foto_perfil_usuario']['name']);
    $img0 = $destino . $id_usuario . "_" . $nombre_archivo;
    $img = $id_usuario . "_" . $nombre_archivo;


    // Mover la imagen a la carpeta especificada
    if (move_uploaded_file($foto_perfil_usuario["tmp_name"], $ruta_imagen)) {
        echo "La imagen de perfil se ha subido correctamente.<br>";
        echo "$ruta_imagen";
    } else {
        echo "Hubo un error al subir la imagen de perfil.<br>";
    }



    try {
        $consulta = $pdo->prepare("INSERT INTO usuarios(nombre_usuario, correo, contrasena, genero, rol, biografia, foto_perfil) VALUES (?,?,?,?,?,?,?)");
        $consulta->execute([$nombre_usuario, $correo_usuario, $contrasena_usuario, $genero_usuario, $rol_usuario, $biografia_usuario, $img]);

        $filas_afectadas = $consulta->rowCount();

        if ($filas_afectadas > 0) {
            echo "Inserción exitosa";
            // Redirigir a una página de éxito
            if ($url == "admin") {
                header("Location: ../../");
            } elseif ($url == "usuario") {
                header("Location: ../../../");
            }
            exit(); // Asegura que el script se detenga después de la redirección
        } else {
            echo "No se pudo insertar el usuario";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este script sin un envío de formulario POST, redireccionar a otra página (opcional)
    header("Location: ../../../");
    exit();
}
