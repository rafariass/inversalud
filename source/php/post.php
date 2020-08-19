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

// VALIDA EL CAMPO ESPECIALIDAD
if (empty(trim($_POST['especialidad']))) {
    $error .= 'El campo Centro Medico es requerido. </br>';
} else {
    $especialidad = filter_var(trim($_POST['especialidad']), FILTER_SANITIZE_STRING);
    switch ($especialidad) {
        case "Laboratorio":
            // $enviarA = 'tomademuestras@inversalud.cl';
            $enviarA = 'raulfaria@gmail.com';
            break;
        case "Ecotomografia":
            // $enviarA = 'ecotomografia@inversalud.cl';
            $enviarA = 'raulfaria@gmail.com';
            break;
        case "Rayos y Mamo":
            // $enviarA = 'contacto@inversalud.cl';
            $enviarA = 'raulfaria@gmail.com';
            break;
        case "Pabellón":
            // $enviarA = 'pabellon@Inversalud.cl';
            $enviarA = 'raulfaria@gmail.com';
            break;
        case "Procedimientos":
            // $enviarA = 'contacto@inversalud.cl';
            $enviarA = 'raulfaria@gmail.com';
            break;
        default:
            $error .= 'La especialidad: '.$especialidad.' es inválida. </br>';
            break;
    }
}

// VALIDA EL CAMPO MENSAJE
if (empty(trim($_POST['mensaje']))) {
    $error .= 'El campo mensaje es requerido. </br>';
} else {
    $mensaje  = wordwrap(filter_var(trim($_POST['mensaje']), FILTER_SANITIZE_STRING), 70, "\r\n");
}

// CUERPO DEL MENSAJE
if($error == ''){
    $cuerpo .= "<b>Nombre: </b>".$nombre."<br>";
    $cuerpo .= "<b>Email: </b>".$email."<br>";
    $cuerpo .= "<b>Telefono: </b>".$telefono."<br>";
    $cuerpo .= "<b>Mensaje: </b>".$mensaje."<br>";
    $cuerpo .= "<b>Enviado el: </b>".date('d/m/Y', time('H:i:s'));

    // PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USER;
        $mail->Password = EMAIL_PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //MENSAJE A ENVIAR
        $mail->setFrom(EMAIL_USER);
        $mail->addAddress($enviarA);
        $mail->addCC($email);
        $mail->isHTML(true);

        //ASUNTO
        $mail->Subject = 'Solicitud de contacto para: '.$especialidad;

        //CUERPO
        $mail->Body = $cuerpo;

        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );

        // Enviar E-MAIL
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
