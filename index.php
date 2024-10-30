<?php 

include("assets/config/op_conectar.php");

$id_usuario = $_POST['id_usuario'];

if (isset($_POST['id_usuario'])) {
    $_SESSION['id_usuario'] = (int)$_POST['id_usuario'];
    header('Location: home/');
}
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_usuario'] == 0) {
    header("Location: login/");
    exit();
}