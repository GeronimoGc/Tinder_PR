<?php
include('../../../assets/config/op_conectar.php');; // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    $page = $_GET["url"];

    try {

        // Obtiene el nombre de la imagen de perfil
        $consulta = $pdo->prepare("SELECT foto_perfil FROM usuarios WHERE id = ?");
        $consulta->execute([$id_usuario]);
        $foto = $consulta->fetchall(PDO::FETCH_ASSOC);

        if ($usuario && !empty($usuario['foto_perfil'])) {
            // Elimina la imagen de perfil del servidor usando la ruta completa
            if (file_exists($usuario['foto_perfil'])) {
                unlink($usuario['foto_perfil']);
            }
        }

        
        // Preparar la consulta de eliminación
        $consulta = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");

        // Ejecutar la consulta de eliminación
        $consulta->execute([$id_usuario]);

        // Redirigir a listar_estudiantes.php después de la eliminación
        if ($page == 'drop_usuario') {
            header("Location: ../index.php");
            exit();
        } elseif ($page == "usuario") {
            header("Location: ../../../index.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este script sin un ID de estudiante válido por GET, redireccionar a otra página (opcional)
    header("Location: ../../../");
    exit();
}
