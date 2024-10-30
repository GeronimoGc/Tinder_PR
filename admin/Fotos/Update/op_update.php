<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['foto'])) {
    $id_foto = $_POST['id'];
    $id_usuario = $_POST['id_usuario'];
    $foto = $_FILES['foto'];

    // Obtener la URL de la foto actual
    $consulta = $conexion->prepare("SELECT url_foto FROM fotos WHERE id = ?");
    $consulta->execute([$id_foto]);
    $foto_actual = $consulta->fetch();

    if ($foto_actual) {
        // Eliminar la foto actual
        unlink($foto_actual['url_foto']);

        // Subir la nueva foto
        $target_dir = "../../../uploads/";
        $target_file = $target_dir . basename($foto["name"]);
        
        if (move_uploaded_file($foto["tmp_name"], $target_file)) {
            try {
                // Actualizar la base de datos con la nueva URL de la foto
                $consulta = $conexion->prepare("UPDATE fotos SET id_usuario = ?, url_foto = ?, fecha_subida = NOW() WHERE id = ?");
                $consulta->execute([$id_usuario, $target_file, $id_foto]);

                header("Location: ../Read/index.php");
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Error al subir la nueva foto.";
        }
    }
} else {
    header("Location: ../Read/index.php");
    exit();
}
?>
