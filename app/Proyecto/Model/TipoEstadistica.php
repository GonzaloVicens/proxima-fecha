<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


/**
 * Implementación de la clase TipoEstadistica
 */
class TipoEstadistica
{
    /**
     * @var integer
     */
    protected $tipo_estadistica_id;
    /**
     * @var string
     */
    protected $descripcion;
   
    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($tipoEstadistica = null)
    {
        if(!is_null($tipoEstadistica)) {
            $this->setTipoEstadistica($tipoEstadistica);
        }
    }


    public static function existeTipoEstadistica($tipo_estadistica_id){
        $query = "SELECT 'X' FROM TIPOS_ESTADISTICA WHERE TIPO_ESTADISTICA_ID = :tipo_estadistica_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['tipo_estadistica_id' => $tipo_estadistica_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function setTipoEstadistica($tipoEstadistica)
    {
        $this->tipo_estadistica_id = $tipoEstadistica;

        $query = "SELECT DESCRIPCION FROM TIPOS_ESTADISTICA WHERE TIPO_ESTADISTICA_ID = :tipo_estadistica_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['tipo_estadistica_id' => $this->tipo_estadistica_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->descripcion = $datos['DESCRIPCION'];
        };
    }


    public function getTipoEstadisticaId(){
        return $this->tipo_estadistica_id;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public static function printOptions(){

        $query = "SELECT TIPO_ESTADISTICA_ID , DESCRIPCION FROM TIPOS_ESTADISTICA WHERE TIPO_ESTADISTICA_ID != 'C' ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            echo "<option value='" . $datos['TIPO_ESTADISTICA_ID'] . "'>" . $datos['DESCRIPCION']  . "</option>";
        } ;
    }
}