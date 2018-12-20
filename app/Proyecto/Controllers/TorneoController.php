<?php
namespace Proyecto\Controllers;
use Proyecto\Model\Notificacion;
use Proyecto\Tools\FormValidator;
use Proyecto\View\View;
use Proyecto\Core\Route;
use Proyecto\Core\Request;
use Proyecto\Model\Equipo;
use Proyecto\Model\Torneo;
use Proyecto\Model\Usuario;
use Proyecto\Model\Partido;
use Proyecto\Model\Fase;
use Proyecto\Session\Session;
use Proyecto\Core\App;
class TorneoController
{


    /**
     * Método que muestra los torneos existentes
     */
    public function verTorneos()
    {
        View::render('web/torneos',[], 3);
    }


    /**
     * Método que renderiza la vista de un Torneo en partícular
     */
    public function ver()
    {
        $routeParams = Route::getRouteParams();
        $torneo_id = $routeParams['torneo_id'];
        if (Torneo::existeTorneo($torneo_id)) {
            $torneoAMostrar = new Torneo($torneo_id);
            Session::set("torneo",$torneoAMostrar);
            $organizadoresActivos= $torneoAMostrar->getOrganizadoresActivos();
            View::render('web/ver-torneo',compact('torneoAMostrar','organizadoresActivos'), 3);
        } else{
            View::render('web/error404',[], 2);
        };
    }


    /**
     * Método que controla la creación de un torneo
     */
    public function registrar(){

        if (Session::has("usuario")) {
            $inputs = Request::getData();

            $formValidator = new FormValidator($inputs, true);

            // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
            if (!empty($formValidator->getCamposError())) {
                Session::set("camposError", $formValidator->getCamposError());
                Session::set("campos", $formValidator->getCampos());
                header('Location: ' . App::$urlPath . '/usuarios/crear-torneo');

            } else {
                if (!isset($inputs['D']) &&
                    !isset($inputs['L']) &&
                    !isset($inputs['M']) &&
                    !isset($inputs['X']) &&
                    !isset($inputs['J']) &&
                    !isset($inputs['V']) &&
                    !isset($inputs['S']) ) {

                    $camposError = [];
                    $camposError ['dias'] = 'Debe elegir al menos un día';
                    Session::set("camposError", $camposError);
                    Session::set("campos", $formValidator->getCampos());
                    header('Location: ' . App::$urlPath . '/usuarios/crear-torneo');
                } else {
                    Session::clearValue("camposError");
                    Session::clearValue("campos");
                    $usuario = Session::get('usuario');
                    $torneo_id = Torneo::CrearTorneo($inputs, $usuario->getUsuarioId());
                    header('Location: ' . App::$urlPath . '/torneos/' . $torneo_id);

                }
            };
        }else {
            header('Location: ' . App::$urlPath . '/error404');
        };

    }


