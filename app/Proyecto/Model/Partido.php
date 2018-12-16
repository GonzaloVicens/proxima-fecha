<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Session\Session;
use Proyecto\Exceptions\PartidoNoGrabadoException;
use Proyecto\Model\Ficha;

/**
 * Implementación de la clase Partido
 */
class Partido
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
     * @var integer
     */
    protected $partido_id;

    /**
     * @var integer
     */
    protected $local_id;

    /**
     * @var integer
     */
    protected $visita_id;

    /**
     * @var date
     */
    protected $fecha;

    /**
     * @var time
     */
    protected $hora;

    /**
     * @var string
     */
    protected $arbitro_id;

    /**
     * @var integer
     */
    protected $puntos_local;

    /**
     * @var integer
     */
    protected $puntos_visita;

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
    protected $jugado;


    /**
     * @var Array of FichaPartido
     */
    protected $fichas;

    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($torneo_id = null, $fase_id = null, $partido_id =null)
    {
        if(!is_null($torneo_id) && !is_null($fase_id) && !is_null($partido_id)) {
            $this->setPartido($torneo_id, $fase_id, $partido_id);
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
     * @return int
     */
    public function getPartidoId()
    {
        return $this->partido_id;
    }

    /**
     * @param int $partido_id
     */
    public function setPartidoId($partido_id)
    {
        $this->partido_id = $partido_id;
    }

    /**
     * @return int
     */
    public function getLocalId()
    {
        return $this->local_id;
    }

    /**
     * @param int $local_id
     */
    public function setLocalId($local_id)
    {
        $this->local_id = $local_id;
    }

    /**
     * @return int
     */
    public function getVisitaId()
    {
        return $this->visita_id;
    }

    /**
     * @param int $visita_id
     */
    public function setVisitaId($visita_id)
    {
        $this->visita_id = $visita_id;
    }

    /**
     * @return date
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param date $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return time
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * @param time $hora
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    /**
     * @return string
     */
    public function getArbitroId()
    {
        return $this->arbitro_id;
    }

    /**
     * @param string $arbitro_id
     */
    public function setArbitroId($arbitro_id)
    {
        $this->arbitro_id = $arbitro_id;
    }

    public function getArbitroDescr(){
        return Usuario::getNombreDeUsuario($this->arbitro_id);
    }

    /**
     * @return int
     */
    public function getPuntosLocal()
    {
        return $this->puntos_local;
    }

    /**
     * @param int $puntos_local
     */
    public function setPuntosLocal($puntos_local)
    {
        $this->puntos_local = $puntos_local;
    }

    /**
     * @return int
     */
    public function getPuntosVisita()
    {
        return $this->puntos_visita;
    }

    /**
     * @param int $puntos_visita
     */
    public function setPuntosVisita($puntos_visita)
    {
        $this->puntos_visita = $puntos_visita;
    }

    /**
     * @return int
     */
    public function getSedeId()
    {
        return $this->sede_id;
    }

    /**
     * @param int $sede_id
     */
    public function setSedeId($sede_id)
    {
        $this->sede_id = $sede_id;
    }

    /**
     * @return int
     */
    public function getCanchaId()
    {
        return $this->cancha_id;
    }

    /**
     * @param int $cancha_id
     */
    public function setCanchaId($cancha_id)
    {
        $this->cancha_id = $cancha_id;
    }

    /**
    * @return Array of Fichas
    */
    public function getFichas(){
        $this->setFichas();
        return $this->fichas;
    }


     public function setFichas()
     {
         $this->fichas = [];

         $datos= [
             'torneo_id' =>$this->torneo_id,
             'fase_id' => $this->fase_id,
             'partido_id' => $this->partido_id
         ];

         $query = "SELECT FICHA_ID FROM FICHA_PARTIDO WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID = :partido_id";
         $stmt = DBConnection::getStatement($query);
         $stmt->execute($datos);
         WHILE ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
             $this->fichas[] = New Ficha($this->torneo_id, $this->fase_id, $this->partido_id, $datos['FICHA_ID']);
         };
     }

    /**
     * @param $torneo
     * @param $fase
     * @param $partido
     *
     */

    public function setPartido($torneo, $fase, $partido)
    {
        $this->torneo_id = $torneo;
        $this->fase_id = $fase;
        $this->partido_id = $partido;

        $datos= [
            'torneo_id' =>$this->torneo_id,
            'fase_id' => $this->fase_id,
            'partido_id' => $this->partido_id
        ];

        $query = "SELECT LOCAL_ID, VISITA_ID, FECHA, HORA, ARBITRO_ID, PUNTOS_LOCAL, PUNTOS_VISITA, SEDE_ID, CANCHA_ID, JUGADO FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID = :partido_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->local_id = $datos['LOCAL_ID'];
            $this->visita_id = $datos['VISITA_ID'];
            $this->fecha= $datos['FECHA'];
            $this->hora= $datos['HORA'];
            $this->arbitro_id= $datos['ARBITRO_ID'];
            $this->puntos_local= $datos['PUNTOS_LOCAL'];
            $this->puntos_visita= $datos['PUNTOS_VISITA'];
            $this->sede_id= $datos['SEDE_ID'];
            $this->cancha_id= $datos['CANCHA_ID'];
            $this->jugado= $datos['JUGADO'];
        };

        $this->setFichas();
    }


    public static function ExistePartidoAnteriorAFaseEntre($torneo, $fase, $local_ID, $visita_ID){
        $query = "SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID < :fase_id AND LOCAL_ID = :local_id AND VISITA_ID = :visita_id";
        $query .= " UNION SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID < :fase_id AND LOCAL_ID = :visita_id AND VISITA_ID = :local_id ";

        $datos= [
            'torneo_id' => $torneo,
            'fase_id' => $fase,
            'local_id' => $local_ID,
            'visita_id' => $visita_ID
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public static function ExistePartidoEnTorneoEntre ($torneo,  $local_ID, $visita_ID){
        $query = "SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND LOCAL_ID = :local_id AND VISITA_ID = :visita_id";
        $query .= " UNION SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND LOCAL_ID = :visita_id AND VISITA_ID = :local_id ";

        $datos= [
            'torneo_id' => $torneo,
            'local_id' => $local_ID,
            'visita_id' => $visita_ID
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    /**
     * Inserta los datos del partido en la base de datos en base
     * Si sale bien, devuelve el ID del partido creada
     * @param $torneo integer
     * @param $fase integer
     * @param $local_id integer
     * @param $visita_id integer
     * @param $arbitro_id string
     * @param $sede_id integer
     * @param $cancha_id integer
     * @return mixed
     * @throws PartidoNoGrabadoException
     */

    public static function InsertarPartido($torneo, $fase, $local_id, $visita_id, $arbitro_id, $fecha, $sede_id = null, $cancha_id = null){

        //Busco la ultima ficha creada para el partido;
        $nuevoPartido= 0;
        $query = "SELECT MAX(PARTIDO_ID) PARTIDO_ID FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id ";
        $datos= [
            'torneo_id' => $torneo,
            'fase_id' => $fase,
        ];
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);

        IF ($ultimoPartido = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $nuevoPartido = $ultimoPartido['PARTIDO_ID'];
        }

        $nuevoPartido++;

        if (!isset($cancha_id)){
            $cancha_id = 1;
        }

        $datos= [
            'torneo_id'   => $torneo,
            'fase_id'     => $fase,
            'partido_id'  => $nuevoPartido,
            'local_id'    => $local_id,
            'visita_id'   => $visita_id,
            'arbitro_id'  => $arbitro_id,
            'fecha'       => $fecha,
            'sede_id'     => $sede_id,
            'cancha_id'   => $cancha_id
        ];

        $script = "INSERT INTO PARTIDOS VALUES (:torneo_id, :fase_id, :partido_id, :local_id, :visita_id, :fecha, null, :arbitro_id, 0,0, ' ', ' ' , :sede_id, :cancha_id, 'N')";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($datos)) {
            $partidoCreado = DBConnection::getConnection()->lastInsertId();

            $notificacion = ['usuario_id' => $arbitro_id,
                'torneo_id' => $torneo,
                'fase_id' => $fase,
                'partido_id' => $partidoCreado,
                'mensaje' => "Has Sido elegido como árbitro en el partido entre " . Equipo::getNombrePorID($local_id) . " y " . Equipo::getNombrePorID($visita_id) . " del torneo " .  Torneo::GetNombreTorneoPorID($torneo)];
            Notificacion::CrearNotificacion($notificacion);

            foreach (Equipo::GetJugadoresDelEquipo($local_id) as $jugador) {
                $notificacion = ['usuario_id' => $jugador,
                    'torneo_id' => $torneo,
                    'fase_id' => $fase,
                    'partido_id' => $partidoCreado,
                    'mensaje' => "Se ha creado el partido entre tu equipo " . Equipo::getNombrePorID($local_id) . " y " . Equipo::getNombrePorID($visita_id) . " en el torneo " .  Torneo::GetNombreTorneoPorID($torneo)];
                Notificacion::CrearNotificacion($notificacion);
            }

            foreach (Equipo::GetJugadoresDelEquipo($visita_id) as $jugador) {
                $notificacion = ['usuario_id' => $jugador,
                    'torneo_id' => $torneo,
                    'fase_id' => $fase,
                    'partido_id' => $partidoCreado,
                    'mensaje' => "Se ha creado el partido entre tu equipo " . Equipo::getNombrePorID($visita_id) . " y " . Equipo::getNombrePorID($local_id) . " en el torneo " .  Torneo::GetNombreTorneoPorID($torneo)];
                Notificacion::CrearNotificacion($notificacion);
            }

            return $partidoCreado;
        } else {
            print_r($stmt->errorInfo());
            throw new PartidoNoGrabadoException("Error al grabar el partido.");
        }
    }

    public function getLocalNombre(){
        return Equipo::getNombrePorID($this->local_id);
    }

    public function getVisitaNombre(){
        return Equipo::getNombrePorID($this->visita_id);
    }


    public function esArbitro ($usuario) {
        $query = "SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID = :partido_id AND ARBITRO_ID = :arbitro_id";

        $datos= [
            'torneo_id' => $this->torneo_id,
            'fase_id' => $this->fase_id,
            'partido_id' => $this->partido_id,
            'arbitro_id' => $usuario
        ];

        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function fueJugado(){
        return $this->jugado == 'Y';
    }

    public function reasignarArbitro($arbitro){
        $datos= [
            'torneo_id'   => $this->torneo_id,
            'fase_id'     => $this->fase_id,
            'partido_id'    => $this->partido_id,
            'arbitro_id'  => $arbitro
        ];
        $script = "UPDATE PARTIDOS SET ARBITRO_ID = :arbitro_id WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID =  :partido_id ";
        $stmt = DBConnection::getStatement($script );
        if( $stmt->execute($datos)) {
            $notificacion = ['usuario_id' => $arbitro,
                    'torneo_id' => $this->torneo_id,
                    'fase_id' => $this->fase_id,
                    'partido_id' => $this->partido_id,
                    'mensaje' => "Has Sido elegido como árbitro en el partido entre " . $this->getLocalNombre() . " y " . $this->getVisitaNombre() . " del torneo " .  Torneo::GetNombreTorneoPorID($this->torneo_id)];
            Notificacion::CrearNotificacion($notificacion);
        } else {
            print_r($stmt->errorInfo());
            throw new PartidoNoGrabadoException("Error al grabar el partido.");
        }
    }


    public static function existePartido($torneo_id, $fase_id, $partido_id){
        $datos= [
            'torneo_id'   => $torneo_id,
            'fase_id'     => $fase_id,
            'partido_id'    => $partido_id
        ];

        $query = "SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID = :partido_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function actualizar(){
        $this->setPartido($this->torneo_id, $this->fase_id, $this->partido_id);
        Session::set('partido', $this);
    }



    public function getInfoPartido()
    {
        $respuesta = [ 'torneo_id' => "",
            'nombre' => "",
            'deporte_id' => "",
            'deporte_descr' => "",
            'tipo_torneo_id' => "",
            'tipo_descr' => "",
            'cantidad_equipos' => "",
            'fecha_inicio' => "",
            'sede_id' => "",
            'sede_descr' => "",
            'estado_torneo_id' => "",
            'estado_descr' => "",
            'fase_id' => "",
            'fase_descr' => ""
        ];

        $query = "SELECT A.TORNEO_ID, A.NOMBRE, A.DEPORTE_ID, B.DESCRIPCION DEPORTE_DESCR, A.TIPO_TORNEO_ID, C.DESCRIPCION TIPO_DESCR,A.CANTIDAD_EQUIPOS, A.FECHA_INICIO, A.SEDE_ID, D.NOMBRE SEDE_DESCR, A.ESTADO_TORNEO_ID , E.DESCRIPCION ESTADO_DESCR, F.FASE_ID, F.DESCRIPCION FASE_DESCR FROM TORNEOS A,  DEPORTES B, TIPOS_TORNEO C,  SEDES D, ESTADOS_TORNEO E, FASES F WHERE A.TORNEO_ID = :torneo_id AND A.DEPORTE_ID = B.DEPORTE_ID AND A.TIPO_TORNEO_ID = C.TIPO_TORNEO_ID AND A.SEDE_ID = D.SEDE_ID AND A.ESTADO_TORNEO_ID = E.ESTADO_TORNEO_ID AND F.TORNEO_ID = A.TORNEO_ID  AND F.FASE_ID = :fase_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id, 'fase_id' => $this->fase_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta = [
                'torneo_id' => $datos['TORNEO_ID'],
                'nombre' => $datos['NOMBRE'],
                'deporte_id' => $datos['DEPORTE_ID'],
                'deporte_descr' => $datos['DEPORTE_DESCR'],
                'tipo_torneo_id' => $datos['TIPO_TORNEO_ID'],
                'tipo_descr' => $datos['TIPO_DESCR'],
                'cantidad_equipos' => $datos['CANTIDAD_EQUIPOS'],
                'fecha_inicio' => $datos['FECHA_INICIO'],
                'sede_id' => $datos['SEDE_ID'],
                'sede_descr' => $datos['SEDE_DESCR'],
                'estado_torneo_id' => $datos['ESTADO_TORNEO_ID'],
                'estado_descr' => $datos['ESTADO_DESCR'],
                'fase_id' => $datos['FASE_ID'],
                'fase_descr' => $datos['FASE_DESCR']
            ];
        };
        return $respuesta;
    }


    public function agregarFicha($tipo_Ficha, $equipo_Ficha, $jugador_Ficha){

        $nuevaFicha = Ficha::InsertarFicha($this->torneo_id , $this->fase_id, $this->partido_id, $tipo_Ficha, $equipo_Ficha, $jugador_Ficha);
        $this->fichas[] = new Ficha($this->torneo_id , $this->fase_id, $this->partido_id, $nuevaFicha) ;

        if ($tipo_Ficha == "G") {
            if ($equipo_Ficha == $this->local_id) {
                $this->SumarPunto($this->local_id);
            } else {
                $this->SumarPunto($this->visita_id);
            }
        };
        if ($tipo_Ficha == "X") {
            if ($equipo_Ficha == $this->local_id) {
                $this->SumarPunto($this->visita_id);
            } else {
                $this->SumarPunto($this->local_id);

            }
        };
    }

    protected function SumarPunto($equipoASumar){
        if ($equipoASumar== $this->local_id) {
            $this->puntos_local++;
        } else {
            $this->puntos_visita++;
        }

        $datos= [
            'torneo_id'     => $this->torneo_id,
            'fase_id'       => $this->fase_id,
            'partido_id'    => $this->partido_id,
            'puntos_local'  => $this->puntos_local,
            'puntos_visita' => $this->puntos_visita
        ];

        $script = "UPDATE PARTIDOS SET PUNTOS_LOCAL = :puntos_local , PUNTOS_VISITA = :puntos_visita , JUGADO = 'Y' WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID =  :partido_id ";
        $stmt = DBConnection::getStatement($script );
        if(! $stmt->execute($datos)) {
            print_r($stmt->errorInfo());
            throw new PartidoNoGrabadoException("Error al grabar el partido.");
        }


        if (Torneo::esCopa($this->torneo_id)) {
            $ganador = 0;
            if ($this->puntos_local > $this->puntos_visita) {
                $ganador = $this->local_id;
            }

            if ($this->puntos_local < $this->puntos_visita) {
                $ganador = $this->visita_id;
            }

            Partido::ActualizarPartidoFase($this->torneo_id, $this->fase_id  ,  $this->partido_id,  $ganador );
        }

        Torneo::FinalizarTorneo($this->torneo_id);
    }

    public static function ActualizarPartidoFase($torneo , $fase , $partido, $equipo ){
        $faseAActualizar = $fase +1 ;
        if ( Fase::ExisteFase($torneo , $faseAActualizar )) {

            $partidoFaseAActualizar = intdiv($partido + 1, 2);

            $datos = [
                'torneo_id' => $torneo,
                'fase_id' => $faseAActualizar,
                'partido_id' => $partidoFaseAActualizar,
                'equipo_id' => $equipo
            ];


            if (($partido % 2) == 1) {
                $script = "UPDATE PARTIDOS SET LOCAL_ID = :equipo_id WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID =  :partido_id ";
            } else {
                $script = "UPDATE PARTIDOS SET VISITA_ID = :equipo_id WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID =  :partido_id ";
            }

            $stmt = DBConnection::getStatement($script );
            if( $stmt->execute($datos)) {
                $script = "SELECT ARBITRO_ID, LOCAL_ID, VISITA_ID FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND PARTIDO_ID =  :partido_id AND LOCAL_ID != ' ' AND  VISITA_ID != ' ' ";

                $stmt = DBConnection::getStatement($script );
                $stmt->execute($datos);
                if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $notificacion = ['usuario_id' => $datos['ARBITRO_ID'],
                        'torneo_id' => $torneo,
                        'fase_id' => $faseAActualizar,
                        'partido_id' => $partidoFaseAActualizar,
                        'mensaje' => "Has Sido elegido como árbitro en el partido entre " . Equipo::getNombrePorID($datos['LOCAL_ID']) . " y " . Equipo::getNombrePorID($datos['VISITA_ID']) . " del torneo " . Torneo::GetNombreTorneoPorID($torneo)];
                    Notificacion::CrearNotificacion($notificacion);

                    foreach (Equipo::GetJugadoresDelEquipo($datos['LOCAL_ID']) as $jugador) {
                        $notificacion = ['usuario_id' => $jugador,
                            'torneo_id' => $torneo,
                            'fase_id' => $faseAActualizar,
                            'partido_id' => $partidoFaseAActualizar,
                            'mensaje' => "Se ha creado el partido entre tu equipo " . Equipo::getNombrePorID($datos['LOCAL_ID']) . " y " . Equipo::getNombrePorID($datos['VISITA_ID']) . " en el torneo " . Torneo::GetNombreTorneoPorID($torneo)];
                        Notificacion::CrearNotificacion($notificacion);
                    }

                    foreach (Equipo::GetJugadoresDelEquipo($datos['VISITA_ID']) as $jugador) {
                        $notificacion = ['usuario_id' => $jugador,
                            'torneo_id' => $torneo,
                            'fase_id' => $faseAActualizar,
                            'partido_id' => $partidoFaseAActualizar,
                            'mensaje' => "Se ha creado el partido entre tu equipo " . Equipo::getNombrePorID($datos['VISITA_ID']) . " y " . Equipo::getNombrePorID($datos['LOCAL_ID']) . " en el torneo " . Torneo::GetNombreTorneoPorID($torneo)];
                        Notificacion::CrearNotificacion($notificacion);
                    }
                }
            } else {
                print_r($stmt->errorInfo());
                throw new PartidoNoGrabadoException("Error al grabar el partido.");
            }
        } else {
            Torneo::actualizarEstadoTorneo($torneo, "F");
        }
    }


    public static function getCantidadPartidosFase($torneo_id, $fase_id) {
        $datos= [
            'torneo_id'   => $torneo_id,
            'fase_id'     => $fase_id
        ];

        $query = "SELECT COUNT(*) CANTIDAD FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        if ($rta = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $rta['CANTIDAD'];
        } else {
          return 0;
        }
    }

}
