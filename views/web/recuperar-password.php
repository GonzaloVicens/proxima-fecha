<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;


if (Session::has("errorLogin")){
    $errorLogin = Session::get("errorLogin");
    Session::clearValue("errorLogin");
} ;

?>
<main class="py-4 mb-4 registro">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen"><i class="fas fa-user"></i> Recuperar Contraseña</h2>
                <form class='formRegistro' action="<?= App::$urlPath;?>/usuarios/recuperar-password"  method="post">
                    <div class="form-group">
                       <label for="email">E-Mail</label>
                       <input type="text" class="form-control" name="email" id="email" placeholder="Ingresa tu correo">
                        <?php
                        if (isset($camposError['email'])) {
                            echo "<p class='rta-validacion text-danger'><small>" . $camposError['email'] . "</small><p>";
                        }
                        ?>
                    </div>
                    <button type="submit" class="btn btn-outline-success mr-2">Recuperar Password</button>
                    <a href="<?=App::$urlPath . '/'?>" class="btn btn-link cancel" data-dismiss="modal">Cancelar</a>
                </form>
            </div>
            <div class="col-md-3">
                <?php

                if ( isset($errorLogin)){
                    echo "<p>" . $errorLogin . "</p>";

                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <?php
                if (Session::has('mailEnviado')){
                    if (Session::get('mailEnviado') == "Y"){
                        echo "<p> Se ha enviado un correo a su cuenta de mail. Revise su correo para poder iniciar sesión</p>";
                    };
                };
                Session::clearValue('mailEnviado');
                ?>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>
</main>

