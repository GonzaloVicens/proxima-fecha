<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\PartidoNoGrabadoException;


/**
 * Implementación de la clase Partido
 */
class Partido
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
    protected $local_id;

    /**
     * @var integer
     */
    protected $visita_id;

    /**
     * @var date
     */
    protected $fecha;

    /**
     * @var time
     */
    protected $hora;

    /**
     * @var string
     */
    protected $arbitro_id;

    /**
     * @var integer
     */
    protected $puntos_local;

    /**
     * @var integer
     */
    protected $puntos_visita;

    /**
     * @var integer
     */
    protected $sede_id;

    /**
     * @var integer
     */
    protected $cancha_id;

    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($torneo_id = null, $fase_id = null, $partido_id =null)
    {
        if(!is_null($torneo_id) && !is_null($fase_id) && !is_null($partido_id)) {
            $this->setPartido($torneo_id, $fase_id, $partido_id);
        }
    }

    /**
     * @return int
     */
    public function getTorneoId()
    {
        return $this->torneo_id;
    }

    /**
     * @param int $torneo_id
     */
    public function setTorneoId($torneo_id)
    {
        $this->torneo_id = $torneo_id;
    }

    /**
     * @return int
     */
    public function getFaseId()
    {
        return $this->fase_id;
    }

    /**
     * @param int $fase_id
     */
    public function setFaseId($fase_id)
    {
        $this->fase_id = $fase_id;
    }

    /**
     * @return int
     */
    public function getPartidoId()
    {
        return $this->partido_id;
    }

    /**
     * @param int $partido_id
     */
    public function setPartidoId($partido_id)
    {
        $this->partido_id = $partido_id;
    }

    /**
     * @return int
     */
    public function getLocalId()
    {
        return $this->local_id;
    }

    /**
     * @param int $local_id
     */
    public function setLocalId($local_id)
    {
        $this->local_id = $local_id;
    }

    /**
     * @return int
     */
    public function getVisitaId()
    {
        return $this->visita_id;
    }

    /**
     * @param int $visita_id
     */
    public function setVisitaId($visita_id)
    {
        $this->visita_id = $visita_id;
    }

    /**
     * @return date
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param date $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return time
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param time $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * @return string
     */
    public function getArbitroId()
    {
        return $this->arbitro_id;
    }

    /**
     * @param string $arbitro_id
     */
    public function setArbitroId($arbitro_id)
    {
        $this->arbitro_id = $arbitro_id;
    }

    /**
     * @return int
     */
    public function getPuntosLocal()
    {
        return $this->puntos_local;
    }

    /**
     * @param int $puntos_local
     */
    public function setPuntosLocal($puntos_local)
    {
        $this->puntos_local = $puntos_local;
    }

    /**
     * @return int
     */
    public function getPuntosVisita()
    {
        return $this->puntos_visita;
    }

    /**
     * @param int $puntos_visita
     */
    public function setPuntosVisita($puntos_visita)
    {
        $this->puntos_visita = $puntos_visita;
    }

    /**
     * @return int
     */
    public function getSedeId()
    {
        return $this->sede_id;
    }

    /**
     * @param int $sede_id
     */
    public function setSedeId($sede_id)
    {
        $this->sede_id = $sede_id;
    }

    /**
     * @return int
     */
    public function getCanchaId()
    {
        return $this->cancha_id;
    }

    /**
     * @param int $cancha_id
     */
    public function setCanchaId($cancha_id)
    {
        $this->cancha_id = $cancha_id;
    }




    public function setPartido($torneo, $fase, $partido)
    {
        $this->torneo_id = $torneo;
        $this->fase_id = $fase;
        $this->partido_id = $partido;

        $datos= [
            'torneo_id' =>$this->torneo_id,
            'fase_id' => $this->fase_id,
            'partido_id' => $this->partido_id
        ];

        $query = "SELECT LOCAL_ID, VISITA_ID, FECHA, HORA, ARBITRO_ID, PUNTOS_LOCAL, PUNTOS_VISITA, SEDE_ID, CANCHA_ID FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID = :partido_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->local_id = $datos['LOCAL_ID'];
            $this->visita_id = $datos['VISITA_ID'];
            $this->fecha= $datos['FECHA'];
            $this->hora= $datos['HORA'];
            $this->arbitro_id= $datos['ARBITRO_ID'];
            $this->puntos_local= $datos['PUNTOS_LOCAL'];
            $this->puntos_visita= $datos['PUNTOS_VISITA'];
            $this->sede_id= $datos['SEDE_ID'];
            $this->cancha_id= $datos['CANCHA_ID'];
        };
    }


    public static function ExistePartidoAnteriorAFaseEntre($torneo, $fase, $local_ID, $visita_ID){
        $query = "SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID < :fase_id AND LOCAL_ID = :local_id AND VISITA_ID = :visita_id";
        $query .= " UNION SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID < :fase_id AND LOCAL_ID = :visita_id AND VISITA_ID = :local_id ";

        $datos= [
            'torneo_id' => $torneo,
            'fase_id' => $fase,
            'local_id' => $local_ID,
            'visita_id' => $visita_ID
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public static function ExistePartidoEnTorneoEntre ($torneo,  $local_ID, $visita_ID){
        $query = "SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND LOCAL_ID = :local_id AND VISITA_ID = :visita_id";
        $query .= " UNION SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND LOCAL_ID = :visita_id AND VISITA_ID = :local_id ";

        $datos= [
            'torneo_id' => $torneo,
            'local_id' => $local_ID,
            'visita_id' => $visita_ID
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    /**
     * Inserta los datos del partido en la base de datos en base
     * Si sale bien, devuelve el ID del partido creada
     * @param $torneo integer
     * @param $fase integer
     * @param $local_id integer
     * @param $visita_id integer
     * @param $arbitro_id string
     * @param $sede_id integer
     * @param $cancha_id integer
     * @return mixed
     * @throws PartidoNoGrabadoException
     */

    public static function InsertarPartido($torneo, $fase, $local_id, $visita_id, $arbitro_id, $sede_id = null, $cancha_id = null){

        if (!isset($cancha_id)){
            $cancha_id = 1;
        }
        $datos= [
            'torneo_id'   => $torneo,
            'fase_id'     => $fase,
            'local_id'    => $local_id,
            'visita_id'   => $visita_id,
            'arbitro_id'  => $arbitro_id,
            'sede_id'     => $sede_id,
            'cancha_id'     => $cancha_id
        ];

        $script = "INSERT INTO PARTIDOS VALUES (:torneo_id, :fase_id, null, :local_id, :visita_id, null, null, :arbitro_id, 0,0, ' ', ' ' , :sede_id, :cancha_id)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($datos)) {
            return $fase;
        } else {
            print_r($stmt->errorInfo());
            throw new PartidoNoGrabadoException("Error al grabar el partido.");
        }
    }

    public function getLocalName(){
        return Equipo::getNombrePorID($this->local_id);
    }

    public function getVisitaName(){
        return Equipo::getNombrePorID($this->visita_id);
    }

}