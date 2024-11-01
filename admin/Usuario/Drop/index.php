<?php
include('../../../assets/config/op_conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    $url = $_GET["url"];
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


        // Preparar y ejecutar la consulta de eliminación
        $consulta = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $consulta->execute([$id_usuario]);

        // Redirigir después de la eliminación
        if ($url == 'admin') {
            header("Location: ../../");
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
