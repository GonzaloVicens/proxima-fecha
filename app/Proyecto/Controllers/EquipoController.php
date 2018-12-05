<?php
namespace Proyecto\Controllers;
use Proyecto\View\View;
use Proyecto\Core\Route;
use Proyecto\Core\Request;
use Proyecto\Model\Equipo;
//use Proyecto\Model\Mensaje;
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
            $equipo = new Equipo($equipo_id);
            $equipo->setJugadores();
            Session::set("equipo_idActual",$equipo->getEquipoId());

            View::render('web/ver-equipo',compact('equipo'), 3);
        } else{
            View::render('web/error404',[], 2);
        };
    }


    /**
     * Método que controla la creación de un equipo
     */
    public function registrar(){
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();

            $inputs = Request::getData();

            $nombre = $inputs['nombre'];

            $equipo_id = Equipo::CrearEquipo($nombre, $usuario_id);

            $files = Request::getFiles();

            if (isset($files ['foto']['tmp_name']) && !empty($files ['foto']['tmp_name'])){
                $archivo_tmp = $files ['foto']['tmp_name'];


                $original = imagecreatefromjpeg($archivo_tmp);
                $ancho = imagesx( $original );
                $alto = imagesy( $original );

                // Copia 200 px
                $alto_max= 200;
                $ancho_max = round( $ancho *  $alto_max / $alto );

                $copia = imagecreatetruecolor( $ancho_max, $alto_max );

                imagecopyresampled( $copia, $original,
                    0,0, 0,0,
                    $ancho_max,$alto_max,
                    $ancho,$alto);

                $nombre_nuevo = App::$rootPath . "/img/equipos/$equipo_id"."_logo_200.jpg";
                imagejpeg( $copia , $nombre_nuevo);

                // Copia 100 px
                $alto_max= 100;
                $ancho_max = round( $ancho *  $alto_max / $alto );

                $copia = imagecreatetruecolor( $ancho_max, $alto_max );
                imagecopyresampled( $copia, $original,
                    0,0, 0,0,
                    $ancho_max,$alto_max,
                    $ancho,$alto);

                $nombre_nuevo = App::$rootPath . "/img/equipos/$equipo_id"."_logo_100.jpg";
                imagejpeg( $copia , $nombre_nuevo);

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
        View::render('web/ver-equipo',compact('equipo','equipo_id'), 3);
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