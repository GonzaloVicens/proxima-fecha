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

if (Session::has('torneo')){
    $torneo = Session::get('torneo');
}
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
                <p class="text-muted"><i class="far fa-calendar-alt"></i> Fecha de Inicio: <span><?= $torneo->getFechaInicio() ?></span></p>
                <p class="text-muted"><i class="far fa-calendar-alt"></i> Sede: <span class="font-italic"><?= $torneo->getDescrSede() ?></span></p>
                <p class="text-muted"><i class="fas fa-shield-alt"></i></i> Cantidad Equipos Participantes: <span><?= $torneo->getCantidadEquipos() ?></span></p>

            <?php if ( $torneo->tieneEquipos() ){ ?>
                <h4 class="mb-3 fontSize font-weight-normal colorGris2">Equipos que participan en este torneo</h4>
                <ul>
                    <?= $torneo->printEquiposEnLi() ?>
                </ul>
                <!-- Agregar clase d-none o d-block de acuerdo a si quedan equipos por agregar o no -->
                <?php }
                if ($torneo->getLugaresLibres() > 0 ){ ?>
                <p class="text-muted font-italic d-block">Resta agregar <?= $torneo->getLugaresLibres() ?> equipos aún</p>
                <?php } ?>
            </div>
            <div class="col-md-4">
                <h3 class="mb-4 pfgreen fontSize1-6rem font-weight-normal">Acciones</h3>
                <p>
                    <a href="<?= App::$urlPath;?>/usuarios/editar-torneo" class="naranjaFecha hoverVerde"><i class="far fa-edit"></i> Modificar Datos del Torneo</a>
                </p>
                <p>
                    <a href="<?= App::$urlPath;?>/agregar-equipos" class="naranjaFecha hoverVerde"><i class="fas fa-plus-circle"></i> Agregar Equipo</a>
                </p>
                <p>
                    <button href="#" class="btn btn-link naranjaFecha hoverVerde" id="eliminar_torneo"><i class="fas fa-times-circle"></i> Eliminar Torneo</button>
                </p>
                <p>
                    <button href="#" class="naranjaFecha btn btn-lg btn-outline-warning"><i class="fas fa-trophy"></i> Generar Fixture</button>
                </p>
                <p class="d-none">
                    <button href="#" class="naranjaFecha btn btn-lg btn-outline-warning hoverVerde"><i class="fas fa-trophy"></i> Ver Fixture</button>
                </p>



            </div>
        </div>
    </div>
</main>

