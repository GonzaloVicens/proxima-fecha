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
$usuario->actualizar();
// Cionfiguro el origen del chat para el botón "Volver" de la conversacion;
//Session::set('origenChat','/usuarios/mensajes');

?>

<main class="py-4 bg-light cuenta-pro">
    <div class="container">
        <div class="row">
             <div class="col-md-3">
             </div>
             <div class="col-md-6 border rounded mt-4 px-4 pb-5 bg-white seguridad">
                 <h2 class="mt-5 mb-3 pfgreen"><i class="fas fa-crown"></i> Pasar a Cuenta Pro</h2>
                 <div class="">
                    <p>Para acceder a la función de organizar más de un torneo en simultáneo, es necesario que hagas <strong>un upgrade en tu cuenta</strong></p>
                     <p>Accediendo al pago semestal de ARS $500 tendrás la posibilidad de organizar 2 o más torneos en simultáneo.</p>
                     <p>Por el momento el único método de pago con el que contamos es el servicio de <a href="https://www.mercadopago.com.ar">mercadopago.com</a>. Para abonar, tendrás que tener una cuenta de usuario y crédito suficiente en la misma.</p>
                     <div class="text-center mt-4 pb-5">
                         <a mp-mode="dftl" href="https://www.mercadopago.com/mla/checkout/start?pref_id=386873980-1290f257-5ad6-4abd-9961-9c39e11d1cf2" name="MP-payButton" class='lightBlue-ar-l-rn-arall'>Pagar con Mercado Pago</a>
                         <script type="text/javascript">
                             (function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
                         </script>
                     </div>
                     <p>Recibirás una notificación por mail cuando se haya registrado el pago</p>
                     <p>Ante cualquier duda o consulta, puedes eviarnos un mensaje a través de nuestro <a class='pfgreen hoverVerde' href="<?= App::$urlPath?>/contacto">formulario de contacto</a></p>
                 </div>
             </div>
             <div class="col-md-3">
                </div>
            </div>
    </div>|
</main>


