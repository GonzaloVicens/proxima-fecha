<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h2 class="mt-4 mb-5 colorGris2 font-weight-normal ">Agregar Equipos al Torneo / Liga</h2>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</button>
            </div>
            <div class="col-md-5">
                <!-- Nombre de Torneo Debajo, tendría que ser dinámico -->
                <h2 class="mb-4 pfgreen fontSize1-6rem">Torneo Federal de Arroyo Dulce</h2>
                <h4 class="mb-3 fontSize font-weight-normal colorGris2">Equipos que participan en este torneo</h4>
                <!-- Listado de Equipos que Ya Participan Debajo, tendría que ser dinámico -->
                <ul>
                    <li>Cambaceres de Don Torcuato</li>
                    <li>La Runfla de Pagani</li>
                    <li>Los Messi</li>
                    <li>Joya Nunca taxi</li>
                </ul>
            </div>
            <div class="col-md-4">
                <!--h3 class="mt-5 mb-4 colorGris2">Agregar Equipos al Torneo / Liga</h3-->
                <!-- Nombre de Torneo Debajo, obvio tendria que ser dinámico -->
                <h2 class="mb-4 pfgreen fontSize1-6rem font-weight-normal">Buscar Equipos para agregar</h2>
                <form action="" method="" enctype="">
                    <div class="form-group">
                       <label for="buscar-equipo">Buscar Equipo por Nombre</label>
                        <div class="input-group">
                            <input class="form-control py-2 border-right-0 border" type="text" placeholder="Buscar" id="buscar-equipo">
                            <span class="input-group-append">
                                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="buscar-equipo">Buscar Equipo por Id</label>
                        <div class="input-group">
                            <input class="form-control py-2 border-right-0 border" type="text" placeholder="Buscar" id="buscar-equipo">
                            <span class="input-group-append">
                                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-success">Buscar</button>
                </form>
            </div>
            <div class="col-md-3">
                <h4 class="mb-4 pfgreen fontSize1-4rem colorGris2 font-weight-normal">Resultado de Búsqueda</h4>
                <form action="" method="" enctype="">
                    <!--
                        Si no se buscó nada aún aparece este div y el formulario pasa a display none (clase d-none)
                        Cuando hay un resultado para mostrar esto se pasa a display:none
                     -->
                    <div class="text-muted d-none">No hay resultados para mostrar</div>

                    <div class="my-1">
                        <label class='m-0 naranjaFecha' for="nombre">Nombre Equipo</label><br>
                        <input  class="inputNoStyle minWidth100" type="text" value="Los Invisibles de avellaneda" id="nombre" name="nombre" disabled/>
                    </div>
                    <div  class="my-1">
                        <label class='m-0 naranjaFecha' for="idequipo">ID</label><br>
                        <input  class="inputNoStyle" type="text" value="324" id="idequipo" name="idequipo" disabled/>
                    </div>
                    <div  class="mt-1 mb-3">
                        <label class='m-0 naranjaFecha' for="nombre">Creado por</label><br>
                        <input class="inputNoStyle" type="text" value="Facundo Salerno" id="creador" name="creador" disabled/>
                    </div>
                    <button type="submit" class="btn btn-outline-success"><i class="fas fa-plus"></i> Agregar Equipo</button>
                </form>
            </div>
        </div>
    </div>
</main>

