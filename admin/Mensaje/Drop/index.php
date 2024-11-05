<?php
include('../../../assets/config/op_conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_mensaje'])) {
    $id_admin = $_POST['id_admin'];
    $id_usuario = $_POST['id_usuario'];
    $url = $_POST["url"];
    $href_img = "../../../assets/img/uploads/";

    try {
        // Obtiene el nombre del archivo de imagen de perfil
        $consulta = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
        $consulta->execute([$id_usuario]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        // Verifica si existe la imagen y la elimina
        if ($usuario && !empty($usuario['foto_perfil'])) {
            $ruta_completa_imagen = $href_img . $usuario['foto_perfil'];
            if (file_exists($ruta_completa_imagen)) {
                unlink($ruta_completa_imagen);
            }
        }



        $consulta = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $consulta->execute([$id_usuario]);


        if ($url == 'admin') {
            echo "
            <form id='redirectForm' action='../../' method='POST' style='display: none;'>
                <input type='hidden' name='id_usuario' value='" . $id_admin .  "'>
                <input type='hidden' name='url' value='" . $url . "'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>";
            exit();
        } elseif ($url == "usuario") {
            header("Location: ../../../");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redireccionar si no hay ID válido
    header("Location: ../../../");
    exit();
}
