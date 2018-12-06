<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;

$torneo->actualizar();
?>
<main class="py-4 mb-4 fixture-completo">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h3 class="h5 mt-4 mb-2 colorGris2 font-weight-normal"><i class="fas fa-trophy"></i><?= $torneo->getDescrTipoTorneo()?></h3>
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/torneos/' . $torneo->getTorneoID() ?>" class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>

            <div class="col-md-12">
                <!-- Nombre de Torneo Debajo, tendría que ser dinámico -->
                <h2 class="mb-3 pfgreen h2"><?= $torneo->getNombre()?></h2>
                <h4 class="mb-3 h3 naranjaFecha">Fixture</h4>
            </div>
            <div class="col-md-6">
                <?php
                foreach ($torneo->getFases() as $fase) {
                    ?>
                    <div class="table_container shadow">
                        <div class="header_table_jornada">
                            <h5 class=""><i class="far fa-calendar-alt"></i> <?= $fase->getDescripcion()?><!--<span> 12 Ago</span>--></h5>
                        </div>
                        <div>
                            <table class="jornada_table">
                                <?php foreach ($fase->getPartidos() as $partido) {
                                    ?>

                                    <tr>
                                        <td class="text-right equipos"><div class="nombre_equipo"><?= $partido->getLocalName()?></div></td>
                                        <td class="versus"><?= $partido->getPuntosLocal()?> - <?= $partido->getPuntosVisita()?></td>
                                        <td class="text-left equipos"><div class="nombre_equipo"><?= $partido->getVisitaName()?></div></td>
                                    </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                <?php }?>

            </div>
        </div>
    </div>
</main>

