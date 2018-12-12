<?php

/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:12 PM
 */

namespace Proyecto\Controllers;
use Proyecto\Model\Usuario;
use Proyecto\Model\Equipo;
use Proyecto\View\View;
use Proyecto\Session\Session;
use Proyecto\Core\App;
use Proyecto\Core\Request;
use Proyecto\Core\Route;

class AdminController //implements JsonSerializable
{
    public function jsonSerialize(){}

    public function login()
    {
        Session::clearValue('admin');
        Session::clearValue('logueadoAdmin');

        View::render('admin/login', [], 2);
    }


    public function loguear()
    {
        $inputs = Request::getData();

        if (isset($inputs ["usuario"]) && !empty($inputs ["usuario"]) && isset($inputs ["password"]) && !empty($inputs ["password"])) {
            $admin = New Usuario($inputs ['usuario'], $inputs ['password']);
            $error = $admin->validarAdmin();
        } else {
            $error = "No ha ingresado el usuario o la contraseña";
        }

        if ($error) {
            Session::set('errorAdmin', $error);
            Session::clearValue('admin');
            Session::clearValue('logueadoAdmin');
            header('Location: ' . App::$urlPath .'/adminPF');

        } else {
            Session::clearValue('errorAdmin');
            Session::set('admin', $admin);
            Session::set('logueadoAdmin', 'S');
            $admin->inicioSesion();
            header('Location: ' . App::$urlPath .'/adminPF/home');
        };
    }

    public function verHome(){
        $admin = Session::get('admin');
        View::render('admin/home',compact('admin'), 3);
    }

    public function activarUsuario(){
        $routeParams = Route::getRouteParams();
        $usuario_id = $routeParams['usuario_id'];

        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
            if(isset($usuario_id) && !empty($usuario_id)) {
                Usuario::ActualizarEstado($usuario_id, "1");
            };
        };
        header('Location: ' . App::$urlPath .'/adminPF/home');

    }

    public function desactivarUsuario(){
        $routeParams = Route::getRouteParams();
        $usuario_id = $routeParams['usuario_id'];

        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
            if(isset($usuario_id) && !empty($usuario_id)) {
                Usuario::ActualizarEstado($usuario_id, "0");
            };
        };
        header('Location: ' . App::$urlPath .'/adminPF/home');

    }

    public function activarEquipo(){
        $routeParams = Route::getRouteParams();
        $equipo_id = $routeParams['equipo_id'];

        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
            if(isset($equipo_id) && !empty($equipo_id)) {
                Equipo::ActualizarEstado($equipo_id, "1");
            };
        };
        header('Location: ' . App::$urlPath .'/adminPF/home');

    }

    public function desactivarEquipo(){
        $routeParams = Route::getRouteParams();
        $equipo_id = $routeParams['equipo_id'];

        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
            if(isset($equipo_id) && !empty($equipo_id)) {
                Equipo::ActualizarEstado($equipo_id, "0");
            };
        };
        header('Location: ' . App::$urlPath .'/adminPF/home');

    }

}

