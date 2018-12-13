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
<main class="py-4 mb-4 torneo editar-organizadores">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen">Organizadores <br><span class="font-weight-normal h3"><?= $torneo->getNombre()?></span></h2>
            </div>
            <div class="col-md-3">
                <a href="<?= App::$urlPath . '/torneos/' . $torneo->getTorneoID() ?>" class="btn btn-outline-secondary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <ul class="list-group mt-2 mb-4">
                    <?php
                    foreach($organizadores as $organizadorActual) {
                        ?>
                        <li class="list-group-item"><span><?=$organizadorActual['APELLIDO'] . ", " . $organizadorActual['NOMBRE'] ?></span>
                        <form action="editar-organizador" class='d-inline float-right' method="POST">
                            <input type="hidden" name='torneo_id' value="<?=$torneo->getTorneoID()?>"/>
                            <input type="hidden" name='organizador_id' value="<?=$organizadorActual['ORGANIZADOR_ID']?>"/>
                            <input type="hidden" name='activo' value="<?=$organizadorActual['ACTIVO']?>"/>
                            <?php if ($organizadorActual['ACTIVO'] == "1"){
                                $estado = "Activado";
                                $label = "Desactivar Organizador";
                                $html = "<i class='fas fa-user-slash'></i>";
                                $class = 'btn-outline-success';
                            } else {
                                $estado = "Desactivado";
                                $label = "Activar Organizador";
                                $html = "<i class='fas fa-user-check'></i>";
                                $class = 'btn-outline-danger';
                            }; ?>
                            <span class="<?=$class?> mr-4"><?=$estado?></span><button class='btn btn-sm btn-outline-secondary' type="submit" title="<?=$label?>"><?=$html?> <span class="d-none"><?=$label?></span></button>
                        </form></li>
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
                        <input class="form-control" id="organizador_id" type="text" name="organizador_id" placeholder="Buscar organizador...">
                    </div>
                    <input  class="btn btn-outline-success"  type="submit" value="Agregar Organizador" />
                    <a href="<?=App::$urlPath . '/torneos/'. $torneo->getTorneoId()?>" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</a>
                </form>
                <?php
                if(Session::has("errorAgregarOrganizador")){
                    ?>
                    <div class='DivErrores h5 my-4 text-center'>
                        <p class="text-danger"><?=Session::get("errorAgregarOrganizador")?></p>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

