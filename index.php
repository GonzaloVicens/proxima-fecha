<?php
/*
 * Este archivo va a incluir el autoload, definir algunas constantes de base, y arrancar la aplicación.
 */

// Requerimos el autoload.
//require __DIR__ . '/../autoload.php';
require 'autoload.php';

//echo __DIR__;

//echo __DIR__ . '/../autoload.php';

//die;

use Proyecto\Core\App;

error_reporting(E_ALL);
//error_reporting(0);

// Definimos una constante con la ruta de base de la app.
// Las constantes predefinidas que empiezan y terminan con __ se conocen como "constantes mágicas".
// Se las llama así porque el valor se la constante se carga mágicamente dependiendo del archivo o contexto en el que esté.
// Ej: __DIR__ retorna el directorio del archivo actual.
//define('APP_PATH', 'saraza');
//$appPath = realpath(__DIR__ . '/..');
$appPath = realpath(dirname(__FILE__));

//echo 'Variable Pesos appPath 1 : ' . $appPath . '<br>';

// Transformamos todas las \ en /.
$appPath = str_replace('\\', '/', $appPath);

//echo 'Variable Pesos appPath Modificado: ' . $appPath . '<br>';

//echo 'El require de Pesos appPath pide Pesos appPath: ' . $appPath . '/app/routes.php<br>';



// Incluimos el archivo de rutas.
require $appPath . '/app/routes.php';

//echo 'Paso el require de Pesos appPath /app/routes.php<br>';


//echo "La variable \$appPath vale: " . $appPath . "<br>";

// Instanciamos nuestra aplicación.
//$app = new \DaVinci\Core\App($appPath);
$app = new App($appPath);

// Arrancamos la app.
$app->run();

