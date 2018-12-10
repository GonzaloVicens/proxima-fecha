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

        $proximaFecha = self::getProximaFecha($torneo, $fase);

        $datos= [
            'torneo_id'   => $torneo,
            'fase_id'     =>  $fase,
            'descripcion' => $descripcion,
            'fecha' => $proximaFecha
        ];


        $script = "INSERT INTO FASES VALUES (:torneo_id, :fase_id, :descripcion, :fecha )";
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


    public static function getPartidosJugadosEnFase($torneo, $fase){
        $respuesta = [] ;
        $query = "SELECT B.NOMBRE NOMBRE_LOCAL , A.PUNTOS_LOCAL, C.NOMBRE NOMBRE_VISITA, A.PUNTOS_VISITA FROM PARTIDOS A, EQUIPOS B, EQUIPOS C WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND JUGADO = 'Y' AND A.LOCAL_ID = B.EQUIPO_ID AND A.VISITA_ID = C.EQUIPO_ID ";

        $datos= [
            'torneo_id' => $torneo,
            'fase_id' => $fase,
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        while ($resultado = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta[] = $resultado;
        }
        return $respuesta;
    }

    public static function getFasesAnteriores($torneo, $fase){
        $respuesta = [] ;
        $query = "SELECT A.TORNEO_ID TORNEO_ID , A.FASE_ID FASE_ID, B.DESCRIPCION DESCRIPCION, MIN(A.FECHA) FECHA FROM PARTIDOS A, FASES B WHERE A.TORNEO_ID = B.TORNEO_ID AND A.FASE_ID = B.FASE_ID  AND A.TORNEO_ID = :torneo_id AND A.FASE_ID <= :fase_id AND A.JUGADO = 'Y' GROUP BY A.TORNEO_ID, A.FASE_ID, B.DESCRIPCION";

        $datos= [
            'torneo_id' => $torneo,
            'fase_id' => $fase,
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        while ($resultado = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta[] = $resultado;
        }
        return $respuesta;
    }


    public static function getProximaFecha($torneo, $fase){

        $query = "SELECT FECHA_INICIO FROM TORNEOS WHERE TORNEO_ID = :torneo_id ";

        $datos= [
            'torneo_id' => $torneo
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        if ($resultado = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $proximaFecha  = $resultado['FECHA_INICIO'];
        }


        $query = "SELECT MAX(FECHA) FECHA FROM FASES  WHERE TORNEO_ID = :torneo_id AND FASE_ID < :fase_id ";
        $datos= [
            'torneo_id' => $torneo,
            'fase_id' => $fase,
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        if ($resultado = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if (isset($resultado['FECHA'])) {
                $proximaFecha  = $resultado['FECHA'];
            }
        }

        $query = "SELECT CASE DIA_ID WHEN 'D' THEN 0 WHEN 'L' THEN 1 WHEN 'M' THEN 2 WHEN 'X' THEN 3 WHEN 'J' THEN 4 WHEN 'V' THEN 5  ELSE 6 END DIA_ID FROM DIAS_TORNEO WHERE TORNEO_ID = :torneo_id ORDER BY 1";
        $datos= [
            'torneo_id' => $torneo
        ];

        $diasEnNumeros = [];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        while ($resultado = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $diasEnNumeros [] = $resultado['DIA_ID'];
        }


        while (self::existeFaseTorneoEnFecha($torneo, $proximaFecha)  ||  !self::BuscarDiaEnDiasTorneo( date('w', strtotime($proximaFecha )), $diasEnNumeros) ){
            $proximaFecha = date("Y-m-d",strtotime($proximaFecha  ."+ 1 days"));
        }

        return $proximaFecha;
    }


    public static function existeFaseTorneoEnFecha($torneo, $fecha){
        $query = "SELECT 'X' FROM FASES WHERE TORNEO_ID = :torneo_id AND FECHA = :fecha";

        $datos= [
            'torneo_id' => $torneo,
            'fecha' => $fecha
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;

    }


    public static function imprimir($algo){
        echo "<pre>";
        print_r ($algo);
        echo "</pre>";
    }


    protected static function BuscarDiaEnDiasTorneo($dia, $array){
        foreach ($array as $i) {
            if ($dia == $i) {
                Fase::Imprimir("devuelveVerdadero");
                return true;
            }
        }
        Fase::Imprimir("devuelveFalso");
        return false;
    }
}