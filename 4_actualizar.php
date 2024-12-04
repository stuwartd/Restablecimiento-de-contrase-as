<?php
include_once '../login.php';
include_once 'cambiar.php';

$conexion = obtConect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $nueva_contraseña = $_POST['nueva_contraseña'];

    
    if (strlen($nueva_contraseña) < 8) {
        echo '<h2 style="color:white;">La contraseña debe tener al menos 8 caracteres.</p>';
        exit;
    }

    
    $sql = "SELECT email FROM recuperacion_contraseña WHERE token = ?";
    $stw = $conexion->prepare($sql);
    $stw->bind_param("s", $token);
    $stw->execute();
    $stw->store_result();

    if ($stw->num_rows > 0) {
        $stw->bind_result($email);
        $stw->fetch();

        
        $nueva_contraseña_hash = password_hash($nueva_contraseña, PASSWORD_BCRYPT);
        $sql = "UPDATE Usuarios SET Clave = ? WHERE Correo = ?";
        $stw = $conexion->prepare($sql);
        $stw->bind_param("ss", $nueva_contraseña_hash, $email);
        $stw->execute();

        
        $sql = "DELETE FROM recuperacion_contraseña WHERE token = ?";
        $stw = $conexion->prepare($sql);
        $stw->bind_param("s", $token);
        $stw->execute();

        echo "<script>
                alert('La contraseña se ha cambiado con exito'); 
                window.location.href = 'https://antiagingmarketsas.com/';
              </script>";
    } else {
        echo "<script>
                alert('Token inválido o expirado'); 
                window.location.href = 'https://antiagingmarketsas.com/';
              </script>";
    }

    $conexion->close();
}
?>
