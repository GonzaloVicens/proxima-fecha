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
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <!-- El h2 debajo tendría que tener contenido dinámico, según se trate de Torneo o Liga-->
                <h3 class="h5 mt-4 mb-2 colorGris2 font-weight-normal"><i class="fas fa-trophy"></i> <?=$datosPartido['tipo_descr']?></h3>
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/torneos/ver-fixture-completo'  ?>" class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mb-3 pfgreen h2"><?=$datosPartido['nombre']?></h2>
                <div class="table_container shadow">
                    <div class="header_table_jornada">
                        <h4 class=""><i class="far fa-calendar-alt"></i>  <?=$datosPartido['fase_descr']?> <span> </span></h4>
                    </div>
                    <div>
                        <table class="jornada_table">
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo"><?= $partidoActual->getLocalName()?></div></td>
                                <td class="versus"><?= $partidoActual->getPuntosLocal()?> - <?= $partidoActual->getPuntosVisita()?></td>
                                <td class="text-left equipos"><div class="nombre_equipo"><?= $partidoActual->getVisitaName()?></div></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php
                echo "<h4>Arbitro del encuentro: " . $partidoActual->getArbitroDescr(). "</h4>";

                if($usuario->esCapitanDeEquipo($partidoActual->getLocalID()) || $usuario->esCapitanDeEquipo($partidoActual->getVisitaID())) {
                    // Configuro el origen del chat para el botón "Volver" de la conversacion;
                    Session::set('origenChat', '/torneos/' . $partidoActual->getTorneoID() . "/" . $partidoActual->getFaseID() . "/" . $partidoActual->getPartidoID() );

                    echo  "<a href='". App::$urlPath . "/mensajes/" . $usuario->getUsuarioID() . "/" . $partidoActual->getArbitroID() . "' class='enviar-mensaje'>Enviar Mensaje</a>";
                } else {
                }
                ?>


            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $local->printJugadoresEnPartido($partidoActual->getFichas(), true );
                $local->printFormularioPartido($partidoActual);
                ?>
            </div>
            <div class="col-md-6">
                <?= $visita->printJugadoresEnPartido($partidoActual->getFichas(), false);
                $visita->printFormularioPartido($partidoActual);
                ?>

            </div>
        </div>
        <a href='<?= App::$urlPath . '/torneos/ver-fixture-completo'  ?>' class="colorGris2 hoverVerde"><i class="fas fa-shield-alt"></i> Ver Fixture Completo</a>
    </div>
</main>

