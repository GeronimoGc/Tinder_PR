<?php
include('../../../assets/config/op_conectar.php');; // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    $page = $_GET¨["url"];

    try {
        // Preparar la consulta de eliminación
        $consulta = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");

        // Ejecutar la consulta de eliminación
        $consulta->execute([$id_usuario]);

        // Redirigir a listar_estudiantes.php después de la eliminación
        if ($page == 'drop_usuario') {
            header("Location: ../");
        } elseif ($page == "usuario") {
            header("Location: ../../../"); // Redirección por defecto si el código no es 'a' ni 'b'
        }
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este script sin un ID de estudiante válido por GET, redireccionar a otra página (opcional)
    header("Location: ../../../");
    exit();
}
