<?php
namespace Proyecto\Controllers;
use Proyecto\View\View;
use Proyecto\Core\Route;
use Proyecto\Core\Request;
use Proyecto\Model\Equipo;
use Proyecto\Model\Torneo;
//use Proyecto\Model\Mensaje;
//use Proyecto\Model\Posteo;
use Proyecto\Model\Usuario;
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
            $torneo->setEquipos();
            Session::set("torneo_idActual",$torneo->getTorneoId());
            View::render('web/ver-torneo',compact('torneo','torneo_id'), 3);
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
            $usuario_id = $usuario->getUsuarioID();

            $inputs = Request::getData();

            $nombre = $inputs['nombre'];
            $deporte = $inputs['deporte'];

//            $torneo_id = Torneo::CrearTorneo($nombre, $deporte , $usuario_id);

            //header('Location: ' . App::$urlPath . '/torneos/'.$torneo_id);
            header('Location: ' . App::$urlPath . '/torneos/1');
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }


    /**
     * Método que agrega un jugador en el equipo
     *
    public function agregarJugador()
    {
        $inputs = Request::getData();

        if (isset($inputs["equipo"]) && !empty($inputs ["equipo"]) ){
            $torneo_id = $inputs ['equipo'];
            $equipo = new Equipo($torneo_id);

            if (isset($inputs ["jugador"]) && !empty($inputs ["jugador"])) {

                $jugador_id = $inputs ['jugador'];

                if ($equipo->existeJugador($jugador_id)) {
                    Session::set("errorAgregarJugador", $jugador_id . " ya es un jugador del equipo");
                } else {
                    if (Usuario::existeUsuario($jugador_id)) {
                        $equipo->insertarJugador($jugador_id);
                        Session::clearValue("errorAgregarJugador");
                    } else {
                        Session::set("errorAgregarJugador", $jugador_id . " no existe en el sistema");
                    }
                };
            } else {
                Session::set("errorAgregarJugador",  " Ingrese un jugador");
            }
        }
        View::render('web/equipo',compact('equipo','torneo_id'), 3);
    }

    /**
     * Método que ordena el Insert de un mensaje si hay datos, y vuelve a la ubicación original;
     * @param Request $request
     *
     *
    public function agregarComentario(Request $request)
    {
        if (Session::has("usuario")){
           $inputs = $request->getData();
            if (!empty($inputs['mensaje'])) {
                $mensajeID = Mensaje::CrearMensaje($inputs);
            };
        header("Location: ../public#posteo".$inputs['posteo_id']);

        } else {
            header("Location: ../public");
        }
    }





    /**
     * Método que ordena el Insert de un mensaje si hay datos, y vuelve a la ubicación original dentro de los posteos de un usuario;
     * @param Request $request
     *
     *
    public function agregarComentarioPosteos(Request $request)
    {
        if (Session::has("usuario")){
            $inputs = $request->getData();
            $usuarioAMostrar  ="";
            if (!empty($inputs['mensaje'])){
                try {
                    $mensajeID = Mensaje::CrearMensaje($inputs);
                } catch ( MensajeNoGrabadoException $exc){
                    echo "<pre>";
				    print_r($exc.getMessage());
				    echo "</pre>";
         
                    header("Location: ../error404");
                }

                $posteo = New Posteo($inputs['posteo_id']);
                $usuarioAMostrar =  $posteo->getUsuarioID();
            };

            header("Location: posteos/".$usuarioAMostrar);
        } else {
            header("Location: ../public");
        }

    }


    /**
     * Método que busca los usuarios que tengan un nombre o apellido que contenga el parámetro.
     *
    public function buscar(Request $request)
    {

        $ruta = "";
        $inputs = $request->getData();
        $dato = $inputs ['dato'];

        View::render('modulos/header',compact('ruta'));
        $resultados = Usuario::BuscarUsuarios($dato );
        View::render('modulos/resultados', compact('ruta','resultados'));
        View::render('modulos/footer',compact('ruta'));

    }
*/
}