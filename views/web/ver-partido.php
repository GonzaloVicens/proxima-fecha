<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
use Proyecto\Model\Torneo;
use Proyecto\Model\Usuario;
use Proyecto\Model\Partido;
use Proyecto\Session\Session;


$partidoActual->actualizar();

$datosPartido = $partidoActual->getInfoPartido();

if ($usuario->tieneMensajesSinLeer()){
    echo "hola";
} else {
    echo "chau;";
}
echo "<pre>";
print_r($datosPartido );
echo "</pre>";
?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <!-- El h2 debajo tendría que tener contenido dinámico, según se trate de Torneo o Liga-->
                <h3 class="h5 mt-4 mb-2 colorGris2 font-weight-normal"><i class="fas fa-trophy"></i> <?=$datosPartido['tipo_descr']?></h3>
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/torneos/' . $partidoActual->getTorneoID() ?>" class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
            </div>
            <div class="col-md-8">
                <!-- Nombre de Torneo Debajo, tendría que ser dinámico -->
                <h2 class="mb-3 pfgreen h2"><?=$datosPartido['nombre']?></h2>
                <h4 class="mb-3 h3 naranjaFecha"><?=$datosPartido['fase_descr']?><span class="font-weight-normal verde3 pl-2"></span></h4>
                <div class="table_container shadow">
                    <div class="header_table_jornada">
                        <h5 class=""><i class="far fa-calendar-alt"></i>  Fecha 5 <span> 12 Nov</span></h5>
                    </div>
                    <div>
                        <table class="jornada_table">
                            <tr>
                                <td class="text-right equipos">Hipocondríacos</td>
                                <td class="versus">vs</td>
                                <td class="text-left equipos">LosPitagonicos</td>
                            </tr>
                            <tr>
                                <td class="text-right equipos">LGTV</td>
                                <td class="versus">vs</td>
                                <td class="text-left equipos">SisterAdmin</td>
                            </tr>
                            <tr>
                                <td class="text-right equipos">SQLInjection</td>
                                <td class="versus">vs</td>
                                <td class="text-left equipos">Pilares de la Defensa e Injusticia</td>
                            </tr>
                            <tr>
                                <td class="text-right equipos">Los Invisibles</td>
                                <td class="versus">vs</td>
                                <td class="text-left equipos">Los Messi</td>
                            </tr>
                            <tr>
                                <td class="text-right equipos">Lo Importante es la Salud</td>
                                <td class="versus">vs</td>
                                <td class="text-left equipos">Solteros contra Calzados</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p class="text-muted font-weight-bold d-none">Equipo libre: <span class="font-weight-normal">Imberbes Afeitados</span></p>
                <a href='#' class="colorGris2 hoverVerde"><i class="fas fa-shield-alt"></i> Ver Fixture Completo</a>
            </div>
            <div class="col-md-4">
                <h3 class="mb-4 pfgreen fontSize1-6rem font-weight-normal">Ver Jornadas</h3>
                <div class="table_container2 shadow">
                    <div>
                        <table class="jornada_table">
                            <tr>
                                <td class=""><a href="#"><i class="far fa-calendar-alt"></i> Fecha 1 <span> 12/11/18</span></a></td>
                            </tr>
                            <tr>
                                <td class=""><a href="#"><i class="far fa-calendar-alt"></i> Fecha 2 <span> 19/11/18</span></a></td>
                            </tr>
                            <tr>
                                <td class=""><a href="#"><i class="far fa-calendar-alt"></i> Fecha 3 <span> 26/11/18</span></a></td>
                            </tr>
                            <tr>
                                <td class=""><a href="#"><i class="far fa-calendar-alt"></i> Fecha 4 <span> 02/12/18</span></a></td>
                            </tr>
                            <tr>
                                <td class=""><a href="#"><i class="far fa-calendar-alt"></i> Fecha 5 <span> 09/12/18</span></a></td>
                            </tr>
                            <tr>
                                <td class=""><a href="#"><i class="far fa-calendar-alt"></i> Fecha 6 <span> 16/12/18</span></a></td>
                            </tr>
                            <tr>
                                <td class=""><a href="#"><i class="far fa-calendar-alt"></i> Fecha 7 <span> 23/12/18</span></a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

