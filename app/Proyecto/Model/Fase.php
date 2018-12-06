<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


/**
 * Implementación de la clase Fase
 */
class Fase
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
     * @var string
     */
    protected $descripcion;


    /**
     * @var Array of Partido
     */
    protected $partidos;


    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($torneo_id = null, $fase_id = null)
    {
        if(!is_null($torneo_id) && !is_null($fase_id) ) {
            $this->setFase($torneo_id, $fase_id);
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
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descr
     */
    public function setDescripcion($descr)
    {
        $this->descripcion = $descr;
    }


    public function getPartidos(){
        return $this->partidos;
    }


    public function setFase($torneo, $fase)
    {
        $this->torneo_id = $torneo;
        $this->fase_id = $fase;
        $this->partidos = [];

        $param= [
            'torneo_id' => $torneo,
            'fase_id'   => $fase
        ];

        $query = "SELECT DESCRIPCION FROM FASES WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->descripcion= $datos['DESCRIPCION'];

            $query = "SELECT PARTIDO_ID FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id ";
            $stmt = DBConnection::getStatement($query);
            $stmt->execute($param);
            while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $this->partidos[] = new Partido($torneo, $fase, $datos['PARTIDO_ID']) ;
            }

        }
    }


    public static function ExisteFase($torneo, $fase){
        $query = "SELECT 'X' FROM FASES WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id ";

        $datos= [
            'torneo_id' => $torneo,
            'fase_id' => $fase,
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
     * @return mixed
     * @throws FaseNoGrabadaException
     */
    public static function CrearFase($torneo, $fase, $descripcion){
        $datos= [
            'torneo_id'   => $torneo,
            'fase_id'     =>  $fase,
            'descripcion' => $descripcion
        ];

        $script = "INSERT INTO FASES VALUES (:torneo_id, :fase_id, :descripcion)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($datos)) {
            return $fase;
        } else {
            throw new FaseNoGrabadaException("Error al grabar la fase.");
        }
    }


    public function tieneEquipo($equipo_id){
        $query = "SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND :equipo_id IN (LOCAL_ID, VISITA_ID) ";

        $datos= [
            'torneo_id' => $this->torneo_id,
            'fase_id' => $this->fase_id,
            'equipo_id' => $equipo_id
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function insertarPartido($local_id, $visita_id, $arbitro_id, $sede_id, $cancha_id = null  ){
        $nuevoPartido = Partido::InsertarPartido($this->torneo_id , $this->fase_id, $local_id, $visita_id, $arbitro_id, $sede_id, $cancha_id );
        $this->partidos[] = new Partido($this->torneo_id , $this->fase_id, $nuevoPartido ) ;
    }

    public function jugaronEnFaseAnterior( $local_ID, $visita_ID){
        return Partido::ExistePartidoAnteriorAFaseEntre( $this->torneo_id, $this->fase_id, $local_ID, $visita_ID);
    }

}