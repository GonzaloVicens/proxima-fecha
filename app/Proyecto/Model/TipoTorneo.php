<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


/**
 * Implementación de la clase TipoTorneo
 */
class TipoTorneo
{
    /**
     * @var integer
     */
    protected $tipo_torneo_id;
    /**
     * @var string
     */
    protected $descripcion;
   
    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($tipoTorneo = null)
    {
        if(!is_null($tipoTorneo)) {
            $this->setTipoTorneo($tipoTorneo);
        }
    }


    public static function existeTipoTorneo($tipo_torneo_id){
        $query = "SELECT 'X' FROM TIPOS_TORNEO WHERE TIPO_TORNEO_ID = :tipo_torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['tipo_torneo_id' => $tipo_torneo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function setTipoTorneo($tipoTorneo)
    {
        $this->tipo_torneo_id = $tipoTorneo;

        $query = "SELECT TIPO_TORNEO_ID, DESCRIPCION FROM TIPOS_TORNEO WHERE TIPO_TORNEO_ID = :tipo_torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['tipo_torneo_id' => $this->tipo_torneo_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->tipo_torneo_id = $datos['TIPO_TORNEO_ID'];
            $this->descripcion = $datos['DESCRIPCION'];
        };
    }


    public function getTipoTorneoId(){
        return $this->tipo_torneo_id;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public static function printRadiosTiposTorneos(){

        $query = "SELECT TIPO_TORNEO_ID , DESCRIPCION FROM TIPOS_TORNEO ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            echo "<div><input type='radio' name='tipoTorneo' value='".$datos['TIPO_TORNEO_ID']."' id='tipoTorneo".$datos['TIPO_TORNEO_ID']."'> <label for='tipoTorneo".$datos['TIPO_TORNEO_ID']."'>". $datos['DESCRIPCION']."</label></div>";
        }       ;
    }
}