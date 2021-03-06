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
if (isset($usuario)){
    $usuario->actualizar();
};
$usuarioAMostrar->actualizar();

if (Session::has('errorUsuarioStandard') && Session::get('errorUsuarioStandard') == "Y"){
    $errorUsuarioStandard = true;
} else {
    $errorUsuarioStandard = false;
}
Session::clearValue('errorUsuarioStandard');

if (Usuario::existeUsuario($usuarioAMostrar->getUsuarioID())) {
?>
<main class="py-4 mb-4 usuario">
    <div class="container">
        <div class="row border-bottom main-info">
            <div class="col-md-4 px-3 py-4">
                <?php
                    $claseCamara = "";
                    if (isset($usuario) && ($usuarioAMostrar->getUsuarioID() == $usuario->getUsuarioID())) {
                        $claseCamara = " hover-camera ";
                    }

                    if(isset($usuarioAMostrar) and file_exists('img/usuarios/'. $usuarioAMostrar->getUsuarioId() . '.jpg')){
                        echo "<div style='width: 220px' class='m-auto text-center rounded-circle border-verdepf p-1 overflowhidden'><div class='". $claseCamara ." rounded-circle border overflowhidden'><img class='w-100 rounded-circle' src='../img/usuarios/".$usuarioAMostrar->getUsuarioId() . ".jpg' alt='foto perfil' /></div></div>";
                    }else {
                        echo "<div style='width: 220px' class='m-auto text-center rounded-circle w-75 border-verdepf p-1 overflowhidden'><div class='". $claseCamara ." rounded-circle border overflowhidden'><img class='w-100 rounded-circle' src='../img/usuarios/UserJugador.jpg' alt='foto perfil' /></div></div>";
                    }

                    if (Session::has('errorImagenNoJPG') ){
                        if (Session::get('errorImagenNoJPG') == 'Y'){
                            echo "<p class='text-center text-danger'><b>Formato de imagen no válido</b><br> sólo se permiten imágenes <em>.jpg</em></p>";
                            echo "<p class='d-none'>111" .Session::get('errorImagenNoJPG2') . "222</p>" ;
                            Session::clearValue('errorImagenNoJPG') ;
                            Session::clearValue('errorImagenNoJPG2') ;
                        }
                    }
                ?>

            </div>
            <div class="col-md-4 pl-4">
                <ul class="list-unstyled">
                    <li class='nombreUser mt-4 mb-3'><h2><?= $usuarioAMostrar->getNombreCompleto()?></h2></li>
                    <li><span class='font-weight-bold text-dark'>Equipos</span>
                        <ul class="list-unstyled">
                            <?php
                            if($usuarioAMostrar->tieneEquipo()){
                                foreach ($usuarioAMostrar->getEquipos() as $equipo) {
                                    echo "<li class='text-secondary'><a href='". App::$urlPath ."/equipos/".$equipo->getEquipoID()."' title='Ver Equipo'>" . $equipo->getNombre() ."</a>";
                                    if (isset($usuario) && ($usuarioAMostrar->getUsuarioID() == $usuario->getUsuarioID())) {
                                       if (!$equipo->estaJugandoTorneo()){
                                            echo "<i id = '".$equipo->getEquipoID()."' class='fas fa-trash-alt eliminar_equipo' data - toggle = 'tooltip' data - placement = 'top' title = 'Eliminar equipo' >";
                                       }
                                    };
                                    echo "</i></li>";
                                }
                            }else{
                                echo "<li class='text-secondary'>Todavía no sos parte de ningún equipo.</li>";
                            }?>
                        </ul>
                    </li>
                    <li><span class='font-weight-bold text-dark'>Torneos en los que participa</span>
                        <ul class="list-unstyled">
                            <?php
                            if($usuarioAMostrar->tieneTorneo()){
                                foreach ($usuarioAMostrar->getTorneos() as $torneo) {
                                    echo "<li class='text-secondary'><a class='negrita' href='". App::$urlPath . "/torneos/" . $torneo->getTorneoID() ."' title='Ver Torneo'>" .   $torneo->getNombre()  ."</a></li>";
                                }
                            }else{
                                echo "<li class='text-secondary'>No participa en ningún torneo</li>";
                            }

                            ?>
                        </ul>
                    </li>
                    <li><span class='font-weight-bold text-dark'>Torneos que organiza</span>
                        <ul class="list-unstyled">
                            <?php
                            if($usuarioAMostrar->tieneTorneosPropios()){
                                foreach ($usuarioAMostrar->getTorneosPropios() as $torneo) {
                                    echo "<li class='text-secondary'><a class='negrita' href='". App::$urlPath . "/torneos/" . $torneo->getTorneoID() ."' title='Ver Torneo'>" .   $torneo->getNombre()  ."</a></li>";
                                }
                            }else{
                                echo "<li class='text-secondary'>No ha creado ningún torneo</li>";
                            };
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 pl-4">
                <?php if (isset($usuario) && $usuarioAMostrar->getUsuarioID() == $usuario->getUsuarioID()) {
                ?>
                    <a href = 'editar-datos' class='editar_user'></a>
                    <ul class="list-unstyled tipo-de-cuenta">
                        <li><span class='font-weight-bold text-dark'>Tipo de cuenta</span>
                            <?php if ($usuario->esUsuarioPro() ) { ?>
                                <p class="my-1 text-secondary">Cuenta Pro <i class="fas fa-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="Puedes organizar más de un torneo en simultáneo"></i></p>
                                <p class="my-1 text-secondary">Vence el <?= $usuario->getVencimientoPro()?><i class="fas fa-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="Puedes organizar más de un torneo en simultáneo"></i></p>
                            <?php } else { ?>
                                <p class="my-1 text-secondary">Cuenta Standar <i class="fas fa-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="No puedes organizar más de un torneo en simultáneo"></i></p>
                                <p class="my-1"><a href="<?= App::$urlPath ?>/usuarios/pasar-a-cuenta-pro" class="pfgreen hoverVerde"><i class="fas fa-crown"></i> Pasar a Cuenta Pro</a></p>
                            <?php } ?>
                        </li>
                    </ul>
                <?php }?>
            </div>
        </div>
        <?php if  (Session::has("logueado") && $usuarioAMostrar->getUsuarioID() == Session::get('usuario')->getUsuarioID()){ ?>
        <div class="row pt-5">
            <div class="col-md-12 mb-3">
                <h2>Acciones</h2>
            </div>
            <div class="col-md-3 text-center">
                <a href="<?= App::$urlPath;?>/usuarios/crear-sede" class="d-block accion h-14rem border  m-auto w-75 rounded py-4 shadow-sm">
                    <h3 class="h4">Crear Sede</h3>
                    <div class="sede"></div>
                </a>
            </div>
            <div class="col-md-3 text-center">
                <a href="<?= App::$urlPath;?>/usuarios/crear-torneo" class="d-block accion h-14rem border  m-auto w-75 rounded py-4 shadow-sm">
                    <h3 class="h4">Crear Torneo</h3>
                    <div class="copa"></div>
                </a>
            </div>
            <div class="col-md-3 text-center">
                <div id='agregar_equipo' class="accion h-14rem border m-auto w-75 rounded py-4 shadow-sm">
                    <h3 class="h4">Crear Equipo</h3>
                    <div class="escudo"></div>
                </div>
            </div>
             <div class="col-md-3 text-center">
                <div id='buscar' class="accion h-14rem border m-auto w-75 rounded py-4 shadow-sm">
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
    header("Location: error404");
}
?>


