<?php
namespace Proyecto\Tools;

class Mail{

    public static function enviarNuevoPassword($destinoNombre,$destinoMail,  $clave)
    {

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False
        //$mail->Username = "contacto@proximafecha.com"; // Tu cuenta de e-mail
        //$mail->Password = "Kcal3405*"; // El Password de tu casilla de correos


        $mail->Host = "localhost";
        $mail->From = "contacto@proximafecha.com";
        $mail->FromName = "Contacto ProximaFecha";
        $mail->Subject = "Recupero de Usuario";
        $mail->AddAddress($destinoMail,$destinoNombre);

        $mail->IsHTML(true);

        $mail->WordWrap = 50;

        $body = '<b>Estimado:</b> ' . $destinoNombre . '<br>';
        $body .= '<b>Tu nueva clave es:</b> ' . $clave. '<br>';
        $body .= '<b>Te recomendamos cambiarla una ve que inicies sesión:</b><br><br>';
        $body .= '<b>Saludos,</b><br>';
        $body .= '<b>El equipo de ProximaFecha</b><br>';
        $body .= '<img src="http://proximafecha.com/img/LOGOPF-Sin-Fondo.png" alt="Logo Proxima Fecha"/>';

        $mail->Body = $body;

        $mail->CharSet = 'UTF-8';

        $exito = $mail->Send();


    }

}