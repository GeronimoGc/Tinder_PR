<?php
include('../../../assets/config/op_conectar.php');

$id_admin = $_POST['id_admin'];
$url = $_POST["url"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_usuario = $_POST['id_usuario'];
    $id_foto = $_POST['id_foto'];

    try {
        $consulta = $pdo->prepare("SELECT url_foto FROM fotos WHERE id = ?");
        $consulta->execute([$id_usuario]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
        $ruta_imagen_actual = $usuario['foto_perfil'];


        if (isset($_FILES['nueva_foto']) && $_FILES['nueva_foto']['error'] === UPLOAD_ERR_OK) {
            $destino = "../../../assets/img/uploads/users/fotos/";
            $nombre_archivo = basename($_FILES['nueva_foto']['name']);
            $img = $id_usuario . "_" . $id_foto  . "_"  . $nombre_archivo;


            $ruta_foto_nueva = $destino . $img;

            // Intentar mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($_FILES['nueva_foto']['tmp_name'], $ruta_foto_nueva)) {
                // Eliminar la imagen anterior si existe y es diferente de la nueva
                if (!empty($ruta_imagen_actual) && file_exists($destino . $ruta_imagen_actual) && $ruta_imagen_actual != $img) {
                    if (!unlink($destino . $ruta_imagen_actual)) {
                        echo "Error al eliminar la imagen anterior.";
                        exit();
                    }
                }
            } else {
                echo "Error al subir la nueva imagen de perfil.";
                exit();
            }
        } else {
            // Si no se subió una nueva imagen, mantener la imagen actual
            $img = $ruta_imagen_actual;
        }

        // Actualizar la información en la base de datos
        $consulta = $pdo->prepare("UPDATE fotos SET id_usuario = ?, url_foto = ? WHERE id = ?");
        $consulta->execute([$id_usuario, $img, $id_foto]);


        if ($url == 'admin') {
            echo "
            <form id='redirectForm' action='../../#fotos' method='POST' style='display: none;'>
                <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_admin) .  "'>
                <input type='hidden' name='url' value='" . htmlspecialchars($url) . "'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>";
            exit();
        } elseif ($url == "usuario") {
            echo "
                <form id='redirectForm' action='../../' method='POST' style='display: none;'>
                    <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_usuario) . "'>
                    <input type='hidden' name='url' value='" . htmlspecialchars($url) . "'>
                </form>
                <script>
                    document.getElementById('redirectForm').submit();
                </script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../../../");
    exit();
}
