<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Perfil de Usuario - Tinder</title>
    <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/social-media-circle-6/1024/tinder-circle-512.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Bienvenido, <?php echo $nombreUsuario; ?></h2>
                <!-- Tarjeta de perfil del usuario -->
                <div class="profile-card">
                    <img src="<?php echo $fotoUsuario; ?>" alt="Foto de perfil" class="profile-pic">
                    <h4><?php echo $nombreUsuario; ?></h4>
                    <p><?php echo $edadUsuario; ?> años</p>
                    <p><?php echo $ubicacionUsuario; ?></p>
                </div>

                <div class="action-btns">
                    <button id="btn-dislike" class="btn-dislike">👎</button>
                    <button id="btn-like" class="btn-like">👍</button>
                </div>

                <div class="mt-5">
                    <h4 class="text-center">Perfiles disponibles:</h4>
                    <!-- Aquí aparecerán los perfiles a deslizar -->
                    <div id="profiles-container">
                        <!-- Perfil 1 (ejemplo estático, pero estos deberían cargarse dinámicamente) -->
                        <div class="profile-card mt-3" id="profile-1">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Foto perfil 1" class="profile-pic">
                            <h4>Ana María</h4>
                            <p>25 años</p>
                            <p>Medellín, Colombia</p>
                        </div>
                        <!-- Perfil 2 -->
                        <div class="profile-card mt-3" id="profile-2" style="display:none;">
                            <img src="https://randomuser.me/api/portraits/men/44.jpg" alt="Foto perfil 2" class="profile-pic">
                            <h4>Carlos López</h4>
                            <p>28 años</p>
                            <p>Bogotá, Colombia</p>
                        </div>
                        <!-- Perfil 3 -->
                        <div class="profile-card mt-3" id="profile-3" style="display:none;">
                            <img src="https://randomuser.me/api/portraits/women/47.jpg" alt="Foto perfil 3" class="profile-pic">
                            <h4>Lucía Pérez</h4>
                            <p>22 años</p>
                            <p>Cali, Colombia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para simular deslizar y hacer match -->
    <script>
        let currentProfile = 1;
        const totalProfiles = 3;

        document.getElementById('btn-like').addEventListener('click', () => {
            alert('¡Le diste like al perfil!');
            mostrarSiguientePerfil();
        });

        document.getElementById('btn-dislike').addEventListener('click', () => {
            alert('Pasaste el perfil.');
            mostrarSiguientePerfil();
        });

        function mostrarSiguientePerfil() {
            document.getElementById(`profile-${currentProfile}`).style.display = 'none';
            currentProfile++;
            if (currentProfile <= totalProfiles) {
                document.getElementById(`profile-${currentProfile}`).style.display = 'block';
            } else {
                alert('No hay más perfiles disponibles.');
            }
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+hk6N/gB9PaYrfFb5KxE8aboWG3h" crossorigin="anonymous"></script>
</body>
</html>
