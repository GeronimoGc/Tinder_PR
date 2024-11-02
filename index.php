<?php
$id_usuario = null;
$url = null;

include("assets/config/op_conectar.php");

$id_usuario = $_POST['id_usuario'];
$url = $_POST['url'];
if (isset($id_usuario)) {
    if ($url == 'admin') {
        echo "
        <form id='redirectForm' action='admin/' method='POST'>
            <input type='hidden' name='id_usuario' value='$id_usuario'>
            <input type='hidden' name='url' value='$url'>
        </form>
        <script>
            document.getElementById('redirectForm').submit();
        </script>";
        exit();
    } else if ($url == 'usuario') {
        echo "
        <form id='redirectForm' action='home/' method='POST'>
            <input type='hidden' name='id_usuario' value='$id_usuario'>
            <input type='hidden' name='url' value='$url'>
        </form>
        <script>
            document.getElementById('redirectForm').submit();
        </script>";
        exit();
    } else {
        header('Location: login/');
        exit();
    }
}

if (!isset($id_usuario) || $id_usuario == 0) {
    header("Location: login/");
    exit();
}
