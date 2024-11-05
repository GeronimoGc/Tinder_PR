<?php
include('../../../assets/config/op_conectar.php');

$id_admin = $_POST['id_admin'] ?? null;
$url = $_POST['url'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_mensaje = $_POST['id_mensaje'] ?? null;
    $id_emisor = $_POST['id_emisor'] ?? null;
    $id_receptor = $_POST['id_receptor'] ?? null;
    $mensaje = $_POST['mensaje'] ?? null;

    if ($id_mensaje && $id_emisor && $id_receptor && $mensaje) {
        try {
            // Actualizar la información en la base de datos
            $consulta = $pdo->prepare("UPDATE mensajes SET id_emisor = ?, id_receptor = ?, mensaje = ? WHERE id = ?");
            $consulta->execute([$id_emisor, $id_receptor, $mensaje, $id_mensaje]);

            // Redirección según el valor de $url
            $id_usuario = $id_admin ?: null;
            echo "
            <form id='redirectForm' action='../../' method='POST' style='display: none;'>
                <input type='hidden' name='id_usuario' value='" . htmlspecialchars($id_usuario, ENT_QUOTES, 'UTF-8') . "'>
                <input type='hidden' name='url' value='" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>";
            exit();
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    } else {
        echo "Faltan datos para actualizar el mensaje.";
    }
} else {
    header("Location: ../../../");
    exit();
}
