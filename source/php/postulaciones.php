<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';
require 'constantes.php';

// DECLARA UNA VARIABLE DE ERROR VACIA
$error = '';
 
// VALIDA EL CAMPO NOMBRE
if (empty(trim($_POST['nombre']))) {
    $error .= 'El campo nombre es requerido. </br>';
} else {
    $nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_STRING);
}

// VALIDA EL CAMPO EMAIL
if (empty(trim($_POST['email'])) ||
    !filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
    $error .= 'El campo email es requerido. </br>';
} else {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
}

// VALIDA EL CAMPO TELEFONO
if (empty(trim($_POST['telefono'])) ||
    !filter_var(trim($_POST['telefono']), FILTER_VALIDATE_INT) ||
    strlen(trim($_POST['telefono'])) != 8) {
    $error .= 'El campo telefono es requerido. </br>';
} else {
    $telefono = "+569".filter_var(trim($_POST['telefono']), FILTER_SANITIZE_NUMBER_INT);
}

// VALIDA EL CAMPO AREA DE DESEMPEÑO
if (empty(trim($_POST['area']))) {
    $error .= 'El campo Area de desempeño es requerido. </br>';
} else {
    $area = filter_var(trim($_POST['area']), FILTER_SANITIZE_STRING);
    switch ($area) {
        case "Administrativa":
            break;
        case "Clínica":
            break;
        default:
            $error .= 'El Area de desempeño: '.$area.' es inválida. </br>';
            break;
    }
}




// VALIDA EL ADJUNTO
$error .=  $_FILES['cv']['name'];
$error .=  $_FILES['cv']['tmp_name'];



// CUERPO DEL MENSAJE
if($error == ''){
    $cuerpo .= "<b>Nombre: </b>".$nombre."<br>";
    $cuerpo .= "<b>Email: </b>".$email."<br>";
    $cuerpo .= "<b>Telefono: </b>".$telefono."<br>";
    $cuerpo .= "<b>Mensaje: </b>".$area;
    $cuerpo .= "<br><b>Enviado el: </b>".date('d/m/Y', time('H:i:s'));

    // PHPMailer
    $mail = new PHPMailer(true);
    try {
        // 0 -> Sin mensajes de debug
        // 1 -> Diálogo de cliente a servidor
        // 2 -> Diálogo de cliente a servidor y viceversa
        // 3 -> Códigos de estado de cada fase de la conexión, además del diálogo entre cliente y servidor/servidor y cliente
        // 4 -> Devuelve a bajo nivel toda la traza de la conversación entre cliente y servidor SMTP
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USER;
        $mail->Password = EMAIL_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //MENSAJE A ENVIAR
        $mail->setFrom(EMAIL_USER, 'Notificacion InverSalud');
        $mail->addAddress('raulfaria@gmail.com');
        $mail->addCC($email);
        $mail->isHTML(true);

        //ASUNTO
        $mail->Subject = 'Solicitud de postulacion: '.$area;

        //CUERPO
        $mail->ChartSet = 'utf-8';
        $mail->Body = $cuerpo;

        $mail->AddAttachment($cv_name, $cv_ruta); 

        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );

        //ENVIAR E-MAIL
        if(!$mail->send()) {
            echo 'No se pudo enviar el mensaje... '.$mail->ErrorInfo;
        } else {
            echo 'ok';
        }
    } catch (Exception $exception) {
        echo 'Algo salio mal, excepcion: ', $exception->getMessage();
    }

}else{
    echo $error;
}
?>
