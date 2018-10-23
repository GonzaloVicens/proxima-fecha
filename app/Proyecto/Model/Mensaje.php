<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 20/08/2017
 * Time: 11:55 AM
 */

namespace Proyecto\Model;
use Proyecto\DB\DBConnection;


class Mensaje
{
    protected $idmensaje;
    protected $nombre_usuario;
    protected $email;
    protected $mensaje;

    public static function armarMail($data)
    {
        $nombre = $data['name'];
        $email = $data['email'];
        $message = $data['message'];

        $mensajeMail= "<b>Nombre usuario:</b> " . $nombre . "<br> 
                       <b>E-mail usuario:</b>" . $email. "<br>
                       <b>Mensaje:</b>" . $message;

        return $mensajeMail;
    }


    /**
     * @return mixed
     */
    public function getIdmensaje()
    {
        return $this->idmensaje;
    }

    /**
     * @param mixed $idmensaje
     */
    public function setIdmensaje($idmensaje)
    {
        $this->idmensaje = $idmensaje;
    }

    /**
     * @return mixed
     */
    public function getNombreUsuario()
    {
        return $this->nombre_usuario;
    }

    /**
     * @param mixed $nombre_usuario
     */
    public function setNombreUsuario($nombre_usuario)
    {
        $this->nombre_usuario = $nombre_usuario;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param mixed $mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

}