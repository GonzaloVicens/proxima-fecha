<?php
namespace Proyecto\Controllers;
use Proyecto\Model\Notificacion;
use Proyecto\View\View;
use Proyecto\Core\Route;
use Proyecto\Core\Request;
use Proyecto\Model\Equipo;
//use Proyecto\Model\Posteo;
use Proyecto\Model\Usuario;
use Proyecto\Session\Session;
use Proyecto\Core\App;
class EquipoController
{


    /**
     * Método que muestra los equipos existentes
     */
    public function verEquipos()
    {
        View::render('web/ver-equipos',[], 3);
    }


    /**
     * Método que renderiza la vista de un Equipo en partícular
     */
    public function ver()
    {
        $routeParams = Route::getRouteParams();
        $equipo_id = $routeParams['equipo_id'];
        if (Equipo::existeEquipo($equipo_id)) {
            $equipoAMostrar = new Equipo($equipo_id);
            $equipoAMostrar->actualizar();
            Session::set("equipo_idActual",$equipoAMostrar->getEquipoId());

            View::render('web/ver-equipo',compact('equipoAMostrar'), 3);
        } else{
            View::render('web/error404',[], 2);
        };
    }


    /**
     * Método que controla la creación de un equipo
     */
    public function registrar(){
        Session::clearValue('errorImagenNoJPG');

        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();

            $inputs = Request::getData();

            if (isset($inputs['nombre']) && !empty($inputs['nombre'])){
                $nombre = $inputs['nombre'];
            } else {
                $nombre = "Sin Nombre";
            }

            $equipo_id = Equipo::CrearEquipo($nombre, $usuario_id);

            $files = Request::getFiles();

            if (isset($files ['foto']['tmp_name']) && !empty($files ['foto']['tmp_name'])){
                if  (! stristr($files ['foto']['name'], '.jpg')){
                    Session::set('errorImagenNoJPG', 'Y');
                } else {

                 $archivo_tmp = $files ['foto']['tmp_name'];
                    $original = imagecreatefromjpeg($archivo_tmp);
                    $ancho = imagesx($original);
                    $alto = imagesy($original);

                    // Copia 200 px
                    $alto_max = 200;
                    $ancho_max = round($ancho * $alto_max / $alto);

                    $copia = imagecreatetruecolor($ancho_max, $alto_max);

                    imagecopyresampled($copia, $original,
                        0, 0, 0, 0,
                        $ancho_max, $alto_max,
                        $ancho, $alto);

                    $nombre_nuevo = App::$rootPath . "/img/equipos/$equipo_id" . "_logo_200.jpg";
                    imagejpeg($copia, $nombre_nuevo);

                    // Copia 100 px
                    $alto_max = 100;
                    $ancho_max = round($ancho * $alto_max / $alto);

                    $copia = imagecreatetruecolor($ancho_max, $alto_max);
                    imagecopyresampled($copia, $original,
                        0, 0, 0, 0,
                        $ancho_max, $alto_max,
                        $ancho, $alto);

                    $nombre_nuevo = App::$rootPath . "/img/equipos/$equipo_id" . "_logo_100.jpg";
                    imagejpeg($copia, $nombre_nuevo);
                }
            }
            header('Location: ' . App::$urlPath . '/equipos/'.$equipo_id);
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }


    /**
     * Método que agrega un jugador en el equipo
     */
    public function agregarJugador()
    {
        $inputs = Request::getData();

        if (isset($inputs["equipo"]) && !empty($inputs ["equipo"]) ){
            $equipo_id = $inputs ['equipo'];
            $equipo = new Equipo($equipo_id);

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

        $equipoAMostrar= $equipo;
        View::render('web/ver-equipo',compact('equipo','equipo_id','equipoAMostrar'), 3);
    }



    /**
     * Método que controla la eliminazión de un equipo
     */
    public function eliminarEquipo(){
        echo "<pre>";
            print_r (Request::getData());
        echo "</pre>";
        /*
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
        ¨*/
    }
}