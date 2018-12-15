<?php

/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:12 PM
 */

namespace Proyecto\Controllers;
use Proyecto\Session\Session;
use Proyecto\Core\Request;
use Proyecto\Core\Route;
use Proyecto\Core\App;
use Proyecto\View\View;
use Proyecto\Model\Usuario;
use Proyecto\Tools\Mail;
use Proyecto\Tools\FormValidator;
use Proyecto\Tools\Buscador;


class HomeController //implements JsonSerializable
{
    public function jsonSerialize(){}

    public function index()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            if (Usuario::existeUsuario($usuario->getUsuarioID())) {
                $usuario->actualizar();

                if ($usuario->getUsuarioID() == 'pf_admin') {
                    header('Location: ' . 'adminPF/home');
                } else {
                    header('Location: ' . 'usuarios/' . $usuario->getUsuarioID());
                }
            } else {
                Session::clearValue("usuario");
                View::render('web/home', [], 1);
            }
        } else {
            View::render('web/home', [], 1);
        };
    }


    public function about()
    {
        View::render('web/about', [], 3);
    }

    public function registrarse()
    {
        View::render('web/registrarse',[], 3);
    }

    public function preguntasFrecuentes()
    {
        View::render('web/preguntas-frecuentes',[], 3);
    }


    public function contacto()
    {
        View::render('web/contacto',[], 3);
    }

    public function contactoEnviar()
    {
        $inputs = Request::getData();

        $formValidator = new FormValidator( $inputs, true);

        // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
        if ( !empty($formValidator->getCamposError()) ){
            Session::set("camposError",$formValidator->getCamposError());
            Session::set("campos",$formValidator->getCampos());
        } else {
            Session::clearValue("camposError");
            Session::clearValue("campos");
            Mail::EnviarMailContacto ($inputs);
            Session::set('mailEnviado',"Y");
        }
        header('Location: ' . App::$urlPath . '/contacto');

    }


    public function terminosYCondiciones()
    {
        View::render('web/terminos-y-condiciones',[], 2);
    }


    /**
     * Método que renderiza la vista de erorr en caso que algo falle
     */
    public function error404()
    {
        View::render('web/error404',[], 2);
    }



    public function verRecuperarPassword(){
        View::render('web/recuperar-password',[], 3);
    }


    public function buscar(){
        $inputs = Request::getData();
        $criterio = $inputs ['criterio'];
        $resultados = Buscador::Buscar($criterio);
        View::render('web/ver-resultados',compact('resultados'), 3);
    }
}

