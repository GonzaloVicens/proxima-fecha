<?php
namespace Proyecto\Controllers;

use Proyecto\Exceptions\MensajeNoGrabadoException;
use Proyecto\View\View;
use Proyecto\Core\Request;
use Proyecto\Core\Route;
use Proyecto\Core\App;
use Proyecto\Model\Usuario;
use Proyecto\Model\Mensaje;
use Proyecto\Model\Equipo;
use Proyecto\Session\Session;
use Proyecto\Tools\FormValidator;
use Proyecto\Exceptions\UsuarioNoGrabadoException;
use Proyecto\Exceptions\NotificacionesNoLeidas;


class UsuarioController
{

    /**
     * Método que contorla la validación del usuario que se intenta loguear al sistema
     **/
    public function loguear()
    {
        $inputs = Request::getData();

        if (isset($inputs ["usuario"]) && !empty($inputs ["usuario"]) && isset($inputs ["password"]) && !empty($inputs ["password"])) {
            $usuario = New Usuario($inputs ['usuario'], $inputs ['password']);
            $error = $usuario->validarUsuario();
        } else {
            $error = "No ha ingresado el usuario o la contraseña";
        }
        if ($error){
            Session::set('errorLogin', $error);
            Session::clearValue('usuario');
            Session::clearValue('logueado');
            header('Location: ' . App::$urlPath . '/');
        } else {
            Session::clearValue('errorLogin');
            Session::set('usuario',$usuario);
            Session::set('logueado','S');
            $usuario->inicioSesion();
            header('Location: ' . App::$urlPath .'/usuarios/'.$usuario->getUsuarioID());
        }
    }



    /**
     * Método que controla el cierre de sesión
     * @param Request $request
     */
    public function desloguear()
    {
        Session::clearValue('logueado');
        Session::clearValue('usuario');
        header('Location: ' . App::$urlPath . '/');
    }




    /**
     * Método que muestra el usuario que recibe como parámetro
     */
    public function ver()
    {
        $routeParams = Route::getRouteParams();
        $usuario_id = $routeParams['usuario_id'];
        if ($usuario_id ){
            if (Usuario::existeUsuario($usuario_id)) {
                $usuarioAMostrar = new Usuario($usuario_id);
                View::render('web/ver-usuario',compact('usuarioAMostrar','usuario_id'), 3);
            } else{
                header('Location: ' . App::$urlPath . '/error404');
            };
        } else {
            if (Session::has("usuario")) {
                $usuarioAMostrar = Session::get('usuario');
                $usuario_id = $usuarioAMostrar->getUsuarioID();
                View::render('web/ver-usuario',compact('usuarioAMostrar','usuario_id'), 3);
            } else {
                header('Location: ' . App::$urlPath . '/error404');
            };
        };
    }

    /**
     * Método que controla el registro de nuevos usuarios en el sistema.
     * @param Request $request
     */
    public function registrar()
    {
        $inputs = Request::getData();
        $error =0;
        $errorActual = "";

        $formValidator = new FormValidator( $inputs);

        // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
        if ( !empty($formValidator->getCamposError()) ){
            Session::set("camposError",$formValidator->getCamposError());
            Session::set("campos",$formValidator->getCampos());
            header('Location: ' . App::$urlPath . '/registrarse');
        } else {
            Session::clearValue("camposError");
            Session::clearValue("campos");

            try {
                $usuario_id = Usuario::CrearUsuario($inputs);
            } catch ( UsuarioNoGrabadoException $exc){
                echo "<pre>";
                print_r($exc->getMessage());
                echo "</pre>";
                header('Location: ' . App::$urlPath . '/error404');
            }

            $usuario = New Usuario($usuario_id);
            Session::set('usuario',$usuario);
            Session::set('logueado','S');
            $usuarioAMostrar  =$usuario;
            View::render('web/ver-usuario',compact('usuario','usuario_id','usuarioAMostrar'), 3);
        }
    }


