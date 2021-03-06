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
            Session::set('usuario', $admin);
            Session::set('logueadoAdmin', 'S');
            $admin->inicioSesion();
            header('Location: ' . App::$urlPath .'/adminPF/home');
        };
    }



    /**
     * Método que controla el cierre de sesión
     * @param Request $request
     */
    public function desloguear()
    {
        Session::clearValue('logueado');
        Session::clearValue('usuario');
        Session::clearValue('logueadoAdmin');
        Session::clearValue('admin');
        header('Location: ' . App::$urlPath . '/');
    }








    public function verHome(){
        $admin = Session::get('admin');

        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')== 'S'){
            View::render('admin/home',compact('admin'), 4);
        } else {
            header('Location: ' . App::$urlPath .'/adminPF');
        }



    }

    public function activarUsuario(){
        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')== 'S'){

            $routeParams = Route::getRouteParams();
            $usuario_id = $routeParams['usuario_id'];

            if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
                if(isset($usuario_id) && !empty($usuario_id)) {
                    Usuario::ActualizarEstado($usuario_id, "1");
                };
            };
            Session::set('tab','usuarios');
            header('Location: ' . App::$urlPath .'/adminPF/home');

        } else {
            header('Location: ' . App::$urlPath .'/adminPF');
        }


    }

    public function desactivarUsuario(){
        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')== 'S'){

            $routeParams = Route::getRouteParams();
            $usuario_id = $routeParams['usuario_id'];

            if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
                if(isset($usuario_id) && !empty($usuario_id)) {
                    Usuario::ActualizarEstado($usuario_id, "0");
                };
            };
            Session::set('tab','usuarios');
            header('Location: ' . App::$urlPath .'/adminPF/home');
        } else {
            header('Location: ' . App::$urlPath .'/adminPF');
        }

    }

    public function activarEquipo(){
        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')== 'S'){

            $routeParams = Route::getRouteParams();
            $equipo_id = $routeParams['equipo_id'];

            if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
                if(isset($equipo_id) && !empty($equipo_id)) {
                    Equipo::ActualizarEstado($equipo_id, "1");
                };
            };
            Session::set('tab','equipos');
            header('Location: ' . App::$urlPath .'/adminPF/home');
         } else {
            header('Location: ' . App::$urlPath .'/adminPF');
        }

        }

    public function desactivarEquipo(){
        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')== 'S'){

            $routeParams = Route::getRouteParams();
            $equipo_id = $routeParams['equipo_id'];

            if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
                if(isset($equipo_id) && !empty($equipo_id)) {
                    Equipo::ActualizarEstado($equipo_id, "0");
                };
            };
            Session::set('tab','equipos');
            header('Location: ' . App::$urlPath .'/adminPF/home');
        } else {
            header('Location: ' . App::$urlPath .'/adminPF');
        }

    }


    /**
     * Método que busca los equipos que tengan un nombre o id que contenga el parámetro.
     */
    public function buscarEquipo()
    {
        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')== 'S'){
            $inputs = Request::getData();
            $resultados = Equipo::BuscarEquipos($inputs );
            Session::set('resultadosEquipo',$resultados);
            header('Location: ' . App::$urlPath .'/adminPF/home');
        } else {
            header('Location: ' . App::$urlPath .'/adminPF');
        }

    }





    /**
     * Método que busca los usaurios que tengan un nombre o id que contenga el parámetro.
     */
    public function buscarUsuario()
    {
        if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')== 'S'){

            $inputs = Request::getData();

            $resultados = Usuario::BuscarUsuariosEnAdmin($inputs);
            Session::set('resultadosUsuario',$resultados);
            header('Location: ' . App::$urlPath .'/adminPF/home');
        } else {
            header('Location: ' . App::$urlPath .'/adminPF');
        }

    }








}

