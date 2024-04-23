<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enviar'])) {
    
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['EMAIL_USERNAME'];
    $mail->Password = $_ENV['EMAIL_PASSWORD'];
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    
    $destinatario = $_POST['destinatario'];
    $asunto = $_POST['asunto'];
    
    
    $mail->setFrom($_ENV['EMAIL_USERNAME'], 'Tu Nombre');
    $mail->addAddress($destinatario);
    $mail->Subject = $asunto;
    $mail->Body = $_POST['mensaje'];
    
    
    try {
        $mail->send();
        echo 'Correo enviado correctamente.';
    } catch (Exception $e) {
        echo 'Error al enviar el correo: ', $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Enviar Correo</title>
</head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<label for="destinatario">Destinatario:</label><br>
<input type="text" id="destinatario" name="destinatario"><br><br>

<label for="asunto">Asunto:</label><br>
<input type="text" id="asunto" name="asunto"><br><br>

<label for="mensaje">Mensaje:</label><br>
<textarea id="mensaje" name="mensaje" rows="4" cols="50"></textarea><br><br>

<input type="submit" name="enviar" value="Enviar Correo de Prueba">
</form>
</body>
</html>
