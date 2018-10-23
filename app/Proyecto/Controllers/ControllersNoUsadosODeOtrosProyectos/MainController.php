<?php

/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:12 PM
 */

namespace Proyecto\Controllers;
use Proyecto\View\View;
use Proyecto\Model\Alimento;
use Proyecto\Model\Articulo;
use Proyecto\Model\enviarmail\PHPMailer;
use Proyecto\Model\enviarmail\SMTP;
use Proyecto\Model\Mensaje;
use Proyecto\Core\Route;
//use \JsonSerializable;

class MainController //implements JsonSerializable
{
    public function jsonSerialize(){}

    public function index()
    {

        //View::render('web/index');
        //$ultimaspub = Articulo::traerUltimosTres();

        View::render('web/index', [
          //  'ultimaspub' => $ultimaspub
        ]);

    }

    public function about()
    {

        View::render('web/about');

    }

    //public function blog()
    //{

      //  View::render('web/blog');

    //}


    //Esta función trae los útimos posteos subidos
    //sería el "home" de la sección blog
    public function traerUltimosCinco()
    {

        $recetas = Articulo::traerUltCinco();

        $paginacion = Articulo::traerIDsreferencia();

        //$cantidad = Articulo::contarTodos();

        //echo 'La cantidad de articulos es:' . count($paginacion) . '<br>';

        //echo '<pre>' . print_r($paginacion) . '</pre>';

        //die;

        View::render('web/blog', [
            'recetas' => $recetas,
            'paginacion' => $paginacion
        ]);
    }


    public function traerCincoArticulos()
    {

        $routeData = Route::getRouteParams();

        $id = $routeData['id'];

        $recetas = Articulo::traerCincoPaginacion($id);

        $paginacion = Articulo::traerIDsreferencia();

        //echo $paginaactual;

        //die;

        //$paginaactual = Articulo::traerPaginaActual($id);

        //$cantidad = Articulo::contarTodos();

        //echo 'La cantidad de articulos es:' . count($paginacion) . '<br>';

        //echo '<pre>' . print_r($paginacion) . '</pre>';

        //die;

        View::render('web/blog', [
            'recetas' => $recetas,
            'paginacion' => $paginacion,
            //'paginaactual' => $paginaactual
        ]);
    }


    public function ayuda()
    {

        View::render('web/ayuda');

    }

    public function contacto()
    {

        View::render('web/contacto');

    }

    public function enviarMail()
    {

        //require_once("../Model/mailer/class.phpmailer.php"); //Importamos la función PHP class.phpmailer

        $mail = new PHPMailer();


        $mail->IsSMTP();
        $mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta o de lo contrario False
        //$mail->Username = "remitente@dominio.com"; // Tu cuenta de e-mail
        $mail->Username = "info@cuantaskcal.com"; // Tu cuenta de e-mail
        $mail->Password = "Kcal3405*"; // El Password de tu casilla de correos


        $mail->Host = "localhost";
        $mail->From = "info@cuantaskcal.com";
        $mail->FromName = "cuantaskcal.com";
        $mail->Subject = "Contacto desde Cuantasckal.com";
        $mail->AddAddress("info@cuantaskcal.com","Administrador");

        $mail->IsHTML(true);

        $mail->WordWrap = 50;

        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $consulta = $_POST['consulta'];

        $body = '<b>Nombre Usuario:</b> ' . $nombre . '<br>';
        $body .= '<b>Dirección de E-mail:</b> ' . $email . '<br>';
        $body .= '<b>Mensaje:</b> ' . $consulta . '<br>';

        $mail->Body = $body;

        $mail->CharSet = 'UTF-8';

        $exito = $mail->Send();

        //if(!$exito){
        //    echo "No se pudo enviar el Mensaje.";
        //}else{
        //    echo "Mensaje enviado";
        //}

        // Notificamos al usuario del estado del mensaje
        if(!$exito) {
            $msgrta = 'problema';
        } else {
            $msgrta = 'ok';
        }

        View::render('web/contacto', [
            'msgrta' => $msgrta
        ]);



        //$data = $_POST;
        //$msg = Mensaje::armarMail($data);

        //$nombre = $_POST['name'];
        //$mail = $_POST['email'];
        //$message = $_POST['message'];

        //$mensajemail = "Mensaje de: " . $nombre . ".<br>Dirección para responder: " . $mail . "<br>Mensaje: " . $message . "<br>";


        // envío del email
        //$mailok = mail("info@cuantaskcal.com", "Consulta desde CuantasKcal.com", $mensajemail, "From: $nombre <$mail>\nReply-To:$mail\nContent-Type: text/html; charset=iso-8859-1\n");

        //if($mailok) {
          //  $msgrta = 'ok';
        //} else {
          //  $msgrta = 'problema';
            //$contenido = $mensajemail;
        //}

        //View::render('web/contacto', [
          //  'msgrta' => $msgrta,
            //'contenido' => $contenido
        //]);
    }


    public function buscarAlimento()
    {
        $data = $_POST;

        //print_r($data);

        //die;

        //$hoy = date("YmdHis");

        //print_r($hoy);

        //die;

        $alim = Alimento::traerPorNombre($data);

        //echo "hola que onda con alim?";
        echo $alim;

        //print_r($alim);
        //$pepe = json_encode($alim);
        //print_r($pepe);
        //die;
        //echo 'hola?';
        //return $alim;

    }

    public function traerAlimento()
    {

        $data = $_POST;
        $alim = Alimento::traerPorNombre($data);
       //View::render('web/index');
        View::render('web/ver-alimento', [
             'alim' => $alim
          ]);
        //echo '<pre>';
        //print_r($data);
        //echo '<pre>';
        //die;
    }

    public function buscarOpciones()
    {
        $data = $_POST;

        //print_r($data);

        //die;

        $opciones = Alimento::traerOpciones($data);

        //echo "hola que onda con alim?";
        echo $opciones;

    }

    public function traerArticulo()
    {

        $routeData = Route::getRouteParams();
        $id = $routeData['id'];
        $artic = Articulo::traerUno($id);

        //print_r($data);
        //die;

        //View::render('web/index');
        View::render('web/ver-articulo', [
            'artic' => $artic
        ]);
        //echo '<pre>';
        //print_r($data);
        //echo '<pre>';
        //die;
    }




}

