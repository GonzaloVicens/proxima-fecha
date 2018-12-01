<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 21/10/2018
 * Time: 03:54 PM
 */

use Proyecto\Core\App;
use Proyecto\Model\Usuario;
use Proyecto\Session\Session;

if (Session::has('logueado') && Session::get('logueado')=='S') {
    $usuarioLogueado = true;
    if (Session::has('usuario')){
        $usuario = Session::get('usuario');
    };
}else{
    $usuarioLogueado = false;
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>proximafecha</title>
    <meta charset="utf-8">
    <link href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/estilo.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/header_nav.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/miequipo.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/notificaciones.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/preguntas-frecuentes.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/fontawesome/css/all.css" rel="stylesheet">
</head>
<header>
    <!--header class="navbar navbar-expand flex-column flex-md-row pl-5 pr-5 shadow_bottom fondoHeader2">
    <div class="flexbox">
        <a class="navbar-brand mr-0 mr-md-2" href="<?= App::$urlPath;?>/" aria-label="Bootstrap">
            <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader2 mr-3">
        </a>
    </div>
    <div class="navbar-nav ml-md-auto text-light">
        <a class="btn btn-outline-light btn-bd-download d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="<?= App::$urlPath;?>/desloguear">Cerrar Sesión</a>
    </div>
</header-->
    <header class="shadow_bottom">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-white navbar-dark fondoHeader2">
            <!--a class="navbar-brand" href="#">Navbar</a-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <!---span style='color:red !important;' class="navbar-toggler-icon"></span-->
                <span class="hamburguer"><i class="fas fa-bars"></i></span>
            </button>
            <a class="navbar-brand mr-0 mr-md-2" href="<?= App::$urlPath;?>/" aria-label="Bootstrap">
                <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader3 mr-3">
            </a>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= App::$urlPath;?>/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMisTorneos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Mis Torneos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMisTorneos">
                            <ul class="list-unstyled">
                                <?php
                                if($usuario->tieneTorneo()){
                                    foreach ($usuario->getTorneos() as $torneo) {
                                        echo "<li class='dropdown-item'><a href='../torneos/".$torneo->getTorneoID() ."' title='Ver Torneo'>" . $torneo->getNombre()  ."</a></li>";
                                    }
                                }else{
                                    echo "<li class='dropdown-item no-options'>No participa <br>en ningún torneo</li>";
                                }
                                ?>
                            </ul>
                        </div>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMisEquipos" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Mis Equipos
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMisEquipos">
                            <ul class="list-unstyled">
                                <?php
                                if($usuario->tieneEquipo()){
                                    foreach ($usuario->getEquipos() as $equipo) {
                                        echo "<li class='dropdown-item'><a href='../equipos/".$equipo->getEquipoID()."' title='Ver Equipo'>" . $equipo->getNombre() ."</a></li>";
                                    }
                                }else{
                                    echo "<li class='dropdown-item no-options'>Todavía no sos parte <br>de ningún equipo.</li>";
                                }?>
                            </ul>
                        </div>

                    </li>
                </ul>
                <ul class="navbar-nav userdropdown">
                    <li class="nav-item dropdown">
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <span class="text-white"><i class="fas fa-bell"></i></span>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownNotification" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span>Notificaciones</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                            <ul class="list-unstyled">
                                <li class="dropdown-item">
                                    <a href="<?= App::$urlPath;?>/usuarios/notificaciones" class="">ver notificaciones</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php
                            if(isset($usuario) and file_exists('img/usuarios/'.$usuario->getUsuarioId() . '.jpg')){
                                echo "<span class='d-block m-auto text-center rounded-circle overflowhidden'> <img class='rounded-circle' src='" . App::$urlPath . "/img/usuarios/".$usuario->getUsuarioId() . ".jpg' alt='foto perfil' /></span>";
                            }else {
                                echo "<span class='d-block m-auto text-center rounded-circle overflowhidden'> <img class='rounded-circle' src='" . App::$urlPath . "/img/usuarios/UserJugador.jpg' alt='foto perfil' /></span>";
                            }
                            ?>
                            <div>
                                <span><?php echo $usuario->getUsuarioID(); ?></span>
                            </div>
                        </a>
                        <div class="dropdown-menu end-session" aria-labelledby="navbarDropdownMenuLink">
                            <ul class="list-unstyled">

                                <li class="dropdown-item">
                                    <a href="<?= App::$urlPath;?>/desloguear">cerrar sesión</a>
                                </li>
                            </ul>
                            <!--a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a-->
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>