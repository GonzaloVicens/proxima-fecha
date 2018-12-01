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
                <h2 class="mt-5 mb-5 pfgreen"><i class="fas fa-question"></i> Preguntas Frecuentes</h2>
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h3 class="mb-0 faq">
                                <a class="btn btn-link faq-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                    ¿Qué puedo hacer en próximafecha.com?
                                </a>
                            </h3>
                        </div>

                        <div id="collapse1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                PróximaFecha.com es un sistema que te permite organizar o participar de torneos deportivos. Si sos organizador, podés gestionar tus torneos desde nuestra plataforma. Si participás con un equipo en un torneo gestionado con ProximaFecha, vas a poder inscribirte, agregar jugadores a tu equipo, consultar el fixture, y comunicarte con el organizador.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h3 class="mb-0 faq">
                                <a class="btn btn-link faq-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    ¿Es gratis el servicio?
                                </a>
                            </h3>
                        </div>
                        <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                Para todos aquellos jugadores que participan de un torneo, el servicio es gratuito. Para aquellos que sean organizadores, el servicio es gratuito mientras no se supere la cantidad de un (1) torneo. A partir del segundo torneo, el servicio tiene un costo fijo mensual.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h3 class="mb-0 faq">
                                <a class="btn btn-link faq-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    ¿Es necesario hacerme usuario?
                                </a>
                            </h3>
                        </div>
                        <div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                Tanto para ser organizador como jugador de un torneo tenés que tener una cuenta de usuario; registrarse en proximafecha.com es gratis.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h3 class="mb-0 faq">
                                <a class="btn btn-link faq-link" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    ¿Qué tipos de torneo puedo organizar?
                                </a>
                            </h3>
                        </div>
                        <div id="collapse4" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                Se pueden organizar campeonatos de liga, torneos de eliminación a un partido, y torneos de eliminación de partidos de ida y vuelta.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h3 class="mb-0 faq">
                                <a class="btn btn-link faq-link" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    ¿Cómo me anoto en un torneo?
                                </a>
                            </h3>
                        </div>
                        <div id="collapse5" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                Para anotarte en un torneo tenés que tener una cuenta de usuario. Luego tenés que crear un equipo, y de esa manera te convertirás en el capitán del equipo. En tu rol de capitán tenés la capacidad de enviar la solicitud a cualquier organizador para anotarte en un torneo. Y también podrás incorporar jugadores a tu equipo. Si sos organizador vas a poder invitar a equipos ya existentes a participar de torneos que has creado.
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h3 class="mb-0 faq">
                                <a class="btn btn-link faq-link" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                    ¿Cómo organizo un torneo?
                                </a>
                            </h3>
                        </div>
                        <div id="collapse6" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                Para organizar un torneo en proximafecha.com, basta con tener una cuenta de usuario. Cuando te logueas, vas a estar en la sección de tu perfil. Allí encontrarás un botón para "Crear Torneo", que te redirigirá a una sección con un formuario de carga, para completar los datos del torneo y el correspondiente botón para confirmar los datos.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>
    </div>
</main>


