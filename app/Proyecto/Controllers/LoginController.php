<?php

namespace Proyecto\Controllers;

use Proyecto\Core\App;
use Proyecto\Core\Route;
use Proyecto\Model\Usuario;
use Proyecto\View\View;
use Proyecto\Auth\Autenticar;

/**
 * Class HomeController
 * @package Proyecto\Controllers
 *
 */
class LoginController
{

    public function index()
    {

        View::render('web/login');

    }

     public function registro()
    {

        View::render('login/registro2');

    }

    /**
     * Ingresa un nuevo Usuario a la base si los datos enviados cunplen con la validación
     *
     * De no pasar la validación devuelve al formulario de registro guardando los datos registrados por el usuairo.
     */

    public function crear_usuario()
    {
        // Obtenemos los datos de POST.
        $input = $_POST;
        $_SESSION['_data_'] = $_POST;

        // Validamos los datos enviados por $_POST
        $regresar = false;

        if ($input['usuario']=='') {
            $_SESSION['usuario_error'] = "Es obligatorio ingresar un nombre de usuario";
            $regresar = true;
        }

        if (!filter_var($input['mail'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['mail_error'] = "La dirección de correo <em>" . $input['mail'] . "</em> no es válida.";
            $regresar = true;
        }

        if ($input['nombre']=='') {
            $_SESSION['nombre_error'] = "Necesitamos que ingreses tu nombre";
            $regresar = true;
        }

        if ($input['apellido']=='') {
            $_SESSION['apellido_error'] = "Necesitamos que ingreses tu apellido";
            $regresar = true;
        }

        if ($input['sexo']=='') {
            $_SESSION['sexo_error'] = "Necesitamos saber tu sexo";
            $regresar = true;
        }

        if ($input['pais']=='') {
            $_SESSION['pais_error'] = "Necesitamos que ingreses tu pais";
            $regresar = true;
        }

        if ($input['password']=='') {
            $_SESSION['password_error'] = "Es obligatorio ingresar un password";
            $regresar = true;
        } else if ($input['password'] != $input['password2']) {
            $_SESSION['password_error'] = "Los passwords no coinciden. Por favor, confirme su password correctamente";
            $regresar = true;
        }

        if($regresar){

            $_SESSION['_input_'] = $_POST;

            View::render('login/registro2');

        } else {

            unset($input['password2']);

            Usuario::crear($input);

            header('Location: ' . App::$urlPath . '/login');

        }

    }

    public function autenticar()
    {

        if(Autenticar::login($_POST['USUARIO'], $_POST['PASSWORD'])){

            $_SESSION['NOMBRE'] = $_POST['USUARIO'];
            header('Location: ' . App::$urlPath . '/abm');
        } else {
            $_SESSION['_error'] = "Usuario y/o password incorrectos.";
            $_SESSION['_input'] = $_POST;
            header('Location: ' . App::$urlPath . '/login');

        }
    }

}
