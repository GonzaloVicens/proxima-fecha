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
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <h2 class="mt-5 mb-4 pfgreen">Registrarse</h2>
                <form class='formRegistro' action="<?= App::$urlPath;?>/usuarios/registrar"  method="post">
                    <div class="form-group">
                       <label for="usuario">Usuario</label>
                       <input type="text" <?= "value='$usuario'"?> class="form-control" name="usuario" id="usuario" placeholder="Elige tu usuario">
                    </div>
                    <div class="form-group">
                       <label for="nombre">Nombre</label>
                        <input type="text" <?= "value='$nombre'"?> class="form-control" name="nombre" id="nombre" aria-describedby="emailHelp" placeholder="Ingresá tu nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" <?= "value='$apellido'"?> class="form-control" name="apellido" id="apellido"  placeholder="Ingresá tu apellido">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" <?= "value='$email'"?> class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Tu dirección de e-mail">
                        <!--small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small-->
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="clave" id="password" placeholder="Elige un Password">
                    </div>
                    <div class="form-group mb-4">
                        <label for="confirmarpassword">Confirmar Password</label>
                        <input type="password" class="form-control" name="confClave" id="confirmarpassword" placeholder="Confirmar Password">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="terminos" id="terminos">
                        <label class="form-check-label" for="terminos"> Acepto los términos y condiciones </label>
                    </div>
                    <button type="submit" class="btn btn-lg btn-outline-success">Crear Cuenta</button>
                    <a href="<?=App::$urlPath . '/'?>" type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</a>
                </form>
            </div>
            <div class="col-md-3">
                <?php
                if (! $usuarioLogueado && isset($camposError)){
                    echo("<div class='DivErrores'><ul>");
                    foreach ($camposError as $error => $descr) {
                        echo ("<li style='color:#F00'>".ucfirst($error).": ".$descr."</li>");
                    }
                    echo("</ul></div>");
                }
                ?>
            </div>
        </div>
    </div>
</main>

