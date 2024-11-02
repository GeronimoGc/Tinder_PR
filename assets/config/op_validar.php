<?php
session_start();

if (!isset($_POST['id_usuario']) || empty($_POST['id_usuario']) || !isset($_POST['url']) || empty($_POST['url'])) {

    header('Location: /Tinder_PR/login/');
    exit;
}

$id_usuario_login = $_POST['id_usuario'];
$url = $_POST['url'];


