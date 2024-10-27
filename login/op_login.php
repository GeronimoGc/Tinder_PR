<?php
session_start();

include("../assets/config/op_conectar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $consulta = $pdo->prepare("SELECT COUNT(*) AS existe FROM usuarios WHERE correo = ? AND contrasena = ?");
        $consulta->execute([$email, $password]);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($resultado["existe"] > 0) {

            $consulta1 = $pdo->prepare("SELECT id FROM usuarios WHERE correo = ? AND contrasena = ?");
            $consulta1->execute([$email, $password]);
            $resultado1 = $consulta1->fetch(PDO::FETCH_ASSOC);
            $_SESSION["id"] = $resultado1["id"];
            header("Location: ../");
        } else {
            echo "<script>alert('Usuario y/o contraseña incorrectos');</script>";
            header("refresh:0; url=login.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
