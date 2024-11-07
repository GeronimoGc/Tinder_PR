<?php
include('../../../assets/config/op_conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id_admin = $_POST['id_admin'];
    $id = $_POST['id'];
    $url = $_POST["url"];

    try {

        $consulta = $pdo->prepare("DELETE FROM coincidencias WHERE id = ?");
        $consulta->execute([$id]);


        if ($url == 'admin') {
            echo "
            <form id='redirectForm' action='../../#' method='POST' style='display: none;'>
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
