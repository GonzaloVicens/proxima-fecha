<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


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



}