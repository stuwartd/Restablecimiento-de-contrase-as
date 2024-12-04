<?php
date_default_timezone_set('America/Bogota');
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecimiento de contraseña</title>
    <link rel="stylesheet" href="style-rec.css">
</head>
<body>
    <main class="contenedor">
            <form action="enviar_enlace.php" method="post">
                <label for="Correo">Introduce tu correo electrónico:</label>
                <input type="email" name="Correo" id="Correo" required>
                <button type="submit" class="boton_rec">Recuperar contraseña</button>
            </form>
    </main>
</body>
</html>
