<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Tipo Tinder</title>
    <?php include("../../assets/config/HeadTailwind.php"); ?>
</head>
<body class="bg-gradient-to-r from-pink-400 to-red-400 flex justify-center items-center min-h-screen">
<a href="../../home" class="absolute top-4 right-4 bg-pink-500 p-2 rounded-full shadow-md hover:bg-pink-600 transition duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-5 h-5 fill-white">
                 <!-- Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free -->
            <path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/>
        </svg>
        </a>
    <div class="bg-white w-full max-w-4xl h-[32rem] rounded-3xl shadow-2xl flex">
        
        <!-- Lista de Chats -->
        <div class="w-1/3 bg-gray-50 rounded-l-3xl p-4 flex flex-col">
            <h2 class="text-center text-lg font-semibold text-pink-600 mb-4">Chats</h2>
            <div id="chat-list" class="flex-1 overflow-y-auto space-y-3">
                <!-- Ejemplo de contacto en la lista de chats -->
                <button class="w-full p-3 rounded-lg bg-pink-100 text-gray-800 text-left hover:bg-pink-200 focus:outline-none">
                    <strong>Usuario 1</strong>
                    <p class="text-sm text-gray-600">Último mensaje...</p>
                </button>
                <button class="w-full p-3 rounded-lg bg-pink-100 text-gray-800 text-left hover:bg-pink-200 focus:outline-none">
                    <strong>Usuario 2</strong>
                    <p class="text-sm text-gray-600">Último mensaje...</p>
                </button>
                <!-- Agrega más contactos aquí -->
            </div>
        </div>
        

        <!-- Contenedor del Chat -->
        <div class="w-2/3 p-6 flex flex-col bg-white rounded-r-3xl">
            <!-- Encabezado del chat -->
            <div class="text-center text-xl font-semibold text-pink-600 mb-4">Chat en Vivo</div>

            <!-- Contenedor de mensajes -->
            <div id="chat-messages" class="flex-1 overflow-y-auto mb-4 p-4 bg-gray-100 rounded-2xl shadow-inner">
                <!-- Los mensajes se cargarán aquí -->
            </div>

            <!-- Formulario para enviar mensajes -->
            <form id="chat-form" class="flex items-center gap-2">
                <input type="text" id="mensaje" placeholder="Escribe un mensaje..." required
                       class="flex-1 px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400 shadow-sm"
                       />
                <button type="submit"
                        class="bg-gradient-to-r from-pink-500 to-red-500 text-white px-6 py-2 rounded-full font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    Enviar
                </button>
            </form>
        </div>
    </div>

    <script>
        // Cargar mensajes del servidor
        async function cargarMensajes() {
            const response = await fetch('chat.php');
            const mensajes = await response.json();

            const chatMessages = document.getElementById('chat-messages');
            chatMessages.innerHTML = '';

            mensajes.reverse().forEach(msg => {
                const mensajeDiv = document.createElement('div');
                mensajeDiv.classList.add('mb-3', 'p-3', 'rounded-lg', 'bg-pink-100', 'text-gray-800', 'max-w-xs', 'shadow-md');
                mensajeDiv.innerHTML = `<span class="font-semibold">${msg.usuario}</span>: ${msg.mensaje}`;
                chatMessages.appendChild(mensajeDiv);
            });

            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Enviar mensaje
        document.getElementById('chat-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const mensaje = document.getElementById('mensaje').value;

            await fetch('chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `mensaje=${mensaje}`
            });

            document.getElementById('mensaje').value = '';
            cargarMensajes();
        });

        // Cargar mensajes cada 2 segundos
        setInterval(cargarMensajes, 2000);
        cargarMensajes();
    </script>
</body>
</html>
