<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\MensajeNoGrabadoException;
use Proyecto\Exceptions\MensajesNoLeidosException;

/**
 * Implementación de la clase Mensaje
 */
class Mensaje
{
    /**
     * @var string
     */
    protected $mensaje_id;
    /**
     * @var string
     */
    protected $emisor_id;
    /**
     * @var string
     */
    protected $receptor_id;

    /**
     * @var string
     */
    protected $leido;

    /**
     * @var string
     */
    protected $mensaje;

    /**
     * @var string
     */
    protected $torneo_id ;

    /**
     * @var string
     */
    protected $fecha_id ;

    /**
     * @var string
     */
    protected $partido_id ;

    /**
     * @var string
     */
    protected $fecha ;

    /**
     * @var string
     */
    protected $hora ;





    /**
     * Mensaje constructor.
     * @param null $mens
     * @param null $datos. Si tiene datos , se crea el usuario con estos datos, sino trae los datos de la base.
     */
    public function __construct($mens = null, $datos = null )
    {
        $this->mensaje_id = $mens;
        if($datos) {
            $this->emisor_id  = $datos['EMISOR_ID'];
            $this->receptor_id  = $datos['RECEPTOR_ID'];
            $this->leido = $datos['LEIDO'];
            $this->mensaje = $datos['MENSAJE'];
            $this->torneo_id = $datos['TORNEO_ID'];
            $this->fecha_id = $datos['FECHA_ID'];
            $this->partido_id = $datos['PARTIDO_ID'];
            $this->fecha = $datos['FECHA'];
            $this->hora = $datos['HORA'];
        } else {
            $this->setMensaje();
        };
    }

