<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


/**
 * Implementación de la clase Deporte
 */
class Deporte
{
    /**
     * @var integer
     */
    protected $deporte_id;
    /**
     * @var string
     */
    protected $descripcion;
    /**
     * @var integer
     */
    protected $maxJugadores;

    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($deporte = null)
    {
        if(!is_null($deporte)) {
            $this->setDeporte($deporte);
        }
    }


    public static function existeDeporte($deporte_id){
        $query = "SELECT 'X' FROM DEPORTES WHERE DEPORTE_ID = :deporte_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['deporte_id' => $deporte_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function setDeporte($deporte)
    {
        $this->deporte_id = $deporte;

        $query = "SELECT DEPORTE_ID, DESCRIPCION, MAX_JUGADORES FROM DEPORTES WHERE DEPORTE_ID = :deporte_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['deporte_id' => $this->deporte_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->deporte_id = $datos['DEPORTE_ID'];
            $this->descripcion = $datos['DESCRIPCION'];
            $this->maxJugadores = $datos['MAX_JUGADORES'];
        };
    }


    public function getDeporteId(){
        return $this->deporte_id;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public static function printOptionsDeportes(){

        $query = "SELECT DEPORTE_ID , DESCRIPCION FROM DEPORTES ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            echo "<option value='" . $datos['DEPORTE_ID'] . "'>" . $datos['DESCRIPCION']  . "</option>";
        }       ;
    }



}