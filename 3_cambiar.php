<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-rec.css">
    <title>cambiar</title>
</head>
<body>
    
</body>
</html>
<?php
include_once '../login.php';


if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $conexion = obtConect();

    $sql = "SELECT email, expire FROM recuperacion_contraseña WHERE token = ?";
    $stw = $conexion->prepare($sql);
    $stw->bind_param("s", $token);
    $stw->execute();
    $stw->store_result();

    if ($stw->num_rows > 0) {
        $stw->bind_result($email, $expire);
        $stw->fetch();

        // Verificar si el token ha expirado
        if ($expire > time()) {
            // Mostrar el formulario para cambiar la contraseña
            echo   '<form action="actualizar.php" method="POST" class="form_cam">
                    <input type="hidden" name="token" value="' . $token . '">
                    <label for="nueva_contraseña" >Nueva contraseña:</label>
                    <input type="password" class="pass_cam" name="nueva_contraseña" id="nueva_contraseña" required>
                    <br>
                    <button type="submit" class="boton_cam">Cambiar contraseña</button>
                    </form>';
        } else {
            echo '<h2 style="color:white;">Enlace expirado.</p>';
        }
    } else {
        echo '<h2 style="color:white;">Token inválido o expirado.</p>';
    }

    $conexion->close();
}
?>
