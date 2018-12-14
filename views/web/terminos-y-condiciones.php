<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/11/2018
 * Time: 06:39 PM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;

if (Session::has('logueado') && Session::get('logueado')=='S') {
    $usuarioLogueado = true;
}else{
    $usuarioLogueado = false;
}

?>
<main class="py-4 mb-4 preguntas-frecuentes">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h2 class="mt-5 mb-5 pfgreen">Términos y condiciones de uso del Sitio</h2>

            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
</main>


