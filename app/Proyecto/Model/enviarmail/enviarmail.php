<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 23/01/2018
 * Time: 05:22 PM
 */

require("class.phpmailer.php"); //Importamos la función PHP class.phpmailer

$mail = new PHPMailer();


$mail->IsSMTP();
$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
//$mail->Username = "remitente@dominio.com"; // Tu cuenta de e-mail
$mail->Username = "info@cuantaskcal.com"; // Tu cuenta de e-mail
$mail->Password = "Kcal3405*"; // El Password de tu casilla de correos


$mail->Host = "localhost";
$mail->From = "info@cuantaskcal.com";
$mail->FromName = "cuantaskcal.com";
$mail->Subject = "Gracias por contactarnos! - Cuantasckal.com ";
$mail->AddAddress("vicens.gonzalo@gmail.com","Gonzalo");

$mail->WordWrap = 50;

$body = "Hola, este es un…";
$body .= "mensaje de prueba";

$mail->Body = $body;

$mail->Send();


// Notificamos al usuario del estado del mensaje

if(!$mail->Send()){
    echo "No se pudo enviar el Mensaje.";
}else{
    echo "Mensaje enviado";
}

?>