<?php
session_start();
include("assets/config/op_conectar.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_usuario_objetivo = filter_input(INPUT_POST, 'id_usuario_objetivo', FILTER_VALIDATE_INT);
    $accion = $_POST['accion'] === 'me_gusta' ? 'me_gusta' : 'no_me_gusta';

    if ($id_usuario && $id_usuario_objetivo) {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=nombre_base_datos', 'usuario', 'contraseña');
            $consulta = $pdo->prepare("INSERT INTO coincidencias (id_usuario, id_usuario_objetivo, accion) VALUES (?, ?, ?)");
            $consulta->execute([$id_usuario, $id_usuario_objetivo, $accion]);

            echo 'success';
        } catch (PDOException $e) {
            echo 'error';
        }
    } else {
        echo 'error';
    }
} else {
    header('Location: login/');
    exit();
}
?>
