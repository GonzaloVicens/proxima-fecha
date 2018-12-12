<?php
namespace Proyecto\Controllers;
use Proyecto\Tools\FormValidator;
use Proyecto\View\View;
use Proyecto\Core\Route;
use Proyecto\Core\Request;
use Proyecto\Model\Equipo;
use Proyecto\Model\Sede;
use Proyecto\Model\Usuario;
use Proyecto\Model\Partido;
use Proyecto\Session\Session;
use Proyecto\Core\App;
class SedeController
{



    /**
     * Método que renderiza la vista de una Sede en partícular
     */
    public function ver()
    {
        $routeParams = Route::getRouteParams();
        $sede_id = $routeParams['sede_id'];
        if (Sede::existeSede($sede_id)) {
            $sede = new Sede($sede_id);
            Session::set("sede",$sede);
            $duenosActivos= $sede->getDuenosActivos();
            View::render('web/ver-sede',compact('sede','duenosActivos'), 3);
        } else{
            View::render('web/error404',[], 2);
        };
    }


    /**
     * Método que controla la creación de una sede
     */
    public function registrar(){
        if (Session::has("usuario")) {
            $inputs = Request::getData();

            $formValidator = new FormValidator($inputs, true);

            // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
            if (!empty($formValidator->getCamposError())) {
                Session::set("camposError", $formValidator->getCamposError());
                Session::set("campos", $formValidator->getCampos());
                header('Location: ' . App::$urlPath . '/usuarios/crear-sede');
            } else {
                Session::clearValue("camposError");
                Session::clearValue("campos");
                $usuario = Session::get('usuario');
                $sede_id = Sede::CrearSede($inputs, $usuario->getUsuarioId());
                header('Location: ' . App::$urlPath . '/sedes/' . $sede_id);
            };
        }else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }





