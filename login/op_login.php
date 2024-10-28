<?php
session_start();

include("../assets/config/op_conectar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $consulta = $pdo->prepare("SELECT COUNT(*) AS existe, id FROM usuarios WHERE correo = ? AND contrasena = ?");
        $consulta->execute([$email, $password]);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        if ($resultado["existe"] > 0) {
            
            $id_usuario = $resultado["id"];
            $_SESSION["id_usuario"] = $id_usuario;
            echo "
            <form id='redirectForm' action='../' method='POST'>
                <input type='hidden' name='id_usuario' value='$id_usuario'>
            </form>
            <script>
                document.getElementById('redirectForm').submit();
            </script>";
            exit();
        } else {
            echo "<script>alert('Usuario y/o contraseña incorrectos');</script>";
            header("refresh:0; url=login.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
