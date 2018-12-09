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
                <h2 class="mt-5 mb-4 pfgreen">Crear <span class="font-weight-normal">Torneo o Liga</span></h2>
                <form method='post' action='<?= App::$urlPath;?>/usuarios/crear-torneo' >
                    <div class="form-group">
                       <label for="nombre">Nombre Torneo / Liga</label>
                       <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del torneo">
                    </div>
                    <div class="form-group">
                       <label for="deporte">Deporte</label>
                       <select name="deporte" id="deporte" class="form-control" required>
                        <?=Deporte::printOptionsDeportes()?>
                       </select>
                        <!--input type="text" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Ingresá tu nombre"-->
                    </div>
                    <div class="form-group">
                        <label>Tipo de Competición</label><br>
                        <?=TipoTorneo::printRadiosTiposTorneos()?>

                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad Equipos</label>
                        <select name="cantidad" id="cantidad" class="form-control">
                            <option value='4'>4</option>
                            <option value='8'>8</option>
                            <option value='16'>16</option>
                            <option value='32'>32</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechainicio">Fecha de Inicio (DD/MM/YYYY) </label>
                        <input type="date" name='fechaInicio' class="form-control" id="fechainicio">
                    </div>
                    <div class="form-group">
                        <label for="sede">Sede</label>
                        <select name="sede" class="form-control">
                            <?=Sede::printOptionsSedes()?>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Días en que se juega el torneo</p>
                        <label for="domingo">Domingo <input type="checkbox" name='D' class="form-control" id="domingo"></label>
                        <label for="lunes">Lunes<input type="checkbox" name='L' class="form-control" id="lunes"></label>
                        <label for="martes">Martes<input type="checkbox" name='M' class="form-control" id="martes"></label>
                        <label for="miercoles">Miércoles<input type="checkbox" name='X' class="form-control" id="miercoles"></label>
                        <label for="jueves">Jueves<input type="checkbox" name='J' class="form-control" id="jueves"></label>
                        <label for="viernes">Viernes<input type="checkbox" name='V' class="form-control" id="viernes"></label>
                        <label for="sabado">Sábado<input type="checkbox" name='S' class="form-control" id="sabado"></label>
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

