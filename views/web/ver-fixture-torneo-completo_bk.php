<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;

//$torneo->actualizar();
?>
<main class="py-4 mb-4 fixture-torneo-completo">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2 class="pfgreen mt-4 mb-2">
                    <span class="d-block font-weight-normal colorGris2 h4 mb-2"><i class="fas fa-trophy"></i> Torneo</span>
                    <span class="">Torneo Da Vinci Lorem Ipsum</span>
                </h2>
                <h4 class="mb-3 h3 naranjaFecha">Fixture Completo</h4>
            </div>
            <div class="col-md-12">
                <div class="large-12 columns">
                    <div class="owl-stage-outer">
                    <div class="owl-stage">
                    <div class="owl-carousel">
                        <div class="item dieciseisavos llave_a">
                            <span class='fase_torneo'>Llave A - 16avos</span>
                            <div class='equipo_container list-group primero list-group'>
                                <div class='torneo_equipo list-group-item list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo Campeones de la Colonia Caroya</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                        </div>
                        <div class="item octavos llave_a">
                            <span class='fase_torneo'>Llave A <br>8avos</span>
                            <div class='equipo_container list-group primero'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group ultimo'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                        </div>
                        <div class="item cuartos llave_a">
                            <span class='fase_torneo'>Llave A <br>4tos</span>
                            <div class='equipo_container list-group primero'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group ultimo'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                        </div>
                        <div class="item semifinal llave_a">
                            <span class='fase_torneo'>Llave A <br>Semifinal</span>
                            <div class='equipo_container list-group unico'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                        </div>
                        <div class="item final">
                            <span class='fase_torneo'>FINAL</span>
                            <div class='equipo_container list-group unico'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                        </div>
                        <div class="item semifinal llave_b">
                            <span class='fase_torneo'>Llave B <br>Semifinal</span>
                            <div class='equipo_container list-group unico'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                        </div>
                        <div class="item cuartos llave_b">
                            <span class='fase_torneo'>Llave B <br>4tos</span>
                            <div class='equipo_container list-group primero'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group ultimo'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                        </div>
                        <div class="item octavos llave_b">
                            <span class='fase_torneo'>Llave B <br>8avos</span>
                            <div class='equipo_container list-group primero'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group ultimo'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                        </div>
                        <div class="item dieciseisavos llave_b">
                            <span class='fase_torneo'>Llave B - 16avos</span>
                            <div class='equipo_container list-group primero'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                            <div class='equipo_container list-group'>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                                <div class='torneo_equipo list-group-item'>Equipo</div>
                            </div>
                        </div>
                    </div>
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
    })

    $('.owl-carousel').click(function () {
        $('.equipo_container .list-group-item').css('z-index', '9999');
        $('.equipo_container .list-group-item::before').css('z-index', '-9999');
    })


    $(document).ready(function () {
        $('.equipo_container .equipo_container .list-group-item').css('z-index', '9999');
    })
</script>

