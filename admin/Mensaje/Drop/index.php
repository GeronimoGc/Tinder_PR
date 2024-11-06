<?php
include('../../../assets/config/op_conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_mensaje'])) {
    $id_admin = $_POST['id_admin'];
    $id_mensaje = $_POST['id_mensaje'];
    $url = $_POST["url"];


    try {

        $consulta = $pdo->prepare("DELETE FROM mensajes WHERE id = ?");
        $consulta->execute([$id_mensaje]);


        if ($url == 'admin') {
            echo "
            <form id='redirectForm' action='../../#mensajes' method='POST' style='display: none;'>
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
