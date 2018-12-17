<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;

use Proyecto\Model\Torneo;
use Proyecto\Session\Session;

$torneoAMostrar->actualizar();
?>

<main class="py-4 mb-4 torneo">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h3 class="mt-4 mb-1 h4 colorGris2 font-weight-normal"><i class="fas fa-trophy"></i> <?= $torneoAMostrar->getDescrTipoTorneo() ?></h3>
            </div>
            <div class="col-md-2">
                <!--button class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</button-->
            </div>
            <div class="col-md-8">
                <!-- Nombre de Torneo Debajo, tendría que ser dinámico -->
                <h2 class="mb-4 pfgreen h1"><?= $torneoAMostrar->getNombre() ?></h2>
                <p class="text-muted"><i class="far fa-calendar-alt"></i> Estado: <?=$torneoAMostrar->getEstadoDescr()?> - Fecha de Inicio: <span><?= $torneoAMostrar->getFechaInicio() ?></span></p>
                <p class="text-muted"><i class="fas fa-home"></i> Sede: <span class="font-italic"><?= $torneoAMostrar->getDescrSede() ?></span></p>
                <p class="text-muted"><i class="fas fa-shield-alt"></i></i> Cantidad Equipos Participantes: <span><?= $torneoAMostrar->getCantidadEquipos() ?></span></p>
                <p class="text-muted"><i class="fas fa-shield-alt"></i></i> Cantidad Equipos Agregados: <span><?= $torneoAMostrar->getCantidadEquiposAgregados() ?></span></p>
                <p class="text-muted"><i class="fas fa-calendar-alt"></i></i> El torneo se juega los dias: <span><?= $torneoAMostrar->getDiasTorneoEnString() ?></span></p>
            <?php
            if ($torneoAMostrar->getLugaresLibres() > 0 ){ ?>
                <p class="text-muted font-italic d-block">Resta agregar <?= $torneoAMostrar->getLugaresLibres() ?> equipos aún</p>
            <?php }
            $torneoAMostrar->printInscripcionesEnLi() ;
            ?>

            </div>
            <div class="col-md-4">
                <h3 class="pfgreen h4 mt-4">Organizadores:</h3>
                <ul class="list-unstyled">
                    <?php
                    foreach($organizadoresActivos as $organizadorActual) {
                        $boton ="";
                        if (Session::has('logueado')){
                            $usuario = Session::get("usuario");
                            $usuario->actualizar();
                            if ($usuario->esCapitanDeEquipo() && $usuario->getUsuarioID() != $organizadorActual['ORGANIZADOR_ID']  ) {

                                // Cionfiguro el origen del chat para el botón "Volver" de la conversacion;
                                Session::set('origenChat','/torneos/'.$torneoAMostrar->getTorneoID());
                                $boton = "<a href='../mensajes/". $usuario->getUsuarioID() . "/" . $organizadorActual['ORGANIZADOR_ID'] . "' class='enviar-mensaje'>Enviar Mensaje</a>";
                            }
                        }

                        echo "<li>" . $organizadorActual['APELLIDO'] . ", " . $organizadorActual['NOMBRE'] . $boton . "</li>";
                    } ?>
                </ul>
                <!--<h3 class="mb-4 pfgreen fontSize1-6rem font-weight-normal">Acciones</h3>-->
                <?php if (isset($usuario) && $usuario->esOrganizadorDeTorneo($torneoAMostrar->getTorneoID())) { ?>
                    <?php if ($torneoAMostrar->esNuevo()) { ?>
                    <p>
                        <a href="<?= App::$urlPath; ?>/torneos/editar-torneo" class="naranjaFecha hoverVerde"><i
                                class="far fa-edit"></i> Modificar Datos del Torneo</a>
                    </p>
                <?php } ?>
                <p>
                    <a href="<?= App::$urlPath; ?>/torneos/editar-organizadores" class="naranjaFecha hoverVerde"><i
                            class="far fa-edit"></i> Administrar Organizadores</a>
                </p>
                <?php if (!$torneoAMostrar->estaEnCurso()) { ?>
                    <p>
                        <button href="#" class="btn btn-link naranjaFecha hoverVerde" id="eliminar_torneo"><i
                                class="fas fa-times-circle"></i> Eliminar Torneo
                        </button>
                    </p>
                <?php } ?>
                <?php if ($torneoAMostrar->esNuevo()) { ?>
                    <?php if ($torneoAMostrar->getLugaresLibres() > 0) { ?>
                        <p>
                            <a href="<?= App::$urlPath; ?>/torneos/agregar-equipos" class="naranjaFecha hoverVerde"><i
                                    class="fas fa-plus-circle"></i> Agregar Equipo</a>
                        </p>
                    <?php }
                    if ($torneoAMostrar->getLugaresLibres() == 0 && !$torneoAMostrar->tieneFixture()) { ?>
                        <p>
                            <a href="generar-fixture" class="naranjaFecha btn btn-lg btn-outline-warning"><i
                                    class="fas fa-trophy"></i> Generar Fixture</a>
                        </p>
                    <?php }
                    if ($torneoAMostrar->tieneFixture() && $torneoAMostrar->estaInicial()) { ?>
                        <p>
                            <a href="comenzar-torneo" class="naranjaFecha btn btn-lg btn-outline-warning"><i
                                    class="fas fa-trophy"></i> Comenzar Torneo</a>
                        </p>
                    <?php }
                }
                if ($torneoAMostrar->estaEnCurso()) {
                    ?>
                    <p>
                        <a href="finalizar-torneo" class="naranjaFecha btn btn-lg btn-outline-warning"><i
                                class="fas fa-trophy"></i> Finalizar Torneo</a>
                    </p>
                    <?php
                }
                if ($torneoAMostrar->estaFinalizado()) {
                    ?>
                    <p>
                        <a href="reiniciar-torneo" class="naranjaFecha btn btn-lg btn-outline-warning"><i
                                class="fas fa-trophy"></i> Reiniciar Torneo</a>
                    </p>
                <?php }
            }
            if ($torneoAMostrar->tieneFixture()) { ?>
                <p>
                    <a href="ver-fixture-completo" class="naranjaFecha btn btn-lg btn-outline-warning hoverVerde"><i class="fas fa-trophy"></i> Ver Fixture</a>
                </p>
            <?php }
                $equiposCapitan =  $usuario->getEquiposInscripcion($torneoAMostrar->getTorneoID());
            if ($torneoAMostrar->estaInicial() && $usuario->esCapitanDeEquipo() && count($equiposCapitan) >0 ){ ?>
                <form action="solicitar-inscripcion" method="POST" class="container">
                    <input type="hidden" name="torneo_id" value="<?=$torneoAMostrar->getTorneoID()?>" />
                    <label for="equipo_id">Mi Equipo</label>
                    <select name="equipo_id" id="equipo_id" class="form-control">
                        <?php foreach($equiposCapitan as $equipo){
                            echo "<option value='" . $equipo['EQUIPO_ID'] . "'>" . $equipo['NOMBRE']  . "</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" class="naranjaFecha btn btn-lg btn-outline-warning hoverVerde" value="Inscribirse en Torneo" />
                </form>
            <?php } ?>
            </div>
        </div>
        <div class="main_miequipo row">

            <div class="col-md-9">
                <nav class="tabs_miequipo">
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link pfgreen hoverVerde active" id="nav-miequipo-tab" data-toggle="tab" href="#nav-miequipo" role="tab" aria-controls="nav-miequipo" aria-selected="true">Equipos que Participan</a>
                        <a class="nav-item nav-link pfgreen hoverVerde" id="nav-posiciones-tab" data-toggle="tab" href="#nav-posiciones" role="tab" aria-controls="nav-posiciones" aria-selected="false">Posiciones</a>
                        <a class="nav-item nav-link pfgreen hoverVerde " id="nav-proximafecha-tab" data-toggle="tab" href="#nav-proximafecha" role="tab" aria-controls="nav-proximafecha" aria-selected="false">Goleadores</a>
                        <a class="nav-item nav-link pfgreen hoverVerde" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Tarjetas</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-miequipo" role="tabpanel" aria-labelledby="nav-miequipo-tab">
                        <?php if ( $torneoAMostrar->tieneEquipos() ){ ?>
                            <h4 class="pfgreen mt-4">Equipos que participan en este torneo</h4>
                            <ul class="list-group equipos_participan">
                                <?= $torneoAMostrar->printEquiposEnLi($torneoAMostrar->getTorneoID()) ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="nav-posiciones" role="tabpanel" aria-labelledby="nav-posiciones-tab">
                        <?=$torneoAMostrar->imprimirTablaPosiciones();?>
                    </div>
                    <div class='tab-pane fade ' id='nav-proximafecha' role='tabpanel' aria-labelledby='nav-proximafecha-tab'>
                        <?=$torneoAMostrar->imprimirTablaGoleadores();?>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <?=$torneoAMostrar->imprimirTablaTarjetas();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id='modal_eliminar_torneo' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="eliminar-torneo" method="post" >
                <input type="hidden" name="torneo_id" value="<?= $torneoAMostrar->getTorneoID() ?>"/>
                <div class="modal-header fondoHeader2 text-white">
                    <h5 class="modal-title">Eliminar Torneo</h5>
                    <button type="button" class="close  text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-body">
                                <p><strong>Está a un paso de eliminar este torneo</strong>. Tenga en cuenta que esta acción es irreversible y no podrá volver atrás.</p>
                                <div class="form-group">
                                    <label for="InputSiEliminar">Por favor para confirmar esta acción, escriba "SI" en el campo debajo:</label>
                                    <input type="text" name="confirmar" class="form-control" id="InputSiEliminar" maxlength="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar Torneo</button>
                    <button type="button" class="btn btn-secondary cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
