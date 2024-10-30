<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['foto'])) {
    $id_usuario = $_POST['id_usuario'];
    $foto = $_FILES['foto'];

    // Ruta de almacenamiento para las fotos
    $target_dir = "../../../uploads/";
    $target_file = $target_dir . basename($foto["name"]);
    $uploadOk = 1;

    // Verificar si el archivo es una imagen
    $check = getimagesize($foto["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }

    // Subir la foto si es válida
    if ($uploadOk && move_uploaded_file($foto["tmp_name"], $target_file)) {
        try {
            $consulta = $conexion->prepare("INSERT INTO fotos (id_usuario, url_foto, fecha_subida) VALUES (?, ?, NOW())");
            $consulta->execute([$id_usuario, $target_file]);

            echo "Foto subida exitosamente.";
            header("Location: ../Read/index.php");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Hubo un error al subir la foto.";
    }
} else {
    header("Location: ../Read/index.php");
    exit();
}
?>
