<?php
include('../../../assets/config/op_conectar.php'); // Incluye el archivo de conexión


$id_admin = $_POST["id_admin"];
$url = $_POST['url'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

$id_emisor = $_POST['id_emisor'];
$id_receptor = $_POST['id_receptor'];
$mensaje = $_POST['mensaje'];

    try {
        $consulta = $pdo->prepare("INSERT INTO mensajes(id_emisor, id_receptor, mensaje) VALUES (?,?,?)");
        $consulta->execute([$id_emisor, $id_receptor, $mensaje]);

        $filas_afectadas = $consulta->rowCount();

        
            if ($url == 'admin') {
                echo "
                <form id='redirectForm' action='../../#mensajes' method='POST' style='display: none;'>
                    <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_admin) . "'>
                    <input type='hidden' name='url' value='" . htmlspecialchars($url) . "'>
                </form>
                <script>
                    document.getElementById('redirectForm').submit();
                </script>";
                exit();
            }

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: ../../../");
    exit();
}
