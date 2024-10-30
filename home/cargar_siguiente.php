<?php
session_start();
include("../assets/config/op_conectar.php");

$id_usuario = $_POST['id_usuario'];

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

if ($siguiente_usuario):
?>
    <div class="card bg-white shadow-lg rounded-lg p-6 text-center">
        <img src="<?php echo $siguiente_usuario['foto_perfil']; ?>" alt="Foto de perfil" class="rounded-full">
        <h2 class="text-2xl mt-4"><?php echo $siguiente_usuario['nombre_usuario']; ?></h2>
        <div class="card-buttons mt-6">
            <button id="no_me_gusta" class="bg-red-500 text-white px-6 py-2 rounded-md">No me gusta</button>
            <button id="me_gusta" class="bg-green-500 text-white px-6 py-2 rounded-md">Me gusta</button>
        </div>
    </div>
<?php else: ?>
    <p class="text-xl">No hay más usuarios disponibles.</p>
<?php endif; ?>
