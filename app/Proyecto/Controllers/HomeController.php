<?php

/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:12 PM
 */

namespace Proyecto\Controllers;
use Proyecto\View\View;
use Proyecto\Session\Session;


class HomeController //implements JsonSerializable
{
    public function jsonSerialize(){}

    public function index()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();
            header('Location: ' . 'usuarios/' . $usuario_id );

            //View::render('web/ver-usuario',compact('usuario','usuario_id'), 3);
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


}

