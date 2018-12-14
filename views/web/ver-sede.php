<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;

use Proyecto\Model\Deporte;
use Proyecto\Session\Session;

$sedeAMostrar->actualizar();


if (Session::has("camposError")) {
    $camposError = Session::get("camposError");
    $camposViejos = Session::get("campos");

    Session::clearValue("camposError");
    Session::clearValue("campos");
} else {
    $camposError = "";
    $camposViejos = "";

} ;

?>

<main class="py-4 mb-4 torneo">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h3 class="mt-4 mb-1 h4 colorGris2 font-weight-normal"><i class="fas fa-home"></i>Sede</h3>
            </div>
            <div class="col-md-2">
                <!--button class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</button-->
            </div>
            <div class="col-md-8">
                <!-- Nombre de Sede Debajo, tendría que ser dinámico -->
                <h2 class="mb-4 pfgreen h1"><?= $sedeAMostrar->getNombre() ?></h2>
                <p class="text-muted"><i class="far fa-calendar-alt"></i> País: <?=$sedeAMostrar->getPaisDescr()?> - Provincia: <span><?= $sedeAMostrar->getProvinciaDescr() ?></span></p>
                <p class="text-muted"><i class="far fa-calendar-alt"></i> Direccion: <span class="font-italic"><?= $sedeAMostrar->getDireccion() ?></span></p>
                <p class="text-muted"><i class="far fa-calendar-alt"></i> Código Postal: <span class="font-italic"><?= $sedeAMostrar->getCodigoPostal() ?></span></p>
                <p class="text-muted"><i class="fas fa-shield-alt"></i></i> Teléfono: <span><?= $sedeAMostrar->getTelefono() ?></span></p>
                <p class="text-muted"><i class="fas fa-shield-alt"></i></i><span><?= $sedeAMostrar->getDetalles() ?></span></p>

                <h3 class="pfgreen h4 mt-4">Dueños:</h3>
                <ul class="list-unstyled">
                    <?php
                    foreach($duenosActivos as $duenoActual) {
                        $boton ="";
                        if (Session::has('logueado')){
                            $usuario = Session::get("usuario");
                            $usuario->actualizar();
                            if ($usuario->esCapitanDeEquipo() && $usuario->getUsuarioID() != $duenoActual['USUARIO_ID']  ) {

                                // Cionfiguro el origen del chat para el botón "Volver" de la conversacion;
                                Session::set('origenChat','/sedes/'.$sedeAMostrar->getSedeID());
                                $boton = "<a href='../mensajes/". $usuario->getUsuarioID() . "/" . $duenoActual['USUARIO_ID'] . "' class='enviar-mensaje'>Enviar Mensaje</a>";
                            }
                        }

                        echo "<li>" . $duenoActual['APELLIDO'] . ", " . $duenoActual['NOMBRE'] . $boton . "</li>";
                         } ?>
                </ul>
            <?php if ( $sedeAMostrar->tieneCanchas() ){ ?>
                <h4 class="pfgreen mt-4">Canchas de la Sede</h4>
                <ul class="list-group equipos_participan">
                    <?= $sedeAMostrar->printCanchasEnLi($sedeAMostrar->getSedeID()) ?>
                </ul>
                <?php } ?>
            </div>
            <div class="col-md-4">
                <h3 class="mb-4 pfgreen fontSize1-6rem font-weight-normal">Acciones</h3>
                <?php if (isset($usuario) && $usuario->esDuenoDeSede($sedeAMostrar->getSedeID())) { ?>
                <p>
                    <a href="<?= App::$urlPath; ?>/sedes/editar-sede" class="naranjaFecha hoverVerde"><i
                                class="far fa-edit"></i> Modificar Datos de la Sede</a>
                </p>
                <p>
                    <a href="<?= App::$urlPath; ?>/sedes/editar-duenos" class="naranjaFecha hoverVerde"><i
                            class="far fa-edit"></i> Administrar Dueños</a>
                </p>
                <p>
                    <button href="#" class="btn btn-link naranjaFecha hoverVerde" id="eliminar_sede"><i
                            class="fas fa-times-circle"></i> Eliminar Sede
                    </button>
                </p>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mb-4 pfgreen h1">Agregar Nueva Cancha</h2>
                <form action="agregar-cancha" method="POST">
                    <input type="hidden" name="sede_id" value="<?= $sedeAMostrar->getSedeID()?>" />
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" required name="nombre" id="nombre"   />
                    </div>
                    <div class="form-group">
                        <label for="deporte">Deporte</label>
                        <select name="deporte" id="deporte" class="form-control"  >
                            <?=Deporte::printOptionsDeportes()?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="text" class="form-control" name="precio" id="precio"   required />
                    </div>
                    <button type="submit" class="btn btn-danger">Agregar</button>
                </form>
            </div>
            <div class="col-md-3">
                <?php
                if (isset($camposError) && $camposError!= "") {
                    echo("<div class='DivErrores'><ul>");
                    foreach ($camposError as $error => $descr) {
                        echo ("<li style='color:#F00'>".ucfirst($error).": ".$descr. "</li>");
                    }
                    echo("</ul></div>");
                }
                ?>
            </div>
        </div>
    </div>
</main>

<div class="modal fade bd-example-modal-lg" id='modal_eliminar_sede' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="eliminar-sede" method="post" >
                <input type="hidden" name="sede_id" value="<?= $sedeAMostrar->getSedeID() ?>"/>
                <div class="modal-header fondoHeader2 text-white">
                    <h5 class="modal-title">Eliminar Sede</h5>
                    <button type="button" class="close  text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-body">
                                <p><strong>Está a un paso de eliminar esta sede</strong>. Tenga en cuenta que esta acción es irreversible y no podrá volver atrás.</p>
                                <div class="form-group">
                                    <label for="InputSiEliminar">Por favor para confirmar esta acción, escriba "SI" en el campo debajo:</label>
                                    <input type="text" name="confirmar" class="form-control" id="InputSiEliminar" maxlength="2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar Sede</button>
                    <button type="button" class="btn btn-secondary cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
