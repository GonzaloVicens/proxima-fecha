<?php


function __autoload($className) {
    //  La clase que vamos a buscar es $className
    // Para compatibilidad con SOs Linux y similares,
    // convertimos las \ en /.
    $className = str_replace('\\', '/', $className);

    // Definimos la ruta donde tenemos las clases.
    $classPath = dirname(__FILE__) . '/app/' . $className . ".php";
	$classPath = str_replace('\\', '/', $classPath);
    //echo $classPath;
    require $classPath;
}