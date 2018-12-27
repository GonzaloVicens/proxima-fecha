<?php
namespace Proyecto\Tools;

class Mail{

    public static function enviarNuevoPassword($destinoNombre,$destinoMail, $usuario,  $clave)
    {

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
        $mail->Username = "no-reply@proximafecha.com"; // Tu cuenta de e-mail
        $mail->Password = "G0nz4l1t0V1c3ns"; // El Password de tu casilla de correos


        //$mail->Host = "localhost";
        $mail->Host = "p4000541.ferozo.com";
        $mail->From = "no-reply@proximafecha.com";
        $mail->FromName = "Contacto ProximaFecha";
        $mail->Subject = "Recupero de Usuario";
        $mail->AddAddress($destinoMail,$destinoNombre);

        $mail->IsHTML(true);

        $mail->WordWrap = 50;

        $body = '<b>Estimado:</b> ' . $destinoNombre . '<br>';
        $body .= '<b>Tu usuario es:</b> ' . $usuario . '<br>';
        $body .= '<b>Tu nueva clave es:</b> ' . $clave. '<br>';
        $body .= '<b>Te recomendamos cambiarla una ve que inicies sesión:</b><br><br>';
        $body .= '<b>Saludos,</b><br>';
        $body .= '<b>El equipo de ProximaFecha</b><br>';
        $body .= '<img src="http://proximafecha.com/img/logo.png" alt="Logo Proxima Fecha"/>';

        $mail->Body = $body;

        $mail->CharSet = 'UTF-8';

        $exito = $mail->Send();


    }

    public static function EnviarMailContacto($datos)
    {

        $nombre = $datos['nombre'];
        $contacto = $datos['contacto'];
        $mensaje = $datos['mensaje'];


        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
        $mail->Username = "no-reply@proximafecha.com"; // Tu cuenta de e-mail
        $mail->Password = "p4ssw0rdPF"; // El Password de tu casilla de correos


        //$mail->Host = "localhost";
        $mail->Host = "p4000541.ferozo.com";
        $mail->From = "no-reply@proximafecha.com";
        $mail->FromName = "Contacto ProximaFecha";
        $mail->Subject = "Contacto desde la web";
        $mail->AddAddress("admin@proximafecha.com","Administrador");

        $mail->IsHTML(true);

        $mail->WordWrap = 50;

        $body  = '<b>Recibiste un contacto de :</b> ' . $nombre . '<br>';
        $body .= '<b>El correo de contacto es:</b> ' . $contacto. '<br>';
        $body .= '<b>El mensaje del formulario fue:</b> ' . $mensaje. '<br><br>';
        $body .= '<b>Cuando puedas respondele:</b><br><br>';
        $body .= '<b>Saludos,</b><br>';
        $body .= '<b>El equipo de ProximaFecha</b><br>';
        $body .= '<img src="http://proximafecha.com/img/logo.png" alt="Logo Proxima Fecha"/>';

        $mail->Body = $body;

        $mail->CharSet = 'UTF-8';

        $exito = $mail->Send();


    }


}