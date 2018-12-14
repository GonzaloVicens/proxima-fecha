<?php
namespace Proyecto\Controllers;
use Proyecto\Tools\FormValidator;
use Proyecto\View\View;
use Proyecto\Core\Route;
use Proyecto\Core\Request;
use Proyecto\Model\Equipo;
use Proyecto\Model\Sede;
use Proyecto\Model\Usuario;
use Proyecto\Model\Cancha;
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
            $sedeAMostrar = new Sede($sede_id);
            Session::set("sede",$sedeAMostrar);
            $duenosActivos= $sedeAMostrar->getDuenosActivos();
            View::render('web/ver-sede',compact('sedeAMostrar','duenosActivos'), 3);
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
                header('Location: ' . App::$urlPath . '/usuarios/editar-sede');

            } else {
                Session::clearValue("camposError");
                Session::clearValue("campos");
                $usuario = Session::get('usuario');
                Sede::ActualizarSede($inputs);
                header('Location: ' . App::$urlPath . '/sedes/' . $sede_id);
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




    public function editarDuenos()
    {
        if (Session::has("usuario") && Session::has('sede')) {
            $usuario = Session::get('usuario');
            $sede = Session::get('sede');
            $sede->actualizar();
            $duenos= $sede->getTodosLosDuenos();
            View::render('web/editar-duenos',compact('usuario','sede','duenos'), 3);

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }

    /**
     * Método que agrega un Dueno en el Sede
     */
    public function agregarDueno()
    {
        $inputs = Request::getData();

        if (isset($inputs["sede_id"]) && !empty($inputs ["sede_id"]) ){
            $sede_id = $inputs ['sede_id'];
            $sede = new Sede($sede_id);

            if (isset($inputs ["dueno_id"]) && !empty($inputs ["dueno_id"])) {

                $dueno_id = $inputs ['dueno_id'];

                if ($sede->existeDueno($dueno_id)) {
                    Session::set("errorAgregarDueno", $dueno_id . " ya es un dueno del sede");
                } else {
                    if (Usuario::existeUsuario($dueno_id)) {
                        $sede->insertarDueno($dueno_id);
                        Session::clearValue("errorAgregarDueno");
                    } else {
                        Session::set("errorAgregarDueno", $dueno_id . " no existe en el sistema");
                    }
                };
            } else {
                Session::set("errorAgregarDueno",  " Ingrese un dueno");
            }
        }

        header('Location: ' . App::$urlPath . '/sedes/editar-duenos');
    }


    /**
     * Método que activa/desactiva un Dueno en el Sede
     */
    public function editarDueno()
    {
        $inputs = Request::getData();

        if (isset($inputs["sede_id"]) && !empty($inputs ["sede_id"]) ){
            $sede_id = $inputs ['sede_id'];
            $sede = new Sede($sede_id);

            if (isset($inputs ["dueno_id"]) && !empty($inputs ["dueno_id"])) {

                $dueno_id = $inputs ['dueno_id'];
                $activo = $inputs ['activo'];

                if (!$sede->existeDueno($dueno_id)) {
                    Session::set("errorAgregarDueno", $dueno_id . " no es un dueno del sede");
                } else {
                    if ($sede->tieneOtrosDuenos($dueno_id)) {
                        $sede->editarDueno($dueno_id, $activo);
                        Session::clearValue("errorAgregarDueno");
                    } else {
                        Session::set("errorAgregarDueno",  "No quedan duenos en el sede");
                    }
                };
            } else {
                Session::set("errorAgregarDueno",  " Ingrese un dueno");
            }
        }

        header('Location: ' . App::$urlPath . '/sedes/editar-duenos');
    }


    /**
     * Método que agrega una Cancha en la Sede
     */
    public function agregarCancha()
    {
        $inputs = Request::getData();

        if (isset($inputs["sede_id"]) && !empty($inputs ["sede_id"]) ){
            $sede_id = $inputs ['sede_id'];
            $sede = new Sede($sede_id);

            $formValidator = new FormValidator($inputs, true);

            // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
            if (!empty($formValidator->getCamposError())) {
                Session::set("camposError", $formValidator->getCamposError());
                Session::set("campos", $formValidator->getCampos());
                header('Location: ' . App::$urlPath . '/sedes/' . $sede_id);
            } else {
                $sede->agregarCancha($inputs);
                Session::clearValue("camposError");
                Session::clearValue("campos");
                header('Location: ' . App::$urlPath . '/sedes/' . $sede_id);
            }
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        }

    }


    /**
     * Método que controla la eliminazión de una cancha de la sede
     */
    public function eliminarCancha(){
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();

            $inputs = Request::getData();


            Cancha::eliminarCancha($inputs);
            header('Location: ' . App::$urlPath . '/sedes/'. $inputs['sede_id']);

        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }


}