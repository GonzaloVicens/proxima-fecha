<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;


if (Session::has('logueado') && Session::get('logueado')=='S') {
    $usuarioLogueado = true;
}else{
    $usuarioLogueado = false;
}

if (! $usuarioLogueado ){
    if (Session::has("camposError")){
        $camposError = Session::get("camposError");
        $camposViejos = Session::get("campos");
        $usuario=$camposViejos['usuario'];
        $nombre=$camposViejos['nombre'];
        $apellido=$camposViejos['apellido'];
        $email=$camposViejos['email'];
        Session::clearValue("camposError");
        Session::clearValue("campos");
    } else {
        $usuario="";
        $nombre="";
        $apellido="";
        $email="";
    }
};

?>
<main class="py-4 mb-4 registro">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen"><i class="fas fa-user"></i> Registrarse</h2>
                <form class='formRegistro' action="<?= App::$urlPath;?>/usuarios/registrar"  method="post">
                    <div class="form-group">
                       <label for="usuario">Usuario</label>
                       <input type="text" <?= "value='$usuario'"?> class="form-control" name="usuario" id="usuario" placeholder="Elige tu usuario">
                        <?php
                        if (! $usuarioLogueado && isset($camposError['usuario'])) {
                            echo "<p class='rta-validacion text-danger'><small>" . $camposError['usuario'] . "</small><p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" <?= "value='$nombre'"?> class="form-control" name="nombre" id="nombre" aria-describedby="emailHelp" placeholder="Ingresá tu nombre">
                        <?php
                        if (! $usuarioLogueado && isset($camposError['nombre'])) {
                            echo "<p class='rta-validacion text-danger'><small>" . $camposError['nombre'] . "</small><p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" <?= "value='$apellido'"?> class="form-control" name="apellido" id="apellido"  placeholder="Ingresá tu apellido">
                        <?php
                        if (! $usuarioLogueado && isset($camposError['apellido'])) {
                            echo "<p class='rta-validacion text-danger'><small>" . $camposError['apellido'] . "</small><p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" <?= "value='$email'"?> class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Tu dirección de e-mail">
                        <?php
                        if (! $usuarioLogueado && isset($camposError['email'])) {
                            echo "<p class='rta-validacion text-danger'><small>" . $camposError['email'] . "</small><p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="clave" id="password" placeholder="Elige un Password">
                        <?php
                        if (! $usuarioLogueado && isset($camposError['clave'])) {
                            echo "<p class='rta-validacion text-danger'><small>" . $camposError['clave'] . "</small><p>";
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="confirmarpassword">Confirmar Password</label>
                        <input type="password" class="form-control" name="confClave" id="confirmarpassword" placeholder="Confirmar Password">
                        <?php
                        if (! $usuarioLogueado && isset($camposError['confClave'])) {
                            echo "<p class='rta-validacion text-danger'><small>" . $camposError['confClave'] . "</small><p>";
                        }
                        ?>
                    </div>
                    <div class="form-check">
                        <!--input type="checkbox" class="form-check-input" name="terminos" id="terminos"-->
                        <label class="form-check-label terminos_condiciones"><input type="checkbox" class="form-check-input" name="terminos" id="terminos"> Acepto los términos y condiciones </label>
                        <?php
                        if (! $usuarioLogueado && isset($camposError['terminos'])) {
                            echo "<small class='rta-validacion text-danger'>" . $camposError['terminos'] . "</small>";
                        }
                        ?>
                    </div>
                    <button type="submit" class="btn btn-outline-success mr-2">Crear Cuenta</button>
                    <a href="<?=App::$urlPath . '/'?>" class="btn btn-link cancel" data-dismiss="modal">Cancelar</a>
                </form>
            </div>
            <div class="col-md-3">
                <?php

                if (! $usuarioLogueado && isset($camposError)){
                    ///echo("<div class='DivErrores'><ul>");
                    foreach ($camposError as $error => $descr) {
                     ///echo ("<li style='color:#F00'>".ucfirst($error).": ".$descr." " . $error . "</li>");
                    }
                    ///echo("</ul></div>");
                }

                ?>
            </div>
        </div>
    </div>
</main>

