<?php

/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */

use Proyecto\Core\App;
use Proyecto\Session\Session;
use Proyecto\Model\Equipo;
use Proyecto\Model\Usuario;
use Proyecto\Tools\Estadisticas;

if (Session::has('resultadosEquipo') ) {
    $resultadosEquipo = Session::get('resultadosEquipo');

}
Session::clearValue('resultadosEquipo');

if (Session::has('resultadosUsuario') ) {
    $resultadosUsuario = Session::get('resultadosUsuario');
}
Session::clearValue('resultadosUsuario');


$vinoDe ="buscar";
if (Session::has('tab')){
    $vinoDe = Session::get('tab');
}
Session::clearValue('tab');
?>

<main class="py-4 mb-4 admin">
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-4">
                <!--a href="<?= App::$urlPath . '/adminPF/desloguear'?>" class="btn btn-outline-secondary float-right"><i class="fas fa-door-open"></i> Cerrar Sesion</a-->
                <h1 class="pfgreen">Admin PF</h1>
            </div>
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link pfgreen hoverVerde <?php if ($vinoDe == 'buscar'){ echo "active";};?>" id="nav-buscar-tab" data-toggle="tab" href="#nav-buscar" role="tab" aria-controls="nav-buscar" aria-selected="true">
                            Buscar
                        </a>
                        <a class="nav-item nav-link pfgreen hoverVerde <?php if ($vinoDe == 'usuarios'){ echo "active";};?>" id="nav-usuarios-tab" data-toggle="tab" href="#nav-usuarios" role="tab" aria-controls="nav-usuarios" aria-selected="true">
                            Usuarios
                        </a>
                        <a class="nav-item nav-link pfgreen hoverVerde <?php if ($vinoDe == 'equipos'){ echo "active";};?>" id="nav-equipos-tab" data-toggle="tab" href="#nav-equipos" role="tab" aria-controls="nav-equipos" aria-selected="false">
                            Equipos
                        </a>
                        <a class="nav-item nav-link pfgreen hoverVerde" id="nav-estadisticas-tab" data-toggle="tab" href="#nav-estadisticas" role="tab" aria-controls="nav-estadisticas" aria-selected="false">
                            Estadísticas
                        </a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show <?php if ($vinoDe == 'buscar'){ echo "active";}?>" id="nav-buscar" role="tabpanel" aria-labelledby="nav-buscar-tab">
                        <div class="row">
                            <div class="col-md-4">
                                <h2  class="my-5 pfgreen"><i class="fas fa-search colorGris2"></i> Buscar</h2>
                                <div class="form-container my-2">
                                    <h3 class="my-3 h4 text-muted">Buscar Usuarios</h3>
                                    <form action="buscar-usuario" method="POST" >
                                        <div class="form-group">
                                            <!--label for="buscar-nombre">Buscar Usuario por Nombre</label-->
                                            <div class="input-group">
                                                <input name="nombre"  class="form-control py-2 border-right-0 border" type="text" placeholder="por nombre" id="buscar-nombre">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--label for="buscar-apellido">Buscar Usuario por Apellido</label-->
                                            <div class="input-group">
                                                <input name="apellido"  class="form-control py-2 border-right-0 border" type="text" placeholder="por apellido" id="buscar-apellido">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--label for="buscar-id">Buscar Usuario por Id</label-->
                                            <div class="input-group">
                                                <input name="id"  class="form-control py-2 border-right-0 border" type="text" placeholder="por ID" id="buscar-id">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline-success">Buscar</button>
                                    </form>
                                </div>
                                <div class="form-container my-4">
                                    <h3 class="my-3 h4 text-muted">Buscar Equipos</h3>
                                    <form action="buscar-equipo" method="POST" >
                                        <div class="form-group">
                                            <!--label for="buscar-nombre">Buscar Equipo por Nombre</label-->
                                            <div class="input-group">
                                                <input name="nombre"  class="form-control py-2 border-right-0 border" type="text" placeholder="por nombre" id="buscar-nombre">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--label for="buscar-id">Buscar Equipo por Id</label-->
                                            <div class="input-group">
                                                <input name="id"  class="form-control py-2 border-right-0 border" type="text" placeholder="por ID" id="buscar-id">
                                                <span class="input-group-append">
                                                    <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                                </span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-outline-success">Buscar</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h2  class="mt-5 mb-4 pfgreen">Resultados</h2>
                                <?php
                                if (isset($resultadosUsuario) && !empty($resultadosUsuario[0]) ) {
                                    Usuario::imprimirUsuariosPorArray($resultadosUsuario);
                                } else if (isset($resultadosEquipo) && !empty($resultadosEquipo[0]) ) {
                                    Equipo::imprimirEquiposPorArray($resultadosEquipo);
                                } else {
                                    echo "<i class='fontSize6rem colorGris1 fas fa-search mb-3 text-center d-block'></i> <br>";
                                    if ((isset($resultadosUsuario) && empty($resultadosUsuario[0]))
                                        || (isset($resultadosEquipo) && empty($resultadosEquipo[0])))
                                    {
                                        echo "<p class='colorGris1  h2 text-center font-weight-normal'>La búsqueda no trajo resultados</p>";
                                    } else {
                                        echo "<p class='colorGris1  h2 text-center font-weight-normal'>No se han realizado búsquedas</p>";
                                    }
                                }?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show <?php if ($vinoDe == 'usuarios'){ echo "active";}?>" id="nav-usuarios" role="tabpanel" aria-labelledby="nav-usuarios-tab">
                        <div>
                            <h2  class="my-5 pfgreen"><i class="fas fa-user colorGris2"></i> Listado de Usuarios</h2>
                            <div>
                                <?= Usuario::imprimirUsuariosEnTabla(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show <?php if ($vinoDe == 'equipos'){ echo "  active";}?>" id="nav-equipos" role="tabpanel" aria-labelledby="nav-equipos-tab">
                        <div>
                            <h2  class="my-5 pfgreen"><i class="fas fa-shield-alt colorGris2"></i> Listado de Equipos</h2>
                            <div>
                                <?= Equipo::imprimirEquiposEnTabla(); ?>
                                   </div>
                         </div>
                    </div>
                    <div class="tab-pane fade" id="nav-estadisticas" role="tabpanel" aria-labelledby="nav-estadisticas-tab">
                        <h2  class="my-5 pfgreen"><i class="fas fa-chart-bar colorGris2"></i> Estadísticas</h2>
                        <ul class="list-unstyled ">
                            <li><h3 class="h4 colorGris2 my-4"><i class="fas fa-calendar-alt verde3 h5"></i> Última Semana</h3>
                                <?php Estadisticas::GetEstadisticas("7")?>
                            </li>
                            <li><li><h3 class="h4 colorGris2 my-4"><i class="fas fa-calendar-alt verde3 h5"></i> Último Mes</h3>
                                <?php Estadisticas::GetEstadisticas("30")?>
                            </li>
                            <li><li><h3 class="h4 colorGris2 my-4"><i class="fas fa-calendar-alt verde3 h5"></i> Último Año</h3>
                                <?php Estadisticas::GetEstadisticas("365")?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
