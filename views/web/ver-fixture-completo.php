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
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/torneos/' . $torneo->getTorneoID() ?>" class="btn btn-outline-secondary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>

            <div class="col-md-12">
                <h2 class="pfgreen mt-4 mb-2">
                    <span class="d-block font-weight-normal colorGris2 h4 mb-2"><i class="fas fa-trophy"></i> <?= $torneo->getDescrTipoTorneo()?></span>
                    <span class=""><?= $torneo->getNombre()?></span>
                </h2>


                <h2 class="mb-3 pfgreen h2"></h2>
                <h4 class="mb-3 h3 naranjaFecha">Fixture Completo</h4>
            </div>

                <?php
                foreach ($torneo->getFases() as $fase) {
                    ?>
                    <div class="col-md-6">
                    <div class="table_container shadow">
                        <div class="header_table_jornada">
                            <h5 class=""><i class="far fa-calendar-alt"></i> <?= $fase->getDescripcion()?></h5>
                        </div>
                        <div>
                            <table class="jornada_table">
                                <?php foreach ($fase->getPartidos() as $partido) {
                                    ?>

                                    <tr>
                                        <td class="numero"><?= $partido->getPartidoID()?></td>
                                        <td class="text-right equipos"><div class="nombre_equipo"><?= $partido->getLocalNombre()?></div></td>
                                        <td class="versus"><?= $partido->getPuntosLocal()?> - <?= $partido->getPuntosVisita()?></td>
                                        <td class="text-left equipos"><div class="nombre_equipo"><?= $partido->getVisitaNombre()?></div></td>
                                        <?php

                                        if (isset($usuario) && $partido->esArbitro($usuario->getUsuarioID()) && $torneo->estaEnCurso() ){
                                            $label = "Actualizar Partido";
                                            $icon = "<i class='fas fa-edit'></i><span class='d-none'>editar</span>";
                                         } else {
                                            $label = "Ver Partido";
                                            $icon = "<i class='fas fa-eye'></i><span class='d-none'>ver</span>";
                                        }
                                        echo "<td class='actualizar_ver'><a href='". $partido->getTorneoID() . "/" . $partido->getFaseID() . "/" . $partido->getPartidoID() . "' title=' $label '>$icon </a></td>";
                                        ?>
                                    </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
            </div>
                <?php }?>

        </div>
    </div>
</main>

