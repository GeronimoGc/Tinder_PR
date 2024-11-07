<?php
include('../../../assets/config/op_conectar.php'); // Incluye el archivo de conexión


$id_admin = $_POST["id_admin"];
$url = $_POST['url'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

$id_usuario = $_POST['id_usuario'];
$foto = $_POST['foto'];


    $directorio_imagenes = "../../../assets/img/uploads/users/fotos/";
    if (!is_dir($directorio_imagenes)) {
        mkdir($directorio_imagenes, 0777, true);
    }

    $nombre_archivo = basename($_FILES['foto']['name']);
    $img =   $id_usuario . "_" . $nombre_archivo;
    $img0 = $directorio_imagenes . $img;
    


    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $img0)) {

        die("Hubo un error al subir la imagen de perfil.");
    }

    try {
        $consulta = $pdo->prepare("INSERT INTO fotos(id_usuario, url_foto) VALUES (?,?)");
        $consulta->execute([$id_usuario, $img]);

        $filas_afectadas = $consulta->rowCount();

        if ($filas_afectadas > 0) {
            if ($url == 'admin') {
                echo "
                <form id='redirectForm' action='../../#fotos' method='POST' style='display: none;'>
                    <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_admin) . "'>
                    <input type='hidden' name='url' value='" . htmlspecialchars($url) . "'>
                </form>
                <script>
                    document.getElementById('redirectForm').submit();
                </script>";
                exit();
            } else {
                header("Location: ../../../");
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
