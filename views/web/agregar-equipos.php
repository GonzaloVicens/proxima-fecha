<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;
?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h2 class="mt-4 mb-5 colorGris2 font-weight-normal ">Agregar Equipos al Torneo / Liga</h2>
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/torneos/' . $torneo->getTorneoID() ?>" class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>
            <div class="col-md-5">
                <h2 class="mb-4 pfgreen fontSize1-6rem"><?= $torneo->getNombre()?></h2>

                <?php if ( $torneo->tieneEquipos() ){ ?>
                    <h4 class="mb-3 fontSize font-weight-normal colorGris2">Equipos que participan en este torneo</h4>
                    <ul>
                        <?= $torneo->printEquiposEnLi() ?>
                    </ul>
                    <!-- Agregar clase d-none o d-block de acuerdo a si quedan equipos por agregar o no -->
                <?php }
                if ($torneo->getLugaresLibres() > 0 ){ ?>
                    <p class="text-muted font-italic d-block">Resta agregar <?= $torneo->getLugaresLibres() ?> equipos aún</p>
                <?php } ?>
            </div>
            <div class="col-md-4">
                <!--h3 class="mt-5 mb-4 colorGris2">Agregar Equipos al Torneo / Liga</h3-->
                <!-- Nombre de Torneo Debajo, obvio tendria que ser dinámico -->
                <h2 class="mb-4 pfgreen fontSize1-6rem font-weight-normal">Buscar Equipos para agregar</h2>
                <form action="buscar-equipo" method="POST" >
                    <div class="form-group">
                       <label for="buscar-nombre">Buscar Equipo por Nombre</label>
                        <div class="input-group">
                            <input name="nombre" value="<?=$inputsBusqueda['nombre']?>" class="form-control py-2 border-right-0 border" type="text" placeholder="Nombre" id="buscar-nombre">
                            <span class="input-group-append">
                                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="buscar-id">Buscar Equipo por Id</label>
                        <div class="input-group">
                            <input name="id" value="<?=$inputsBusqueda['id']?>" class="form-control py-2 border-right-0 border" type="text" placeholder="ID" id="buscar-id">
                            <span class="input-group-append">
                                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-success">Buscar</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <h4 class="mb-4 pfgreen fontSize1-4rem colorGris2 font-weight-normal">Resultado de Búsqueda</h4>
                    <?php
                    if (isset($resultados) && !empty($resultados [0]) ){
                        if (Session::has("IDAgregarEquipo")){
                            $idAgregarEquipo =Session::get("IDAgregarEquipo");
                        } else {
                            $idAgregarEquipo ="";
                        };
                        if (Session::has("errorAgregarEquipo")){
                            $errorAgregarEquipo =Session::get("errorAgregarEquipo");
                        } else {
                            $errorAgregarEquipo ="";
                        };
                        foreach ($resultados as $resultado){
                    ?>
                            <div class="my-1">
                                <form action="agregar-equipo" method="POST">
                                    <input  name="equipo_id" type="hidden" value="<?= $resultado->getEquipoID() ?>" />
                                    <label class='m-0 naranjaFecha' for="nombre">Nombre Equipo</label><br>
                                    <input  class="inputNoStyle minWidth100" type="text" value="<?= $resultado->getNombre() ?>" id="nombre" name="nombre" disabled/>
                                    <button type="submit" class="btn btn-outline-success"><i class="fas fa-plus"></i> Agregar Equipo</button>
                                </form>
                                <?php
                                if ($idAgregarEquipo == $resultado->getEquipoID()){
                                    echo "<p> $errorAgregarEquipo </p>";
                                }
                                ?>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<div class='text-muted d-none'>No hay resultados para mostrar</div>";
                    }
                    ?>
            </div>
        </div>
    </div>
</main>

