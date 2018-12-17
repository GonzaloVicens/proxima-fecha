<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Model\Torneo;
use Proyecto\Model\Usuario;
use Proyecto\Model\Partido;
use Proyecto\Session\Session;


$partidoActual->actualizar();
$local->actualizar();
$visita->actualizar();
$datosPartido = $partidoActual->getInfoPartido();

?>
<main class="py-4 mb-4 ver-partido-cargar-datos">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
            </div>

            <?php
            $hrefBotonVolver =   App::$urlPath . "/torneos/ver-fixture-completo";
            $etiquetaBotonVolver = "Volver";
            if (Torneo::GetEstadoIdPorTorneo($partidoActual->getTorneoID()) == 'C') {
                if (Session::has('logueado')) {
                    $usuario = Session::get('usuario');
                    if (($usuario->getUsuarioID() == $partidoActual->getArbitroID()) && (!$partidoActual->fueJugado())) {
                        Session::set('partidoAFinalizar',$partidoActual);
                        $hrefBotonVolver  =   App::$urlPath . "/torneos/finalizar-partido";
                        $etiquetaBotonVolver=   "Finalizar";
                    }
                }
            };
            ?>

            <div class="col-md-2">
                <a href='<?=$hrefBotonVolver ?>' class='btn btn-outline-secondary' style='float:right'><i class='fas fa-chevron-left'></i> <?= $etiquetaBotonVolver?></a>
            </div>
            <div class="col-md-12">
                <h2 class="pfgreen mt-4 mb-2">
                    <span class="font-weight-normal colorGris2"><i class="fas fa-trophy"></i> <?=$datosPartido['tipo_descr']?></span>
                    <span class=""><?=$datosPartido['nombre']?></span>
                </h2>
                <a href='<?= App::$urlPath . '/torneos/ver-fixture-completo'  ?>' class="d-block ml-2 mb-5 colorGris1 hoverVerde"><i class="fas fa-shield-alt"></i> Ver Fixture Completo</a>
                <h2 class="mt-3 mb-3 pfgreen h4"><i class="fas fa-edit"></i> Cargar Datos en Partido</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">


                <div class="container_tabla_y_arbitro">
                    <div class="table_container shadow">
                        <div class="header_table_jornada">
                            <h4 class=""><i class="far fa-calendar-alt"></i>  <?=$datosPartido['fase_descr']?> <span> </span></h4>
                        </div>
                        <div>
                            <table class="jornada_table">
                                <tr>
                                    <td class="text-right equipos"><div class="nombre_equipo"><?= $partidoActual->getLocalNombre()?></div></td>
                                    <td class="versus"><?= $partidoActual->getPuntosLocal()?> - <?= $partidoActual->getPuntosVisita()?></td>
                                    <td class="text-left equipos"><div class="nombre_equipo"><?= $partidoActual->getVisitaNombre()?></div></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php
                    echo "<p class='colorGris4 text-center'><span class='font-regular-bold'> Arbitro del encuentro:</span> " . $partidoActual->getArbitroDescr();
                IF ( Session::has('logueado')){
                    if(($usuario->esCapitanDeEquipo($partidoActual->getLocalID()) || $usuario->esCapitanDeEquipo($partidoActual->getVisitaID())) && ($usuario->getUsuarioID() != $partidoActual->getArbitroID())) {
                        // Configuro el origen del chat para el botón "Volver" de la conversacion;
                        Session::set('origenChat', '/torneos/' . $partidoActual->getTorneoID() . "/" . $partidoActual->getFaseID() . "/" . $partidoActual->getPartidoID() );

                        echo  "<a href='". App::$urlPath . "/mensajes/" . $usuario->getUsuarioID() . "/" . $partidoActual->getArbitroID() . "' class='enviar-mensaje'>Enviar Mensaje</a>";
                    }
                }
                    echo "</p>";
                    ?>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $local->printFormularioPartido($partidoActual);
                    $local->printJugadoresEnPartido($partidoActual->getFichas(), true );
                ?>
            </div>
            <div class="col-md-6">
                <?= $visita->printFormularioPartido($partidoActual);
                    $visita->printJugadoresEnPartido($partidoActual->getFichas(), false);
                ?>

            </div>
        </div>
    </div>
</main>

