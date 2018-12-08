<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\FichaNoGrabadaException;

/**
 * Implementación de la clase Ficha
 */
class Ficha
{
    /**
     * @var integer
     */
    protected $torneo_id;

    /**
     * @var integer
     */
    protected $fase_id;


    /**
     * @var integer
     */
    protected $partido_id;

    /**
     * @var integer
     */
    protected $ficha_id;

    /**
     * @var string
     */
    protected $tipo_estadistica_id;

    /**
     * @var string
     */
    protected $tipo_estadistica_descr;

    /**
     * @var integer
     */
    protected $equipo_id;

    /**
     * @var string
     */
    protected $jugador_id;

    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($torneo_id , $fase_id , $partido_id, $ficha_id)
    {
        $this->setFicha($torneo_id, $fase_id, $partido_id, $ficha_id);
    }

    /**
     * @return int
     */
    public function getTorneoId()
    {
        return $this->torneo_id;
    }

    /**
     * @return int
     */
    public function getFaseId()
    {
        return $this->fase_id;
    }

    /**
     * @return int
     */
    public function getFichaID()
    {
        return $this->ficha_id;
    }


    public function getTipoEstadisticaID(){
        return $this->tipo_estadistica_id;
    }


    public function getTipoEstadisticaDescr(){
        return $this->tipo_estadistica_descr;
    }

    public function getEquipoID(){
        return $this->equipo_id;
    }

    public function getJugadorID(){
        return $this->jugador_id;
    }

    public function setFicha($torneo, $fase, $partido, $ficha)
    {
        $this->torneo_id = $torneo;
        $this->fase_id = $fase;
        $this->partido_id = $partido;
        $this->ficha_id = $ficha;

        $param= [
            'torneo_id' => $torneo,
            'fase_id'   => $fase,
            'partido_id'   => $partido,
            'ficha_id'   => $ficha
        ];

        $query = "SELECT A.TIPO_ESTADISTICA_ID , B.DESCRIPCION , A.EQUIPO_ID, A.JUGADOR_ID FROM FICHA_PARTIDO A , TIPOS_ESTADISTICA B WHERE A.TORNEO_ID = :torneo_id AND A.FASE_ID = :fase_id AND A.PARTIDO_ID = :partido_id AND A.FICHA_ID = :ficha_id AND A.TIPO_ESTADISTICA_ID = B.TIPO_ESTADISTICA_ID";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->tipo_estadistica_id= $datos['TIPO_ESTADISTICA_ID'];
            $this->descripcion= $datos['DESCRIPCION'];
            $this->equipo_id= $datos['EQUIPO_ID'];
            $this->jugador_id= $datos['JUGADOR_ID'];
        }
    }


    public static function ExisteFicha($torneo, $fase, $partido){
        $query = "SELECT 'X' FROM FICHA_PARTIDO WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID = :partido_id";

        $datos= [
            'torneo_id' => $torneo,
            'fase_id' => $fase,
            'partido_id' => $partido
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    /**
     * Inserta los datos de la fase en la base de datos en base
     * Si sale bien, devuelve el ID de la fase creada
     * @param $torneo integer
     * @param $fase integer
     * @param $partido integer
     * @param $tipo string
     * @param $equipo integer
     * @param $jugador string
     * @return mixed
     * @throws FichaNoGrabadaException
     */
    public static function InsertarFicha($torneo, $fase, $partido, $tipo, $equipo , $jugador){
        $datos= [
            'torneo_id'   => $torneo,
            'fase_id'     =>  $fase,
            'partido_id' => $partido,
            'tipo_estadistica_id' => $tipo,
            'equipo_id' => $equipo,
            'jugador_id' => $jugador
        ];

        $script = "INSERT INTO FICHA_PARTIDO VALUES (:torneo_id, :fase_id, :partido_id, null,  :tipo_estadistica_id, :equipo_id, :jugador_id)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($datos)) {
            return DBConnection::getConnection()->lastInsertId();
        } else {
            throw new FichaNoGrabadaException("Error al grabar la ficha.");
        }
    }





}