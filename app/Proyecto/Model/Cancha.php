<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\CanchaNoGrabadaException;
use Proyecto\Session\Session;

/**
 * Implementación de la clase Cancha
 */
class Cancha
{
    /**
     * @var integer
     */
    protected $sede_id;

    /**
     * @var integer
     */
    protected $cancha_id;


    /**
     * @var string
     */
    protected $decripcion;

    
    /**
     * @var string
     */
    protected $deporte_id;


    protected $deporte_descr;


    /**
     * @var integer
     */
    protected $precio;

    /**
     * Usuario constructor.
     * @param null $id
     */
    public function __construct($sede_id = null, $cancha_id = null)
    {
        if(!is_null($sede_id) && !is_null($cancha_id)) {
            $this->setCancha($sede_id, $cancha_id);
        }
    }


    public static function CrearCancha($sede, $decripcion , $deporte, $precio){
        $cancha= [
            'sede_id' => $sede,
            'decripcion' => $decripcion,
            'deporte_id'   =>  $deporte,
            'precio'   =>  $precio
        ];

        $script = "INSERT INTO CANCHAS VALUES (:sede, null, :decripcion, :deporte_id, :precio)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($cancha)) {
            $idCancha = DBConnection::getConnection()->lastInsertId();
            return $idCancha;
        } else {
            throw new CanchaNoGrabadaException("Error al grabar la cancha.");
        }
    }


    public static function existeCancha($cancha_id){
        $query = "SELECT 'X' FROM CANCHAS WHERE CANCHA_ID = :cancha_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['cancha_id' => $cancha_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function setCancha($sede, $cancha)
    {

        $this->sede_id = $sede;
        $this->cancha_id = $cancha;

        $query = "SELECT A.DESCRIPCION DESCR_CANCHA, A.DEPORTE_ID DEPORTE_ID, A.PRECIO PRECIO , B.DESCRIPCION DESCR_DEPORTE FROM CANCHAS A, DEPORTES B WHERE A.DEPORTE_ID = B.DEPORTE_ID AND A.SEDE_ID = :sede AND A.CANCHA_ID = :cancha ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['sede' => $sede, 'cancha'   =>  $cancha]);

        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->decripcion = $datos['DESCR_CANCHA'];
            $this->deporte_id = $datos['DEPORTE_ID'];
            $this->deporte_descr = $datos['DESCR_DEPORTE'];
            $this->precio = $datos['PRECIO'];
        };
    }


    public function getSedeId()
    {
        return $this->sede_id;
    }

    public function getCanchaId()
    {
        return $this->cancha_id;
    }

    public function getNombre()
    {
        return $this->decripcion;
    }

    public function getDeporteID()
    {
        return $this->deporte_id;
    }

    public function getDeporteDescr()
    {
        return $this->deporte_descr;
    }


    public function getPrecio()
    {
        return $this->precio;
    }



}
