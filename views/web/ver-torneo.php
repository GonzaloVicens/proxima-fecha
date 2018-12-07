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

$torneo->actualizar();
?>

<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <!-- El h2 debajo tendría que tener contenido dinámico, según se trate de Torneo o Liga-->
                <h3 class="mt-4 mb-2 colorGris2 font-weight-normal "><i class="fas fa-trophy"></i><?= $torneo->getDescrTipoTorneo() ?></h3>
            </div>
            <div class="col-md-2">
                <!--button class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</button-->
            </div>
            <div class="col-md-8">
                <!-- Nombre de Torneo Debajo, tendría que ser dinámico -->
                <h2 class="mb-4 pfgreen h1"><?= $torneo->getNombre() ?></h2>
                <p class="text-muted"><i class="far fa-calendar-alt"></i> Estado: <?=$torneo->getEstadoDescr()?> - Fecha de Inicio: <span><?= $torneo->getFechaInicio() ?></span></p>
                <p class="text-muted"><i class="far fa-calendar-alt"></i> Sede: <span class="font-italic"><?= $torneo->getDescrSede() ?></span></p>
                <p class="text-muted"><i class="fas fa-shield-alt"></i></i> Cantidad Equipos Participantes: <span><?= $torneo->getCantidadEquipos() ?></span></p>

                <h3>Organizadores:</h3>
                <ul>
                    <?php
                    foreach($organizadoresActivos as $organizadorActual) {
                        $boton ="";
                        if (Session::has('logueado')){
                            $usuario = Session::get("usuario");
                            $usuario->actualizar();
                            if ($usuario->esCapitanDeEquipo() && $usuario->getUsuarioID() != $organizadorActual['ORGANIZADOR_ID']  ) {
                                $boton = "<a href='../mensajes/". $usuario->getUsuarioID() . "/" . $organizadorActual['ORGANIZADOR_ID'] . "' class='mayuscula'>Enviar Mensaje</a>";
                            }
                        }

                        echo "<li>" . $organizadorActual['APELLIDO'] . ", " . $organizadorActual['NOMBRE'] . $boton . "</li>";
                         } ?>
                </ul>









            <?php if ( $torneo->tieneEquipos() ){ ?>
                <h4 class="mb-3 fontSize font-weight-normal colorGris2">Equipos que participan en este torneo</h4>
                <ul>
                    <?= $torneo->printEquiposEnLi($torneo->getTorneoID()) ?>
                </ul>
                <!-- Agregar clase d-none o d-block de acuerdo a si quedan equipos por agregar o no -->
                <?php }
                if ($torneo->getLugaresLibres() > 0 ){ ?>
                <p class="text-muted font-italic d-block">Resta agregar <?= $torneo->getLugaresLibres() ?> equipos aún</p>
                <?php } ?>
            </div>
            <div class="col-md-4">
                <h3 class="mb-4 pfgreen fontSize1-6rem font-weight-normal">Acciones</h3>
                <?php if (isset($usuario) && $usuario->esOrganizadorDeTorneo($torneo->getTorneoID())) { ?>
                    <?php if ($torneo->esNuevo()) { ?>
                    <p>
                        <a href="<?= App::$urlPath; ?>/torneos/editar-torneo" class="naranjaFecha hoverVerde"><i
                                class="far fa-edit"></i> Modificar Datos del Torneo</a>
                    </p>
                <?php } ?>
                <p>
                    <a href="<?= App::$urlPath; ?>/torneos/editar-organizadores" class="naranjaFecha hoverVerde"><i
                            class="far fa-edit"></i> Administrar Organizadores</a>
                </p>
                <?php if (!$torneo->estaEnCurso()) { ?>
                    <p>
                        <button href="#" class="btn btn-link naranjaFecha hoverVerde" id="eliminar_torneo"><i
                                class="fas fa-times-circle"></i> Eliminar Torneo
                        </button>
                    </p>
                <?php } ?>
                <?php if ($torneo->esNuevo()) { ?>
                    <?php if ($torneo->getLugaresLibres() > 0) { ?>
                        <p>
                            <a href="<?= App::$urlPath; ?>/torneos/agregar-equipos" class="naranjaFecha hoverVerde"><i
                                    class="fas fa-plus-circle"></i> Agregar Equipo</a>
                        </p>
                    <?php }
                    if ($torneo->getLugaresLibres() == 0 && !$torneo->tieneFixture()) { ?>
                        <p>
                            <a href="generar-fixture" class="naranjaFecha btn btn-lg btn-outline-warning"><i
                                    class="fas fa-trophy"></i> Generar Fixture</a>
                        </p>
                    <?php }
                    if ($torneo->tieneFixture() && $torneo->estaInicial()) { ?>
                        <p>
                            <a href="comenzar-torneo" class="naranjaFecha btn btn-lg btn-outline-warning"><i
                                    class="fas fa-trophy"></i> Comenzar Torneo</a>
                        </p>
                    <?php }
                }
                if ($torneo->estaEnCurso()) {
                    ?>
                    <p>
                        <a href="finalizar-torneo" class="naranjaFecha btn btn-lg btn-outline-warning"><i
                                class="fas fa-trophy"></i> Finalizar Torneo</a>
                    </p>
                    <?php
                }
                if ($torneo->estaFinalizado()) {
                    ?>
                    <p>
                        <a href="reiniciar-torneo" class="naranjaFecha btn btn-lg btn-outline-warning"><i
                                class="fas fa-trophy"></i> Reiniciar Torneo</a>
                    </p>
                <?php }
            }
            if ($torneo->tieneFixture()) { ?>
                <p>
                    <a href="ver-fixture-completo" class="naranjaFecha btn btn-lg btn-outline-warning hoverVerde"><i class="fas fa-trophy"></i> Ver Fixture</a>
                </p>
            <?php } ?>
            </div>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id='modal_eliminar_torneo' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="eliminar-torneo" method="post" >
                <input type="hidden" name="torneo_id" value="<?= $torneo->getTorneoID() ?>"/>
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
