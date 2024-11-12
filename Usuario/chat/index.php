<?php
include('../../assets/config/op_conectar.php');

$id_usuario = $_POST['id_usuario'];
$id_receptor = $_POST['id_receptor'];

$consulta_mensajes_recibidos = $pdo->prepare('SELECT mensajes.*, user1.nombre_usuario as user_emisor, user2.nombre_usuario as user_receptor FROM mensajes 
inner join usuarios user1 on mensajes.id_emisor = user1.id
inner join usuarios user2 on mensajes.id_receptor = user2.id 
WHERE mensajes.id_emisor IN (?, ?) AND mensajes.id_receptor IN (?, ?) order by fecha_envio asc');
$consulta_mensajes_recibidos->execute([$id_usuario, $id_receptor, $id_usuario, $id_receptor]);

$resultado_consulta = $consulta_mensajes_recibidos->fetchAll(PDO::FETCH_ASSOC);

$consulta_usuarios_charla = $pdo->prepare('SELECT mensajes.id_emisor, user1.nombre_usuario as user_emisor FROM mensajes 
inner join usuarios user1 on mensajes.id_emisor = user1.id
inner join usuarios user2 on mensajes.id_receptor = user2.id 
where mensajes.id_emisor != ? and mensajes.id_receptor = ?
group by id_emisor');
$consulta_usuarios_charla->execute([$id_usuario, $id_usuario]);
$resultado_usuarios_charla = $consulta_usuarios_charla->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chat Tinder</title>
    <?= include("../../assets/config/HeadTailwind.php"); ?>
</head>

<body class="bg-gradient-to-r from-pink-400 to-red-400 flex justify-center items-center min-h-screen">
    <form id='redirectForm' action='../../home/' method='POST'>
        <input type="hidden" name='id_usuario' value='<?= $id_usuario ?>'>
        <button type="submit" class="absolute top-4 right-4 bg-pink-500 p-2 rounded-full shadow-md hover:bg-pink-600 transition duration-300"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 fill-white">
                <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
            </svg></button>
    </form>

    <div class="bg-white w-full max-w-4xl h-[32rem] rounded-3xl shadow-2xl flex">


        <div class="w-1/3 bg-gray-50 rounded-l-3xl p-4 flex flex-col">
            <h2 class="text-center text-lg font-semibold text-pink-600 mb-4">Chats</h2>
            <div id="chat-list" class="flex-1 overflow-y-auto space-y-3">

                <?php foreach ($resultado_usuarios_charla as $resultado_usuario) : ?>

                    <form id='redirectForm' action='../chat/' method='POST'>
                        <input type="hidden" name='id_usuario' value='<?= $id_usuario ?>'>
                        <input type="hidden" name='id_receptor' value='<?= $resultado_usuario['id_emisor'] ?>'>
                        <button class="w-full p-3 rounded-lg bg-pink-100 text-gray-800 text-left hover:bg-pink-200 focus:outline-none">
                            <strong><?= $resultado_usuario['user_emisor'] ?></strong>
                            <p class="text-sm text-gray-600">Último mensaje...</p>
                        </button>
                    </form>
                <?php endforeach ?>

            </div>
        </div>



        <div class="w-2/3 p-6 flex flex-col bg-white rounded-r-3xl">

            <div class="text-center text-xl font-semibold text-pink-600 mb-4">Chat en Vivo</div>



            <div id="chat-messages" class="flex-1 overflow-y-scroll mb-4 p-4 bg-gray-100 rounded-2xl shadow-inner flex flex-col-reverse">
                <div class="space-y-2">
                    <?php foreach ($resultado_consulta as $mensaje): ?>
                        <?php if ($mensaje['id_emisor'] == $id_usuario): ?>

                            <div class="flex justify-end">
                                <div class="bg-pink-500 text-white p-3 rounded-lg max-w-xs shadow">
                                    <span class="block text-sm font-semibold"><?= $mensaje['user_emisor'] ?>:</span>
                                    <p class="text-sm"><?= $mensaje['mensaje'] ?></p>
                                </div>
                            </div>

                        <?php else: ?>

                            <div class="flex justify-start">
                                <div class="bg-pink-300 text-black p-3 rounded-lg max-w-xs shadow">
                                    <span class="block text-sm font-semibold"><?= $mensaje['user_emisor'] ?>:</span>
                                    <p class="text-sm"><?= $mensaje['mensaje'] ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>



            <form method="post" action="op_mensaje.php" id="chat-form" class="flex items-center gap-2">
                <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
                <input type="hidden" name="id_receptor" value="<?= $id_receptor ?>">
                <input type="text" id="mensaje" name="mensaje" placeholder="Escribe un mensaje..." required
                    class="flex-1 px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400 shadow-sm" />
                <button type="submit"
                    class="bg-gradient-to-r from-pink-500 to-red-500 text-white px-6 py-2 rounded-full font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    Enviar
                </button>
            </form>
        </div>
    </div>

    <script>
        setInterval(() => {
            location.reload();
        }, 10000);

    </script>

<!-- <script>

    function updateChat() {
        fetch('index.php?update_chat=1')
            .then(response => response.text())
            .then(data => {
                document.getElementById('chat-messages').innerHTML = data;
            })
            .catch(error => console.error('Error al actualizar el chat:', error));
    }

    setInterval(updateChat, 10000);

    window.onload = updateChat;
</script> -->




</body>

</html>