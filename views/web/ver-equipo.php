<?php
use Proyecto\Core\App;
use Proyecto\Session\Session;
use Proyecto\Model\Fase;
use Proyecto\Model\Equipo;

$rutaFotoPortada = App::$urlPath . "/img/equipos/portada6-4.jpg";
$rutaFotoLogo = App::$urlPath . "/img/icons/escudolaurel-gris.jpg";
if(isset($equipoAMostrar)){
    $equipoAMostrar->actualizar();
    $equipo_id = $equipoAMostrar->getEquipoID();

    $estaJugandoTorneo = $equipoAMostrar->estaJugandoTorneo();
    $participaEnTorneo = $equipoAMostrar->participaEnTorneo();


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
                        <h2 class='mt-5 ml-3 text-white'><?=$equipoAMostrar->getNombre()?></h2>
                    </div>
                    <?php if ( (Session::has("usuario")) && ($equipoAMostrar->getCapitanID() == Session::get("usuario")->getUsuarioID())) {?>
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
                        <h4 class='pfgreen mt-5 mb-4'>Integrantes del equipo <span class='font-weight-normal'><?=$equipoAMostrar->getNombre()?></span></h4>
                        <?php
                        $equipoAMostrar->printJugadoresEnUL();
                        if  (Session::has("usuario")){
                            if (! $equipoAMostrar->participaEnTorneo() && $equipoAMostrar->getCapitanID() == Session::get("usuario")->getUsuarioID()) {
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
                                                        <input type="hidden" name="equipo" value="<?= $equipoAMostrar->getEquipoID() ?>"/>
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
                            <?php }
                        }?>
                    </div>

                    <?php if ($estaJugandoTorneo){?>
                        <div class='tab-pane fade ' id='nav-proximafecha' role='tabpanel' aria-labelledby='nav-proximafecha-tab'>
                            <?php
                            $partidos = $equipoAMostrar->getProximosPartidos();
                            foreach ($partidos as $proximoPartido) {
                                $infoPartido = $proximoPartido->getInfoPartido();
                                $rutaLogoLocal = App::$urlPath . "/img/icons/escudolaurel-gris.jpg";
                                $rutaLogoVisita = App::$urlPath . "/img/icons/escudolaurel-gris.jpg";
                                if(file_exists('img/equipos/'. $proximoPartido->getLocalID() . '_logo_200.jpg')) {
                                    $rutaLogoLocal = App::$urlPath . "/img/equipos/" . $proximoPartido->getLocalID()  . "_logo_200.jpg";
                                };
                                if(file_exists('img/equipos/'. $proximoPartido->getVisitaID()  . '_logo_200.jpg')) {
                                    $rutaLogoVisita = App::$urlPath . "/img/equipos/" . $proximoPartido->getVisitaID()  . "_logo_200.jpg";
                                };
                                ?>
                                <div class='d-flex mt-5 pf_miequipo'>
                                    <h4 class='mt-5 pfgreen nombreEquipo text-right'> <?= $proximoPartido->getLocalNombre()?>  </h4>
                                    <div class='d-inline-block fondoHeader2 rounded-circle ml-3  escudoequipo'>
                                        <img class="rounded-circle" src="<?=$rutaLogoLocal?>" alt='Logo del Equipo Local'/>
                                    </div>
                                    <div class='vs'>VS</div>
                                    <div class='d-inline-block fondoHeader2 rounded-circle mr-3 escudoequipo'>
                                        <img class='rounded-circle' src='<?=$rutaLogoVisita?>' alt='Logo del Equipo Visitante'/>
                                    </div>
                                    <h4 class='mt-5 pfgreen nombreEquipo text-left'><?=$proximoPartido->getVisitaNombre()?></h4>
                                </div>
                                <div class="datospf_miequipo colorGris2">
                                    <ul class="d-flex list-unstyled">
                                        <li class="fecha_miequipo border-right"><i class="far fa-calendar"></i> <?= $infoPartido['nombre'] . ", ". $infoPartido['fase_descr']?></li>
                                        <li class="hora_miequipo border-right"><i class="far fa-clock"></i> Sede: <span><?= $infoPartido['sede_descr']?></span></li>
                                        <?php
                                        $boton  ="";
                                        if($usuario->esCapitanDeEquipo($proximoPartido->getLocalID()) || $usuario->esCapitanDeEquipo($proximoPartido->getVisitaID())) {
                                            // Configuro el origen del chat para el botón "Volver" de la conversacion;
                                            Session::set('origenChat', '/equipos/' . $equipoAMostrar->getEquipoID()  );
                                            $boton = "<a href='". App::$urlPath . "/mensajes/" . $usuario->getUsuarioID() . "/" . $proximoPartido->getArbitroID() . "' class='enviar-mensaje'>Enviar Mensaje</a>";
                                        };
                                        ?>
                                        <li class="sede_miequipo"><i class="fas fa-map-marker-alt"></i> Arbitro: <span><?= $proximoPartido->getArbitroDescr() ?></span><?=$boton ?></li>
                                    </ul>
                                </div>
                            <?php  } ?>
                        </div>
                        <div class="tab-pane fade" id="nav-posiciones" role="tabpanel" aria-labelledby="nav-posiciones-tab">
                            <?php
                            $torneosAMostrar= $equipoAMostrar->getTorneos();
                            foreach ($torneosAMostrar as $proximoTorneo) {
                                $proximoTorneo->imprimirTablaPosiciones();
                            } ?>
                        </div>
                    <?php };
                    if ($participaEnTorneo){?>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <?php
                            $torneosAMostrar= $equipoAMostrar->getTorneos();
                            foreach ($torneosAMostrar as $proximoTorneo) {
                                ?>
                                <div>
                                    <h4 class="mb-4 pfgreen mt-5"><?=$proximoTorneo->getNombre()?> </h4>
                                    <p class="text-muted"><i class="far fa-calendar-alt"></i> Fecha de Inicio: <span><?=$proximoTorneo->getFechaInicio()?></span></p>
                                    <p class="text-muted"><i class="far fa-shield-alt"></i> Sede: <span class="font-italic"> <?=$proximoTorneo->getDescrSede()?></span></p>
                                    <p class="text-muted"><i class="fas fa-shield-alt"></i></i> Cantidad Equipos Participantes: <span> <?=$proximoTorneo->getCantidadEquipos()?> </span></p>

                                    <h4>Organizadores:</h4>
                                    <ul>
                                        <?php
                                        $organizadoresActivos= $proximoTorneo->getOrganizadoresActivos();
                                        foreach($organizadoresActivos as $organizadorActual) {
                                            $boton ="";
                                            if (Session::has('logueado')){
                                                $usuario = Session::get("usuario");
                                                $usuario->actualizar();
                                                if ($usuario->esCapitanDeEquipo() && $usuario->getUsuarioID() != $organizadorActual['ORGANIZADOR_ID']  ) {
                                                    // Cionfiguro el origen del chat para el botón "Volver" de la conversacion;
                                                    Session::set('origenChat','/torneos/'.$torneo->getTorneoID());
                                                    $boton = "<a href='../mensajes/". $usuario->getUsuarioID() . "/" . $organizadorActual['ORGANIZADOR_ID'] . "' class='enviar-mensaje'>Enviar Mensaje</a>";
                                                }
                                            }
                                            echo "<li>" . $organizadorActual['APELLIDO'] . ", " . $organizadorActual['NOMBRE'] . $boton . "</li>";
                                        } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class='col-md-3'>
                <aside class="aside_miequipo">
                    <h4 class="text-white rounded p-2 mt-4 font-weight-normal">Ultima Fecha</h4>
                    <?php $ultimaFecha = $equipoAMostrar->getUltimaFecha();
                    if (!isset($ultimaFecha['TORNEO_ID'] )) { ?>
                        <p class='ml-2 colorGris2 font-weight-normal nombretorneo font-italic '>Tu equipo no estás inscripto en ningún torneo aún</p>
                        <h4 class="text-white rounded p-2 mt-4 font-weight-normal">Resultados</h4>
                        <p class='ml-2 colorGris2 font-weight-normal nombretorneo font-italic '>No se ha completado ninguna jornada del torneo aún</p>
                        <h4 class='text-white rounded p-2 mt-4 font-weight-normal'>Ver Fechas Anteriores</h4>
                        <div class="table_container2 shadow-sm">
                            <p class='ml-2 colorGris2 font-weight-normal nombretorneo font-italic '>No estás participando de ningún torneo aún</p>
                        </div>
                    <?php }else { ?>
                        <p class="ml-2 colorGris2 font-weight-normal nombretorneo"><i class="fas fa-trophy mr-1"></i> <?=$ultimaFecha['NOMBRE']. " - " . $ultimaFecha['FASE_DESCR'] ?> </p>
                        <h4 class="text-white rounded p-2 mt-4 font-weight-normal">Resultados</h4>
                        <div class="d-block">
                            <?php $partidosUltimaFase = Fase::getPartidosJugadosEnFase($ultimaFecha['TORNEO_ID'], $ultimaFecha['FASE_ID']);
                            foreach($partidosUltimaFase as $partidoViejoAMostrar) {
                                ?>
                                <div class="table_resultado_container shadow-sm">
                                    <table class="resultado-encuentro pfgreen table">
                                        <tr class="border-bottom">
                                            <td><?= $partidoViejoAMostrar['NOMBRE_LOCAL']?></td>
                                            <td class="border-left text-center marcador"><?= $partidoViejoAMostrar['PUNTOS_LOCAL']?></td>
                                        </tr>
                                        <tr>
                                            <td><?= $partidoViejoAMostrar['NOMBRE_VISITA']?></td>
                                            <td class="border-left text-center marcador"><?= $partidoViejoAMostrar['PUNTOS_VISITA']?></td>
                                        </tr>
                                    </table>
                                </div>
                            <?php } ?>
                        </div>
                        <h4 class="text-white rounded p-2 mt-4 font-weight-normal">Ver Fechas Anteriores</h4>
                        <div class="table_container2 shadow-sm">
                            <div>
                                <table class="jornada_table">
                                    <?php $fasesAnteriores = Fase::getFasesAnteriores($ultimaFecha['TORNEO_ID'], $ultimaFecha['FASE_ID']);
                                    foreach($fasesAnteriores as $faseAnterior){?>
                                        <tr>
                                            <td class=""><a href="#"><i class="far fa-calendar-alt"></i> <?=$faseAnterior['DESCRIPCION']?> <span> <?=$faseAnterior['FECHA']?></span></a></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </aside>
            </div>
        </div>
    </div>
</main>

