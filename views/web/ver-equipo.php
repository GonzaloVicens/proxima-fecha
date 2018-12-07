<?php
use Proyecto\Model\Equipo;
use Proyecto\Session\Session;
use Proyecto\Core\App;

$rutaFotoPortada = App::$urlPath . "/img/equipos/portada6-4.jpg";
$rutaFotoLogo = App::$urlPath . "/img/icons/escudolaurel-gris.jpg";
if(isset($equipo)){
    $equipo_id = $equipo->getEquipoID();

    $estaJugandoTorneo = $equipo->estaJugandoTorneo();
    $participaEnTorneo = $equipo->participaEnTorneo();


    if(file_exists('img/equipos/'. $equipo_id  . '_portada.jpg')) {
        $rutaFotoPortada = App::$urlPath . "/img/equipos/" . $equipo_id . "_portada.jpg";
    }
    if(file_exists('img/equipos/'. $equipo_id  . '_logo_200.jpg')) {
        $rutaFotoLogo = App::$urlPath . "/img/equipos/" . $equipo_id . "_logo_200.jpg";
    };
}
?>


    <main class="main_miequipo">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <section class="portada mb-5" style="background-image: url(<?=$rutaFotoPortada?>)">
                        <div class='escudo_y_nombre d-flex align-items-center'>
                            <div class='d-inline-block p-1 fondoHeader2 rounded-circle ml-3'>
                                <img class="rounded-circle" src="<?=$rutaFotoLogo?>" alt='Logo del Equipo'/>
                            </div>
                            <h2 class='mt-5 ml-3 text-white'><?=$equipo->getNombre()?></h2>
                        </div>
                    <?php if ( (Session::has("usuario")) && ($equipo->getCapitanID() == Session::get("usuario")->getUsuarioID())) {?>
                        <div id='cambiar_fotoportada'><a href='#' title='actualizar portada' class='colorGris1 hoverVerde'><i class='fas fa-camera'></i> actualizar portada</a></div>
                    <?php };?>
                    </section>


                    <nav class="tabs_miequipo">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link pfgreen hoverVerde active" id="nav-miequipo-tab" data-toggle="tab" href="#nav-miequipo" role="tab" aria-controls="nav-miequipo" aria-selected="true">Mi Equipo</a>
                            <?php if ($estaJugandoTorneo){?>
                            <a class="nav-item nav-link pfgreen hoverVerde " id="nav-proximafecha-tab" data-toggle="tab" href="#nav-proximafecha" role="tab" aria-controls="nav-proximafecha" aria-selected="false">Próxima Fecha</a>
                            <a class="nav-item nav-link pfgreen hoverVerde" id="nav-posiciones-tab" data-toggle="tab" href="#nav-posiciones" role="tab" aria-controls="nav-posiciones" aria-selected="false">Posiciones</a>
                            <?php };
                            if ($participaEnTorneo){?>
                            <a class="nav-item nav-link pfgreen hoverVerde" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Torneo / Liga</a>
                            <?php } ?>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-miequipo" role="tabpanel" aria-labelledby="nav-miequipo-tab">
                            <?php
                            echo "<h4 class='pfgreen mt-5 mb-4'>Integrantes del equipo <span class='font-weight-normal'>" . $equipo->getNombre() . "</span></h4>";

                            $equipo->printJugadoresEnUL();
                            if  (Session::has("usuario")){
                                if (! $equipo->participaEnTorneo() && $equipo->getCapitanID() == Session::get("usuario")->getUsuarioID()) {
                                    ?>
                                    <div id="registroAgregar">
                                        <div>
                                            <div id="AgregarCompanero">
                                                <div>
                                                    <div id='cabeceraAgregarCompanero'>
                                                        <h2 class='mayusculas'>Agregar un compañero</h2>
                                                    </div>
                                                    <div id='cuerpoAgregarCompanero'>
                                                        <form class='formRegistro' action="agregar-jugador" method="POST">
                                                            <input type="hidden" name="equipo" value="<?= $equipo->getEquipoID() ?>"/>
                                                            <label>Jugador<input id="jugador" type="text" name="jugador"/></label>
                                                            <input  type="submit" value="Agregar Compañero" />
                                                        </form>
                                                        <?php
                                                        if(Session::has("errorAgregarJugador")){
                                                            ?>
                                                            <div class='DivErrores'>
                                                            <h2 style='color:#F00'><?=Session::get("errorAgregarJugador")?></h2>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }}
                            ?>
                        </div>







                        <?php if ($estaJugandoTorneo){?>
                            <div class="tab-pane fade " id="nav-proximafecha" role="tabpanel" aria-labelledby="nav-proximafecha-tab">
                            <div class='d-flex mt-5 pf_miequipo'>
                            <h4 class='mt-5 pfgreen nombreEquipo text-right'> <?= $equipo->getNombre()?>  </h4>
                            <div class='d-inline-block fondoHeader2 rounded-circle ml-3  escudoequipo'>
                                <img class="rounded-circle" src="<?=$rutaFotoLogo?>" alt='Logo del Equipo'/>
                            </div>
                            <div class='vs'>VS</div>
                            <div class='d-inline-block fondoHeader2 rounded-circle mr-3 escudoequipo'>
                                <img class='rounded-circle' src='../img/equipos/1_logo_200.jpg' alt='Logo del Equipo'/>
                            </div>
                                <h4 class='mt-5 pfgreen nombreEquipo text-left'>Preprocesor Futbol Club </h4>
                            </div>
                            <div class="datospf_miequipo colorGris2">
                                <ul class="d-flex list-unstyled">
                                    <li class="fecha_miequipo border-right"><i class="far fa-calendar"></i> Fecha: <span>12/12/2019</span></li>
                                    <li class="hora_miequipo border-right"><i class="far fa-clock"></i> Hora: <span>10:00</span><span>hs</span></li>
                                    <li class="sede_miequipo"><i class="fas fa-map-marker-alt"></i> Sede: <span>Complejo Cataluñas</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-posiciones" role="tabpanel" aria-labelledby="nav-posiciones-tab">
                            <h4 class="mb-4 pfgreen mt-5">Tabla de posiciones <br><span class="font-weight-normal colorGris2">Torneo Federal de Arroyo Dulce</span></h4>
                            <div class="posiciones_table shadow-sm">
                                <table class="">
                                    <tr class="fondoHeader2 text-white">
                                        <th>Equipo</th>
                                        <th>Ptos</th>
                                        <th>PJ</th>
                                        <th>PG</th>
                                        <th>PE</th>
                                        <th>PP</th>
                                        <th>GF</th>
                                        <th>GC</th>
                                        <th>Dif</th>
                                    </tr>
                                    <tr>
                                        <td class="nombre_tablaposiciones">La Runfla de Pagani</td>
                                        <td class="font-weight-bold">12</td>
                                        <td>4</td>
                                        <td>4</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>23</td>
                                        <td>11</td>
                                        <td>12</td>
                                    </tr>
                                    <tr>
                                        <td class="nombre_tablaposiciones">Los Messi</td>
                                        <td class="font-weight-bold">9</td>
                                        <td>4</td>
                                        <td>3</td>
                                        <td>0</td>
                                        <td>1</td>
                                        <td>22</td>
                                        <td>21</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td class="nombre_tablaposiciones">Los Arrays de 1 índice</td>
                                        <td class="font-weight-bold">7</td>
                                        <td>2</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>0</td>
                                        <td>14</td>
                                        <td>15</td>
                                        <td>-1</td>
                                    </tr>
                                    <tr>
                                        <td class="nombre_tablaposiciones">PHP Futbol Club</td>
                                        <td class="font-weight-bold">0</td>
                                        <td>4</td>
                                        <td>1</td>
                                        <td>3</td>
                                        <td>0</td>
                                        <td>23</td>
                                        <td>11</td>
                                        <td>12</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <?php };
                    if ($participaEnTorneo){?>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <h4 class="mb-4 pfgreen mt-5">Torneo Federal de Arroyo Dulce</h4>
                            <p class="text-muted"><i class="far fa-calendar-alt"></i> Fecha de Inicio: <span>14/12/18</span></p>
                            <p class="text-muted"><i class="far fa-calendar-alt"></i> Fecha Finalización: <span class="font-italic">No definida aún</span></p>
                            <p class="text-muted"><i class="fas fa-shield-alt"></i></i> Cantidad Equipos Participantes: <span>8</span></p>
                            <h4 class="mb-3 fontSize font-weight-normal colorGris2">Equipos que participan en este torneo</h4>
                            <!-- Listado de Equipos que Ya Participan Debajo, tendría que ser dinámico -->
                            <ul>
                                <li>Cambaceres de Don Torcuato</li>
                                <li>La Runfla de Pagani</li>
                                <li>Los Messi</li>
                                <li>Joya Nunca taxi</li>
                            </ul>
                            <!-- Agregar clase d-none o d-block de acuerdo a si quedan equipos por agregar o no -->
                            <!--p class="text-muted font-italic d-block">Resta agregar 4 equipos aún</p-->
                        </div>
                    <?php } ?>
                    </div>

                    <!--h4 class="my-3 h3 naranjaFecha">Próxima Fecha <span class="font-weight-normal verde3 pl-2">Jornada 5</span></h4-->
                    <!--div class="table_container shadow">
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
                    <a-- href='#' class="colorGris2 hoverVerde"><i class="fas fa-shield-alt"></i> Ver Fixture Completo</a-->
                </div>
                <div class='col-md-3'>
                    <aside class="aside_miequipo">
                        <h4 class="text-white rounded p-2 mt-4 font-weight-normal">Torneos en los que participas</h4>
                        <p class="ml-2 colorGris2 font-weight-normal nombretorneo font-italic d-none">Tu equipo no estás inscripto en ningún torneo aún</p>
                        <p class="ml-2 colorGris2 font-weight-normal nombretorneo"><i class="fas fa-trophy mr-1"></i> Augurios de Montecarlo</p>
                        <h4 class="text-white rounded p-2 mt-4 font-weight-normal">Resultados última jornada</h4>
                        <p class="ml-2 colorGris2 font-weight-normal nombretorneo font-italic d-none">No se ha completado ninguna jornada del torneo aún</p>
                        <!-- En caso de que todavía no se haya jugado ningún partido, se saca el d-none del elemento de arriba y se agrega al div de abajo sacando el d-block -->
                        <div class="d-block">
                            <p class="ml-2 colorGris2 font-weight-normal nombretorneo"><i class="fas fa-calendar mr-1"></i> Fecha <span class="numero_fecha">5</span></p>
                            <div class="table_resultado_container shadow-sm">
                                <table class="resultado-encuentro pfgreen table">
                                    <tr class="border-bottom">
                                        <td>Jacintos Merquetos</td>
                                        <td class="border-left text-center marcador">2</td>
                                    </tr>
                                    <tr>
                                        <td>Larga la pastafrola</td>
                                        <td class="border-left text-center marcador">2</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table_resultado_container shadow-sm">
                                <table class="resultado-encuentro pfgreen table">
                                    <tr class="border-bottom">
                                        <td>Filosofía Tobara</td>
                                        <td class="border-left text-center marcador">3</td>
                                    </tr>
                                    <tr>
                                        <td>Pero pero pero</td>
                                        <td class="border-left text-center marcador">1</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table_resultado_container shadow-sm">
                                <table class="resultado-encuentro pfgreen table">
                                    <tr class="border-bottom">
                                        <td>Solteros contra Calzados</td>
                                        <td class="border-left text-center marcador">1</td>
                                    </tr>
                                    <tr>
                                        <td>SisterAdmin</td>
                                        <td class="border-left text-center marcador">4</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="table_resultado_container shadow-sm">
                                <table class="resultado-encuentro pfgreen table">
                                    <tr class="border-bottom">
                                        <td>SQLInjection</td>
                                        <td class="border-left text-center marcador">1</td>
                                    </tr>
                                    <tr>
                                        <td>Los Messi</td>
                                        <td class="border-left text-center marcador">1</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <h4 class="text-white rounded p-2 mt-4 font-weight-normal">Ver Fechas Anteriores</h4>
                        <p class="ml-2 colorGris2 font-weight-normal nombretorneo font-italic d-none">No estás participando de ningún torneo aún</p>
                        <div class="table_container2 shadow-sm">
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
                                </table>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>

