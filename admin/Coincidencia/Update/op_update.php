<?php
include('../../../assets/config/op_conectar.php');

$id_admin = $_POST['id_admin'];
$url = $_POST["url"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_usuario = $_POST["id_usuario"];
    $id_usuario_objetivo = $_POST["id_usuario_objetivo"];
    $accion = $_POST["accion"];
    $id = $_POST["id"]; 


    try {

        // Actualizar la información en la base de datos
        $consulta = $pdo->prepare("UPDATE coincidencias SET id_usuario = ?, id_usuario_objetivo = ?, accion = ? WHERE id = ?");
        $consulta->execute([$id_usuario, $id_usuario_objetivo, $accion, $id]);


        if ($url == 'admin') {
            echo "
            <form id='redirectForm' action='../../#coincidencias' method='POST' style='display: none;'>
                <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_admin) .  "'>
                <input type='hidden' name='url' value='" . htmlspecialchars($url) . "'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>";
            exit();
        } elseif ($url == "usuario") {
            echo "
                <form id='redirectForm' action='../../' method='POST' style='display: none;'>
                    <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_usuario) . "'>
                    <input type='hidden' name='url' value='" . htmlspecialchars($url) . "'>
                </form>
                <script>
                    document.getElementById('redirectForm').submit();
                </script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../../../");
    exit();
}
