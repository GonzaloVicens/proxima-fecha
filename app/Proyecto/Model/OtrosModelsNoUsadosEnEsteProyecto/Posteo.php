<?php

/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 22/06/2017
 * Time: 05:46 PM
 */

namespace Proyecto\Model;
use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\ErrorIngresoException;
use Proyecto\Exceptions\ErrorEdicionException;
use Proyecto\Exceptions\ErrorEliminarException;

class Posteo
{
    // Propiedades
    private $idposteo;
    private $texto_posteo;
    private $fecha_hora;
    private $usuario_idusuario;

    private $usuario;
    private $comentarios = [];

    /**
     * Posteo constructor.
     *
     * @param null|int $id
     */
    public function __construct($id = null)
    {
        // Si hay definido un parámetro $id, se lo busca en la db.
        if(!is_null($id)) {
            $this->cargarPorId($id);
        }
    }

    public function cargarPorId($id)
    {
        $query = "SELECT * FROM posteos
                  WHERE idposteo = ?";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        $this->cargarDatos($stmt->fetch());
    }

    /**
     * Retorna todas los posteos de la base como Objetos Posteo.
     *
     * @param bool $cargarRelaciones
     * @return Posteo[]
     */

    public static function traerTodos()
    {
        $query = "SELECT * FROM posteos ORDER BY idposteo DESC";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute();

        $salida = [];

        while($fila = $stmt->fetch()) {

            $post = new Posteo();

            $post->cargarDatos($fila);

            $salida[] = $post;
        }

                return $salida;
    }


    /**
     * Retorna todos los posteos de 1 Usuario como Objetos Posteo.
     *
     * @param string $id
     * @return Posteo[]
     */
    public static function traerPostDe1Usuario($id)
    {
        $query = "SELECT * FROM posteos WHERE usuario_idusuario = ? 
                  ORDER BY idposteo DESC";
        $db = \DaVinci\DB\DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        $salida = [];

        while($fila = $stmt->fetch()) {
            $post = new Posteo();
            $post->cargarDatos($fila);
            $salida[] = $post;
        }
        return $salida;
    }


    /**
     * Carga los datos de un Posteo
     *
     * @param $datos
     */
    protected function cargarDatos($datos)
    {
        $this->setIdposteo($datos['idposteo']);
        $this->setTextoPosteo($datos['texto_posteo']);
        $this->setFechaHora($datos['fecha_hora']);
        $this->setUsuarioIdusuario($datos['usuario_idusuario']);
        $this->setUsuario($datos['usuario_idusuario']);
        $this->setComentarios($datos['idposteo']);
    }


    /**
     * Crea un nuevo Posteo en la base de datos.
     *
     * @param array $data
     * @return bool
     * @throws ErrorIngresoException
     */
    public static function crear($data)
    {
        $query = "INSERT INTO posteos (usuario_idusuario, texto_posteo, fecha_hora)
                  VALUES (:usuario_idusuario, :texto_posteo, :fecha_hora)";

        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $exito = $stmt->execute($data);

        if($exito){
            return $exito;
        } else {
            throw new ErrorIngresoException('Hubo un error, no se pudo crear el nuevo post. Por favor vuelve a intentarlo más tarde.');
        }
    }



    /**
     * Edita un Posteo en la base de datos.
     *
     * @param array $data
     * @return bool
     * @throws ErrorEdicionException
     */
    public static function editar($data)
    {
        $query = "UPDATE posteos SET texto_posteo = :texto_posteo WHERE idposteo = :idposteo";

        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);

        $exito = $stmt->execute($data);

        if($exito){
            return $exito;
        } else {
            throw new ErrorEdicionException('Hubo un error, no se pudo editar el post. Por favor vuelve a intentarlo más tarde.');
        }

    }




    /**
     * Elimina un Posteo en la base de datos.
     *
     * @param array $data
     * @return bool
     * @throws ErrorEliminarException
     */
    public static function eliminar($id)
    {
        $query = "DELETE FROM posteos
                  WHERE idposteo = ?";
        echo $query . "<br>";
        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);
        $exito = $stmt->execute([$id]);

        if($exito){
            return $exito;
        } else {
            throw new ErrorEliminarException('Hubo un error, no se pudo eliminar el post. Por favor vuelve a intentarlo más tarde.');
        }
    }

    /**
     * @return mixed
     */
    public function getIdposteo()
    {
        return $this->idposteo;
    }

    /**
     * @param mixed $idposteo
     */
    public function setIdposteo($idposteo)
    {
        $this->idposteo = $idposteo;
    }

    /**
     * @return mixed
     */
    public function getTextoPosteo()
    {
        return $this->texto_posteo;
    }

    /**
     * @param mixed $texto_posteo
     */
    public function setTextoPosteo($texto_posteo)
    {
        $this->texto_posteo = $texto_posteo;
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
     * @param mixed $texto_posteo
     */
    public function setUsuarioIdusuario($usuario_idusuario)
    {
        $this->usuario_idusuario = $usuario_idusuario;
    }

    /**
     * @param $usuario
     */
    public function setUsuario($idusuario)
    {


        if(is_null($this->usuario)) {
            $usuarioUsuario = Usuario::devolverNombre($idusuario);
            $this->usuario = $usuarioUsuario;
        }
    }

    public function getUsuario()
    {
        return $this->usuario;
    }


    public function setComentarios($idposteo)
    {
        $coment = Comentario::traerComentarios1Post($idposteo);
        $this->comentarios = $coment;
    }

    public function getComentarios()
    {
        return $this->comentarios;
    }

}
