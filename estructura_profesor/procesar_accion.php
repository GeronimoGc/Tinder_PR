<?php
// Conexión a la base de datos con PDO
$host = 'localhost';
$nombre_bd = 'root':
$usuario_bd = 'root';
$contrasena_bd = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$nombre_bd", $usuario_bd, $contrasena_bd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_usuario_objetivo = $_POST['id_usuario_objetivo'];
    $accion = $_POST['accion']; // me_gusta o no_me_gusta

    // Insertar la acción en la tabla coincidencias
    $insertar = $pdo->prepare("INSERT INTO coincidencias (id_usuario, id_usuario_objetivo, accion) VALUES (:id_usuario, :id_objetivo, :accion)");
    $insertar->execute([':id_usuario' => $id_usuario, ':id_objetivo' => $id_usuario_objetivo, ':accion' => $accion]);

    // Verificar si hay match (si ambos usuarios se han dado "me gusta")
    if ($accion === 'me_gusta') {
        $consulta_match = $pdo->prepare("
            SELECT * FROM coincidencias 
            WHERE id_usuario = :id_objetivo AND id_usuario_objetivo = :id_usuario AND accion = 'me_gusta'
        ");
        $consulta_match->execute([':id_objetivo' => $id_usuario_objetivo, ':id_usuario' => $id_usuario]);

        if ($consulta_match->rowCount() > 0) {
            echo "¡Es un match!";
        }
    }
}
?>
