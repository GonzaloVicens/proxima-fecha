<?php

namespace Proyecto\Core;

/**
 * Class Request
 * @package Proyecto\Core
 *
 * Se encarga de maneja lo relativo a las peticiones.
 *
 * Esto incluye:
 * - Parseo de la url.
 * - Obtención de datos por GET, POST, PUT, DELETE.
 */
class Request
{
    /** @var string La URL que el usuario pidió. */
    protected static $requestedUrl;

    /** @var string La URL a partir de la carpeta public. */
    protected static $routeUrl;

    /** @var array Los datos recibidos por POST. */
    protected static $postData = [];

    /** @var string El verbo de la petición HTTP. */
    protected static $method;

    /**
     * Parsea la url pedida por el usuario, y registra
     * la url de la ruta.
     *
     * @param string $publicPath La ruta a la carpeta public.
     */
    public static function parse($publicPath)
    {
        //echo "Parseando la url...<br>";
        //echo "<pre>";
        //print_r($_SERVER);
        //echo "</pre>";

        // Registramos el verbo.
        self::$method = $_SERVER['REQUEST_METHOD'];

        //echo "pesos server DOCUMENT_ROOT" . $_SERVER['DOCUMENT_ROOT'] . "<br>";
        //echo "<br><br>pesos server REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";

        //Le saco el primer caracter porque me tira una ruta con doble barra en la mitad
        $name = $_SERVER['REQUEST_URI'];
        $name = substr($name,1);

        //echo '<br>' . $name;


        // Armamos con los datos de $_SERVER la ruta
        // del archivo ficticio que nos están pidiendo.
        $requestedPath = $_SERVER['DOCUMENT_ROOT'] . $name;

        // Obtenemos la ruta quitando el public path al
        // requested path.
        self::$routeUrl = str_replace($publicPath, '', $requestedPath);
        self::$routeUrl = '/' . self::$routeUrl;

        //echo "<br><br>El requested path es: " . $requestedPath . "<br>";
        //echo "<br><br>El public path es: " . $publicPath . "<br>";
        //echo "Finalmente, la url de la ruta es... " . self::$routeUrl;
    }

    /**
     * @return string
     */
    public static function getRouteUrl()
    {

        return self::$routeUrl;
    }

    /**
     * @return string
     */
    public static function getMethod()
    {
        return self::$method;
    }
}