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
                       <select name="deporte" id="deporte" class="form-control">
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
                            <option value='64'>64</option>
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

                    <button type="submit" class="btn btn-lg btn-outline-success">Crear</button>
                    <a type="button" href="<?=App::$urlPath . '/usuarios/'. $usuario->getUsuarioId()?>" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</a>
                </form>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

