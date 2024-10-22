<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Registro e Inicio de Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Formulario de Inicio de Sesión -->
        <div class="form-container">
            <h2>Inicio de Sesión</h2>
            <form action="/login" method="POST">
                <label for="login_correo">Correo Electrónico:</label>
                <input type="email" id="login_correo" name="login_correo" required>

                <label for="login_password">Contraseña:</label>
                <input type="password" id="login_password" name="login_password" required>

                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>