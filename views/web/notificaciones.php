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

<main class="py-4 mb-4 notificaciones">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h2 class="mt-5 mb-5 pfgreen"><i class="fas fa-bell"></i> Notificaciones</h2>
                <ul class="list-group colorGris2">

                    <li class="list-group-item"><span class="fecha">11/12/18</span> Has sido invitado al equipo Los Paisanos Enfermos</li>
                    <li class="list-group-item"><span class="fecha">21/11/18</span> Lorem ipsum dolor, upstea git upstream pre-prod. No por mucho madrugar se amanece mas temprano amaicha del valle, añola kit kat dos por uno</li>
                    <li class="list-group-item"><span class="fecha">03/08/18</span> Mensaje de Carlitos Cepeda: bartoleo quinoa cecha</li>
                </ul>
            </div>
            <div class="col-md-2">

            </div>
        </div>
    </div>
</main>


