<?php
include('../../assets/config/op_conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $id_usuario = $_POST["id_usuario"];
    $id_usuario_objetivo = $_POST["id_usuario_objetivo"];
    $accion = $_POST["accion"];


    try {
        $consulta = $pdo->prepare("INSERT INTO coincidencias(id_usuario, id_usuario_objetivo, accion) VALUES (?,?,?)");
        $consulta->execute([$id_usuario, $id_usuario_objetivo, $accion,]);

        $filas_afectadas = $consulta->rowCount();

        if ($filas_afectadas > 0) {

                echo "
                <form id='redirectForm' action='../matchs/' method='POST' style='display: none;'>
                    <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_usuario) . "'>
                    <input type='hidden' name='url' value='" . htmlspecialchars($url) . "'>
                </form>
                <script>
                    document.getElementById('redirectForm').submit();
                </script>";
                exit();

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