    /**
     *  Trae de la base los datos del Mensaje instanciado, en base al ID de la isntancia.
     */
    public function setMensaje()
    {
        $query = "SELECT EMISOR_ID, RECEPTOR_ID,  MENSAJE , TORNEO_ID, FECHA_ID, PARTIDO_ID, MENSAJE_ORIGINAL_ID, FECHA, HORA, LEIDO FROM MENSAJES WHERE MENSAJE_ID = :mensaje_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['MENSAJE_ID' => $this->mensaje_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->emisor_id  = $datos['EMISOR_ID'];
            $this->receptor_id  = $datos['RECEPTOR_ID'];
            $this->mensaje = $datos['MENSAJE'];
            $this->torneo_id = $datos['TORNEO_ID'];
            $this->fecha_id = $datos['FECHA_ID'];
            $this->partido_id = $datos['PARTIDO_ID'];
            $this->fecha = $datos['FECHA'];
            $this->hora = $datos['HORA'];
            $this->leido = $datos['LEIDO'];
        };
    }

    /**
     * @return string
     */
    public function getEmisorID(){
        return $this->emisor_id;
    }

    /**
     * @return string
     */
    public function getReceptorID(){
        return $this->receptor_id;
    }

    /**
     * @return string
     */
    public function getLeido(){
        return $this->leido;
    }


    /**
     * @return string
     */
    public function getMensaje(){
        return $this->mensaje;
    }



    /**
     * Inserta en la base el Mensaje en base a los datos del parámetro vMensaje
     * Si logra crearlo, devuelve el ID del mensaje creado
     * @param $vMensaje
     * @return string
     * @throws MensajeNoGrabadoException
     */
    public static function CrearMensaje($vMensaje){

        if (empty($vMensaje['torneo_id'])){
            $vMensaje['torneo_id'] = 0;
        }

        if (empty($vMensaje['fecha_id'])){
            $vMensaje['fecha_id'] = 0;
        }

        if (empty($vMensaje['partido_id'])){
            $vMensaje['partido_id'] = 0;
        }


        if (empty($vMensaje['fecha'])){
            $vMensaje['fecha'] = date('Y/m/d');
        }

        if (empty($vMensaje['hora'])){
            $vMensaje['hora'] = date('H:i:s');
        }

        $mensaje= [
            'emisor_id' => $vMensaje['usuario_id'],
            'receptor_id'   =>  $vMensaje['contacto_id'],
            'mensaje'     => $vMensaje['mensaje'],
            'torneo_id'   =>  $vMensaje['torneo_id'],
            'fecha_id'   =>  $vMensaje['fecha_id'],
            'partido_id'   =>  $vMensaje['partido_id'],
            'fecha'   =>  $vMensaje['fecha'],
            'hora'   =>  $vMensaje['hora'],
        ];

        $script = "INSERT INTO MENSAJES VALUES (null, :mensaje, :emisor_id, :receptor_id, :torneo_id, :fecha_id, :partido_id , :fecha, :hora, 'N')";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($mensaje)) {
            return DBConnection::getConnection()->lastInsertId();
        } else {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";

            throw new MensajeNoGrabadoException("Error al grabar el mensaje.");
        }
    }


    /**
     * Devuelve un array con todos los Mensajes que tengan se intercambien entre los usuarios pasados por parámetros
     * @param $emisor
     * @param $receptor
     * @return array
     */
    public static function GetConversacion ($emisor, $receptor)
    {
        $query = "SELECT MENSAJE_ID, EMISOR_ID, RECEPTOR_ID,  MENSAJE , TORNEO_ID, FECHA_ID, PARTIDO_ID, FECHA, HORA, LEIDO FROM MENSAJES WHERE (EMISOR_ID = :emisor_id AND RECEPTOR_ID = :receptor_id ) OR (EMISOR_ID = :receptor_id AND RECEPTOR_ID = :emisor_id ) ORDER BY MENSAJE_ID ";

        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['emisor_id' => $emisor, 'receptor_id' => $receptor]);
        $mensajes = [];

        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $mensajes  [] = New Mensaje( $datos['MENSAJE_ID'] ,$datos );
        }
        return $mensajes  ;
    }


    /**
     *  Actualiza el campo LEIDO en base a si el receptor vio los mensajes.
     * @param $usuario_id
     * @param $amigo_id
     * @throws MensajesNoLeidosException
     */
    public static function leerMensajes($usuario_id, $amigo_id)
    {
        $query = "UPDATE MENSAJES SET LEIDO ='Y' WHERE EMISOR_ID = :amigo_id AND RECEPTOR_ID = :usuario_id";
        $stmt = DBConnection::getStatement($query);
        if(!$stmt->execute(['usuario_id' => $usuario_id, 'amigo_id'=> $amigo_id ])) {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
            throw new MensajesNoLeidosException("Error al leer los mensajes.");
        }
    }

    /**
     *  Verifica si hay líneas con el campo LEIDO=N en base al emisor y al receptor .
     */
    public static function HayMensajesSinLeer( $receptor_id, $emisor_id)
    {
        if ($emisor_id != $receptor_id) {
            $query = "SELECT DISTINCT 'Y' FROM MENSAJES WHERE EMISOR_ID = :emisor_id AND RECEPTOR_ID = :receptor_id AND LEIDO = 'N'";
        }else {
            $query = "SELECT DISTINCT 'Y' FROM MENSAJES WHERE :receptor_id  = :emisor_id AND RECEPTOR_ID = :receptor_id AND LEIDO = 'N'";
        }
         $stmt = DBConnection::getStatement($query);
        $stmt->execute(['emisor_id' => $emisor_id, 'receptor_id' => $receptor_id ]);

        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }



    /**
     *  Verifica si hay líneas en base al emisor y al receptor .
     */
    public static function HayMensajesDeUsuario($usuario_id)
    {
        $query = "SELECT DISTINCT 'Y' FROM MENSAJES WHERE EMISOR_ID = :usuario_id OR RECEPTOR_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id ]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public static function GetContactosDeMensajesDeUsuario ($usuario){
        $query = "SELECT RECEPTOR_ID  USUARIO_ID FROM MENSAJES WHERE EMISOR_ID = :emisor_id UNION SELECT EMISOR_ID USUARIO_ID FROM MENSAJES WHERE RECEPTOR_ID = :emisor_id  ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['emisor_id' => $usuario]);
        $contactos = [];

        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $contactos [] = New Usuario( $datos['USUARIO_ID'] ,$datos );
        }
        return $contactos ;
    }

}