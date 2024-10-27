<?php
include("assets/config/op_conectar.php");

// ID del usuario autenticado (deberías cambiar esto por una sesión de usuario real)
$id = 0; // Usuario autenticado, ejemplo: Juan

echo"$id";

if (!isset($_SESSION['id']) || $_SESSION['id'] == 0) {
    header("Location: login/");
    exit(); 
} 



// Obtener el siguiente usuario al que no se ha dado "me gusta" ni "no me gusta"
$consulta_siguiente = $pdo->prepare("
    SELECT u.id, u.nombre_usuario, u.foto_perfil 
    FROM usuarios u
    LEFT JOIN coincidencias c ON u.id = c.id_usuario_objetivo AND c.id_usuario = :id_usuario
    WHERE u.id != :id_usuario AND c.id IS NULL
    LIMIT 1
");
$consulta_siguiente->execute([':id_usuario' => $id_usuario]);
$siguiente_usuario = $consulta_siguiente->fetch(PDO::FETCH_ASSOC);

// Obtener la lista de usuarios aceptados por el usuario autenticado
$consulta_aceptados = $pdo->prepare("
    SELECT u.nombre_usuario, u.foto_perfil 
    FROM usuarios u
    INNER JOIN coincidencias c ON u.id = c.id_usuario_objetivo 
    WHERE c.id_usuario = :id_usuario AND c.accion = 'me_gusta'
");
$consulta_aceptados->execute([':id_usuario' => $id_usuario]);
$usuarios_aceptados = $consulta_aceptados->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tinder</title>
    <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/social-media-circle-6/1024/tinder-circle-512.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container text-center mt-5">
        <button class="btn btn-primary me-2">
            <a href="CrearCuenta/" class="text-white text-decoration-none">Registrarse</a>
        </button>
        <button class="btn btn-secondary">
            <a href="login/" class="text-white text-decoration-none">Inicio de sesión</a>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+hk6N/gB9PaYrfFb5KxE8aboWG3h" crossorigin="anonymous"></script>
</body>
</html>
