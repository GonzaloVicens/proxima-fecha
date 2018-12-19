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
<section class="pt-4 bg-image-full fondoFull img-fluid ">
    <div class="container">
        <div class="row">
            <p class="d-none d-md-block d-lg-block col-md-5 h1 text-white sombraTexto display-4 font-weight-normal">
                ORGANIZA <br>O BUSCA <br><span class="font-weight-bold">TORNEOS DEPORTIVOS</span>
            </p>
            <div class='col-md-2'>
            </div>
            <div class='col-xs-12 col-md-5'>
                <div class="container-form-home  m-auto">
                    <form method='post' action='<?= App::$urlPath;?>/' class="rounded fondoFormHome">
                        <div class="text-white border-bottom form-header">
                            <p class="iniciarsesion">Iniciar Sesión</p>
                        </div>
                        <div class="form-container">
                            <div class="form-group floating-label-form-group">
                                <label for="usuario">Usuario</label>
                                <input type="text" class="form-control" name='usuario' id="usuario" aria-describedby="emailHelp" placeholder="Usuario">
                            </div>
                            <div class="form-group floating-label-form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name='password' id="password" placeholder="Password">
                            </div>
                            <!--div-- class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div-->
                            <button type="submit" class="btn btn-primary">Enviar</button>
                            <div class="form-footer">
                                <div class="rta_fail_login">
                                    <div class="div_rta">
                                        <?php
                                        if (Session::has('errorLogin')) {
                                            echo("<p class='text-center'> " . Session::get('errorLogin') . " </p>");
                                            Session::clearValue('errorLogin');
                                        };
                                        ?>
                                    </div>
                                    <div class="d-flex justify-content-around text-muted">
                                        <a class='recuperar_pass' href="<?= App::$urlPath;?>/recuperar-password">recuperar contraseña</a>
                                        <a class='crear_cuenta' href="<?= App::$urlPath;?>/registrarse">crear una cuenta</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
                    <p class="naranjaFecha  mt-4 h4">Inscríbete en <br>COPAS </p>
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
                <a href="<?= App::$urlPath;?>/registrarse" type="button" class="btn btn-outline-success btn-lg btn-block alto70">CREA TU TORNEO <b>AHORA</b></a>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
</main>
