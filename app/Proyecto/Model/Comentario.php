<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/06/2017
 * Time: 03:09 PM
 */

namespace Proyecto\Model;
use Proyecto\DB\DBConnection;


class Comentario
{

    // Propiedades
    private $idcomentario;
    private $posteo_idposteo;
    private $texto_comentario;
    private $fecha_hora;
    private $usuario_idusuario;

    private $usuario_usuario;

    /**
     * Comentario constructor.
     *
     * @param null|int $id
     */
    public function __construct($id = null)
    {
        if(!is_null($id)) {
            $this->cargarPorId($id);
        }
    }

    public function cargarPorId($id)
    {
        $query = "SELECT * FROM comentarios
                  WHERE idcomentario = ?";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $this->cargarDatos($stmt->fetch());
    }

    /**
     * Retorna todos los comentarios de la base como Objetos Comentarios.
     *
     * @param bool $cargarRelaciones
     * @return Posteo[]
     */

    public static function traerTodos()
    {
        $query = "SELECT * FROM comentarios";
        $db = \DaVinci\DB\DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute();

        $salida = [];

        while($fila = $stmt->fetch()) {
            $post = new Comentario();
            $post->cargarDatos($fila);
            $salida[] = $post;
        }

        return $salida;
    }


    /**
     * busca todos los comentarios asociados a un posteo y los devuelve como un array de Objetos Comentario
     *
     * @param $idposteo
     * @return array Comentario
     */

    public static function traerComentarios1Post($idposteo)
    {
        $query = "SELECT * FROM comentarios 
                  WHERE posteo_idposteo = ?";
        $db = \DaVinci\DB\DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$idposteo]);

        $salida = [];

        while($fila = $stmt->fetch()) {
            $post = new Comentario();
            $post->cargarDatos($fila);
            $salida[] = $post;
        }
        //Retornamos el Array de Objetos Comentarios asociados a 1 Post
        return $salida;
    }


    /**
     * Carga los datos de un Comentario
     *
     * @param $datos
     */
    protected function cargarDatos($datos)
    {
        $this->setIdcomentario($datos['idcomentario']);
        $this->setPosteoIdposteo($datos['posteo_idposteo']);
        $this->setTextoComentario($datos['texto_comentario']);
        $this->setFechaHora($datos['fecha_hora']);
        $this->setUsuarioIdusuario($datos['usuario_idusuario']);
        $this->setUsuarioUsuario($datos['usuario_idusuario']);
    }

    /**
     * Crea un nuevo Comentario en la base de datos.
     *
     * @param array $data
     * @throws \Exception
     */
    public static function crear($data)
    {
        $query = "INSERT INTO comentarios (posteo_idposteo, texto_comentario, fecha_hora, usuario_idusuario)
                  VALUES (:posteo_idposteo, :texto_comentario, :fecha_hora, :usuario_idusuario)";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $exito = $stmt->execute($data);
        if(!$exito) {
            throw new \Exception("Error al crear el comentario.");
        }
    }


    /**
     * Edita un Comentario en la base de datos.
     *
     * @throws \Exception
     */


    public static function editar($data)
    {

        $query = "UPDATE comentarios SET texto_comentario = :texto_comentario WHERE idcomentario = :idcomentario";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $exito = $stmt->execute($data);
        if(!$exito) {
            throw new \Exception("Error al editar el comentario.");
        }
    }

    /**
     * Elimina un Comentario en la base de datos.
     *
     * @throws \Exception
     */
    public static function eliminar($idcomentario)
    {
        $query = "DELETE FROM comentarios
                  WHERE idcomentario = ?";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$idcomentario]);
    }


    /***** SETTERS & GETTERS *****/

    /**
     * @return mixed
     */
    public function getIdcomentario()
    {
        return $this->idcomentario;
    }

    /**
     * @param mixed $idcomentario
     */
    public function setIdcomentario($idcomentario)
    {
        $this->idcomentario = $idcomentario;
    }

    /**
     * @return mixed
     */
    public function getPosteoIdposteo()
    {
        return $this->posteo_idposteo;
    }

    /**
     * @param mixed $posteo_idposteo
     */
    public function setPosteoIdposteo($posteo_idposteo)
    {
        $this->posteo_idposteo = $posteo_idposteo;
    }

    /**
     * @return mixed
     */
    public function getTextoComentario()
    {
        return $this->texto_comentario;
    }

    /**
     * @param mixed $texto_comentario
     */
    public function setTextoComentario($texto_comentario)
    {
        $this->texto_comentario = $texto_comentario;
    }

    /**
     * @return mixed
     */
    public function getFechaHora()
    {
        return $this->fecha_hora;
    }

    /**
     * @param mixed $fecha_hora
     */
    public function setFechaHora($fecha_hora)
    {
        $this->fecha_hora = $fecha_hora;
    }

    /**
     * @return mixed
     */
    public function getUsuarioIdusuario()
    {
        return $this->usuario_idusuario;
    }

    /**
     * @param mixed $usuario_idusuario
     */
    public function setUsuarioIdusuario($usuario_idusuario)
    {
        $this->usuario_idusuario = $usuario_idusuario;
    }

    /**
     * @return mixed
     */
    public function getUsuarioUsuario()
    {
        return $this->usuario_usuario;
    }

    /**
     * @param $idusuario
     */
    public function setUsuarioUsuario($idusuario)
    {
        $usuarioUsuario = Usuario::devolverNombre($idusuario);
        $this->usuario_usuario = $usuarioUsuario;
    }
}
