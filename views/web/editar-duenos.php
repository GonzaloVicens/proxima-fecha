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
<main class="py-4 mb-4 sedes">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen">Dueños <br><span class="font-weight-normal h3"> Sede <?= $sede->getNombre()?></span></h2>
            </div>
            <div class="col-md-3">
                <a href="<?= App::$urlPath . '/sedes/' . $sede->getSedeID() ?>" class="btn btn-outline-secondary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <ul class="list-group  mt-2 mb-4">
                    <?php
                    foreach($duenos as $duenoActual) {
                        ?>
                        <li class="list-group-item"><?=$duenoActual['APELLIDO'] . ", " . $duenoActual['NOMBRE'] ?>
                        <form action="editar-dueno" class='d-inline float-right' method="POST">
                            <input type="hidden" name='sede_id' value="<?=$sede->getSedeID()?>"/>
                            <input type="hidden" name='dueno_id' value="<?=$duenoActual['USUARIO_ID']?>"/>
                            <input type="hidden" name='activo' value="<?=$duenoActual['ACTIVO']?>"/>
                            <?php if ($duenoActual['ACTIVO'] == "1"){

                                $estado = "Activado";
                                $label = "Desactivar Dueño";
                                $html = "<i class='fas fa-user-slash'></i>";
                                $class = 'btn-outline-success';

                            } else {

                                $estado = "Desactivado";
                                $label = "Activar Dueño";
                                $html = "<i class='fas fa-user-check'></i>";
                                $class = 'btn-outline-danger';

                            }; ?>
                            <span class="<?=$class?> mr-4"><?=$estado?></span><button class='btn btn-sm btn-outline-secondary' type="submit" title="<?=$label?>"><?=$html?> <span class="d-none"><?=$label?></span></button>

                            <!--input class='btn btn-sm btn-outline-primary' type="submit" value="<?=$label?>"/-->
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
                <form class='formRegistro' action='<?= App::$urlPath;?>/sedes/agregar-dueno' method="POST">
                    <input type="hidden" name="sede_id" value="<?= $sede->getSedeID() ?>"/>
                    <div class="form-group">
                        <label for="dueno_id">Agregar un Dueño </label>
                        <input class="form-control" id="dueno_id" type="text" name="dueno_id"/>
                    </div>
                    <input  class="btn btn-outline-success" type="submit" value="Agregar Dueño" />
                    <a href="<?=App::$urlPath . '/sedes/'. $sede->getSedeId()?>" class="btn btn-outline-secondary">Cancelar</a>
                </form>
                <?php
                if(Session::has("errorAgregarDueno")){
                    ?>
                    <div class='DivErrores h5 my-4 text-center'>
                        <p class="text-danger"><?=Session::get("errorAgregarDueno")?></p>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

