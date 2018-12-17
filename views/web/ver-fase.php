<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;
use Proyecto\Model\Torneo;

$faseActual->actualizar();
$torneo = New Torneo($faseActual->getTorneoID());
?>
<main class="py-4 mb-4 fixture-completo">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h2 class="pfgreen mt-4 mb-2">
                    <span class="d-block font-weight-normal colorGris2 h4 mb-2"><i class="fas fa-trophy"></i> <?= $torneo->getDescrTipoTorneo()?></span>
                    <span class=""><?= $torneo->getNombre()?></span>
                </h2>
                <h4 class="mb-3 h3 naranjaFecha">Ver Fecha</h4>
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/torneos/' . $torneo->getTorneoID() ?>" class="btn btn-outline-secondary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="table_container shadow">
                    <div class="header_table_jornada">
                        <h5 class=""><i class="far fa-calendar-alt"></i> <?= $faseActual->getDescripcion()?></h5>
                    </div>
                    <div>
                        <table class="jornada_table">
                            <?php foreach ($faseActual->getPartidos() as $partido) {
                                ?>

                                <tr>
                                    <td class="numero"><?= $partido->getPartidoID()?></td>
                                    <td class="text-right equipos"><div class="nombre_equipo"><?= $partido->getLocalNombre()?></div></td>
                                    <td class="versus"><?= $partido->getPuntosLocal()?> - <?= $partido->getPuntosVisita()?></td>
                                    <td class="text-left equipos"><div class="nombre_equipo"><?= $partido->getVisitaNombre()?></div></td>
                                    <?php
                                    Session::set('vinoDeFase','Y');
                                    if (isset($usuario) && $partido->esArbitro($usuario->getUsuarioID()) && $torneo->estaEnCurso() ){
                                        $label = "Actualizar Partido";
                                        $icon = "<i class='fas fa-edit'></i><span class='d-none'>editar</span>";
                                    } else {
                                        $label = "Ver Partido";
                                        $icon = "<i class='fas fa-eye'></i><span class='d-none'>ver</span>";
                                    }
                                    echo "<td class='actualizar_ver'><a href='../". $partido->getTorneoID() . "/" . $partido->getFaseID() . "/" . $partido->getPartidoID() . "' title=' $label '>$icon </a></td>";
                                    ?>
                                </tr>
                            <?php }?>
                        </table>
                    </div>
                </div>
                <a href='../ver-fixture-completo' class="colorGris2 hoverVerde"><i class="fas fa-shield-alt"></i> Ver Fixture Completo</a>
            </div>
            <div class="col-md-4">
                <h3 class="mb-4 pfgreen fontSize1-6rem font-weight-normal">Ver Jornadas</h3>
                <div class="table_container2 shadow">
                    <div>
                        <table class="jornada_table">
                            <?php
                            foreach($torneo->getFases() as $f){?>
                                <tr>
                                    <td class=""><a href="../<?=$f->getTorneoID()."/".$f->getFaseID()?>"><i class="far fa-calendar-alt"></i> <?=$f->getDescripcion()?> <span> <?=$f->getFecha()?></span></a></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

