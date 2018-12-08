<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Model\Deporte;
use Proyecto\Model\Sede;
use Proyecto\Model\TipoTorneo;
use Proyecto\Session\Session;

if (Session::has('torneo')){
    $torneo = Session::get('torneo');
    $torneo->actualizar();
}
?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen">Editar <span class="font-weight-normal">Torneo o Liga</span></h2>
                <form method='post' action='<?= App::$urlPath;?>/torneos/editar-torneo' >
                    <input type="hidden" name="torneo_id" id="torneo_id"  value='<?= $torneo->getTorneoID() ?>'>
                    <div class="form-group">
                        <label for="nombre">Nombre Torneo / Liga</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?= $torneo->getNombre()?>">
                    </div>
                    <div class="form-group">
                        <label for="deporte">Deporte</label>
                        <select name="deporte" id="deporte"  class="form-control">
                            <?=Deporte::printOptionsDeportes($torneo->getDeporteID())?>
                        </select>
                        <!--input type="text" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Ingresá tu nombre"-->
                    </div>
                    <div class="form-group">
                        <label>Tipo de Competición</label><br>
                        <?=TipoTorneo::printRadiosTiposTorneos($torneo->getTipoTorneoID())?>

                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad Equipos</label>
                        <select name="cantidad" id="cantidad" class="form-control">
                            <option value='4'  <?php if ($torneo->getCantidadEquipos() == 4 ){ echo "selected";} ?> >4</option>
                            <option value='8'  <?php if ($torneo->getCantidadEquipos() == 8 ){ echo "selected";} ?> >8</option>
                            <option value='16' <?php if ($torneo->getCantidadEquipos() == 16){ echo "selected";} ?> >16</option>
                            <option value='32' <?php if ($torneo->getCantidadEquipos() == 32){ echo "selected";} ?> >32</option>
                            <option value='64' <?php if ($torneo->getCantidadEquipos() == 64){ echo "selected";} ?> >64</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="fechainicio">Fecha de Inicio </label>
                        <input type="date" name='fechaInicio' class="form-control" id="fechainicio" value="<?= $torneo->getFechaInicio()?>">
                    </div>
                    <div class="form-group">
                        <label for="sede">Sede</label>
                        <select name="sede" class="form-control">
                            <?=Sede::printOptionsSedes($torneo->getSedeID())?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-success">Enviar</button>
                    <a type="button" href="<?=App::$urlPath . '/torneos/'. $torneo->getTorneoId()?>" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</a>
                </form>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

