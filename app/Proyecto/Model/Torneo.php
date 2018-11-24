<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\TorneoNoGrabadoException;


/**
 * Implementación de la clase Torneo
 */
class Torneo
{
    /**
     * @var integer
     */
    protected $torneo_id;
    /**
     * @var string
     */
    protected $nombre;
    /**
     * @var integer
     */
    protected $deporte_id;

    /**
     * @var string
     */
    protected $tipo_torneo_id;

    /**
     * @var int
     */
    protected $cantidad_equipos;

    /**
     * @var date
     */
    protected $fecha_inicio;

    /**
     * @var integer
     */
    protected $sede_id;

    /**
     * @var array of Equipo;
     */
    protected $equipos;

    /**
     * @var array of Usuario;
     */
    protected $organizadores;


    /**
     * @return int
     */
    public function getCantidadEquipos()
    {
        return $this->cantidad_equipos;
    }

    /**
     * @return int
     */
    public function getDeporteId()
    {
        return $this->deporte_id;
    }

    /**
     * @param int $deporte_id
     */
    public function setDeporteId($deporte_id)
    {
        $this->deporte_id = $deporte_id;
    }




    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($torneo = null)
    {
        if(!is_null($torneo)) {
            $this->setTorneo($torneo);
        }
    }


    public static function existeTorneo($torneo_id){
        $query = "SELECT 'X' FROM TORNEOS WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $torneo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function setTorneo($torneo)
    {
        $this->torneo_id = $torneo;

        $query = "SELECT NOMBRE, DEPORTE_ID, TIPO_TORNEO_ID, CANTIDAD_EQUIPOS, FECHA_INICIO, SEDE_ID FROM TORNEOS WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->deporte_id = $datos['DEPORTE_ID'];
            $this->tipo_torneo_id= $datos['TIPO_TORNEO_ID'];
            $this->cantidad_equipos= $datos['CANTIDAD_EQUIPOS'];
            $this->fecha_inicio= $datos['FECHA_INICIO'];
            $this->sede_id= $datos['SEDE_ID'];
        };
        $this->equipos = [];
        $this->organizadores = [];
    }


    public static function CrearTorneo($nombreParam , $deporteId, $tipoTorneoId, $cantidadEquipos, $fechaInicio, $sedeId, $organizador_id){

        if (!$sedeId) {
            $sedeId = 1;
        }
        $torneo= [
            'nombre' => $nombreParam,
            'deporte_id'   =>  $deporteId,
            'tipo_torneo_id'   =>  $tipoTorneoId,
            'cantidad_equipos'   =>  $cantidadEquipos,
            'fecha_inicio'   =>  $fechaInicio,
            'sede_id'   =>  $sedeId
        ];

        $script = "INSERT INTO TORNEOS VALUES (null, :nombre, :deporte_id, :tipo_torneo_id, :cantidad_equipos, STR_TO_DATE(:fecha_inicio, '%d/%m/%Y'), :sede_id)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($torneo)) {
            $torneoID = DBConnection::getConnection()->lastInsertId();

            $organizador= [
                'torneo_id' => $torneoID,
                'organizador_id'   =>  $organizador_id
            ];
            $script = "INSERT INTO ORGANIZADORES VALUES (:torneo_id, :organizador_id, 1)";
            $stmt = DBConnection::getStatement($script );
            $stmt->execute($organizador);

            return $torneoID;
        } else {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        }
    }

    public function setEquipos()
    {
        $this->equipos = [];
        $query = "SELECT EQUIPO_ID FROM EQUIPOS_TORNEO WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->equipos[] = New Equipo($datos['EQUIPO_ID']);
        };
    }

    public function getTorneoId(){
        return $this->torneo_id;
    }
    public function getEquipos(){
        return $this->equipos;
    }

    public function getNombre(){
        return $this->nombre;
    }

    /**
    * @return date
    */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }


    public function getDescrTipoTorneo(){
        $tipoTorneo = new TipoTorneo($this->tipo_torneo_id);
        return $tipoTorneo->getDescripcion();
    }

    public function getDescrSede()
    {
        $sede = new Sede($this->sede_id);
        return $sede->getNombre();
    }

    public function printTabla($equipoID){
        echo "<table>";
        echo "<thead>";
        echo "<tr><td>Equipos</td><td>Ptos</td><td>PJ</td><td>PG</td><td>PE</td><td>PP</td><td>GF</td><td>GC</td><td>Dif</td></tr>";
        echo "</thead>";
        echo "<tbody>";
        $query = "SELECT A.EQUIPO_ID , B.NOMBRE FROM EQUIPOS_TORNEO A, EQUIPOS B WHERE A.EQUIPO_ID = B.EQUIPO_ID AND A.TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if($datos['EQUIPO_ID'] == $equipoID) {
                $resaltado = "id='EquipoResaltado'";
            }else{
                $resaltado = "";
            };
            echo "<tr ". $resaltado.">";
            echo "<td><a href='../equipos/".$datos['EQUIPO_ID']."' title='Ver Equipo'>". $datos['NOMBRE'] . "</a></td ><td>15</td><td>5</td><td>5</td><td>0</td><td>0</td><td>27</td><td>8</td><td>19</td></tr>";

        }       ;
        echo "</tbody>";
        echo "</table>";
    }


    public  function printEquiposEnLi(){
        foreach ($this->equipos as $equipo) {
             echo "<li>" . $equipo->getNombre()  . "</li>";
        }
    }

    public function tieneEquipos(){
        return !empty($this->equipos[0]);
    }

    public function getLugaresLibres(){
        return $this->cantidad_equipos - count($this->equipos);
    }
}