    public function editarSede()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();
            View::render('web/editar-sede',compact('usuario','usuario_id'), 3);
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }


    /**
     * Método que controla la actualización de un torneo
     */
    public function actualizar()
    {
        if (Session::has("usuario")) {
            $inputs = Request::getData();
            $sede_id = $inputs['sede_id'];

            $formValidator = new FormValidator($inputs, true);

            // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
            if (!empty($formValidator->getCamposError())) {
                Session::set("camposError", $formValidator->getCamposError());
                Session::set("campos", $formValidator->getCampos());
                header('Location: ' . App::$urlPath . '/usuarios/crear-sede');

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
                    header('Location: ' . App::$urlPath . '/usuarios/crear-sede');
                } else {
                    Session::clearValue("camposError");
                    Session::clearValue("campos");
                    $usuario = Session::get('usuario');
                    Sede::ActualizarSede($inputs);
                    header('Location: ' . App::$urlPath . '/sedes/' . $sede_id);
                }
            };
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }







    /**
     * Método que controla la eliminazión de un sede
     */
    public function eliminar(){
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();

            $inputs = Request::getData();

            $sede_id = $inputs['sede_id'];
            $confirmar = $inputs['confirmar'];

            if ($confirmar == "SI"){
                $sede = new Sede($sede_id);
                $sede->eliminarSede();
                Session::clearValue('sede');
                $usuario->actualizar();
                header('Location: ' . App::$urlPath . '/usuarios/'. $usuario_id);
            } ELSE {
                header('Location: ' . App::$urlPath . '/sedes/'. $sede_id);
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
        header('Location: ' . App::$urlPath . '/sedes/agregar-equipos');
    }


    /**
     * Método que agrega un Equipo en el Sede
     */
    public function agregarEquipo()
    {
        $inputs = Request::getData();
        Session::clearValue("errorAgregarEquipo");
        Session::clearValue("IDAgregarEquipo");
        $sede = Session::get('sede');
        if (isset($inputs ["equipo_id"]) && !empty($inputs ["equipo_id"])) {
            $equipo_id = $inputs ['equipo_id'];
            $nombre = $inputs ['nombre'];
            Session::set("IDAgregarEquipo", $equipo_id );
            if ($sede->getLugaresLibres() > 0) {

                if ($sede->existeEquipo($equipo_id)) {
                    Session::set("errorAgregarEquipo", $nombre  . " ya es un equipo del sede");
                } else {
                    if (Equipo::existeEquipo($equipo_id)) {
                        $sede->insertarEquipo($equipo_id);
                        Session::set("errorAgregarEquipo", $nombre  . " fue agregado al sede");
                    } else {
                        Session::set("errorAgregarEquipo", $equipo_id . " no existe en el sistema");
                    }
                };
            } else {
                Session::set("errorAgregarEquipo", "El sede ya esta lleno");
            }
        } else {
                Session::set("errorAgregarEquipo", " Ingrese un equipo");
        }
        $sede->actualizar();
        if (Session::has('inputsBuscados')){
            $inputsBusqueda = Session::get('inputsBuscados');
            Session::set('inputsBusqueda',$inputsBusqueda);
            $resultados = Equipo::BuscarEquipos($inputsBusqueda );
            Session::set('resultados',$resultados);
        }

        header('Location: ' . App::$urlPath . '/sedes/agregar-equipos');

    }

    /**
     * Método que elimina un Equipo en el Sede
     */
    public function eliminarEquipo()
    {
        $inputs = Request::getData();
        if (isset($inputs ["equipo_id"]) && !empty($inputs ["equipo_id"])) {
            $sede = Session::get('sede');
            $equipo_id = $inputs ['equipo_id'];
            $origen = $inputs ['origen'];
            if ($sede->existeEquipo($equipo_id)) {
                $sede->eliminarEquipo($equipo_id);
            };
        }
        $sede->actualizar();
         header('Location: ' . App::$urlPath . '/sedes/' . $origen);

    }

    public function generarFixture(){
        $sede = Session::get('sede');
        $sede->actualizar();
        $sede->generarFixture();
        Session::set('sede',$sede);
        header('Location: ' . App::$urlPath . '/sedes/ver-fixture-completo' );
    }

    public function verFixtureCompleto()
    {
        if (Session::has("sede")) {
            $sede = Session::get('sede');
            $sede ->actualizar();
            View::render('web/ver-fixture-completo',compact('sede'), 3);

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };

    }

    public function verFixtureSedeCompleto()
    {
        $sede = Session::get('sede');
        View::render('web/ver-fixture-sede-completo',compact('sede'), 3);

        /*
        if (Session::has("sede")) {
            $sede = Session::get('sede');
            $sede ->actualizar();
            View::render('web/ver-fixture-sede-completo',compact('sede'), 3);

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };*/

    }


    public function editarOrganizadores()
    {
        if (Session::has("usuario") && Session::has('sede')) {
            $usuario = Session::get('usuario');
            $sede = Session::get('sede');
            $sede->actualizar();
            $organizadores= $sede->getTodosLosOrganizadores();
            View::render('web/editar-organizadores',compact('usuario','sede','organizadores'), 3);

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }

    /**
     * Método que agrega un Organizador en el Sede
     */
    public function agregarOrganizador()
    {
        $inputs = Request::getData();

        if (isset($inputs["sede_id"]) && !empty($inputs ["sede_id"]) ){
            $sede_id = $inputs ['sede_id'];
            $sede = new Sede($sede_id);

            if (isset($inputs ["organizador_id"]) && !empty($inputs ["organizador_id"])) {

                $organizador_id = $inputs ['organizador_id'];

                if ($sede->existeOrganizador($organizador_id)) {
                    Session::set("errorAgregarOrganizador", $organizador_id . " ya es un organizador del sede");
                } else {
                    if (Usuario::existeUsuario($organizador_id)) {
                        $sede->insertarOrganizador($organizador_id);
                        Session::clearValue("errorAgregarOrganizador");
                    } else {
                        Session::set("errorAgregarOrganizador", $organizador_id . " no existe en el sistema");
                    }
                };
            } else {
                Session::set("errorAgregarOrganizador",  " Ingrese un organizador");
            }
        }

        header('Location: ' . App::$urlPath . '/sedes/editar-organizadores');
    }


    /**
     * Método que activa/desactiva un Organizador en el Sede
     */
    public function editarOrganizador()
    {
        $inputs = Request::getData();

        if (isset($inputs["sede_id"]) && !empty($inputs ["sede_id"]) ){
            $sede_id = $inputs ['sede_id'];
            $sede = new Sede($sede_id);

            if (isset($inputs ["organizador_id"]) && !empty($inputs ["organizador_id"])) {

                $organizador_id = $inputs ['organizador_id'];
                $activo = $inputs ['activo'];

                if (!$sede->existeOrganizador($organizador_id)) {
                    Session::set("errorAgregarOrganizador", $organizador_id . " no es un organizador del sede");
                } else {
                    if ($sede->tieneOtrosOrganizadores($organizador_id)) {
                        $sede->editarOrganizador($organizador_id, $activo);
                        Session::clearValue("errorAgregarOrganizador");
                    } else {
                        Session::set("errorAgregarOrganizador",  "No quedan organizadores en el sede");
                    }
                };
            } else {
                Session::set("errorAgregarOrganizador",  " Ingrese un organizador");
            }
        }

      //  header('Location: ' . App::$urlPath . '/sedes/editar-organizadores');
    }




    /**
     * Método que da por decide la actualización del Sede
     */
    protected function actualizarEstadoSede($estado)
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario->actualizar();

            if (Session::has("sede")) {
                $sede = Session::get('sede');
                $sede->actualizar();

                if ($sede->tieneOrganizadorActivo($usuario->getUsuarioID())) {
                    switch ($estado){
                        case "C":
                            $sede->comenzar();
                            break;
                        case "F":
                            $sede->finalizar();
                            break;
                        case "R":
                            $sede->reiniciar();
                            break;
                    }
                }
            };
        }

        $sede->actualizar();
        header('Location: ' . App::$urlPath . '/sedes/' . $sede->getSedeID());

    }

    /**
     * Método que da por comenzado el Sede
     */
    public function comenzarSede()
    {
        $this->actualizarEstadoSede("C");
    }

    /**
     * Método que da por finalizado el Sede
     */
    public function finalizarSede()
    {
        $this->actualizarEstadoSede("F");
    }

    /**
     * Método que da por finalizado el Sede
     */
    public function reiniciarSede()
    {
        $this->actualizarEstadoSede("R");
    }


    public function verPartido(){

        $routeParams = Route::getRouteParams();
        $sede_id = $routeParams['sede'];
        $fase_id = $routeParams['fase'];
        $partido_id = $routeParams['partido'];
        if (Partido::existePartido($sede_id, $fase_id, $partido_id)) {
            $partidoActual = new Partido($sede_id, $fase_id, $partido_id) ;
            $local = new Equipo ($partidoActual->getLocalId());
            $visita = new Equipo ($partidoActual->getVisitaId());
            View::render('web/ver-partido',compact('partidoActual', 'local','visita'), 3);
        } else{
            View::render('web/error404',[], 2);
        };
    }

    public function agregarFichaPartido(){
        $inputs = Request::getData();

        if ( (isset($inputs["sede"]) && !empty($inputs ["sede"]) )
        &&  (isset($inputs["fase"]) && !empty($inputs ["fase"]) )
        &&  (isset($inputs["partido"]) && !empty($inputs ["partido"]) )
        &&  (isset($inputs["equipo"]) && !empty($inputs ["equipo"]) )
        &&  (isset($inputs["jugador"]) && !empty($inputs ["jugador"]) )
        &&  (isset($inputs["tipo"]) && !empty($inputs ["tipo"]) )){

            $partido = New Partido($inputs["sede"], $inputs["fase"], $inputs["partido"]);
            $partido->agregarFicha($inputs["tipo"], $inputs["equipo"], $inputs["jugador"]);
        }

        header('Location: ' . App::$urlPath . '/sedes/' . $inputs["sede"] . "/". $inputs["fase"] ."/". $inputs["partido"]);

    }
}