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
<main class="py-4 mb-4 editar-mis-datos">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <form class='formEditarDatos' action="<?= App::$urlPath;?>/usuarios/editar-datos"  method="post">
                    <div class="form-group user-photo-block">
                        <div class="user-block">
                            <h2 class="mt-5 mb-4 pfgreen">Editar <span class="font-weight-normal">Mis Datos</span></h2>
                            <label>Usuario</label>
                            <h3 class="pfgreen h4"><?= $usuario->getUsuarioId() ?></h3>
                        </div>
                        <div class="photo-block text-center mx-auto">
                            <?php
                            if(isset($usuario) and file_exists('img/usuarios/'. $usuario->getUsuarioId() . '.jpg')){
                                echo "<div class='m-auto text-center rounded-circle border-verdepf p-1 overflowhidden'><img class='rounded-circle' src='../img/usuarios/".$usuario->getUsuarioId() . ".jpg' alt='foto perfil' /></div>";
                            }else {
                                echo "<div class='m-auto text-center rounded-circle border-verdepf p-1 overflowhidden'><img class='rounded-circle' src='../img/usuarios/UserJugador.jpg' alt='foto perfil' /></div>";
                            }
                            ?>
                            <span id='cambiar-foto-perfil' class="mt-2 btn btn-outline-info">Cambiar foto</span>
                            <input type="file" id='cambiar-foto-perfil-input' name="foto" class="d-none">
                        </div>
                    </div>
                    <div class="form-group">
                       <label for="nombre">Nombre</label>
                        <input type="text" value='<?= $usuario->getNombre()?>' class="form-control" name="nombre" id="nombre" aria-describedby="emailHelp" placeholder="Ingresá tu nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" value='<?= $usuario->getApellido()?>' class="form-control" name="apellido" id="apellido"  placeholder="Ingresá tu apellido">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" value='<?= $usuario->getEmail()?>' class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Tu dirección de e-mail">
                    </div>
                    <div class="my-4">
                        <span id='edit_pass' class="btn btn-outline-info">Cambiar Contraseña</span>
                            <div class="d-none edit-pass-field mt-2">
                                <div class="form-group">
                                    <label for="password">Password Actual</label>
                                    <input type="password" class="form-control" name="clave" id="passwordactual" placeholder="Password">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="confirmarpassword">Nuevo Password</label>
                                    <input type="password" class="form-control" name="confClave" id="nuevopassword" placeholder="Nuevo Password">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="confirmarpassword">Confirmar Nuevo Password</label>
                                    <input type="password" class="form-control" name="confClave" id="confirmarpassword" placeholder="Confirmar Password">
                                </div>
                            </div>
                    </div>
                    <button type="submit" class="btn btn-outline-success">Enviar</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
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
