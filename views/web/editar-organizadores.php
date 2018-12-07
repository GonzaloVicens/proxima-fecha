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
                <h2 class="mt-5 mb-4 pfgreen">Organizadores <span class="font-weight-normal"><?= $torneo->getNombre()?></span></h2>
            </div>
            <div class="col-md-3">
                <a href="<?= App::$urlPath . '/torneos/' . $torneo->getTorneoID() ?>" class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <ul>
                    <?php
                    foreach($organizadores as $organizadorActual) {
                        ?>
                        <li><?=$organizadorActual['APELLIDO'] . ", " . $organizadorActual['NOMBRE'] ?> </li>
                        <form action="editar-organizador" method="POST">
                            <input type="hidden" name='torneo_id' value="<?=$torneo->getTorneoID()?>"/>
                            <input type="hidden" name='organizador_id' value="<?=$organizadorActual['ORGANIZADOR_ID']?>"/>
                            <input type="hidden" name='activo' value="<?=$organizadorActual['ACTIVO']?>"/>
                            <?php if ($organizadorActual['ACTIVO'] == "1"){
                                $label = "Desactivar Organizador";
                            } else {
                                $label = "Activar Organizador";
                            }; ?>
                            <input type="submit" value="<?=$label?>"/>
                        </form>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <form class='formRegistro' action='<?= App::$urlPath;?>/torneos/agregar-organizador' method="POST">
                    <input type="hidden" name="torneo_id" value="<?= $torneo->getTorneoID() ?>"/>
                    <div class="form-group">
                        <label for="organizador_id">Agregar un Organizador </label>
                        <input class="form-control" id="organizador_id" type="text" name="organizador_id"/>
                    </div>
                    <input  class="btn btn-outline-secondary"  type="submit" value="Agregar Organizador" />
                    <a type="button" href="<?=App::$urlPath . '/torneos/'. $torneo->getTorneoId()?>" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</a>
                </form>
                <?php
                if(Session::has("errorAgregarOrganizador")){
                    ?>
                    <div class='DivErrores'>
                        <h2 style='color:#F00'><?=Session::get("errorAgregarOrganizador")?></h2>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

