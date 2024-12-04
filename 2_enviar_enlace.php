<?php
include_once 'recuperar.php';
include_once '../login.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['Correo'];

    $conexion = obtConect();

    $sql = "SELECT Id_usuario FROM Usuarios WHERE Correo = ?";
    $stw = $conexion->prepare($sql);
    $stw->bind_param("s", $email);
    $stw->execute();
    $stw->store_result();

    if ($stw->num_rows > 0) {
        $token = bin2hex(random_bytes(16));
        $expire = time() + 3600;

        $sql = "INSERT INTO recuperacion_contraseña (email, token, expire) VALUES (?, ?, ?)";
        $stw = $conexion->prepare($sql);
        $stw->bind_param("ssi", $email, $token, $expire);
        $stw->execute();

        $enlace = "https://antiagingmarketsas.com/Recuperacion/cambiar.php?token=" . $token;

        $to = $email;
        $subject = "Recuperación de contraseña antiagingmarketsas";
        $message = "Haz clic en el siguiente enlace para cambiar tu contraseña: " . $enlace;
        $headers = "From: no-reply@antiagingmarketsas.com\r\n";
        $headers .= "Reply-To: no-reply@antiagingmarketsas.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($to, $subject, $message, $headers);
        
        
        echo "<script>
                alert('Se ha enviado un enlace al correo electrónico para restablecer tu contraseña.'); 
                window.location.href = 'https://antiagingmarketsas.com/';
              </script>";
    } else {
        echo "<script>
                alert('Este correo no está registrado.');
                window.location.href = 'https://antiagingmarketsas.com/';
              </script>";
        exit();

    }

    $conexion->close();
}
?>
