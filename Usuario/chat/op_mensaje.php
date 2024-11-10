<?php
include('../../assets/config/op_conectar.php'); // Incluye el archivo de conexión


$url = $_POST['url'];

$id_usuario = $_POST['id_usuario'];
$id_receptor = $_POST['id_receptor'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_emisor = $_POST['id_usuario'];
    $id_receptor = $_POST['id_receptor'];
    $mensaje = $_POST['mensaje'];

    try {
        $consulta = $pdo->prepare("INSERT INTO mensajes(id_emisor, id_receptor, mensaje) VALUES (?,?,?)");
        $consulta->execute([$id_emisor, $id_receptor, $mensaje]);

        $filas_afectadas = $consulta->rowCount();


        if ($filas_afectadas > 0) {
            echo "
                <form id='redirectForm' action='../chat/' method='POST' style='display: none;'>
                    <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_usuario) . "'>
                    <input type='hidden' name='id_receptor' value='" . htmlspecialchars($id_receptor) . "'>
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
