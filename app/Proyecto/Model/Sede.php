<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\SedeNoGrabadaException;

/**
 * Implementación de la clase Sede
 */
class Sede
{
    /**
     * @var integer
     */
    protected $sede_id;
    /**
     * @var string
     */
    protected $nombre;
    /**
     * @var string
     */
    protected $pais;

    /**
     * @var string
     */
    protected $provincia;

    /**
     * @var string
     */
    protected $codigo_postal;

    /**
     * @var string
     */
    protected $calle;

    /**
     * @var integer
     */
    protected $altura;

    /**
     * @var string
     */
    protected $telefono;

    /**
     * @var string
     */
    protected $detalles;


    /**
     * @var array of Canchas;
     */
    protected $canchas;



    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($sede = null)
    {
        if(!is_null($sede)) {
            $this->setSede($sede);
        }
    }

    public static function CrearSede($nombre, $pais_id, $provincia_id, $codigo_postal, $calle, $altura, $telefono, $detalles){
        $sede= [
            'nombre' => $nombre,
            'pais_id' => $pais_id,
            'provincia_id' => $provincia_id,
            'codigo_postal'   =>  $codigo_postal,
            'calle'   =>  $calle,
            'altura' => $altura,
            'telefono' => $telefono,
            'detalles' => $detalles
        ];

        $script = "INSERT INTO SEDES VALUES ( null, :nombre, :pais_id, :provincia_id, :codigo_postal, :calle, :altura, :telefono, :detalles)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($sede)) {
            $idSede= DBConnection::getConnection()->lastInsertId();
            return $idSede;
        } else {
            throw new SedeNoGrabadaException("Error al grabar la sede.");
        }
    }




    public static function existeSede($sede_id){
        $query = "SELECT 'X' FROM SEDES WHERE SEDE_ID = :sede_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['sede_id' => $sede_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function setSede($sede)
    {
        $this->sede_id = $sede;

        $query = "SELECT NOMBRE, PAIS_ID, PROVINCIA_ID, CODIGO_POSTAL, CALLE, ALTURA, TELEFONO, DETALLES FROM SEDES WHERE SEDE_ID = :sede_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['sede_id' => $this->sede_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->pais_id = $datos['PAIS_ID'];
            $this->provincia_id= $datos['PROVINCIA_ID'];
            $this->codigo_postal= $datos['CODIGO_POSTAL'];
            $this->calle = $datos['CALLE'];
            $this->altura= $datos['ALTURA'];
            $this->telefono = $datos['TELEFONO'];
            $this->detalles = $datos['DETALLES'];
        };
        $this->canchas = [];
    }


    public function setCanchas()
    {
        $this->equipos = [];
        $query = "SELECT CANCHA_ID FROM CANCHAS WHERE SEDE_ID = :sede_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['sede_id' => $this->sede_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->canchas[] = New Cancha($this->sede_id, $datos['CANCHA_ID']);
        };
    }

    public function getSedeId(){
        return $this->sede_id;
    }
    public function getCanchas(){
        return $this->canchas;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function existeCancha($cancha_id){
        $datos = ['sede_id' => $this->sede_id,
                    'cancha_id' => $cancha_id
        ];

        $query = "SELECT 'X' FROM CANCHAS WHERE SEDE_ID = :sede_id AND CANCHA_ID = :cancha_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function insertarCancha($decripcion , $deporte, $precio){
        Cancha::CrearCancha($this->sede_id, $decripcion , $deporte, $precio);
    }


    public static function printOptionsSedes(){

        $query = "SELECT SEDE_ID , NOMBRE FROM SEDES ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            echo "<option value='" . $datos['SEDE_ID'] . "'>" . $datos['NOMBRE']  . "</option>";
        }       ;
    }

}