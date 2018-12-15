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


if (Session::has('resultadosEquipo') ) {
    $resultadosEquipo = Session::get('resultadosEquipo');
}
Session::clearValue('resultadosEquipo');

if (Session::has('resultadosUsuario') ) {
    $resultadosUsuario = Session::get('resultadosUsuario');
}
Session::clearValue('resultadosUsuario');

?>

<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
              <div class="col-md-10">
                <div>
                    <h2 class="my-5 pfgreen">Listado de Equipos</h2>
                    <div>
                        <form action="buscar-equipo" method="POST" >
                            <div class="form-group">
                                <label for="buscar-nombre">Buscar Equipo por Nombre</label>
                                <div class="input-group">
                                    <input name="nombre"  class="form-control py-2 border-right-0 border" type="text" placeholder="Nombre" id="buscar-nombre">
                                    <span class="input-group-append">
                                            <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="buscar-id">Buscar Equipo por Id</label>
                                <div class="input-group">
                                    <input name="id"  class="form-control py-2 border-right-0 border" type="text" placeholder="ID" id="buscar-id">
                                    <span class="input-group-append">
                                        <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                                    </span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-success">Buscar</button>
                        </form>
                    </div>
                    <?php /*
                    if (isset($resultadosEquipo) && !empty($resultadosEquipo[0]) ) {
                        Equipo::imprimirEquiposPorArray($resultadosEquipo);
                    } else {
                        Equipo::imprimirEquiposEnTabla();

                    }*/
                    ?>
                </div>
                <div>
                    <h2  class="my-5 pfgreen">Listado de Usuarios</h2>

                    <div>
                        <form action="buscar-usuario" method="POST" >
                            <div class="form-group">
                                <label for="buscar-nombre">Buscar Usuario por Nombre</label>
                                <div class="input-group">
                                    <input name="nombre"  class="form-control py-2 border-right-0 border" type="text" placeholder="Nombre" id="buscar-nombre">
                                    <span class="input-group-append">
                                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                            </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="buscar-apellido">Buscar Usuario por Apellido</label>
                                <div class="input-group">
                                    <input name="apellido"  class="form-control py-2 border-right-0 border" type="text" placeholder="Apellido" id="buscar-apellido">
                                    <span class="input-group-append">
                                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                            </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="buscar-id">Buscar Usuario por Id</label>
                                <div class="input-group">
                                    <input name="id"  class="form-control py-2 border-right-0 border" type="text" placeholder="ID" id="buscar-id">
                                    <span class="input-group-append">
                                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                            </span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-success">Buscar</button>
                        </form>
                    </div>
                    <?php
                    if (isset($resultadosUsuario) && !empty($resultadosUsuario[0]) ) {
                        Usuario::imprimirUsuariosPorArray($resultadosUsuario);
                    } else {
                        Usuario::imprimirUsuariosEnTabla();
                    }
                    ?>

                </div>
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/adminPF/desloguear'?>" class="btn btn-outline-secondary float-right"><i class="fas fa-door-open"></i> Cerrar Sesion</a>
            </div>
        </div>
    </div>
</main>
