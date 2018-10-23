<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
?>
<!DOCTYPE html>
<html>
<head>
    <title>proximafecha</title>
    <meta charset="utf-8">
    <link href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/estilo.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/fontawesome/css/all.css" rel="stylesheet">
</head>
<body>
<header class="navbar navbar-expand flex-column flex-md-row fondoHeader pl-5 pr-5">
    <div class="flexbox">
        <a class="navbar-brand mr-0 mr-md-2" href="<?= App::$urlPath;?>/" aria-label="Bootstrap">
                <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader mr-3">
        </a>
        <!--h1>
            <a class="navbar-brand mr-0 mr-md-2 text-white" href="#/home" aria-label="Bootstrap">
                Stardust T-shirts
            </a>
        </h1-->
    </div>
    <div class="flexbox navbar-nav ml-md-auto">
        <form class="d-none d-md-block d-lg-block">
        <!--input class="form-control ml-5 mr-sm-2" type="search" placeholder="Buscar" aria-label="Search"-->
            <div class="input-group">
                <div class="input-group-prepend justify-content-center">
                    <span class="input-group-text" id="inputGroupPrepend2"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" id="validationDefaultUsername" placeholder="Buscar..." aria-describedby="inputGroupPrepend2" required>
            </div>
            <!--button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button-->
        </form>
    </div>
    <!--div class="navbar-nav ml-md-auto d-none d-md-flex text-light"-->
    <div class="navbar-nav ml-md-auto text-light">
        <button class="btn btn-outline-warning btn-bd-download d-lg-inline-block mb-3 mb-md-0 ml-md-3" ng-click="cerrarSesion()">REGISTRARSE</button>
    </div>
</header>
<section class="pt-4 bg-image-full fondoFull img-fluid ">
    <div class="container">
    <div class="row">
        <!--p class="d-block mr-auto ml-5 col-md-5"-->
        <p class="d-none d-md-block d-lg-block col-md-5 h1 text-white sombraTexto display-4 font-weight-normal">
            HOLA HOLA <br>O BUSCA <br><span class="font-weight-bold">TORNEOS DEPORTIVOS</span>
        </p>
        <div class='col-md-2'>
        </div>
        <div class='col-xs-12 col-md-5'>
            <form class="rounded shadow px-4 py-3 fondoFormHome">
                <div class="form-group text-center text-white border-bottom">
                    <p>Iniciar Sesión</p>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Usuario</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <!--div-- class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div-->
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
    </div>
</section>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class='col-md-4 text-center p-3'>
                <div class="rounded  shadow  p-5">
                    <img src="<?= App::$urlPath;?>/img/torneo.png" class='porcentaje60' alt="ícono organizar torneo">
                    <p class="naranjaFecha mt-4 h4">Organiza tus <br>TORNEOS</p>
                </div>
            </div>
            <div class='col-md-4 text-center p-3'>
                <div class="rounded  shadow  p-5">
                    <img src="<?= App::$urlPath;?>/img/liga.png" class='porcentaje60' alt="ícono gestionar ligas">
                    <p class="naranjaFecha  mt-4 h4">Gestiona las <br>LIGAS</p>
                </div>
            </div>
            <div class='col-md-4 text-center p-3'>
                <div class="rounded  shadow  p-5">
                    <img src="<?= App::$urlPath;?>/img/buscarligas.png" class='porcentaje60' alt="ícono buscar ligas">
                    <p class="naranjaFecha  mt-4 h4">Inscríbete en <br>CAMPEONATOS </p>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="row text-white fondoNaranjaFecha h3 font-italic p-4 my-4">
            <p class="col-md-12 m-0">¿QUÉ PUEDO HACER EN PROXIMAFECHA.COM?</p>
        </div>
        <div class="row p-4 my-4 text-muted">
            <div class="col-md-6">
                <p class="naranjaFecha h3 pb-3 border-bottom">ORGANIZADORES</p>
                <div class="mt-4 fontSize">
                    <ul class="vinietasCheck">
                        <li> <p class="ml-2">Organizar torneos o ligas de cualquier deporte y llevar toda la gestión desde la web.</p></li>
                        <li> <p class="ml-2">Tener una web propia del torneo donde se publicará toda la información necesaria.</p></li>
                        <li> <p class="ml-2">Comunicarte con cualquier equipo participante del torneo.</p></li>
                    </ul>
                    <!--p><i class="fas fa-check-square text-success"></i> Organizar torneos o ligas de cualquier deporte y llevar toda la gestión desde la web.</p-->
                </div>
            </div>
            <div class="col-md-6">
                <p class="naranjaFecha h3 pb-3 border-bottom">JUGADORES</p>
                <div class="mt-4 fontSize">
                    <ul class="vinietasCheck">
                        <li> <p class="ml-2">Sumarte a un equipo y a través de él participar de un torneo.</p></li>
                        <li> <p class="ml-2">Ser el delegado de tu equipo, encargado de la comunicación con el organizador.</p></li>
                        <li> <p class="ml-2">Informarte vía online acerca de los detalles de la próxima fecha, en la web exclusiva del torneo.</p></li>
                    </ul>
                    <!--p><i class="fas fa-check text-success"></i> Sumarte a un equipo y a través de él participar de un torneo.</p-->
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-outline-success btn-lg btn-block alto70">CREA TU CAMPEONATO <b>AHORA</b></button>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
</main>
<footer class="fondoFooter pt-5">
    <div class="container-fluid pb-4">
        <div class="row   text-white">
            <div class="col-md-3 text-center">
                <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader mr-3">
            </div>
            <div class="col-md-2">
                <p class="h5 mb-3">Organizadores</p>
                <ul class="list-unstyled fontSize14">
                    <li class="mb-3"><a href="#" class="text-white">Organizar un Torneo</a></li>
                    <li class="mb-3"><a href="#" class="text-white">Registrarme</a></li>
                    <li class="mb-3"><a href="#" class="text-white">Ingresar</a></li>
                    <li class="mb-3"><a href="#" class="text-white">Gratuidad del Serivicio</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <p class="h5 mb-3">Jugadores</p>
                <ul class="list-unstyled fontSize14">
                    <li class="mb-3"><a href="#" class="text-white">Buscar Campeonato</a></li>
                    <li class="mb-3"><a href="#" class="text-white">Registrarme</a></li>
                    <li class="mb-3"><a href="#" class="text-white">Ingresar</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <p class="h5 mb-3">Preguntas Frecuentes</p>
                <ul class="list-unstyled fontSize14">
                    <li class="mb-3"><a href="#" class="text-white">¿Es necesario hacerme un usuario?</a></li>
                    <li class="mb-3"><a href="#" class="text-white">¿Es gratis el servicio?</a></li>
                    <li class="mb-3"><a href="#" class="text-white">¿Que tipos de torneo puedo organizar?</a></li>
                    <li class="mb-3"><a href="#" class="text-white">¿Puedo organizar un campeonato siendo jugador de otro?</a></li>
                    <li class="mb-3"><a href="#" class="text-white">¿Cuántos campeonatos puedo organizar?</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <p>Redes Sociales</p>
                <ul class="list-unstyled d-flex">
                    <li class="mr-4"><img src="<?= App::$urlPath;?>/img/fb_naranja.png" alt="facebook icon"></li>
                    <li><img src="<?= App::$urlPath;?>/img/twitter.png" alt="twitter icon"></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="basefooter">
    </div>
</footer>
</body>
<script src="<?= App::$urlPath;?>/js/jquery-3.3.1.min.js"></script>
<script src="<?= App::$urlPath;?>/bootstrap/js/bootstrap.min.js"></script>
</html>
