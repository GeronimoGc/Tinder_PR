<?php
include('../../../assets/config/op_conectar.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id_foto = $_GET['id'];

    try {
        // Obtener la URL de la foto para eliminar el archivo físico
        $consulta = $conexion->prepare("SELECT url_foto FROM fotos WHERE id = ?");
        $consulta->execute([$id_foto]);
        $foto = $consulta->fetch();

        if ($foto) {
            // Eliminar el archivo físico
            unlink($foto['url_foto']);

            // Eliminar el registro de la base de datos
            $consulta = $conexion->prepare("DELETE FROM fotos WHERE id = ?");
            $consulta->execute([$id_foto]);

            header("Location: ../Read/index.php");
            exit();
        } else {
            echo "Foto no encontrada.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../Read/index.php");
    exit();
}
?>
