<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/11/2018
 * Time: 06:39 PM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;

?>

<main class="py-4 mb-4 notificaciones">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h2 class="mt-5 mb-5 pfgreen"><i class="fas fa-bell"></i> Resultados</h2>
                <ul class="list-group colorGris2">
                    <?php foreach($resultados as $linea) {
                        $boton = "";
                        switch ($linea['TIPO']) {
                            CASE 'U':
                                $boton = "<li class='list-group-item'><h3>Usuario: </h3><a href='" . App::$urlPath . "/usuarios/" . $linea['ID'] . "' title='Ver Equipo'>" . $linea['NOMBRE'] . "</a></li>";
                                BREAK;
                            CASE 'E':
                                $boton = "<li class='list-group-item'><h3>Equipo: </h3><a href='" . App::$urlPath . "/equipos/" . $linea['ID'] . "' title='Ver Equipo'>" . $linea['NOMBRE'] . "</a></li>";
                                BREAK;
                            CASE 'T':
                                $boton = "<li class='list-group-item'><h3>Torneo: </h3><a href='" . App::$urlPath . "/torneos/" . $linea['ID'] . "' title='Ver Equipo'>" . $linea['NOMBRE'] . "</a></li>";
                                BREAK;
                            CASE 'S':
                                $boton = "<li class='list-group-item'><h3>Sede: </h3><a href='" . App::$urlPath . "/sedes/" . $linea['ID'] . "' title='Ver Equipo'>" . $linea['NOMBRE'] . "</a></li>";
                                BREAK;
                        }
                        echo $boton;
                        }
                        ?>
                </ul>
            </div>
            <div class="col-md-2">

            </div>
        </div>
    </div>
</main>


