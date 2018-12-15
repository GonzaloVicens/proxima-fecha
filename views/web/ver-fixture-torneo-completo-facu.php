<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;
$usuarioID ="";
if (Session::has('usuario')) {
    $usuario = Session::get('usuario');
    $usuarioID = $usuario->getUsuarioID();
}


$torneo->actualizar();
?>
<main class="py-4 mb-4 fixture-torneo-completo">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/torneos/' . $torneo->getTorneoID() ?>" class="btn btn-outline-secondary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>
            <div class="col-md-12 mb-4">
                <h2 class="pfgreen mt-4 mb-2">
                    <span class="d-block font-weight-normal colorGris2 h4 mb-2"><i class="fas fa-trophy"></i> <?= $torneo->getDescrTipoTorneo()?></span>
                    <span class="">Torneo Da Vinci Lorem Ipsum BLA</span>
                </h2>
                <h4 class="mb-3 h3 naranjaFecha">Fixture Completo</h4>
            </div>
            <div class="col-md-12">
                <div class="large-12 columns">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            <div class="owl-carousel">
                                <?= $torneo->mostrarFixtureCopa(1, $usuarioID ) ?>
                            </div>
                        </div>
                    </div>

                </div>
              </div>
            </div>
        </div>

</main>
<script>
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        margin: 10,
        nav: true,
        loop: false,
        responsiveClass:true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });

    $('.owl-carousel').click(function () {
        $('.equipo_container .list-group-item').css('z-index', '9999 !important');
        $('.equipo_container .list-group-item::before').css('z-index', '-9999');
    })


    $(document).ready(function () {
        $('.owl-item').css('z-index', '9999');
        $('.equipo_container:nth-child(even):before').css('z-index', '-9999');
    })
</script>

