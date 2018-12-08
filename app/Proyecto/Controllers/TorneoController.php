<?php
namespace Proyecto\Controllers;
use Proyecto\View\View;
use Proyecto\Core\Route;
use Proyecto\Core\Request;
use Proyecto\Model\Equipo;
use Proyecto\Model\Torneo;
use Proyecto\Model\Usuario;
use Proyecto\Model\Partido;
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
            $torneo = new Torneo($torneo_id);
            Session::set("torneo",$torneo);
            $organizadoresActivos= $torneo->getOrganizadoresActivos();


            View::render('web/ver-torneo',compact('torneo','organizadoresActivos'), 3);
        } else{
            View::render('web/error404',[], 2);
        };
    }


    /**
     * Método que controla la creación de un torneo
     */
    public function registrar(){
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $inputs = Request::getData();
            $torneo_id = Torneo::CrearTorneo($inputs, $usuario->getUsuarioId());
            header('Location: ' . App::$urlPath . '/torneos/'. $torneo_id);

        } else {
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
    public function actualizar(){
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();

            $inputs = Request::getData();

            $torneo_id = $inputs['torneo_id'];


            Torneo::ActualizarTorneo($inputs);

            $usuario->actualizar();
            header('Location: ' . App::$urlPath . '/torneos/'. $torneo_id);

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

        $resultados = Equipo::BuscarEquipos($inputs );
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
                Session::set("errorAgregarEquipo", "El torneo ya esta lleno");
            }
        } else {
                Session::set("errorAgregarEquipo", " Ingrese un equipo");
        }
        $torneo->actualizar();
        if (Session::has('inputsBuscados')){
            $inputsBusqueda = Session::get('inputsBuscados');
            Session::set('inputsBusqueda',$inputsBusqueda);
            $resultados = Equipo::BuscarEquipos($inputsBusqueda );
            Session::set('resultados',$resultados);
        }

        header('Location: ' . App::$urlPath . '/torneos/agregar-equipos');

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
        header('Location: ' . App::$urlPath . '/torneos/ver-fixture-completo' );
    }

    public function verFixtureCompleto()
    {
        if (Session::has("torneo")) {
            $torneo = Session::get('torneo');
            $torneo ->actualizar();
            View::render('web/ver-fixture-completo',compact('torneo'), 3);

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
                        $torneo->insertarOrganizador($organizador_id);
                        Session::clearValue("errorAgregarOrganizador");
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

      //  header('Location: ' . App::$urlPath . '/torneos/editar-organizadores');
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


    }
}