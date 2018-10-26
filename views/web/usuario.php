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
        <div class="row border-bottom">
            <div class="col-md-4 p-3">

                    <?php
                    if(isset($usuario) and file_exists('../img/usuarios/'.$usuario->getUsuarioId() . '.jpg')){
                        echo "<div class='m-auto text-center rounded-circle w-75 border-verdepf p-2 overflowhidden'> <img class='w-100 rounded-circle' src='../img/usuarios/".$usuario->getUsuarioId() . ".jpg' alt='foto perfil' /></div>";
                    }else {
                        echo "<div class='m-auto text-center rounded-circle w-75 border-verdepf p-2 overflowhidden'><div class='hover-camera rounded-circle border overflowhidden'><img class='w-100 rounded-circle' src='../img/usuarios/vicensG.jpg' alt='foto perfil' /></div></div>";
                    }
                ?>

            </div>
            <div class="col-md-8 pl-4">
                <ul class="list-unstyled">
                    <span class="editar_user"></span>
                    <li class='nombreUser mt-4 mb-3'><h2>Gonzalo Vicens</h2><?php //echo $usuario->getNombreCompleto()?></li>
                    <li><span class='font-weight-bold text-dark'>Equipos</span>
                        <ul class="list-unstyled">
                            <li  class="text-secondary">Todavía no sos parte de ningún equipo.</li>
                            <?php
                            /*if($usuario->tieneEquipo()){
                                foreach ($usuario->getEquipos() as $equipo) {

                                    echo "<li><a class='negrita' href='index.php?seccion=miequipo&equipo_id=".$equipo->getEquipoID()."' title='Ver Equipo'>" . $equipo->getNombre() ."</a></li>";
                                }
                            }else{
                                echo "<li>Todavía no sos parte de ningún equipo.</li>";

                            }*/
                            ?>
                        </ul>
                    </li>
                    <li><span class='font-weight-bold text-dark'>Torneos en los que participa</span>
                        <ul class="list-unstyled">
                            <li  class="text-secondary">No participa en ningún torneo</li>
                            <?php
                            /*
                            if($usuario->tieneTorneo()){
                                foreach ($usuario->getTorneos() as $torneo) {
                                    echo "<li>" . $torneo->getNombre() ." </li>";
                                }
                            }else{
                                echo "<li>No participa en ningún torneo</li>";
                            }
                            */
                            ?>
                        </ul>
                    </li>
                    <li><span class='font-weight-bold text-dark'>Torneos creados</span>
                        <ul class="list-unstyled">
                            <li class="text-secondary">No ha creado ningún torneo</li>
                            <?php
                            /*
                            if($usuario->tieneTorneoPropio()){
                                foreach ($usuario->getTorneosPropios() as $torneo) {
                                    echo "<li>" . $torneo->getNombre() ." </li>";
                                }
                            }else{
                                echo "<li>No ha creado ningún torneo</li>";
                            }
                            */
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-md-12 mb-3">
                <h2>Acciones</h2>
            </div>
            <div class="col-md-4 text-center">
                <div class="accion h-16rem border  m-auto w-75 rounded py-4 shadow-sm">
                    <h3 class="h4">Crear Torneo</h3>
                    <div class="copa"></div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div id='agregar_equipo' class="accion h-16rem border m-auto w-75 rounded py-4 shadow-sm">
                    <h3 class="h4">Crear Equipo</h3>
                    <div class="escudo"></div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="accion h-16rem border m-auto w-75 rounded py-4 shadow-sm">
                    <h3 class="h4">Buscar</h3>
                    <div class="buscar"></div>
                </div>
            </div>
        </div>
    </div>
</main>

