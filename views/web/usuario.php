<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Model\Usuario;
use Proyecto\Session\Session;

if (Usuario::existeUsuario($usuario_id)) {
?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row border-bottom">
            <div class="col-md-4 p-3">
                <?php
                    if(isset($usuario) and file_exists('img/usuarios/'.$usuario->getUsuarioId() . '.jpg')){
                        echo "<div class='m-auto text-center rounded-circle w-75 border-verdepf p-2 overflowhidden'> <img class='w-100 rounded-circle' src='../img/usuarios/".$usuario->getUsuarioId() . ".jpg' alt='foto perfil' /></div>";
                    }else {
                        echo "<div class='m-auto text-center rounded-circle w-75 border-verdepf p-2 overflowhidden'><div class='hover-camera rounded-circle border overflowhidden'><img class='w-100 rounded-circle' src='../img/usuarios/UserJugador.jpg' alt='foto perfil' /></div></div>";
                    }
                ?>

            </div>
            <div class="col-md-8 pl-4">
                <ul class="list-unstyled">
                    <span class="editar_user"></span>
                    <li class='nombreUser mt-4 mb-3'><h2><?= $usuario->getNombreCompleto()?></h2></li>
                    <li><span class='font-weight-bold text-dark'>Equipos</span>
                        <ul class="list-unstyled">
                            <?php
                            if($usuario->tieneEquipo()){
                                foreach ($usuario->getEquipos() as $equipo) {
                                    echo "<li class='text-secondary'><a class='negrita' href='../equipos/".$equipo->getEquipoID()."' title='Ver Equipo'>" . $equipo->getNombre() ."</a></li>";
                                }
                            }else{
                                echo "<li class='text-secondary'>Todavía no sos parte de ningún equipo.</li>";
                            }?>
                        </ul>
                    </li>
                    <li><span class='font-weight-bold text-dark'>Torneos en los que participa</span>
                        <ul class="list-unstyled">
                            <?php
                            if($usuario->tieneTorneo()){
                                foreach ($usuario->getTorneos() as $torneo) {
                                    echo "<li class='text-secondary'><a class='negrita' href='../torneos/".$torneo->getTorneoID() ."' title='Ver Torneo'>" . $torneo->getNombre()  ."</a></li>";
                                }
                            }else{
                                echo "<li class='text-secondary'>No participa en ningún torneo</li>";
                            }

                            ?>
                        </ul>
                    </li>
                    <li><span class='font-weight-bold text-dark'>Torneos creados</span>
                        <ul class="list-unstyled">
                            <?php
                            if($usuario->tieneTorneoPropio()){
                                foreach ($usuario->getTorneosPropios() as $torneo) {
                                    echo "<li class='text-secondary'><a class='negrita' href='../torneos/".$torneo->getTorneoID() ."' title='Ver Torneo'>" . $torneo->getNombre()  ."</a></li>";
                                }
                            }else{
                                echo "<li class='text-secondary'>No ha creado ningún torneo</li>";
                            };
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <?php if  (Session::has("usuario")){ ?>
        <div class="row pt-5">
            <div class="col-md-12 mb-3">
                <h2>Acciones</h2>
            </div>
            <div class="col-md-4 text-center">
                <a href="<?= App::$urlPath;?>/crear-torneo" class="d-block accion h-16rem border  m-auto w-75 rounded py-4 shadow-sm">
                    <h3 class="h4">Crear Torneo</h3>
                    <div class="copa"></div>
                </a>
            </div>
            <div class="col-md-4 text-center">
                <div id='agregar_equipo' class="accion h-16rem border m-auto w-75 rounded py-4 shadow-sm">
                    <h3 class="h4">Crear Equipo</h3>
                    <div class="escudo"></div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div id='buscar' class="accion h-16rem border m-auto w-75 rounded py-4 shadow-sm">
                    <h3 class="h4">Buscar</h3>
                    <div class="buscar"></div>
                </div>
            </div>
        </div>
        <?php }?>
    </div>
</main>
<?php
} else {
    header("Location: /error404");
}
?>

