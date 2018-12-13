<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Model\Sede;
use Proyecto\Session\Session;

if (Session::has('sede')){
    $sede = Session::get('sede');
    $sede->actualizar();
}
?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen">Dueños <span class="font-weight-normal"><?= $sede->getNombre()?></span></h2>
            </div>
            <div class="col-md-3">
                <a href="<?= App::$urlPath . '/sedes/' . $sede->getSedeID() ?>" class="btn btn-outline-secondary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <ul>
                    <?php
                    foreach($duenos as $duenoActual) {
                        ?>
                        <li class="list-unstyled"><?=$duenoActual['APELLIDO'] . ", " . $duenoActual['NOMBRE'] ?> </li>
                        <form action="editar-dueno" method="POST">
                            <input type="hidden" name='sede_id' value="<?=$sede->getSedeID()?>"/>
                            <input type="hidden" name='dueno_id' value="<?=$duenoActual['USUARIO_ID']?>"/>
                            <input type="hidden" name='activo' value="<?=$duenoActual['ACTIVO']?>"/>
                            <?php if ($duenoActual['ACTIVO'] == "1"){
                                $label = "Desactivar Organizador";
                            } else {
                                $label = "Activar Organizador";
                            }; ?>
                            <input class='btn btn-sm btn-outline-primary' type="submit" value="<?=$label?>"/>
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
                <form class='formRegistro' action='<?= App::$urlPath;?>/sedes/agregar-dueno' method="POST">
                    <input type="hidden" name="sede_id" value="<?= $sede->getSedeID() ?>"/>
                    <div class="form-group">
                        <label for="dueno_id">Agregar un Dueño </label>
                        <input class="form-control" id="dueno_id" type="text" name="dueno_id"/>
                    </div>
                    <input  class="btn btn-outline-secondary"  type="submit" value="Agregar Dueño" />
                    <a type="button" href="<?=App::$urlPath . '/sedes/'. $sede->getSedeId()?>" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</a>
                </form>
                <?php
                if(Session::has("errorAgregarDueno")){
                    ?>
                    <div class='DivErrores'>
                        <h2 style='color:#F00'><?=Session::get("errorAgregarDueno")?></h2>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

