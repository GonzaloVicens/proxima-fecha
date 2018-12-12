<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;
use Proyecto\Model\Deporte;
use Proyecto\Model\Sede;
use Proyecto\Model\TipoTorneo;

if (Session::has("camposError")){
    $camposError = Session::get("camposError");
    $camposViejos = Session::get("campos");
    if (isset($camposViejos['nombre']) ){
        $nombre=$camposViejos['nombre'];
    }
    Session::clearValue("camposError");
    Session::clearValue("campos");
} else {
    $nombre="";
};

?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen">Crear <span class="font-weight-normal">Sede</span></h2>
                <form method='post' action='<?= App::$urlPath;?>/usuarios/crear-sede' >
                    <div class="form-group">
                       <label for="nombre">Nombre Sede</label>
                       <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre de la sede">
                    </div>
                    <div class="form-group">
                       <label for="deporte">Provincia</label>
                       <select name="provincia" id="provincia" class="form-control" required>
                        <?=Sede::printOptionsProvincias()?>
                       </select>
                        <!--input type="text" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Ingresá tu nombre"-->
                    </div>
                    <div class="form-group">
                        <label for="postal">Código Postal</label>
                        <input type="text" class="form-control" name="postal" id="postal" placeholder="Código Postal">
                    </div>
                    <div class="form-group">
                        <label for="calle">Cale</label>
                        <input type="text" class="form-control" name="calle" id="calle" placeholder="Calle">
                    </div>
                    <div class="form-group">
                        <label for="altura">Altura</label>
                        <input type="text" class="form-control" name="altura" id="altura" placeholder="Altura">
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" placeholder="Teléfono">
                    </div>

                    <div class="col-sm-10">
                        <textarea rows='5' name="detalles" id='detalles' class="form-control" placeholder="Detalles de la sede..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-lg btn-outline-success">Crear</button>
                    <a type="button" href="<?=App::$urlPath . '/usuarios/'. $usuario->getUsuarioId()?>" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</a>
                </form>
            </div>
            <div class="col-md-3">
                <?php

                if (isset($camposError)){
                    echo("<div class='DivErrores'><ul>");
                    foreach ($camposError as $error => $descr) {
                        echo ("<li style='color:#F00'>".ucfirst($error).": ".$descr."</li>");
                    }
                    echo("</ul></div>");
                }
                ?>
            </div>
        </div>
    </div>
</main>

