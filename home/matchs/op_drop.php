<?php
include('../../assets/config/op_conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id_usuario = $_POST['id_usuario'];
    $id = $_POST['id'];


    try {

        $consulta = $pdo->prepare("DELETE FROM coincidencias WHERE id = ?");
        $consulta->execute([$id]);


            echo "
            <form id='redirectForm' action='../matchs/' method='POST' style='display: none;'>
                <input type='hidden' name='id_usuario' value='" . $id_usuario .  "'>
                <input type='hidden' name='url' value='" . $url . "'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>";
            exit();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redireccionar si no hay ID válido
    header("Location: ../../../");
    exit();
}
