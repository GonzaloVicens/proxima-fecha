<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/11/2018
 * Time: 06:39 PM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;


$resultado = "<ul class='list-group colorGris2 rounded shadow-sm'>";
$finresultado = "</ul>";
$sinresultados = "<div class='d-flex align-items-center justify-content-center sin_resultados text-center colorGris1 fontSize5rem border shadow-sm p-3'><i class='fas fa-search mx-5'></i><p class='h2 text-left'>No hubo coincidencias<br> con la búsqueda</p></div>";
$listado_user = "";
$listado_torneos = "";
$listado_sedes = "";
$listado_equipos = "";
?>

<main class="py-4 mb-4 notificaciones">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h2 class="mt-5 mb-5 pfgreen"><i class="fas fa-search"></i> Resultados de Búsqueda</h2>
                <!--ul class="list-group colorGris2"-->
                    <?php foreach($resultados as $linea) {
                        switch ($linea['TIPO']) {
                            CASE 'U':
                                $listado_user .= "<li class='list-group-item'><a class='pfgreen hoverVerde' href='" . App::$urlPath . "/usuarios/" . $linea['ID'] . "' title='Ver Usuario'>" . $linea['NOMBRE'] . "</a></li>";
                                BREAK;
                            CASE 'E':
                                $listado_equipos .= "<li class='list-group-item'><a class='pfgreen hoverVerde' href='" . App::$urlPath . "/equipos/" . $linea['ID'] . "' title='Ver Equipo'>" . $linea['NOMBRE'] . "</a></li>";
                                BREAK;
                            CASE 'T':
                                $listado_torneos .= "<li class='list-group-item'><a class='pfgreen hoverVerde' href='" . App::$urlPath . "/torneos/" . $linea['ID'] . "' title='Ver Torneo'>" . $linea['NOMBRE'] . "</a></li>";
                                BREAK;
                            CASE 'S':
                                $listado_sedes .= "<li class='list-group-item'><a class='pfgreen hoverVerde' href='" . App::$urlPath . "/sedes/" . $linea['ID'] . "' title='Ver Sede'>" . $linea['NOMBRE'] . "</a></li>";
                                BREAK;
                        }
                        //echo $boton;
                        }
                        ?>
                <!--/ul-->
                <div class="resultado_container my-5">
                    <h3 class="text-muted my-3 h4"><i class="fas fa-trophy"></i> Torneos encontrados </h3>
                    <?php
                    if($listado_torneos == ""){
                        echo $sinresultados;
                    } else {
                        echo $resultado . $listado_torneos . $finresultado;
                    }
                    ?>
                </div>
                <div class="resultado_container my-5">
                    <h3 class="text-muted my-3 h4"><i class="fas fa-shield-alt"></i> Equipos Encontrados </h3>
                    <?php
                    if($listado_equipos == ""){
                        echo $sinresultados;
                    } else {
                        echo $resultado . $listado_equipos . $finresultado;
                    }
                    ?>
                </div>
                <div class="resultado_container my-5">
                    <h3 class="text-muted my-3 h4"><i class="fas fa-user"></i> Usuarios Encontrados </h3>
                    <?php
                    if($listado_user == ""){
                        echo $sinresultados;
                    } else {
                        echo $resultado . $listado_user . $finresultado;
                    }
                    ?>
                </div>
                <div class="resultado_container my-5">
                    <h3 class="text-muted my-3 h4"><i class='fas fa-map-marker-alt'></i>  Sedes Encontradas </h3>
                    <?php
                    if($listado_sedes == ""){
                        echo $sinresultados;
                    } else {
                        echo $resultado . $listado_sedes . $finresultado;
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-2">

            </div>
        </div>
    </div>
</main>


