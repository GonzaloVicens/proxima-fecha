<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */
use Proyecto\Core\App;
?>
<main class="py-4 mb-4 fixture-completo">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <!-- El h2 debajo tendría que tener contenido dinámico, según se trate de Torneo o Liga-->
                <h3 class="h5 mt-4 mb-2 colorGris2 font-weight-normal"><i class="fas fa-trophy"></i> Torneo</h3>
            </div>
            <div class="col-md-2">
                <!--button class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</button-->
            </div>
            <div class="col-md-12">
                <!-- Nombre de Torneo Debajo, tendría que ser dinámico -->
                <h2 class="mb-3 pfgreen h2">Torneo Federal de Arroyo Dulce</h2>
                <h4 class="mb-3 h3 naranjaFecha">Fixture</h4>
            </div>
            <div class="col-md-6">
                <div class="table_container shadow">
                    <div class="header_table_jornada">
                        <h5 class=""><i class="far fa-calendar-alt"></i>  Fecha 1 <span> 12 Ago</span></h5>
                    </div>
                    <div>
                        <table class="jornada_table">
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Hipocondríacos de la IpófisisPteroidea</div></td>
                                <td class="versus">1 - 0</td>
                                <td class="text-left equipos"><div class="nombre_equipo">LosPitagonicos</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">LGTV</div></td>
                                <td class="versus">6 - 8</td>
                                <td class="text-left equipos"><div class="nombre_equipo">SisterAdmin</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">SQLInjection</div></td>
                                <td class="versus">2 - 2</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Pilares de la Defensa e Injusticia</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Los Invisibles</div></td>
                                <td class="versus">1 - 3</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Los Messi</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Lo Importante es la Salud</div></td>
                                <td class="versus">0 - 0</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Solteros contra Calzados</div></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p class="text-muted font-weight-bold d-none">Equipo libre: <span class="font-weight-normal">Imberbes Afeitados</span></p>
            </div>
            <div class="col-md-6">
                <div class="table_container shadow">
                    <div class="header_table_jornada">
                        <h5 class=""><i class="far fa-calendar-alt"></i>  Fecha 2 <span> 19 Ago</span></h5>
                    </div>
                    <div>
                        <table class="jornada_table">
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Hipocondríacos</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">LosPitagonicos</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">LGTV</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">SisterAdmin</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">SQLInjection</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Pilares de la Defensa e Injusticia</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Los Invisibles</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Los Messi</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Lo Importante es la Salud</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Solteros contra Calzados</div></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p class="text-muted font-weight-bold d-none">Equipo libre: <span class="font-weight-normal">Imberbes Afeitados</span></p>
            </div>
            <div class="col-md-6">
                <div class="table_container shadow">
                    <div class="header_table_jornada">
                        <h5 class=""><i class="far fa-calendar-alt"></i>  Fecha 3 <span> 26 Ago</span></h5>
                    </div>
                    <div>
                        <table class="jornada_table">
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Hipocondríacos</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">LosPitagonicos</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">LGTV</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">SisterAdmin</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">SQLInjection</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Pilares de la Defensa e Injusticia</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Los Invisibles</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Los Messi</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Lo Importante es la Salud</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Solteros contra Calzados</div></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p class="text-muted font-weight-bold d-none">Equipo libre: <span class="font-weight-normal">Imberbes Afeitados</span></p>
            </div>
            <div class="col-md-6">
                <div class="table_container shadow">
                    <div class="header_table_jornada">
                        <h5 class=""><i class="far fa-calendar-alt"></i>  Fecha 4 <span> 2 Sept</span></h5>
                    </div>
                    <div>
                        <table class="jornada_table">
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Hipocondríacos</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">LosPitagonicos</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">LGTV</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">SisterAdmin</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">SQLInjection</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Pilares de la Defensa e Injusticia</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Los Invisibles</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Los Messi</div></td>
                            </tr>
                            <tr>
                                <td class="text-right equipos"><div class="nombre_equipo">Lo Importante es la Salud</div></td>
                                <td class="versus">VS</td>
                                <td class="text-left equipos"><div class="nombre_equipo">Solteros contra Calzados</div></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p class="text-muted font-weight-bold d-none">Equipo libre: <span class="font-weight-normal">Imberbes Afeitados</span></p>
            </div>
        </div>
    </div>
</main>

