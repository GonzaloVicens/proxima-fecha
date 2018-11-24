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
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();

            View::render('web/usuario',compact('usuario','usuario_id'), 3);
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


    public function verProximaFecha()
    {
        View::render('web/ver-proxima-fecha',[], 3);
    }


    public function verFixtureCompleto()
    {
        View::render('web/ver-fixture-completo',[], 3);
    }


    public function agregarEquipos()
    {
        View::render('web/agregar-equipos',[], 3);
    }


    public function editarTorneo()
    {
        View::render('web/editar-torneo',[], 3);
    }


    /**
     * Método que renderiza la vista de erorr en caso que algo falle
     */
    public function error404()
    {
        View::render('web/error404',[], 2);
    }


}

