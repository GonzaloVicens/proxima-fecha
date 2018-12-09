<?php

/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:12 PM
 */

namespace Proyecto\Controllers;
use Proyecto\Model\Usuario;
use Proyecto\View\View;
use Proyecto\Session\Session;


class HomeController //implements JsonSerializable
{
    public function jsonSerialize(){}

    public function index()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            if (Usuario::ExisteUsuario($usuario->getUsuarioID())) {
                $usuario->actualizar();
                header('Location: ' . 'usuarios/' . $usuario->getUsuarioID());
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
}