    /**
     * Método que enviar una nueva contraseña al correo en caso que el usuario olvidara la acutal
     */
    public function recuperarPassword()
    {
        $inputs = Request::getData();
        $email = $inputs ["email"];
        $error = "";
        if (isset($email ) && !empty($email )) {
            if (!Usuario::existeMail ($email )){
                $error = "El correo no existe en el sistema";
            }
        } else {
            $error = "No ha ingresado correo";
        }
        if ($error){
            Session::set('errorLogin', $error);

        } else {
            $respuesta = Usuario::EnviarPassword($email  );
            Session::set('errorLogin', $respuesta );
            Session::set('mailEnviado',"Y");
        }
        header('Location: ' . App::$urlPath . '/recuperar-password');
    }




    /**
     * Método que muestra el formulario para crear el Torneo
     */
    public function verCrearTorneo()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario->actualizar();
            $usuario_id = $usuario->getUsuarioID();
            if ($usuario->puedeCrearTorneo()){
                View::render('web/crear-torneo',compact('usuario','usuario_id'), 3);
            } else {
                Session::set('errorUsuarioStandard','Y');
                header('Location: ' . App::$urlPath . '/usuarios/' . $usuario->getUsuarioID());
            }
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };

    }



    /**
     * Método que muestra el formulario para crear la Sede
     */
    public function verCrearSede()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();
            View::render('web/crear-sede',compact('usuario','usuario_id'), 3);
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };

    }


    public function notificaciones()
    {
        if (Session::has("usuario")){
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();

            if (Usuario::existeUsuario($usuario_id) ){
                $usuario->actualizar();

                $notificaciones = $usuario->getUltimasNotificaciones(20);

                View::render('web/notificaciones',compact('usuario','usuario_id','notificaciones'), 3);
                try {
                    $usuario->leerNotificaciones();
                } catch (NotificacionesNoLeidas $err)   {
                    alert($err.message);
                    header('Location: ' . App::$urlPath . '/error404');
                }
            } else{
                header('Location: ' . App::$urlPath . '/error404');
            };
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        }
    }

    public function mensajes()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();
            View::render('web/mensajes',compact('usuario','usuario_id'), 3);
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }


    public function cuentaPro()
    {
        if (Session::has("usuario")) {
            $usuario = Session::get('usuario');
            $usuario_id = $usuario->getUsuarioID();
            View::render('web/cuenta-pro',compact('usuario','usuario_id'), 3);
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        };
    }

    //




    /**
     * Método que muestra el chat entre el usuario conectado y el amigo elegido
     */
    public function mostrarMensajes()
    {
        if (Session::has("usuario")){
            $routeParams = Route::getRouteParams();
            $usuario_id = $routeParams['usuario_id'];
            $contacto_id = $routeParams['contacto_id'];
            if (Usuario::existeUsuario($usuario_id) && Usuario::existeUsuario($contacto_id))  {
                $usuarioActual = new Usuario($usuario_id);
                $contactoActual = new Usuario($contacto_id);
                $mensajes = $usuarioActual->getMensajesCon($contacto_id);

                View::render('web/conversacion', compact('mensajes','usuarioActual','contactoActual'),3);

                try {
                    $usuarioActual->leerMensajes($contacto_id);
                } catch (MensajesNoLeidosException $err)   {
                    alert($err.message);
                    header('Location: ' . App::$urlPath . '/error404');
                }
            } else{
                header('Location: ' . App::$urlPath . '/error404');
            };
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        }
    }



    /**
     * Método que ordena el Insert de un Mensaje si hay datos, y vuelve a la ubicación original;
     * @param Request $request
     *
     */
    public function agregarMensaje()
    {

        if (Session::has("usuario")) {

            $inputs = Request::getData();
            if (!empty($inputs['mensaje'])) {
                try {
                    $mensajeID = Mensaje::CrearMensaje($inputs);
                } catch (MensajeNoGrabadoException $exc) {
                    echo "<pre>";
                    print_r($exc.getMessage());
                    echo "</pre>";
                    header("Location: ../error404");
                }
            };
            header("Location: ../mensajes/" . $inputs['usuario_id'] . "/" . $inputs['contacto_id']);
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        }
    }

    public function verEditarUsuario()
    {
        View::render('web/editar-mis-datos',[], 3);
    }




    /**
     * Método que controla la actualización de del perfil de usuario.
     * @param Request $request
     */
    public function editarUsuario()
    {
        Session::clearValue('errorImagenNoJPG');

        if (Session::has("usuario")){
            $usuario = Session::get('usuario');
            $usuario->actualizar();
            $inputs = Request::getData();

            $error =0;
            $errorActual = "";

            $formValidator = new FormValidator( $inputs, true);

            // Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
            if ( !empty($formValidator->getCamposError()) ){
                Session::set("camposError",$formValidator->getCamposError());
                Session::set("campos",$formValidator->getCampos());
                  header('Location: ' . App::$urlPath . '/usuarios/editar-datos');

            } else {
                Session::clearValue("camposError");
                Session::clearValue("campos");

                try {
                    $usuario->actualizarUsuario($inputs);
                } catch ( UsuarioNoGrabadoException $exc){
                    echo "<pre>";
                    print_r($exc->getMessage());
                    echo "</pre>";
                    header('Location: ' . App::$urlPath . '/error404');
                }
            }

            if ( empty($formValidator->getCamposError()) ) {
                $files = Request::getFiles();

                if (isset($files['foto']['tmp_name']) && !empty($files ['foto']['tmp_name'])) {
                    if  (! stristr($files ['foto']['name'], '.jpg')){
                        Session::set('errorImagenNoJPG', 'Y');
                    } else {
                        $archivo_tmp = $files ['foto']['tmp_name'];
                        $original = imagecreatefromjpeg($archivo_tmp);
                        $ancho = imagesx($original);
                        $alto = imagesy($original);

                        $alto_max = 200;
                        //$ancho_max = round($ancho * $alto_max / $alto);
                        $ancho_max = 200;

                        $copia = imagecreatetruecolor($ancho_max, $alto_max);
                        imagecopyresampled($copia, $original,
                            0, 0, 0, 0,
                            $ancho_max, $alto_max,
                            $ancho, $alto);
                        $nombre_nuevo = App::$rootPath . "/img/usuarios/" . $usuario->getUsuarioID() . ".jpg";
                        imagejpeg($copia, $nombre_nuevo);
                    }
                }
                header('Location: ' . App::$urlPath . '/usuarios/' . $usuario->getUsuarioID());
            } else {
                header('Location: ' . App::$urlPath . '/usuarios/editar-datos');
            }
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        }
    }


    /**
     * Método que controla la actualización de la foto del perfil de usuario.
     * @param Request $request
     */
    public function actualizarFotoPerfil()
    {
        Session::clearValue('errorImagenNoJPG');

        if (Session::has("usuario")){
            $inputs = Request::getData();
            $files =  Request::getFiles();

            $usuario = $inputs['usuario_id'];
            if (isset($files['foto']['tmp_name']) && !empty($files ['foto']['tmp_name'])){
                if  (! stristr($files ['foto']['name'], '.jpg')){
                    Session::set('errorImagenNoJPG', 'Y');
                } else {
                    $archivo_tmp = $files ['foto']['tmp_name'];
                    $original = imagecreatefromjpeg($archivo_tmp);
                    $ancho = imagesx( $original );
                    $alto = imagesy( $original );

                    $alto_max= 200;
                  //  $ancho_max = round( $ancho *  $alto_max / $alto );
                    $ancho_max = 200;

                    $copia = imagecreatetruecolor( $ancho_max, $alto_max );
                    imagecopyresampled( $copia, $original,
                                        0,0, 0,0,
                                    $ancho_max,$alto_max,
                                    $ancho,$alto);
                    $nombre_nuevo = App::$rootPath . "/img/usuarios/$usuario".".jpg";
                    imagejpeg( $copia , $nombre_nuevo);
                }
            }
            header('Location: ' . App::$urlPath . '/usuarios/'.$usuario);
        } else {
            header('Location: ' . App::$urlPath . '/error404');
        }
    }


}

