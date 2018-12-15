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

$nombre ="";
$id = "";

if (Session::has('inputsBusqueda') ) {
    if (isset($inputsBusqueda['nombre']) && !empty($inputsBusqueda['nombre']) ) {
        $nombre = $inputsBusqueda['nombre'];
    };

    if (isset($inputsBusqueda['id']) && !empty($inputsBusqueda['id']) ) {
        $nombre = $inputsBusqueda['id'];
    };
}
if (Session::has('resultados') ) {
    $resultados = Session::get('resultados');
}
Session::clearValue('resultados');
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
                                    <input name="nombre" value="<?=$nombre?>" class="form-control py-2 border-right-0 border" type="text" placeholder="Nombre" id="buscar-nombre">
                                    <span class="input-group-append">
                                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                            </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="buscar-id">Buscar Equipo por Id</label>
                                <div class="input-group">
                                    <input name="id" value="<?=$id?>" class="form-control py-2 border-right-0 border" type="text" placeholder="ID" id="buscar-id">
                                    <span class="input-group-append">
                                <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                            </span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-success">Buscar</button>
                        </form>
                    </div>
                    <?php
                    if (isset($resultados) && !empty($resultados [0]) ) {
                        Equipo::imprimirEquiposPorArray($resultados);
                    } else {
                        Equipo::imprimirEquiposEnTabla();

                    }
                    ?>
                </div>
                <div>
                    <h2  class="my-5 pfgreen">Listado de Usuarios</h2>

                    <div>
                        <form class='formRegistro d-none' action="buscar-usuario" method="POST">
                            <label>Usuario</label><br><input id="jugador" type="text" name="usuario">
                            <input class='btn btn-outline-success' type="submit" value="Buscar" />
                        </form>
                        <?php
                        if(Session::has("errorBuscarUsuario")){
                            ?>
                            <div class='DivErrores'>
                                <p class="text-danger font-italic ml-5"><?=Session::get("errorBuscarUsuario")?></p>
                            </div>
                            <?php Session::clearValue('errorBuscarUsuario');
                        } ?>
                    </div>
                    <?php
                    Usuario::imprimirUsuariosEnTabla($whereEquipos);
                    ?>
                </div>
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/adminPF/desloguear'?>" class="btn btn-outline-secondary float-right"><i class="fas fa-door-open"></i> Cerrar Sesion</a>
            </div>
        </div>
    </div>
</main>
