<?php
include('../../../assets/config/op_conectar.php'); // Incluye el archivo de conexión


$id_admin = $_POST["id_admin"];
$url = $_POST['url'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $id_usuario = $_POST["id_usuario"];
    $nombre_usuario = $_POST["nombre"];
    $correo_usuario = $_POST["email"];
    $contrasena_usuario = $_POST["password"];
    $genero_usuario = $_POST["genero"];
    $biografia_usuario = $_POST["biografia"];
    $rol_usuario = $_POST["rol"];


    $directorio_imagenes = "../../../assets/img/uploads/";
    if (!is_dir($directorio_imagenes)) {
        mkdir($directorio_imagenes, 0777, true); 
    }

    $nombre_archivo = basename($_FILES['foto_perfil_usuario']['name']);
    $img0 = $directorio_imagenes . $nombre_usuario . "_" . $rol_usuario . "_" . $nombre_archivo;
    $img = $nombre_usuario . "_" . $rol_usuario . "_" . $nombre_archivo;


    if (!move_uploaded_file($_FILES['foto_perfil_usuario']['tmp_name'], $img0)) {

        die("Hubo un error al subir la imagen de perfil.");
    }

    try {
        $consulta = $pdo->prepare("INSERT INTO usuarios(nombre_usuario, correo, contrasena, genero, rol, biografia, foto_perfil) VALUES (?,?,?,?,?,?,?)");
        $consulta->execute([$nombre_usuario, $correo_usuario, $contrasena_usuario, $genero_usuario, $rol_usuario, $biografia_usuario, $img]);

        $filas_afectadas = $consulta->rowCount();

        if ($filas_afectadas > 0) {
            if ($url == 'admin') {
                echo "
                <form id='redirectForm' action='../../' method='POST' style='display: none;'>
                    <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_admin) . "'>
                    <input type='hidden' name='url' value='" . htmlspecialchars($url) . "'>
                </form>
                <script>
                    document.getElementById('redirectForm').submit();
                </script>";
                exit();
            }
        } else {
            die("No se pudo insertar el usuario.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: ../../../");
    exit();
}
