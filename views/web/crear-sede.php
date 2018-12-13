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

$nombre="";
$provincia ="";
$postal="";
$calle="";
$altura="";
$telefono="";
$detalles="";

if (Session::has("camposError")){
    $camposError = Session::get("camposError");
    $camposViejos = Session::get("campos");
    if (isset($camposViejos['nombre']) ){
        $nombre=$camposViejos['nombre'];
    }
    if (isset($camposViejos['provincia']) ){
        $provincia =$camposViejos['provincia'];
    }
    if (isset($camposViejos['postal']) ){
        $postal =$camposViejos['postal'];
    }
    if (isset($camposViejos['calle']) ){
        $calle=$camposViejos['calle'];
    }
    if (isset($camposViejos['altura']) ){
        $altura=$camposViejos['altura'];
    }
    if (isset($camposViejos['telefono']) ){
        $telefono=$camposViejos['telefono'];
    }
    if (isset($camposViejos['detalles']) ){
        $detalles=$camposViejos['detalles'];
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
                       <input type="text" class="form-control" name="nombre" id="nombre" required placeholder="Nombre de la sede"  value="<?=$nombre?>" />
                    </div>
                    <div class="form-group">
                       <label for="deporte">Provincia</label>
                       <select name="provincia" id="provincia" required class="form-control" required>
                        <?=Sede::printOptionsProvincias($provincia)?>
                       </select>
                        <!--input type="text" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Ingresá tu nombre"-->
                    </div>
                    <div class="form-group">
                        <label for="postal">Código Postal</label>
                        <input type="text" class="form-control" name="postal" id="postal" required  placeholder="Código Postal" value="<?=$postal?>" />
                    </div>
                    <div class="form-group">
                        <label for="calle">Calle</label>
                        <input type="text" class="form-control" name="calle" id="calle" required  placeholder="Calle" value="<?=$calle?>" />
                    </div>
                    <div class="form-group">
                        <label for="altura">Altura</label>
                        <input type="text" class="form-control" name="altura" id="altura" required   placeholder="Altura" value="<?=$altura?>" />
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" required  placeholder="Teléfono" value="<?=$telefono?>" />
                    </div>

                    <div class="col-sm-10">
                        <textarea rows='5' name="detalles" id='detalles' class="form-control" placeholder="Detalles de la sede..."><?=$detalles?></textarea>
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

