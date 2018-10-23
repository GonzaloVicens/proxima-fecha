<?php

/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:12 PM
 */

namespace Proyecto\Controllers;
use Proyecto\View\View;
use Proyecto\Auth\Autenticar;
use Proyecto\Core\App;
use Proyecto\Model\Mensaje;
//use Proyecto\Model\Alimento;
//use Proyecto\Model\Articulo;
//use \JsonSerializable;

class HomeController //implements JsonSerializable
{
    public function jsonSerialize(){}

    public function index()
    {

        //$ultimaspub = Articulo::traerUltimosTres();

        View::render('web/home', [], 1);

    }

    public function loguin()
    {


        if(Autenticar::login($_POST['usuario'], $_POST['password'])){
            //if(Autenticar::login($_POST){
            $_SESSION['NOMBRE'] = $_POST['usuario'];
            header('Location: ' . App::$urlPath . '/about');
        } else {
            $_SESSION['_error'] = "Usuario y/o password incorrectos.";
            $_SESSION['_input'] = $_POST;
            //print_r($_SESSION['_input']);
            //die;
            header('Location: ' . App::$urlPath . '/');
        }


        /*
        Session::start();
        if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && isset($_POST["password"]) && !empty($_POST["password"])) {
            $usuario = New Usuario($_POST['usuario'], $_POST['password']);
            $error = $usuario->validarUsuario();
        } else {
            $error = "No ha ingresado el usuario o la contraseña";
        }

        if(isset($_POST['ajax'])) {
            if ($error){
                echo json_encode([
                    'status' => 1,
                    'data' => $error
                ]);
            } else {
                echo json_encode([
                    'status' => 0,
                ]);
            }
        } else {
            if ($error){
                Session::set('errorLogin', $error);
                Session::clear('usuario');
                Session::clear('logueado');
                header("Location: ../index.php");
            } else {
                Session::clear('errorLogin');
                Session::set('usuario',$usuario);
                Session::set('logueado','S');
                header("Location: ../index.php?seccion=miusuario&usuario_id=".$usuario->getUsuarioID());
            }
        }
            */

    }


    public function about()
    {

        View::render('web/about');

    }

    public function registrarse()
    {
        View::render('web/registrarse',[], 2);
    }


    public function miusuario()
    {
        View::render('web/miusuario',[], 3);
    }

}

