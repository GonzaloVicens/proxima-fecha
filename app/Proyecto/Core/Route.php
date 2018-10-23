<?php

namespace Proyecto\Core;

/**
 * Class Route
 * @package Proyecto\Core
 *
 * Se encarga de manejar todo lo relativo a rutas.
 *
 * De una ruta, necesitamos saber:
 * - Método
 * - URL
 * - Método del controller que la va a manejar
 */
class Route
{
    /** @var array Las rutas de nuestra aplicación. */
    protected static $routes = [
        'GET'       => [
            // 'URL' => 'Controller@acciónDelController'
            // Ejemplo:
            // '/peliculas' => 'PeliculaController@index',
        ],
        'POST'      => [],
        'PUT'       => [],
        'DELETE'    => [],
    ];

    protected static $routeDetected;
    protected static $routeParams;

    /**
     * @return array
     * @todo Eventualmente, deberíamos eliminar este método.
     */
    public static function getRoutes()
    {
        return self::$routes;
    }

    /**
     * Registra una URL en la aplicación.
     *
     * @param string $method El verbo de HTTP. Puede ser GET, POST, PUT, DELETE.
     * @param string $url La url a registrar.
     * @param string $controllerAction La acción que queremos realizar. Formato: Controller@acción .
     */
    public static function addRoute($method, $url, $controllerAction)
    {
        // Pasamos el método a mayúsculas.
        $method = strtoupper($method);

        // Agregamos la ruta al listado.
        // TODO: Verificar que el método sea válido.
        self::$routes[$method][$url] = $controllerAction;
    }

    /**
     * Verifica si la url para ese método está definida
     * como una ruta.
     *
     * @param string $method El método de la ruta.
     * @param string $url La url de la ruta.
     * @return bool
     */
    public static function routeExists($method, $url)
    {
        // Primero, verificamos si existe una ruta con la
        // exacta url que nos están pidiendo.
        // Ejemplo: self::$routes['GET']['/peliculas']
        if(isset(self::$routes[$method][$url])) {
            return true;
        } else {
            // Si no existe la anterior, entonces verificamos
            // si es una ruta con parámetros. Los parámetros
            // son los valores que definimos entre {} en la
            // ruta.
            return self::parameterizedRouteExists($method, $url);
        }
    }

    /**
     * Indica si la ruta parametrizada existe o no.
     * Ej:
     * '/peliculas/{id}'
     *
     * @param string $method El verbo HTTP.
     * @param string $url La url.
     * @return boolean
     */
    public static function parameterizedRouteExists($method, $url)
    {
        // Contamos la cantidad de niveles de la url
        // pedida.
        $urlNiveles = substr_count($url, '/');
//        echo "La url que están pidiendo es: " . $url . " - tiene " . $urlNiveles . " niveles<br>";
//        echo "Listando las rutas...<br>";
        // Recorremos las rutas del verbo pedido.
        foreach (self::$routes[$method] as $route => $action) {
            // Primero, descartamos las rutas que no tengan
            // la misma cantidad de "niveles" de la url
            // pedida. Cada nivel sería cada "/", es decir,
            // cada directorio.
            // Ej: La ruta
            // /peliculas/1
            // Tiene 2 niveles.
            $cantidadDeNiveles = substr_count($route, '/');
            // Preguntamos si la cantidad de niveles es
            // correcta y si la ruta contiene una "{".
            if($cantidadDeNiveles == $urlNiveles
                && strpos($route, '{') !== false) {
//                echo $route . " - tiene " . $cantidadDeNiveles . " niveles.<br>";
                // Verificamos finalmente si la ruta
                // coincide con la url.
                if(self::parameterizedRouteMatches($route, $url)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Indica si $route matchea con $url.
     *
     * @param string $route La ruta. Ej: /peliculas/{id}
     * @param string $url La url pedida. Ej: /peliculas/1
     * @return boolean
     */
    public static function parameterizedRouteMatches($route, $url)
    {
        //echo "Verificando que la ruta parametrizada coincida.<br>";
        //echo "Ruta: " . $route . "<br>";
        //echo "URL: " . $url . "<br>";
        // Para saber si la ruta matchea o no, debemos
        // verificar que todos los niveles que NO tengan
        // {}, sean idénticos en ambas rutas.
        // Obtenemos los fragmentos de la url y la ruta.
        $routeParts = explode('/', $route);
        $urlParts = explode('/', $url);
        // Asumimos por defecto que la ruta matchea.
        $routeMatches = true;
        // Creamos un array para almacenar los valores
        // dinámicos (los que están entre {}).
        $routeData = [];

        // Recorremos las partes de la ruta para ver que
        // todas matcheen.
        //echo "Verificamos las partes que matcheen...<br>";
        foreach ($routeParts as $key => $routePart) {
            // Obtenemos la posición equivalente de la url.
            $urlPart = $urlParts[$key];
            // Verificamos si esta parte de la ruta
            // no coincide con la de la url.
            //echo $routePart . " == " . $urlPart . "<br>";
            if($routePart != $urlPart) {
                // Verificamos si es un parámetro.
                if(strpos($routePart, '{') !== false) {
                    // Es un parámetro!
                    // Lo guardamos en el array de
                    // $routeData
                    // substr($var, 1, -1) quita el
                    // primer y último caracter.
                    $parameterName =  substr($routePart, 1, -1);
                    // Guardamos ese parámetro en el
                    // array.
                    // Ej:
                    // $routeData['id'] = 1;
                    $routeData[$parameterName] = $urlPart;
                } else {
                    // La ruta no matchea...
                    $routeMatches = false;
                }
            }
        }

        // Preguntamos si la ruta matchea.
        if($routeMatches) {
            // Guardamos los datos de la ruta.
            self::$routeDetected = $route;
            self::$routeParams = $routeData;

                    //echo "La ruta matchea! :D<br>";
                    //echo "La ruta es: " . $route . "<br>";
                    //echo "Los datos son: ";
                    //echo "<pre>";
                    //print_r($routeData);
                    //echo "</pre>";

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $method El método de la ruta.
     * @param string $url La url de la ruta.
     * @return array Los datos de la acción. En el índice 0 va a estar el nombre del Controller, en el índice 1 va a estar el método del Controller.
     */
    public static function getRouteAction($method, $url)
    {
        // Si hay una ruta que hayamos matcheado
        // previamente, por ejemplo en la verificación de
        // url parametrizada, usamos esa como url.
        if(!empty(self::$routeDetected)) {
            $url = self::$routeDetected;
        }

        // Buscamos la data del controller asociada a la
        // ruta. El formato siempre es:
        // 'Controller@métodoDelController'
        $controllerData = self::$routes[$method][$url];

        return explode('@', $controllerData);
    }

    /**
     * @return mixed
     */
    public static function getRouteParams()
    {
        return self::$routeParams;
    }
}