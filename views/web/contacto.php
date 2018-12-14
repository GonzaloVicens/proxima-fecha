<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/11/2018
 * Time: 06:39 PM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;

if (Session::has("camposError")) {
    $camposError = Session::get("camposError");
    $camposViejos = Session::get("campos");

    Session::clearValue("camposError");
    Session::clearValue("campos");
} else {
    $camposError = "";
    $camposViejos = "";

} ;


?>
<main class="py-4 mb-4 contacto">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h2 class="mt-5 mb-4 pfgreen"><i class="fas fa-envelope"></i> Contacto</h2>
                <h3 class="mb-5 text-muted h5 font-weight-normal">Envianos tu consulta, duda o sugerencia. Te responderemos a la brevedad.</h3>
                <form action="<?= App::$urlPath;?>/contacto" enctype="application/x-www-form-urlencoded" method="post">
                    <div class="form-group row">
                        <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name='nombre' id="nombre" placeholder="Nombre" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name='contacto' class="form-control" id="email" placeholder="Email" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="mensaje" class="col-sm-2 col-form-label">Mensaje</label>
                        <div class="col-sm-10">
                            <textarea rows='5' name="mensaje" id='mensaje' class="form-control" placeholder="Tu mensaje..."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-outline-success">Enviar consulta</button>
                            <a href="<?= App::$urlPath;?>/" class="btn btn-link">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6 pfgreen h6 text-center">
            <?php
                if (isset($camposError) && $camposError!= "") {
                    echo("<div class='DivErrores'><ul>");
                    foreach ($camposError as $error => $descr) {
                        echo ("<li style='color:#F00'>".ucfirst($error).": ".$descr. "</li>");
                    }
                    echo("</ul></div>");
                }

                if (Session::has('mailEnviado')){
                    if (Session::get('mailEnviado') == "Y"){
                        echo "<p> Hemos recibido tu contacto.</p><p> Te responderemos a la brevedad.</p>";
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


