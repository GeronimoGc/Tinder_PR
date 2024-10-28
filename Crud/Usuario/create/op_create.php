<?php
include('../../../assets/config/op_conectar.php'); // Incluye el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$id_usuario = $_POST["id_usuario"];
$nombre_usuario = $_POST["nombre"];
$correo_usuario = $_POST["email"];
$contrasena_usuario = $_POST["password"];
$genero_usuario = $_POST["genero"];
$biografia_usuario = $_POST["biografia"];
// $foto_perfil_usuario = $_POST["foto_perfil_usuario"];
// date_default_timezone_set('America/Bogota');
// $fecha_creacion_usuario = date('d-m-Y H:i:s');

$directorio_imagenes = "../../../assets/img/uploads/";
if (!is_dir($directorio_imagenes)) {
    mkdir($directorio_imagenes, 0777, true); // Crear la carpeta si no existe
}
// Procesar la imagen de perfil
$foto_perfil_usuario = $_FILES["foto_perfil_usuario"];
$nombre_imagen = $foto_perfil_usuario["name"];
$ruta_imagen = $directorio_imagenes . uniqid() . "_" . basename($nombre_imagen);

// Mover la imagen a la carpeta especificada
if (move_uploaded_file($foto_perfil_usuario["tmp_name"], $ruta_imagen)) {
    echo "La imagen de perfil se ha subido correctamente.<br>";
} else {
    echo "Hubo un error al subir la imagen de perfil.<br>";
}



    try {
        $consulta = $pdo->prepare("INSERT INTO usuario(nombre_usuario, correo, contrasena, genero, biografia, foto_perfil, fecha_creacion) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $consulta->execute([$nombre_usuario, $correo_usuario, $contrasena_usuario, $genero_usuario, $biografia_usuario, $ruta_imagen, $fecha_creacion_usuario]);
        
        $filas_afectadas = $consulta->rowCount();
        
        if ($filas_afectadas > 0) {
            echo "Inserción exitosa";
            // Redirigir a una página de éxito
            header("Location: ../");
            exit(); // Asegura que el script se detenga después de la redirección
        } else {
            echo "No se pudo insertar el usuario";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Si se intenta acceder a este script sin un envío de formulario POST, redireccionar a otra página (opcional)
    header("Location: listar_estudiantes.php");
    exit();
}