    public function verProximaFecha()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();
            View::render('web/ver-proxima-fecha',compact('usuario','usuario_id'), 3);

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }




    public function verAgregarEquipos()
    {
        $puedeAgregarEquipos = false;
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            if (Session::has("torneo")) {
                $torneo = Session::get('torneo');
                $torneo->actualizar();
                $puedeAgregarEquipos = $usuario->puedeAgregarEquiposEnTorneo($torneo->getTorneoID());
            }
        };

        if ($puedeAgregarEquipos ){
            if (Session::has('resultados')){
                $resultados = Session::get('resultados');
                Session::clearValue('resultados');
            }
            if (Session::has('inputsBusqueda')){
                $inputsBusqueda = Session::get('inputsBusqueda');
                Session::clearValue('inputsBusqueda');
                Session::set('inputsBuscados',$inputsBusqueda);
            } else {
                $inputsBusqueda = [];
                $inputsBusqueda['nombre']= "";
                $inputsBusqueda['id']= "";
            }
            View::render('web/agregar-equipos',compact('usuario','torneo','resultados','inputsBusqueda' ), 3);
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }


    public function editarTorneo()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();
            View::render('web/editar-torneo',compact('usuario','usuario_id'), 3);

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }


    /**
     * Método que controla la actualización de un torneo
     */
    public function actualizarTorneo()
    {
        if (Session::has("usuario")) {
            $inputs = Request::getData();
            $torneo_id = $inputs['torneo_id'];

            $formValidator = new FormValidator($inputs, true);

            // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
            if (!empty($formValidator->getCamposError())) {
                Session::set("camposError", $formValidator->getCamposError());
                Session::set("campos", $formValidator->getCampos());
                header('Location: ' . App::$urlPath . '/torneos/editar-torneo');

            } else {
                if (!isset($inputs['D']) &&
                    !isset($inputs['L']) &&
                    !isset($inputs['M']) &&
                    !isset($inputs['X']) &&
                    !isset($inputs['J']) &&
                    !isset($inputs['V']) &&
                    !isset($inputs['S'])
                ) {

                    $camposError = [];
                    $camposError ['dias'] = 'Debe elegir al menos un día';
                    Session::set("camposError", $camposError);
                    header('Location: ' . App::$urlPath . '/torneos/editar-torneo');
                } else {
                    Session::clearValue("camposError");
                    Session::clearValue("campos");
                    $usuario = Session::get('usuario');
                    Torneo::ActualizarTorneo($inputs);
                    header('Location: ' . App::$urlPath . '/torneos/' . $torneo_id);
                }
            };
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }







    /**
     * Método que controla la eliminazión de un torneo
     */
    public function eliminar(){
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();

            $inputs = Request::getData();

            $torneo_id = $inputs['torneo_id'];
            $confirmar = $inputs['confirmar'];

            if ($confirmar == "SI"){
                $torneo = new Torneo($torneo_id);
                $torneo->eliminarTorneo();
                Session::clearValue('torneo');
                $usuario->actualizar();
                header('Location: ' . App::$urlPath . '/usuarios/'. $usuario_id);
            } ELSE {
                header('Location: ' . App::$urlPath . '/torneos/'. $torneo_id);
            }

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }

    /**
     * Método que busca los equipos que tengan un nombre o id que contenga el parámetro.
     */
    public function buscarEquipo()
    {
        $inputs = Request::getData();

        Session::clearValue('inputsBusqueda');
        Session::clearValue("errorAgregarEquipo");
        Session::clearValue("IDAgregarEquipo");
        Session::clearValue('inputsBuscados');

        Session::set('inputsBusqueda',$inputs);

        $resultados = Equipo::BuscarEquipos($inputs , " AND ACTIVO = 1 ");
        Session::set('resultados',$resultados);
        header('Location: ' . App::$urlPath . '/torneos/agregar-equipos');
    }


    /**
     * Método que agrega un Equipo en el Torneo
     */
    public function agregarEquipo()
    {
        $inputs = Request::getData();
        Session::clearValue("errorAgregarEquipo");
        Session::clearValue("IDAgregarEquipo");
        $torneo = Session::get('torneo');
        if (isset($inputs ["equipo_id"]) && !empty($inputs ["equipo_id"])) {
            $equipo_id = $inputs ['equipo_id'];
            $nombre = $inputs ['nombre'];
            Session::set("IDAgregarEquipo", $equipo_id );
            if ($torneo->getLugaresLibres() > 0) {

                if ($torneo->existeEquipo($equipo_id)) {
                    Session::set("errorAgregarEquipo", $nombre  . " ya es un equipo del torneo");
                } else {
                    if (Equipo::existeEquipo($equipo_id)) {
                        $torneo->insertarEquipo($equipo_id);
                        Session::set("errorAgregarEquipo", $nombre  . " fue agregado al torneo");
                    } else {
                        Session::set("errorAgregarEquipo", $equipo_id . " no existe en el sistema");
                    }
                };
            } else {
                Session::set("errorAgregarEquipo", "El torneo ya está completo");
            }
        } else {
                Session::set("errorAgregarEquipo", " Ingrese un equipo");
        }
        $torneo->actualizar();
        if (Session::has('inputsBuscados')){
            $inputsBusqueda = Session::get('inputsBuscados');
            Session::set('inputsBusqueda',$inputsBusqueda);
            $resultados = Equipo::BuscarEquipos($inputsBusqueda , " AND ACTIVO = 1 ");
            Session::set('resultados',$resultados);
        }

        if ($torneo->getLugaresLibres() > 0) {
            header('Location: ' . App::$urlPath . '/torneos/agregar-equipos');
        } else {
            header('Location: ' . App::$urlPath . '/torneos/' . $torneo->getTorneoID());
        }

    }

    /**
     * Método que elimina un Equipo en el Torneo
     */
    public function eliminarEquipo()
    {
        $inputs = Request::getData();
        if (isset($inputs ["equipo_id"]) && !empty($inputs ["equipo_id"])) {
            $torneo = Session::get('torneo');
            $equipo_id = $inputs ['equipo_id'];
            $origen = $inputs ['origen'];
            if ($torneo->existeEquipo($equipo_id)) {
                $torneo->eliminarEquipo($equipo_id);
            };
        }
        $torneo->actualizar();
         header('Location: ' . App::$urlPath . '/torneos/' . $origen);

    }

    public function generarFixture(){
        $torneo = Session::get('torneo');
        $torneo->actualizar();
        $torneo->generarFixture();
        Session::set('torneo',$torneo);
        header('Location: ' . App::$urlPath . '/torneos/ver-fixture-completo/' . $torneo->getTorneoID() );
    }

    public function verFixtureCompleto()
    {
        $routeParams = Route::getRouteParams();
        $torneo_id = $routeParams['torneo'];
        if (Torneo::existeTorneo($torneo_id)){
            $torneoAMostrar = New Torneo($torneo_id);

            if ($torneoAMostrar->getTipoTorneoId() == "C"){
                View::render('web/ver-fixture-torneo-completo',compact('torneoAMostrar'), 3);
            } else {
                View::render('web/ver-fixture-completo',compact('torneoAMostrar'), 3);
            }

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };

    }

    public function verFixtureTorneoCompleto()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
        };

        $routeParams = Route::getRouteParams();
        $torneo_id = $routeParams['torneo'];
        if (Torneo::existeTorneo($torneo_id)){
            $torneoAMostrar = New Torneo($torneo_id);
            View::render('web/ver-fixture-torneo-completo',compact('torneoAMostrar'), 3);

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }


    public function editarOrganizadores()
    {
        if (Session::has("usuario") && Session::has('torneo')) {
            $usuario = Session::get('usuario');
            $torneo = Session::get('torneo');
            $torneo->actualizar();
            $organizadores= $torneo->getTodosLosOrganizadores();
            View::render('web/editar-organizadores',compact('usuario','torneo','organizadores'), 3);

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }

    /**
     * Método que agrega un Organizador en el Torneo
     */
    public function agregarOrganizador()
    {
        $inputs = Request::getData();

        if (isset($inputs["torneo_id"]) && !empty($inputs ["torneo_id"]) ){
            $torneo_id = $inputs ['torneo_id'];
            $torneo = new Torneo($torneo_id);

            if (isset($inputs ["organizador_id"]) && !empty($inputs ["organizador_id"])) {

                $organizador_id = $inputs ['organizador_id'];

                if ($torneo->existeOrganizador($organizador_id)) {
                    Session::set("errorAgregarOrganizador", $organizador_id . " ya es un organizador del torneo");
                } else {
                    if (Usuario::existeUsuario($organizador_id)) {
                        $orga = new Usuario($organizador_id);
                        if ((!$orga->esUsuarioPro()) && count($orga->getTorneosPropios())> 1) {
                            Session::set("errorAgregarOrganizador", $organizador_id . " no puede organizar mas de un torneo");
                        } else {
                            $torneo->insertarOrganizador($organizador_id);
                            Session::clearValue("errorAgregarOrganizador");
                        }
                    } else {
                        Session::set("errorAgregarOrganizador", $organizador_id . " no existe en el sistema");
                    }
                };
            } else {
                Session::set("errorAgregarOrganizador",  " Ingrese un organizador");
            }
        }

        header('Location: ' . App::$urlPath . '/torneos/editar-organizadores');
    }


    /**
     * Método que activa/desactiva un Organizador en el Torneo
     */
    public function editarOrganizador()
    {
        $inputs = Request::getData();

        if (isset($inputs["torneo_id"]) && !empty($inputs ["torneo_id"]) ){
            $torneo_id = $inputs ['torneo_id'];
            $torneo = new Torneo($torneo_id);

            if (isset($inputs ["organizador_id"]) && !empty($inputs ["organizador_id"])) {

                $organizador_id = $inputs ['organizador_id'];
                $activo = $inputs ['activo'];

                if (!$torneo->existeOrganizador($organizador_id)) {
                    Session::set("errorAgregarOrganizador", $organizador_id . " no es un organizador del torneo");
                } else {
                    if ($torneo->tieneOtrosOrganizadores($organizador_id)) {
                        $torneo->editarOrganizador($organizador_id, $activo);
                        Session::clearValue("errorAgregarOrganizador");
                    } else {
                        Session::set("errorAgregarOrganizador",  "No quedan organizadores en el torneo");
                    }
                };
            } else {
                Session::set("errorAgregarOrganizador",  " Ingrese un organizador");
            }
        }

        header('Location: ' . App::$urlPath . '/torneos/editar-organizadores');
    }


    public function finalizarPartido(){
        $partidoAFinalizar = Session::get('partidoAFinalizar');
        $partidoAFinalizar->actualizar();
        Session::clearValue('partidoAFinalizar');

        if (Torneo::GetEstadoIdPorTorneo($partidoAFinalizar->getTorneoID()) == 'C') {
            if (Session::has('logueado')) {
                $usuario = Session::get('usuario');
                if ($usuario->getUsuarioID() == $partidoAFinalizar->getArbitroID()) {
                    $partidoAFinalizar->finalizarPartido();
                }
            }
        }

        if (Session::has('vinoDeFase') && Session::get('vinoDeFase') =="Y") {
            Session::clearValue('vinoDeFase');
            header('Location: ' . App::$urlPath . '/torneos/' . $partidoAFinalizar->getTorneoID()."/".$partidoAFinalizar->getFaseID());
        }else {
            header('Location: ' . App::$urlPath . '/torneos/ver-fixture-completo/' . $partidoAFinalizar->getTorneoID());
        }

    }



    /**
     * Método que da por decide la actualización del Torneo
     */
    protected function actualizarEstadoTorneo($estado)
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario->actualizar();

            if (Session::has("torneo")) {
                $torneo = Session::get('torneo');
                $torneo->actualizar();

                if ($torneo->tieneOrganizadorActivo($usuario->getUsuarioID())) {
                    switch ($estado){
                        case "C":
                            $torneo->comenzar();
                            break;
                        case "F":
                            $torneo->finalizar();
                            break;
                        case "R":
                            $torneo->reiniciar();
                            break;
                    }
                }
            };
        }

        $torneo->actualizar();
        header('Location: ' . App::$urlPath . '/torneos/' . $torneo->getTorneoID());

    }

    /**
     * Método que da por comenzado el Torneo
     */
    public function comenzarTorneo()
    {
        $this->actualizarEstadoTorneo("C");
    }

    /**
     * Método que da por finalizado el Torneo
     */
    public function finalizarTorneo()
    {
        $this->actualizarEstadoTorneo("F");
    }

    /**
     * Método que da por finalizado el Torneo
     */
    public function reiniciarTorneo()
    {
        $this->actualizarEstadoTorneo("R");
    }

    public function verFase(){

        $routeParams = Route::getRouteParams();
        $torneo_id = $routeParams['torneo'];
        $fase_id = $routeParams['fase'];
        if (Fase::ExisteFase($torneo_id, $fase_id)) {
            $faseActual = new Fase($torneo_id, $fase_id) ;
            View::render('web/ver-fase',compact('faseActual'), 3);
        } else{
            View::render('web/error404',[], 2);
        };
    }


    public function verPartido(){

        $routeParams = Route::getRouteParams();
        $torneo_id = $routeParams['torneo'];
        $fase_id = $routeParams['fase'];
        $partido_id = $routeParams['partido'];
        if (Partido::existePartido($torneo_id, $fase_id, $partido_id)) {
            $partidoActual = new Partido($torneo_id, $fase_id, $partido_id) ;
            $local = new Equipo ($partidoActual->getLocalId());
            $visita = new Equipo ($partidoActual->getVisitaId());
            View::render('web/ver-partido',compact('partidoActual', 'local','visita'), 3);
        } else{
            View::render('web/error404',[], 2);
        };
    }

    public function agregarFichaPartido(){
        $inputs = Request::getData();

        if ( (isset($inputs["torneo"]) && !empty($inputs ["torneo"]) )
        &&  (isset($inputs["fase"]) && !empty($inputs ["fase"]) )
        &&  (isset($inputs["partido"]) && !empty($inputs ["partido"]) )
        &&  (isset($inputs["equipo"]) && !empty($inputs ["equipo"]) )
        &&  (isset($inputs["jugador"]) && !empty($inputs ["jugador"]) )
        &&  (isset($inputs["tipo"]) && !empty($inputs ["tipo"]) )){

            $partido = New Partido($inputs["torneo"], $inputs["fase"], $inputs["partido"]);
            $partido->agregarFicha($inputs["tipo"], $inputs["equipo"], $inputs["jugador"]);
        }

        header('Location: ' . App::$urlPath . '/torneos/' . $inputs["torneo"] . "/". $inputs["fase"] ."/". $inputs["partido"]);

    }



    public function solicitarInscripcion(){
        $inputs = Request::getData();

        if ( (isset($inputs["torneo_id"]) && !empty($inputs ["torneo_id"]) )
            &&  (isset($inputs["equipo_id"]) && !empty($inputs ["equipo_id"]) )){
            Torneo::InscribirEquipo($inputs);
        }
        header('Location: ' . App::$urlPath . '/torneos/' . $inputs["torneo_id"] );
    }

    /**
     * Método que elimina un Equipo en el Torneo
     */
    public function eliminarInscripcion()
    {
        $inputs = Request::getData();
        if (isset($inputs ["equipo_id"]) && !empty($inputs ["equipo_id"])
            && (isset($inputs ["torneo_id"]) && !empty($inputs ["torneo_id"]))) {
            $equipo_id = $inputs ['equipo_id'];
            $torneo_id = $inputs ['torneo_id'];
            Torneo::EliminarInscripcion($torneo_id, $equipo_id);

            $nombreEquipo = Equipo::getNombrePorID($equipo_id);
            $jugadores = Equipo::GetJugadoresDelEquipo($equipo_id);
            $nombreTorneo = Torneo::getNombrePorID($torneo_id);
            foreach ($jugadores as $jugador) {
                $notificacion = ['usuario_id' => $jugador,
                    'torneo_id' => $torneo_id,
                    'mensaje' => "Tu inscripción al torneo <span class='verde3 font-regular-bold'>" . $nombreTorneo . "</span> con el equipo <span class='verde3 font-regular-bold'>" . $nombreEquipo . "</span> ha sido rechazada."
                ];
                Notificacion::CrearNotificacion($notificacion);
            }
        }
        header('Location: ' . App::$urlPath . '/torneos/' . $torneo_id);

    }

    /**
     * Método que agrega un Equipo en el Torneo
     */
    public function agregarInscripcion()
    {
        $inputs = Request::getData();
        Session::clearValue("errorAgregarEquipo");
        Session::clearValue("IDAgregarEquipo");
        $torneo = Session::get('torneo');
        if (isset($inputs ["equipo_id"]) && !empty($inputs ["equipo_id"])) {
            $equipo_id = $inputs ['equipo_id'];
            $nombre = $inputs ['nombre'];
            Session::set("IDAgregarEquipo", $equipo_id );
            if ($torneo->getLugaresLibres() > 0) {

                if ($torneo->existeEquipo($equipo_id)) {
                    Session::set("errorAgregarEquipo", $nombre  . " ya es un equipo del torneo");
                } else {
                    if (Equipo::existeEquipo($equipo_id)) {
                        $torneo->insertarEquipo($equipo_id);
                        Torneo::EliminarInscripcion($torneo->getTorneoID(), $equipo_id);
                    } else {
                        Session::set("errorAgregarEquipo", $equipo_id . " no existe en el sistema");
                    }
                };
            } else {
                Session::set("errorAgregarEquipo", "El torneo ya está completo");
            }
        } else {
            Session::set("errorAgregarEquipo", " Ingrese un equipo");
        }
        $torneo->actualizar();
        header('Location: ' . App::$urlPath . '/torneos/' . $torneo->getTorneoID());
    }
}