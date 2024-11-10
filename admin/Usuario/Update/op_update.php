<?php
include('../../../assets/config/op_conectar.php');

$id_admin = $_POST['id_admin'];
$url = $_POST["url"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_usuario = $_POST["id_usuario"];
    $nombre_usuario = $_POST["nombre_usuario"];
    $correo_usuario = $_POST["email"];
    $contrasena_usuario = $_POST["password"]; // Asegúrate de cifrarla si no lo haces antes
    $genero_usuario = $_POST["genero"];
    $rol_usuario = $_POST["rol"];
    $biografia_usuario = $_POST["biografia"];

    try {
        // Obtener la ruta de la imagen actual del usuario
        $consulta = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
        $consulta->execute([$id_usuario]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
        $ruta_imagen_actual = $usuario['foto_perfil'];

        // Comprobar si se ha subido un nuevo archivo de imagen
        if (isset($_FILES['foto_perfil_usuario']) && $_FILES['foto_perfil_usuario']['error'] === UPLOAD_ERR_OK) {
            $destino = "../../../assets/img/uploads/";
            $nombre_archivo = basename($_FILES['foto_perfil_usuario']['name']);
            $img = $id_usuario . "_" . $nombre_archivo;

            // Ruta completa para mover la imagen
            $ruta_foto_nueva = $destino . $img;

            // Intentar mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($_FILES['foto_perfil_usuario']['tmp_name'], $ruta_foto_nueva)) {
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
        $consulta = $pdo->prepare("UPDATE usuarios SET nombre_usuario = ?, correo = ?, contrasena = ?, genero = ?, rol = ?, biografia = ?, foto_perfil = ? WHERE id = ?");
        $consulta->execute([$nombre_usuario, $correo_usuario, $contrasena_usuario, $genero_usuario, $rol_usuario, $biografia_usuario, $img, $id_usuario]);


        if ($url == 'admin') {
            echo "
            <form id='redirectForm' action='../../' method='POST' style='display: none;'>
                <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_admin) .  "'>
                <input type='hidden' name='url' value='" . htmlspecialchars($url) . "'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>";
            exit();
        } elseif ($url == "usuario") {
            echo "
                <form id='redirectForm' action='../../../usuario/Perfil/' method='POST' style='display: none;'>
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
