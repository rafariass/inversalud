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
    $cuerpo .= '
        <div>
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="width: 100%; max-width: 600px" align="center">
            <tbody>
            <tr>
                <td role="modules-container" style="padding: 0px 0px 0px 0px; color: #75787b; text-align: left" bgcolor="#ffffff" width="100%" align="left">
                <!-- Header -->
                <table role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed">
                    <tbody>
                    <tr>
                        <td style="font-size: 6px; line-height: 10px; padding: 0px 0px 0px 0px" valign="top" align="center">
                        <img src="https://inversalud.herokuapp.com/source/img/logos/banner.jpg" border="0" style="display: block; max-width: 100% !important; width: 100%; height: auto !important" alt="" width="600" tabindex="0" />
                        </td>
                    </tr>
                    </tbody>
                </table><!-- Header -->
                <table role="module" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed">
                    <tbody>
                    <tr>
                        <td height="100%" valign="top">
                        <!-- Body -->
                        <div style="margin-left: 20px; margin-right: 20px">
                            <div>
                            <h2 style="font-family: Nunito; color: #ffffff; text-align: center; background-color: #235b90; border-radius: 10px; padding: 5px 10px 5px 10px; margin-top: 10px; margin-bottom: 10px">
                                SOLICITUD DE CONTACTO
                            </h2>
                            </div>
                            <br />
                            <div style="width: 100%; text-align: center">
                            <span style="font-family: Nunito; color: #75787b; font-size: 16px; font-weight: 700">Estimado paciente, le adjuntamos la siguiente solicitud de contacto:</span>
                            </div>
                            <div style="font-size: 16px">
                            <!-- Solicitante -->
                            <div style="border-color: #235b90; border-style: solid; border-radius: 10px; border-width: 2px; padding: 5px; margin-top: 20px; margin-bottom: 20px">
                                <span style="font-family: Nunito; color: #235b90; margin-right: 25px; padding-left: 5px; font-weight: bold">Solicitante:</span>
                                <span style="font-family: Nunito; color: #75787b; font-weight: 600">'.$nombre.'</span>
                            </div><!-- Solicitante -->
                            <!-- Email -->
                            <div style="border-color: #235b90; border-style: solid; border-radius: 10px; border-width: 2px; padding: 5px; margin-top: 20px; margin-bottom: 20px">
                                <span style="font-family: Nunito; color: #235b90; margin-right: 56px; padding-left: 5px; font-weight: bold">Email:</span>
                                <span style="font-family: Nunito; color: #75787b; font-weight: 600">'.$email.'</span>
                            </div><!-- Email -->
                            <!-- Telefono -->
                            <div style="border-color: #235b90; border-style: solid; border-radius: 10px; border-width: 2px; padding: 5px; margin-top: 20px; margin-bottom: 20px">
                                <span style="font-family: Nunito; color: #235b90; margin-right: 39px; padding-left: 5px; font-weight: bold">Telefono:</span>
                                <span style="font-family: Nunito; color: #75787b; font-weight: 600">'.$telefono.'</span>
                            </div><!-- Telefono -->
                            <!-- Especialidad -->
                            <div style="border-color: #235b90; border-style: solid; border-radius: 10px; border-width: 2px; padding: 5px; margin-top: 20px; margin-bottom: 20px">
                                <span style="font-family: Nunito; color: #235b90; margin-right: 10px; padding-left: 5px; font-weight: bold">Especialidad:</span>
                                <span style="font-family: Nunito; color: #75787b; font-weight: 600">'.$especialidad.'</span>
                            </div><!-- Especialidad -->
                            <!-- Direccion -->
                            <div style="border-color: #235b90; border-style: solid; border-radius: 10px; border-width: 2px; padding: 5px; margin-top: 20px; margin-bottom: 20px">
                                <span style="font-family: Nunito; color: #235b90; margin-right: 31px; padding-left: 5px; font-weight: bold">Direccion:</span>
                                <span style="font-family: Nunito; color: #75787b; font-weight: 600">Merced 552, San Felipe</span>
                            </div>
                            <!-- Direccion -->
                            <!-- Mensaje -->
                            <div style="border-color: #235b90; border-style: solid; border-radius: 10px; border-width: 2px; padding: 5px; margin-top: 20px; margin-bottom: 20px">
                                <span style="font-family: Nunito; color: #235b90; margin-right: 39px; padding-left: 5px; font-weight: bold">Mensaje:</span>
                                <span style="font-family: Nunito; color: #75787b; font-weight: 600">'.$mensaje.'</span>
                            </div>
                            <!-- Mensaje -->
                            <br />
                            </div>
                        </div><!-- Body -->
                        <!-- Footer -->
                        <div style="background-color: #f2f2f2">
                            <table width="95%" height="70px" style="padding-left: 25px">
                            <tbody>
                                <tr>
                                <!-- Web -->
                                <td width="50%" align="left" valign="center">
                                    <span style="text-align: left; font-size: 14px; font-style: italic; font-weight: 600; text-decoration: none">
                                    <a href="https://inversalud.cl/" style="color: #235b90" target="_blank">www.inversalud.cl</a>
                                    </span>
                                </td><!-- Web -->
                                <!-- Examenes -->
                                <td width="40%" align="right" valign="center">
                                    <span style="text-align: right; font-size: 14px; font-weight: 600; color: #75787b">
                                    <a href="http://200.111.199.219:84/" target="_blank"
                                        style="
                                        display: inline-block;
                                        text-align: center;
                                        vertical-align: middle;
                                        border: 1px solid transparent;
                                        line-height: 1.5;
                                        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                                        padding: 0.25rem 0.5rem;
                                        color: #fff;
                                        background-color: #235b90;
                                        border-color: #235b90;
                                        outline: none;
                                        border-radius: 40px;
                                        padding-right: 1rem !important;
                                        padding-left: 1rem !important;
                                        padding-top: 0.3rem !important;
                                        text-decoration: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 310.42 310.42" style="enable-background: new 0 0 310.42 310.42" xml:space="preserve">
                                        <g transform="matrix(-1.83697e-16 -1 1 -1.83697e-16 0 310.42)">
                                            <g>
                                            <g>
                                                <path d="M273.587,214.965c49.11-49.111,49.109-129.021,0-178.132c-49.111-49.111-129.02-49.111-178.13,0 C53.793,78.497,47.483,140.462,76.51,188.85c0,0,2.085,3.498-0.731,6.312c-16.065,16.064-64.263,64.263-64.263,64.263 c-12.791,12.79-15.836,30.675-4.493,42.02l1.953,1.951c11.343,11.345,29.229,8.301,42.019-4.49c0,0,48.096-48.097,64.128-64.128    c2.951-2.951,6.448-0.866,6.448-0.866C169.958,262.938,231.923,256.629,273.587,214.965z M118.711,191.71 c-36.288-36.288-36.287-95.332,0.001-131.62c36.288-36.287,95.332-36.288,131.619,0c36.288,36.287,36.288,95.332,0,131.62 C214.043,227.996,155,227.996,118.711,191.71z" data-original="#fff" fill="#fff" />
                                                <g>
                                                <path d="M126.75,118.424c-1.689,0-3.406-0.332-5.061-1.031c-6.611-2.798-9.704-10.426-6.906-17.038 c17.586-41.559,65.703-61.062,107.261-43.476c6.611,2.798,9.704,10.426,6.906,17.038c-2.799,6.612-10.425,9.703-17.039,6.906 c-28.354-11.998-61.186,1.309-73.183,29.663C136.629,115.445,131.815,118.424,126.75,118.424z" data-original="#fff" fill="#fff" />
                                                </g>
                                            </g>
                                            </g>
                                        </g>
                                        </svg>
                                        Resultado de Examenes</a>
                                    </span>
                                </td><!-- Examenes -->
                                </tr>
                            </tbody>
                            </table>
                        </div><!-- Footer -->
                        </td>
                    </tr>
                    </tbody>
                </table>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    ';
    // $cuerpo .= "<b>Nombre: </b>".$nombre."<br>";
    // $cuerpo .= "<b>Email: </b>".$email."<br>";
    // $cuerpo .= "<b>Telefono: </b>".$telefono."<br>";
    // $cuerpo .= "<b>Mensaje: </b>".$mensaje;
    // $cuerpo .= "<br><b>Enviado el: </b>".date('d/m/Y', time('H:i:s'));

    // PHPMailer
    $mail = new PHPMailer(true);
    try {
        // 0 -> Sin mensajes de debug
        // 1 -> Diálogo de cliente a servidor
        // 2 -> Diálogo de cliente a servidor y viceversa
        // 3 -> Códigos de estado de cada fase de la conexión, además del diálogo entre cliente y servidor/servidor y cliente
        // 4 -> Devuelve a bajo nivel toda la traza de la conversación entre cliente y servidor SMTP
        $mail->SMTPDebug = 0;
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
        $mail->ChartSet = 'utf-8';
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
