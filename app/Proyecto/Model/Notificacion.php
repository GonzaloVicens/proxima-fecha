<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\NotificacionNoGrabadaException;
use Proyecto\Exceptions\NotificacionesNoLeidas;

/**
 * Implementación de la clase Notificacion
 */
class Notificacion
{
    /**
     * @var string
     */
    protected $notif_id;
    /**
     * @var string
     */
    protected $usuario_id;

    
    /**
     * @var string
     */
    protected $mensaje;


    /**
     * @var string
     */
    protected $fecha ;

    /**
     * @var string
     */
    protected $hora ;

    /**
     * @var string
     */
    protected $leido;

    /**
     * Mensaje constructor.
     * @param null $mens
     * @param null $datos. Si tiene datos , se crea el usuario con estos datos, sino trae los datos de la base.
     */
    public function __construct($mens = null, $datos = null )
    {
        $this->notif_id = $mens;
        if($datos) {
            $this->usuario_id  = $datos['USUARIO_ID'];
            $this->mensaje = $datos['MENSAJE'];
            $this->fecha = $datos['FECHA'];
            $this->hora = $datos['HORA'];
            $this->leido = $datos['LEIDO'];
        } else {
            $this->setNotificacion();
        };
    }

    /**
     *  Trae de la base los datos del Mensaje instanciado, en base al ID de la isntancia.
     */
    public function setNotificacion()
    {
        $query = "SELECT USUARIO_ID, MENSAJE , FECHA, HORA, LEIDO FROM NOTIFICACIONES WHERE NOTIF_ID = :notif_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['NOTIF_ID' => $this->notif_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->usuario_id  = $datos['USUARIO_ID'];
            $this->mensaje = $datos['MENSAJE'];
            $this->fecha = $datos['FECHA'];
            $this->hora = $datos['HORA'];
            $this->leido = $datos['LEIDO'];
        };
    }

    /**
     * @return string
     */
    public function getUsuarioID(){
        return $this->usuario_id;
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
     * Inserta en la base el Notificacion en base a los datos del parámetro vNotificacion
     * Si logra crearlo, devuelve el ID del mensaje creado
     * @param $vNotificacion
     * @return string
     * @throws NotificacionNoGrabadaException
     */
    public static function CrearNotificacion($usuario ,  $mensaje){
        $fecha = date('Y/m/d');

        $hora = date('H:i:s');


        $mensaje= [
            'usuario_id' => $usuario,
            'mensaje'     => $mensaje,
            'fecha'   =>  $fecha ,
            'hora'   =>  $hora,
        ];

        $script = "INSERT INTO NOTIFICACIONES VALUES (null, :mensaje, :usuario_id, :fecha, :hora, 'N')";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($mensaje)) {
            return DBConnection::getConnection()->lastInsertId();
        } else {
            throw new NotificacionNoGrabadaException("Error al grabar a la notificación.");
        }
    }


    /**
     * Devuelve un array con todos los Notificaciones que tenga el usuario del parámetro
     * @param $usuario
     * @return array
     */
    public static function GetNotificaciones ($usuario)
    {
        $query = "SELECT NOTIF_ID, USUARIO_ID,  MENSAJE, FECHA, HORA, LEIDO FROM NOTIFICACIONES WHERE USUARIO_ID = :usuario_id ORDER BY NOTIF_ID ";

        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario]);
        $notificaciones = [];

        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $notificaciones[] = New Notificacion( $datos['NOTIF_ID'] ,$datos );
        }
        return $notificaciones  ;
    }


    /**
     *  Actualiza el campo LEIDO en base a si el receptor vio los mensajes.
     * @param $usuario_id
     * @throws NotificacionesNoLeidas
     */
    public static function leerNotificaciones($usuario_id)
    {
        $query = "UPDATE NOTIFICACIONES SET LEIDO ='Y' WHERE USUARIO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($query);
        if(!$stmt->execute(['usuario_id' => $usuario_id])) {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
            throw new NotificacionesNoLeidas("Error al leer las notificaciones.");
        }
    }

    /**
     *  Verifica si hay líneas con el campo LEIDO=N en base al emisor y al receptor .
     */
    public static function HayNotificacionesSinLeer( $usuario_id)
    {
        $query = "SELECT DISTINCT 'Y' FROM NOTIFICACIONES WHERE USUARIO_ID = :usuario_id AND LEIDO = 'N'";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id]);

        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }



    /**
     *  Verifica si hay líneas en base al usuario.
     */
    public static function HayNotificaciones($usuario_id)
    {
        $query = "SELECT DISTINCT 'Y' FROM NOTIFICACIONES WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id ]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

}