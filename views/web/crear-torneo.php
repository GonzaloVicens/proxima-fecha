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
$deporte="";
$tipoTorneo = "";
$cantidad = "";
$fechaInicio = "";
$sede = "";
$domingo = "";
$lunes = "";
$martes = "";
$miercoles = "";
$jueves = "";
$viernes = "";
$sabado = "";


if (Session::has("camposError")){
    $camposError = Session::get("camposError");
    $camposViejos = Session::get("campos");
    if (isset($camposViejos['nombre']) ){
        $nombre=$camposViejos['nombre'];
    }
    if (isset($camposViejos['deporte']) ){
        $deporte=$camposViejos['deporte'];
    }
    if (isset($camposViejos['tipoTorneo']) ){
        $tipoTorneo=$camposViejos['tipoTorneo'];
    }

    if (isset($camposViejos['cantidad']) ){
        $cantidad=$camposViejos['cantidad'];
    }

    if (isset($camposViejos['fechaInicio']) ){
        $fechaInicio=$camposViejos['fechaInicio'];
    }

    if (isset($camposViejos['sede']) ){
        $fechaInicio=$camposViejos['sede'];
    }

    if (isset($camposViejos['D']) ){
        $domingo="checked";
    }

    if (isset($camposViejos['L']) ){
        $lunes="checked";
    }

    if (isset($camposViejos['M']) ){
        $martes="checked";
    }

    if (isset($camposViejos['X']) ){
        $miercoles="checked";
    }

    if (isset($camposViejos['J']) ){
        $jueves="checked";
    }

    if (isset($camposViejos['V']) ){
        $viernes="checked";
    }

    if (isset($camposViejos['S']) ){
        $sabado="checked";
    }

    Session::clearValue("camposError");
    Session::clearValue("campos");
} ;

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
                        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del torneo" value="<?=$nombre?>" />
                        <?php
                        if (isset($camposError['nombre'])) {
                            echo "<p class='rta-validacion text-danger ml-1'><small>" . $camposError['nombre'] . "</small><p>";
                        }
                        ?>
                    </div>

                    <div class="form-group">
                       <label for="deporte">Deporte</label>
                       <select name="deporte" id="deporte" class="form-control">
                        <?=Deporte::printOptionsDeportes($deporte)?>
                       </select>
                        <!--input type="text" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Ingresá tu nombre"-->
                    </div>

                    <div class="form-group">
                        <label>Tipo de Competición</label><br>
                        <?=TipoTorneo::printRadiosTiposTorneos($tipoTorneo)?>

                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad Equipos</label>
                        <div id="cantidadEquipos">
                            <select name="cantidad" <?php if(!$cantidad){echo"disabled";} ?>  id="cantidad" class="form-control">
                                <option value='4'  <?php if ($cantidad == 4 ){ echo "selected";} ?> >4</option>
                                <option value='8'  <?php if ($cantidad == 8 ){ echo "selected";} ?> >8</option>
                                <option value='16' <?php if ($cantidad == 16){ echo "selected";} ?> >16</option>
                                <option value='32' <?php if ($cantidad == 32){ echo "selected";} ?> >32</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fechainicio">Fecha de Inicio </label>
                        <input type="text" name='fechaInicio' class="form-control" id="fechainicio" value="<?php
                        //Se agrega porque cuando vuelve con un error, toma como valor "1"
                        if($fechaInicio == 1) {
                            echo "";
                        } else {
                            echo $fechaInicio;
                        }
                        ?>"/>
                        <?php
                        if (isset($camposError['fechaInicio'])) {
                            echo "<p class='rta-validacion text-danger ml-1'><small>" . $camposError['fechaInicio'] . "</small><p>";
                        }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="sede">Sede</label>
                        <select name="sede" class="form-control">
                            <?=Sede::printOptionsSedes($sede)?>
                        </select>
                    </div>

                    <div class="form-group">
                        <p>Días en que se juega el torneo</p>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name='D' <?= $domingo ?>  class="form-check-input" id="domingo"><label for="domingo" class="form-check-label">Dom</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name='L' <?= $lunes ?> class="form-check-input" id="lunes"><label for="lunes" class="form-check-label">Lun</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name='M' <?= $martes ?> class="form-check-input" id="martes"><label for="martes" class="form-check-label">Mar</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name='X' <?= $miercoles ?> class="form-check-input" id="miercoles"><label for="miercoles" class="form-check-label">Mie</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name='J' <?= $jueves ?> class="form-check-input" id="jueves"><label for="jueves" class="form-check-label">Jue</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name='V' <?= $viernes ?> class="form-check-input" id="viernes"><label for="viernes" class="form-check-label">Vie</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name='S' <?= $sabado ?> class="form-check-input" id="sabado"><label for="sabado" class="form-check-label">Sab</label>
                    </div>
                    <div>
                        <?php
                        if (isset($camposError['dias'])) {
                            echo "<p class='rta-validacion text-danger ml-1'><small>" . $camposError['dias'] . "</small><p>";
                        }
                        ?>
                    </div>
                    <div class="form-group my-4">
                        <button type="submit" class="btn btn-outline-success">Crear Torneo</button>
                        <a href="<?=App::$urlPath . '/usuarios/'. $usuario->getUsuarioId()?>" class="btn btn-link colorGris2">Cancelar</a>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <?php
                /*
                if (isset($camposError)){
                    echo("<div class='DivErrores'><ul>");
                    foreach ($camposError as $error => $descr) {
                        echo ("<li style='color:#F00'>".ucfirst($error).": ".$descr. "</li>");
                    }
                    echo("</ul></div>");
                }
                */
                ?>
            </div>
        </div>
    </div>
</main>

