<?php

namespace Proyecto\View;

use Proyecto\Core\App;
use Proyecto\Session\Session;
/**
 * Class View
 * @package Proyecto\View
 *
 * Se encarga del renderizado de vistas.
 */

class View
{
    /**
     * @param string $template La ruta a la vista a partir de la carpeta /views, sin la extensión .php
     * @param array $data Los datos a proporcionarle a la vista. El índice de cada item es el nombre de la variable a crear, y su valor, el contenido.
     */
    public static function render($template, $data = [], $contexto = null)
    {

        $header1 = App::$viewPath . '/templates/header-home.php';
        $header2 = App::$viewPath . '/templates/header-registro.php';
        $header3 = App::$viewPath . '/templates/header-cuenta-usuario.php';
        $header4 = App::$viewPath . '/templates/header-admin.php';

        $footer1 = App::$viewPath . '/templates/footer-home.php';
        $footer2 = App::$viewPath . '/templates/footer-registro.php';
        $footer3 = App::$viewPath . '/templates/footer-cuenta-usuario.php';
        $footer4 = App::$viewPath . '/templates/footer-admin.php';


        // Calculamos la ruta del template.
        $templatePath = App::$viewPath . '/' . $template . ".php";

        // Recorro el array de data, y creo las variables para el template.
        foreach ($data as $varName => $value) {
            ${$varName} = $value;
        }

        // Si no hay un usuario conectado no puedo mostrar el template de "Cerrar Sesión"
        if(($contexto == 3) &&  !(Session::has("logueado"))){
            $contexto = 2;
        }

            // Incluimos el header.
        //require App::getViewsPath() . '/templates/header.php';

        if($contexto == 1){
            // Renderizo el template.
            require $header1;
            require $templatePath;
            require $footer1;
        }
        else if($contexto == 2){
            require $header2;
            require $templatePath;
            require $footer2;

        } else if($contexto == 3){
            require $header3;
            require $templatePath;
            require $footer3;
        } else if($contexto == 4){
            require $header4;
            require $templatePath;
            require $footer4;
        } else {
            require $templatePath;
        }

    }
}