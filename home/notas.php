<!-- Modal -->
<div id="myModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative">
        <!-- Botón para cerrar el modal -->
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800">&times;</button>

        <!-- Título del modal -->
        <h2 class="text-2xl font-semibold mb-4 text-center text-pink-600">Mis Matches</h2>

        <!-- Pestañas -->
        <div class="flex justify-around mb-4">
            <button onclick="showTab('completos')" id="tab-completos" class="focus:outline-none px-4 py-2 text-pink-500 border-b-2 border-pink-500 hover:text-pink-700 transition duration-300">
                Matches Completos
            </button>
            <button onclick="showTab('enviados')" id="tab-enviados" class="focus:outline-none px-4 py-2 text-gray-500 hover:text-pink-500 transition duration-300">
                Matches Enviados
            </button>
            <button onclick="showTab('recibidos')" id="tab-recibidos" class="focus:outline-none px-4 py-2 text-gray-500 hover:text-pink-500 transition duration-300">
                Matches Recibidos
            </button>
        </div>

        <!-- Contenido de cada pestaña -->
        <div class="space-y-4">
            <!-- Matches Completos -->
            <div id="content-completos" class="space-y-2">
                <div class="p-4 bg-red-100 rounded flex items-center space-x-4 hover:bg-red-200 transition duration-300">
                    <img src="path/to/image1.jpg" class="w-12 h-12 rounded-full border-2 border-pink-500" alt="Foto de Usuario Completo 1">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">Juan Pérez</p>
                        <p class="text-gray-600">Match completo</p>
                    </div>
                    <!-- Botón de Chat -->
                    <button class="bg-pink-500 text-white px-3 py-1 rounded-md ml-auto hover:bg-pink-600 transition duration-300">
                        Chat
                    </button>
                </div>
                <div class="p-4 bg-red-100 rounded flex items-center space-x-4 hover:bg-red-200 transition duration-300">
                    <img src="path/to/image2.jpg" class="w-12 h-12 rounded-full border-2 border-pink-500" alt="Foto de Usuario Completo 2">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">Ana Gómez</p>
                        <p class="text-gray-600">Match completo</p>
                    </div>
                    <!-- Botón de Chat -->
                    <button class="bg-pink-500 text-white px-3 py-1 rounded-md ml-auto hover:bg-pink-600 transition duration-300">
                        Chat
                    </button>
                </div>
            </div>

            <!-- Matches Enviados -->
            <div id="content-enviados" class="hidden space-y-2">
                <div class="p-4 bg-gray-100 rounded flex items-center space-x-4 hover:bg-gray-200 transition duration-300">
                    <img src="path/to/image3.jpg" class="w-12 h-12 rounded-full" alt="Foto de Usuario Enviado 1">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">Carlos López</p>
                        <p class="text-gray-600">Match enviado</p>
                    </div>
                </div>
            </div>

            <!-- Matches Recibidos -->
            <div id="content-recibidos" class="hidden space-y-2">
                <div class="p-4 bg-green-100 rounded flex items-center space-x-4 hover:bg-green-200 transition duration-300">
                    <img src="path/to/image5.jpg" class="w-12 h-12 rounded-full border-2 border-green-500" alt="Foto de Usuario Recibido 1">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">Laura Martínez</p>
                        <p class="text-gray-600">Match recibido</p>
                    </div>
                </div>
                <div class="p-4 bg-green-100 rounded flex items-center space-x-4 hover:bg-green-200 transition duration-300">
                    <img src="path/to/image6.jpg" class="w-12 h-12 rounded-full border-2 border-green-500" alt="Foto de Usuario Recibido 2">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">Pedro Sánchez</p>
                        <p class="text-gray-600">Match recibido</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('myModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('myModal');
        if (event.target === modal) {
            closeModal();
        }
    }

    function showTab(tab) {
        const tabs = ['completos', 'enviados', 'recibidos'];
        tabs.forEach(t => {
            document.getElementById(tab - $ {
                t
            }).classList.remove('text-pink-500', 'border-pink-500');
            document.getElementById(tab - $ {
                t
            }).classList.add('text-gray-500');
            document.getElementById(content - $ {
                t
            }).classList.add('hidden');
        });

        document.getElementById(tab - $ {
            tab
        }).classList.add('text-pink-500', 'border-pink-500');
        document.getElementById(tab - $ {
            tab
        }).classList.remove('text-gray-500');
        document.getElementById(content - $ {
            tab
        }).classList.remove('hidden');
    }
</script>

<button onclick="openModal()" class="flex items-center space-x-3 text-gray-600 hover:bg-gray-200 p-2 rounded-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500" fill="currentcolor" viewBox="0 0 24 24" stroke="currentColor">
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
    </svg>
    Ver Mis Matches
</button>