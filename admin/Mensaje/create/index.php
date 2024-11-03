<?php $url = $_GET['url']; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Mensaje</title>
    <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/social-media-circle-6/1024/tinder-circle-512.png" type="image/x-icon">
    <?php include("../../../assets/config/HeadTailwind.php"); ?>
</head>

<body class="flex items-center justify-center min-h-screen bg-pink-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold text-center text-pink-600 mb-6">Enviar Mensaje</h2>

        <form action="op_send_message.php" method="POST">
            <input type="hidden" name="url" value="<?= $url; ?>">

            <!-- ID Emisor -->
            <label for="id_emisor" class="block text-sm font-semibold text-gray-700">ID Emisor</label>
            <input type="text" name="id_emisor" id="id_emisor" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>

            <!-- ID Receptor -->
            <label for="id_receptor" class="block text-sm font-semibold text-gray-700">ID Receptor</label>
            <input type="text" name="id_receptor" id="id_receptor" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" required>

            <!-- Mensaje -->
            <label for="mensaje" class="block text-sm font-semibold text-gray-700">Mensaje</label>
            <textarea name="mensaje" id="mensaje" rows="4" class="w-full px-4 py-2 mb-4 border rounded-lg focus:outline-none focus:border-pink-500" placeholder="Escribe tu mensaje..." required></textarea>

            <!-- Botón de Enviar -->
            <button type="submit" class="w-full py-2 text-white bg-pink-600 rounded-lg hover:bg-pink-700">Enviar Mensaje</button>
        </form>
    </div>
</body>

</html>