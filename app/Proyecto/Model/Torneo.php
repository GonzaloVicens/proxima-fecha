<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\EquipoNoGrabadoException;
use Proyecto\Exceptions\TorneoNoGrabadoException;
use Proyecto\Session\Session;
use Proyecto\Core\App;

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
     * @var array of string;
     */
    protected $equipos;

    /**
     * @var array of string;
     */
    protected $organizadores;

    /**
     * @var string
     */
    protected $estado_torneo_id;


    /**
     * @var string
     */
    protected $estado_torneo_descr;

    /**
     * @var array of Fase
     */
    protected $fases;

    /**
     * @var array of string
     */
    protected $diasTorneo;

    /**
     * @return int
     */
    public function getCantidadEquipos()
    {
        if ($this->cantidad_equipos == 0) {
            $query = "SELECT CANTIDAD_EQUIPOS FROM TORNEOS WHERE TORNEO_ID = :torneo_id ";
            $stmt = DBConnection::getStatement($query);
            $stmt->execute(['torneo_id' => $this->torneo_id]);
            if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $this->cantidad_equipos = $datos['CANTIDAD_EQUIPOS'];
            } else {
                $this->cantidad_equipos = 1;
            }
        }
        return $this->cantidad_equipos;
    }

    /**
     * @return int
     */
    public function getDeporteId()
    {
        return $this->deporte_id;
    }

    /**
     * @param int $deporte_id
     */
    public function setDeporteId($deporte_id)
    {
        $this->deporte_id = $deporte_id;
    }

    /**
     * @return int
     */
    public function getSedeId()
    {
        return $this->sede_id;
    }

    /**
     * @return mixed
     */
    public function getFases(){
        return $this->fases;
    }


    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($torneo = null)
    {
        if(!is_null($torneo)) {
            $this->setTorneo($torneo);
            $this->setOrganizadores();
            $this->setFases();
            $this->setEquipos();
            $this->setDiasTorneo();
        }
    }


    public static function existeTorneo($torneo_id){
        $query = "SELECT 'X' FROM TORNEOS WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $torneo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public static function GetOrganizadoresActivosDelTorneo($torneo_id){
        $organizadores= [];
        $query = "SELECT ORGANIZADOR_ID FROM ORGANIZADORES WHERE TORNEO_ID = :torneo_id  AND ACTIVO = '1'  ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $torneo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $organizadores[] = $datos['ORGANIZADOR_ID'];
        };
        RETURN $organizadores;
    }

    public static function GetNombreTorneoPorID($torneo_id){
        $query = "SELECT NOMBRE FROM TORNEOS WHERE TORNEO_ID = :torneo_id  ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $torneo_id]);
        IF ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            RETURN $datos['NOMBRE'];
        };
        RETURN "";
    }

    public function setTorneo($torneo)
    {
        $this->torneo_id = $torneo;
        $this->equipos = [];
        $this->organizadores = [];
        $this->fases = [];


        $query = "SELECT NOMBRE, DEPORTE_ID, TIPO_TORNEO_ID, CANTIDAD_EQUIPOS, FECHA_INICIO, SEDE_ID, ESTADO_TORNEO_ID FROM TORNEOS WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->deporte_id = $datos['DEPORTE_ID'];
            $this->tipo_torneo_id= $datos['TIPO_TORNEO_ID'];
            $this->cantidad_equipos= $datos['CANTIDAD_EQUIPOS'];
            $this->fecha_inicio= $datos['FECHA_INICIO'];
            $this->sede_id= $datos['SEDE_ID'];
            $this->estado_torneo_id = $datos['ESTADO_TORNEO_ID'];
        };

    }


    public static function CrearTorneo($inputs, $organizador_id){

        $cantidadFinal = 4;
        if (isset($inputs ["cantidad"])  && !empty($inputs ["cantidad"])) {
            $cantidadFinal = $inputs['cantidad'];
        }

         $torneo= [
            'nombre'           => $inputs['nombre'],
            'deporte_id'       =>  $inputs['deporte'],
            'tipo_torneo_id'   =>  $inputs['tipoTorneo'],
            'cantidad_equipos' =>  $cantidadFinal,
            'fecha_inicio'     =>  $inputs['fechaInicio'],
            'sede_id'          =>  $inputs['sede'],
            'estado_torneo_id'    =>  "I"
        ];


//        $script = "INSERT INTO TORNEOS VALUES (null, :nombre, :deporte_id, :tipo_torneo_id, :cantidad_equipos, STR_TO_DATE(:fecha_inicio, '%Y/%m/%d'), :sede_id, :estado_torneo_id)";
        $script = "INSERT INTO TORNEOS VALUES (null, :nombre, :deporte_id, :tipo_torneo_id, :cantidad_equipos, :fecha_inicio, :sede_id, :estado_torneo_id, CURDATE() )";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($torneo)) {
            $torneoID = DBConnection::getConnection()->lastInsertId();

            $organizador= [
                'torneo_id' => $torneoID,
                'organizador_id'   =>  $organizador_id
            ];
            $script = "INSERT INTO ORGANIZADORES VALUES (:torneo_id, :organizador_id, 1)";
            $stmt = DBConnection::getStatement($script );
            if ($stmt->execute($organizador)) {

                $inputs['torneo_id'] = $torneoID;
                self::InsertarDiasTorneo($inputs);

                $notificacion = ['usuario_id' => $organizador_id  ,
                                'torneo_id' => $torneoID,
                                'mensaje' =>   "Se ha creado el torneo '" . $inputs['nombre'] . "'"];

                Notificacion::CrearNotificacion($notificacion );
            } else {
                throw new TorneoNoGrabadoException("Error al Grabar el Organizador del Torneo");
            };

            return $torneoID;
        } else {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        }
    }

    public static function ActualizarTorneo($inputs){

        $torneo= [
            'torneo_id'         => $inputs['torneo_id'],
            'nombre'            => $inputs['nombre'],
            'deporte_id'        =>  $inputs['deporte'],
            'tipo_torneo_id'    =>  $inputs['tipoTorneo'],
            'cantidad_equipos'  =>  $inputs['cantidad'],
            'fecha_inicio'      =>  $inputs['fechaInicio'],
            'sede_id'           =>  $inputs['sede']
        ];



        $script = "UPDATE TORNEOS SET NOMBRE = :nombre, DEPORTE_ID = :deporte_id, TIPO_TORNEO_ID = :tipo_torneo_id, CANTIDAD_EQUIPOS = :cantidad_equipos, FECHA_INICIO = :fecha_inicio, SEDE_ID = :sede_id WHERE TORNEO_ID = :torneo_id";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($torneo)) {
            self::InsertarDiasTorneo( $inputs);
            self::eliminarFixtureDelTorneo( $inputs['torneo_id']);

            foreach(Torneo::GetOrganizadoresActivosDelTorneo($inputs['torneo_id']) as $organizador) {
                $notificacion = ['usuario_id' => $organizador  ,
                    'torneo_id' => $inputs['torneo_id'],
                    'mensaje' =>   "Se ha actualizado el torneo '" . $inputs['nombre']. "'"];
                Notificacion::CrearNotificacion($notificacion );
            }
        }else {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        };
    }


    protected function eliminarFixture()
    {
        self::eliminarFixtureDelTorneo($this->torneo_id);
    }


    public static function eliminarFixtureDelTorneo ($torneo_id){
        $torneo= [
            'torneo_id' => $torneo_id
        ];

        $script = "DELETE FROM FICHA_PARTIDO WHERE TORNEO_ID = :torneo_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($torneo)) {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        };

        $script = "DELETE FROM PARTIDOS WHERE TORNEO_ID = :torneo_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($torneo)) {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        };

        $script = "DELETE FROM FASES WHERE TORNEO_ID = :torneo_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($torneo)) {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        };
    }

    public function eliminarTorneo(){

        $this->eliminarFixture();

        $torneo= [
            'torneo_id' => $this->torneo_id
        ];

        foreach($this->organizadores as $organizador) {
            $notificacion = ['usuario_id' => $organizador  ,
                'mensaje' =>   "Se ha eliminado el torneo '" . $this->nombre. "'"];
            Notificacion::CrearNotificacion($notificacion );
        }


        $script = "DELETE FROM EQUIPOS_TORNEO WHERE TORNEO_ID = :torneo_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($torneo)) {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        };

        $script = "DELETE FROM ORGANIZADORES WHERE TORNEO_ID = :torneo_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($torneo)) {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        };

        $script = "DELETE FROM TORNEOS WHERE TORNEO_ID = :torneo_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($torneo)) {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        };

    }


    public function setEquipos()
    {
        $this->equipos = [];
        $query = "SELECT A.EQUIPO_ID , A.NOMBRE FROM EQUIPOS A, EQUIPOS_TORNEO B WHERE A.EQUIPO_ID = B.EQUIPO_ID AND B.TORNEO_ID = :torneo_id ORDER BY NOMBRE ";

        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->equipos[] = $datos['EQUIPO_ID'];
        };
    }

    public function setOrganizadores(){
        $this->organizadores= [];
        $query = "SELECT ORGANIZADOR_ID FROM ORGANIZADORES WHERE TORNEO_ID = :torneo_id  AND ACTIVO = '1'  ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->organizadores[] = $datos['ORGANIZADOR_ID'];
        };
    }

    public function setFases()
    {
        $this->fases = [];
        $query = "SELECT FASE_ID FROM FASES WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->fases[] = New Fase($this->torneo_id, $datos ['FASE_ID']);
        };
    }


    public function getTorneoId(){
        return $this->torneo_id;
    }

    public function getEquipos(){
        return $this->equipos;
    }

    public function getEstadoID(){
        return $this->estado_torneo_id;
    }

    public function getEstadoDescr()
    {
        if (!isset($this->estado_torneo_descr) || empty ($this->estado_torneo_descr)) {

            $query = "SELECT DESCRIPCION FROM ESTADOS_TORNEO WHERE ESTADO_TORNEO_ID  = :estado_torneo_id ";
            $stmt = DBConnection::getStatement($query);
            $stmt->execute(['estado_torneo_id' => $this->estado_torneo_id]);
            if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $this->estado_torneo_descr = $datos['DESCRIPCION'];
            }
        }
        return $this->estado_torneo_descr;
    }

    public function getNombre(){
        return $this->nombre;
    }

    /**
    * @return date
    */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    public function getTipoTorneoId (){
        return $this->tipo_torneo_id;
    }

    public function getDescrTipoTorneo(){
        $tipoTorneo = new TipoTorneo($this->tipo_torneo_id);
        return $tipoTorneo->getDescripcion();
    }

    public function getDescrSede()
    {
        $sede = new Sede($this->sede_id);
        return $sede->getNombre();
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


    public  function printEquiposEnLi( $origen){
        foreach ($this->equipos as $id) {
            $equipo = New Equipo($id);


            echo "<li class='list-group-item'><img src='" . App::$urlPath . "/img/equipos/". $equipo->getEquipoId() ."_logo_200.jpg'><a href='" . App::$urlPath . "/equipos/" . $equipo->getEquipoID()."' class='pfgreen hoverVerde' title='Ver Equipo'>" . $equipo->getNombre() ."</a>";
            if (Session::has('logueado')) {
                $usuario = Session::get('usuario');
                if ($this->tieneOrganizador($usuario->getUsuarioID()) && $this->estado_torneo_id == "I") {
                    echo "<form style='display:inline' action='eliminar-equipo' method='POST'>";
                    echo "<input type='hidden' name='equipo_id' value='" . $equipo->getEquipoId() ."'/>";
                    echo "<input type='hidden' name='origen' value='". $origen . "'/>";
                    echo "<button type='submit' class='eliminar-button float-right mt-2 d-inline-block'><i class='far fa-trash-alt'></i><span class='d-none'>Eliminar</span></button></form>";
                }
            }
            echo "</li>";
        }
    }

    public function tieneEquipos(){
        return !empty($this->equipos[0]);
    }

    public function getLugaresLibres(){
        return $this->cantidad_equipos - count($this->equipos);
    }

    public function getCantidadEquiposAgregados(){
        return count($this->equipos);
    }

    public function esNuevo(){
        return ($this->estado_torneo_id == "I");
    }


    public function existeEquipo($equipo_id){
        $datos = ['torneo_id' => $this->torneo_id,
            'equipo_id' => $equipo_id
        ];

        $query = "SELECT 'X' FROM EQUIPOS_TORNEO WHERE TORNEO_ID = :torneo_id AND EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function insertarEquipo($equipo_id){
        $datos = ['torneo_id' => $this->torneo_id,
            'equipo_id' => $equipo_id
        ];

        $query = "INSERT INTO EQUIPOS_TORNEO VALUE (:torneo_id, :equipo_id )";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos );
        $stmt->fetch(\PDO::FETCH_ASSOC);

        $nombreEquipo = Equipo::getNombrePorID($equipo_id);

        foreach($this->organizadores as $organizador) {
            $notificacion = ['usuario_id' => $organizador  ,
                'torneo_id' => $this->torneo_id,
                'mensaje' =>   "Se ha agregado el equipo '". $nombreEquipo ."' al torneo '" . $this->nombre. "'"];
            Notificacion::CrearNotificacion($notificacion );
        }

        foreach(Equipo::GetJugadoresDelEquipo($equipo_id) as $jugador) {
            $notificacion = ['usuario_id' => $jugador  ,
                'torneo_id' => $this->torneo_id,
                'mensaje' =>   "Tu equipo '". $nombreEquipo ."' ha sido agregado al torneo '" . $this->nombre. "'"];
            Notificacion::CrearNotificacion($notificacion );
        }

    }

    public function eliminarEquipo($equipo_id){
        $datos = ['torneo_id' => $this->torneo_id,
            'equipo_id' => $equipo_id
        ];

        $query = "DELETE FROM EQUIPOS_TORNEO WHERE TORNEO_ID = :torneo_id AND EQUIPO_ID  = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        IF ($stmt->execute($datos )){
            $this->eliminarFixture();
            $this->actualizar();

            $nombreEquipo = Equipo::getNombrePorID($equipo_id);
            foreach($this->organizadores as $organizador) {
                $notificacion = ['usuario_id' => $organizador  ,
                    'torneo_id' => $this->torneo_id,
                    'mensaje' =>   "Se ha eliminado el equipo '". $nombreEquipo ."' del torneo '" . $this->nombre. "'"];
                Notificacion::CrearNotificacion($notificacion );
            }


            $nombreEquipo = Equipo::getNombrePorID($equipo_id);
            $jugadores = Equipo::GetJugadoresDelEquipo($equipo_id);
            foreach ($jugadores as $jugador) {
                $notificacion = ['usuario_id' => $jugador,
                    'torneo_id' => $this->torneo_id,
                    'mensaje' =>   "Tu equipo '". $nombreEquipo ."' ha sido eliminado del torneo '" . $this->nombre. "'"
                ];
                Notificacion::CrearNotificacion($notificacion);
            }


        } else {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        }
    }

    public function actualizar(){
        $this->setTorneo($this->torneo_id);
        $this->setEquipos();
        $this->setOrganizadores();
        $this->setFases();
        $this->setDiasTorneo();
        Session::clearValue('torneo');
        Session::set('torneo',$this);
    }


    public function tieneOrganizador($usuario_id){
        $query = "SELECT 'Y' FROM ORGANIZADORES WHERE TORNEO_ID = :torneo_id AND ORGANIZADOR_ID = :usuario_id AND ACTIVO = 1 ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id, 'torneo_id' => $this->torneo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function tieneFixture(){
        $query = "SELECT 'Y' FROM FASES WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function generarFixture(){
        $this->eliminarFixture();

        foreach($this->organizadores as $organizador) {
            $notificacion = ['usuario_id' => $organizador  ,
                'torneo_id' => $this->torneo_id,
                'mensaje' =>   "Se ha generado el fixture del torneo '" . $this->nombre . "'"];
            Notificacion::CrearNotificacion($notificacion );
        }


        switch( $this->tipo_torneo_id){
            case "L":
                $this->generarLiga();
                break;
            case "C":
                $this->generarCopa();
                break;
            case "T":
                $this->generarTorneoIdaYVuelta();
                break;
        }
        $this->comenzar();
        $this-> actualizar();


    }

    public function existeFase($fase_id) {
        return Fase::ExisteFase($this->torneo_id, $fase_id);
    }

    public function crearFaseLiga($fase_id){
        if (! $this->existeFase($fase_id)){
            Fase::CrearFase($this->torneo_id, $fase_id, "Fecha " .$fase_id);
        }
    }

    public function crearFaseCopa($fase_id, $nombre){
        if (! $this->existeFase($fase_id)){
            Fase::CrearFase($this->torneo_id, $fase_id, $nombre);
        }
    }

    public function yaOrganizaronPartido($local_ID, $visita_ID){
        return Partido::ExistePartidoEnTorneoEntre( $this->torneo_id, $local_ID, $visita_ID);
    }


    public function generarLiga(){
        $this->actualizar();
        $faseInicial = 1;
        foreach ($this->equipos as $iEquipo => $equipoI ){
            foreach ($this->equipos as $jEquipo => $equipoJ ){
                if ($jEquipo != $iEquipo ) {
                    $partidoHecho = $this->yaOrganizaronPartido($equipoI, $equipoJ);

                    $iFase =  $faseInicial ;
                    while(!$partidoHecho ) {
                        if ($iFase == $this->cantidad_equipos ) {
                            $iFase = 1;
                        }
                        if (! $this->existeFase($iFase)){
                            $this->crearFaseLiga($iFase);
                        }
                        $fase = New Fase($this->torneo_id, $iFase);

                        if ($fase->tieneEquipo($equipoI)) {
                            $iFase++;
                        } else {
                            if ($fase->tieneEquipo($equipoJ)) {
                                $iFase++;
                            } else {
                                $organizadorRandom = mt_rand(0, count($this->organizadores) - 1);
                                $fase->insertarPartido($equipoI, $equipoJ, $this->organizadores[$organizadorRandom], $fase->getFecha(), $this->sede_id);
                                $partidoHecho = true;
                                $faseInicial =$iFase +1;
                            }
                        }
                    }
                }
            }
        }
    }


    public function generarCopa(){
        $this->actualizar();
        $faseACrear = 1;
        $cantidadPartidos = $this->getCantidadEquipos();

        while ($cantidadPartidos > 1) {

            // Primero genero la llave original
            $resto = $cantidadPartidos  % 2;
            $cantidadPartidos  = $cantidadPartidos  - $resto;
            $cantidadPartidos =  $cantidadPartidos / 2 ;
            switch ($cantidadPartidos){
                case 1:
                    $nombre = "Final";
                    break;
                case 2:
                    $nombre = "Semifinal";
                    break;
                case 3:
                    $nombre = "Cuartos de Final";
                    break;
                default:
                    $nombre = $cantidadPartidos . "avos";
            }

            $this->crearFaseCopa($faseACrear , $nombre);
            $nuevaFase = New Fase ($this->torneo_id, $faseACrear);
            $this->fases[] = $nuevaFase ;

            for( $i = 0; $i < $cantidadPartidos ; $i++) {
                $organizadorRandom = mt_rand(0, count($this->organizadores) - 1);
                if ($faseACrear == 1) {
                    $nuevaFase->insertarPartido($this->equipos[$i], $this->equipos[$i + $cantidadPartidos], $this->organizadores[$organizadorRandom], $nuevaFase->getFecha(), $this->sede_id);
                }else{
                    $nuevaFase->insertarPartido(0 , 0, $this->organizadores[$organizadorRandom], $nuevaFase->getFecha(), $this->sede_id);
                }
            }

            $faseACrear++;
        }
    }



    public function generarTorneoIdaYVuelta(){
        $this->generarLiga();
        $this->actualizar();

        $fasesExistentes = count($this->fases);
        foreach($this->fases as $faseActual) {
            $nuevaFase_ID = $fasesExistentes  + $faseActual->getFaseID();
            $this->crearFaseLiga($nuevaFase_ID);
            $nuevaFase = New Fase ($this->torneo_id, $nuevaFase_ID );
            $this->fases[] = $nuevaFase ;

            foreach ( $faseActual->getPartidos() as $partidoActual) {
                $organizadorRandom = mt_rand(0, count($this->organizadores) - 1);

                $nuevaFase->insertarPartido($partidoActual->getVisitaID(), $partidoActual->getLocalID(), $this->organizadores[$organizadorRandom], $this->sede_id);
            }

        }
    }

    public function getOrganizadores() {
        return $this->organizadores;
    }

    public function getOrganizadoresActivos(){
        return $this->getTodosLosOrganizadores(" AND B.ACTIVO = '1' ");
    }


    public function getTodosLosOrganizadores($where = null){
        $respuesta= [];
        $query = "SELECT B.ORGANIZADOR_ID ORGANIZADOR_ID ,  A.NOMBRE NOMBRE , A.APELLIDO APELLIDO , B.ACTIVO ACTIVO FROM USUARIOS A, ORGANIZADORES B WHERE A.USUARIO_ID = B.ORGANIZADOR_ID AND B.TORNEO_ID = :torneo_id ";

        if (isset($where)){
            $query .= $where ;
        }

        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);

        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta[] = $datos;
        };

        return $respuesta;
    }



    public static function GetEstadoIdPorTorneo($torneo_id){
        $datos = ['torneo_id' => $torneo_id];

        $query = "SELECT ESTADO_TORNEO_ID FROM TORNEOS WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        IF ($rta = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $rta['ESTADO_TORNEO_ID'];
        } else {
            return "";
        }
    }

    public function existeOrganizador($organizador_id){
        $datos = ['torneo_id' => $this->torneo_id,
            'organizador_id' => $organizador_id
        ];

        $query = "SELECT 'X' FROM ORGANIZADORES WHERE TORNEO_ID = :torneo_id AND ORGANIZADOR_ID = :organizador_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function tieneOtrosOrganizadores($organizador_id){
        $datos = ['torneo_id' => $this->torneo_id,
            'organizador_id' => $organizador_id
        ];

        $query = "SELECT 'X' FROM ORGANIZADORES WHERE TORNEO_ID = :torneo_id AND ORGANIZADOR_ID != :organizador_id AND ACTIVO = '1' ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function tieneOrganizadorActivo($organizador_id){
        $datos = ['torneo_id' => $this->torneo_id,
            'organizador_id' => $organizador_id
        ];

        $query = "SELECT 'X' FROM ORGANIZADORES WHERE TORNEO_ID = :torneo_id AND ORGANIZADOR_ID = :organizador_id AND ACTIVO = '1'";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function editarOrganizador($organizador_id, $activo)
    {

        if ($activo) {
            $activo = '0';
            $mensaje = "Se ha desactivado al organizador '" . $organizador_id . "' del torneo '" . $this->nombre . "'";
        } else {
            $activo = '1';
            $mensaje = "Se ha activado al organizador '" . $organizador_id . "' del torneo '" . $this->nombre . "'";
        }

        $datos = ['torneo_id' => $this->torneo_id,
            'organizador_id'  => $organizador_id,
            'activo'          => $activo
        ];
        $query = "UPDATE ORGANIZADORES SET ACTIVO = :activo WHERE TORNEO_ID = :torneo_id AND ORGANIZADOR_ID =  :organizador_id";
        $stmt = DBConnection::getStatement($query);
        if ($stmt->execute($datos )) {
            //$stmt->fetch(\PDO::FETCH_ASSOC);
            $this->setOrganizadores();
            foreach($this->organizadores as $organizador) {
                $notificacion = ['usuario_id' => $organizador  ,
                    'torneo_id' => $this->torneo_id,
                    'mensaje' =>   $mensaje];
                Notificacion::CrearNotificacion($notificacion );
            }

        } else {
            throw new TorneoNoGrabadoException( "Error al actualizar un organizador") ;
        }

        if ($activo == '0') {
            $this->reasignarOrganizador($organizador_id);
        }
    }

    public function insertarOrganizador($organizador_id){
        $datos = ['torneo_id' => $this->torneo_id,
            'organizador_id' => $organizador_id
        ];
        $query = "INSERT INTO ORGANIZADORES VALUE (:torneo_id , :organizador_id, '1')";
        $stmt = DBConnection::getStatement($query);

        if ( $stmt->execute($datos )) {
            $notificacion = ['usuario_id' => $organizador_id  ,
                'torneo_id' => $this->torneo_id,
                'mensaje' =>   "Has sido agregado como organizador del torneo '" . $this->nombre. "'"];
            Notificacion::CrearNotificacion($notificacion );


            foreach($this->organizadores as $organizador) {
                $notificacion = ['usuario_id' => $organizador  ,
                    'torneo_id' => $this->torneo_id,
                    'mensaje' =>   "Se ha agregado el organizador '". $organizador_id."' al torneo '" . $this->nombre. "'"];
                Notificacion::CrearNotificacion($notificacion );
            }

        } else {
            throw new TorneoNoGrabadoException( "Error al insertar un Organizador");
        }
    }

    public function estaEnCurso(){
        return $this->estado_torneo_id == 'C';
    }

    public function estaInicial(){
        return $this->estado_torneo_id == 'I';
    }

    public function estaFinalizado(){
        return $this->estado_torneo_id == 'F';
    }



    public static function actualizarEstadoTorneo($torneo, $nuevoEstado){
        $datos = ['torneo_id' => $torneo,
                'estado_torneo_id' => $nuevoEstado
            ];

        $query = "UPDATE TORNEOS SET ESTADO_TORNEO_ID = :estado_torneo_id WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        if ($stmt->execute($datos )) {
            //$stmt->fetch(\PDO::FETCH_ASSOC);


            $nombre = Torneo::GetNombreTorneoPorID($torneo);

            switch ( $nuevoEstado) {
                case "I":
                    $mensaje = "Se ha reiniciado el torneo '" . $nombre. "'";
                    break;
                case "C":
                    $mensaje = "Se ha comenzado el torneo '" . $nombre. "'";
                    break;
                case "F":
                    $mensaje = "Se ha finalizado el torneo '" . $nombre. "'";
                    break;
            }
            foreach(Torneo::getOrganizadoresActivosDelTorneo($torneo) as $organizador) {
                $notificacion = ['usuario_id' => $organizador  ,
                    'torneo_id' => $torneo,
                    'mensaje' =>   $mensaje];
                Notificacion::CrearNotificacion($notificacion );
            }

        } else {
            throw new TorneoNoGrabadoException("Erorr al Actualizar el Estado del Torneo");
        }
    }

    public function comenzar(){
        Torneo::actualizarEstadoTorneo($this->torneo_id, "C");
    }

    public function finalizar(){
        Torneo::actualizarEstadoTorneo($this->torneo_id, "F");
    }

    public function reiniciar(){
        Torneo::actualizarEstadoTorneo($this->torneo_id, "I");
        $this->eliminarFixture();
    }

    public function reasignarOrganizador($organizador){
        $this->actualizar();
        foreach($this->fases as $faseActual) {
            foreach ( $faseActual->getPartidos() as $partidoActual) {
                if ( $partidoActual->getArbitroID() == $organizador && !$partidoActual->fueJugado()){
                    do {
                        $organizadorRandom = mt_rand(0, count($this->organizadores) - 1);
                    } while ($this->organizadores[$organizadorRandom] == $organizador);

                    $partidoActual->reasignarArbitro($this->organizadores[$organizadorRandom]);
                }
            }
        }
    }


    public static function GetInfoTorneo($torneo)
    {
        $respuesta = ['nombre' => "",
            'deporte_id' => "",
                'deporte_descr' => "",
                'tipo_torneo_id' => "",
                'tipo_descr' => "",
                'cantidad_equipos' => "",
                'fecha_inicio' => "",
                'sede_id' => "",
                'sede_descr' => "",
                'estado_torneo_id' => "",
                'estado_descr' => ""
            ];

        $query = "SELECT A.NOMBRE, A.DEPORTE_ID, B.DESCRIPCION DEPORTE_DESCR, A.TIPO_TORNEO_ID, C.DESCRIPCION TIPO_DESCR,A.CANTIDAD_EQUIPOS, A.FECHA_INICIO, A.SEDE_ID, D.NOMBRE SEDE_DESCR, A.ESTADO_TORNEO_ID , E.DESCRIPCION ESTADO_DESCR  FROM TORNEOS A,  DEPORTES B, TIPOS_TORNEO C,  SEDES D, ESTADOS_TORNEO E WHERE A.TORNEO_ID = :torneo_id AND A.DEPORTE_ID = B.DEPORTE_ID AND A.TIPO_TORNEO_ID = C.TIPO_TORNEO_ID AND A.SEDE_ID = D.SEDE_ID AND A.ESTADO_TORNEO_ID = E.ESTADO_TORNEO_ID ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $torneo]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta = [
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
                'estado_descr' => $datos['ESTADO_DESCR']
            ];
        };
        return $respuesta;
    }


    public function imprimirTablaPosiciones(){
        ?>
        <h4 class="mb-4 pfgreen mt-5"><span class="font-weight-normal colorGris2"><?= $this->getNombre()?></span></h4>
        <div class="posiciones_table shadow-sm">
        <table class="">
            <tr class="fondoHeader2 text-white">
                <th>Equipo</th><th>Ptos</th><th>PJ</th><th>PG</th><th>PE</th><th>PP</th><th>GF</th><th>GC</th><th>Dif</th>
            </tr>
            <?php
            foreach($this->getEquiposTablaPosiciones() as $equipoActual) {
                echo "<tr><td class='nombre_tablaposiciones'>". $equipoActual['NOMBRE'] . "</td>";
                echo "<td class='font-weight-bold'>" . $equipoActual['PUNTOS'] ."</td>";
                echo "<td>". $equipoActual['JUGADOS']. "</td>";
                echo "<td>". $equipoActual['GANADOS']. "</td>";
                echo "<td>". $equipoActual['EMPATADOS']. "</td>";
                echo "<td>". $equipoActual['PERDIDOS']. "</td>";
                echo "<td>". $equipoActual['GOLES_FAVOR'] . "</td>";
                echo "<td>". $equipoActual['GOLES_CONTRA']. "</td>";
                echo "<td>". $equipoActual['DIFERENCIA'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <?php
    }


    public function imprimirTablaGoleadores(){
        ?>
        <h4 class="mb-4 pfgreen mt-5"><span class="font-weight-normal colorGris2">Goleadores</span></h4>
        <div class="posiciones_table shadow-sm">
            <table class="">
                <tr class="fondoHeader2 text-white">
                    <th>Jugador</th><th>Equipo</th><th>Goles</th>
                </tr>
                <?php
                foreach($this->getTablaGoleadores() as $goleador) {
                    echo "<tr><td class='nombre_tablaposiciones'>". $goleador['USU_NOMBRE'] . "</td>";
                    echo "<td class='nombre_tablaposiciones'>". $goleador['EQUI_NOMBRE']. "</td>";
                    echo "<td class='font-weight-bold'>" . $goleador['CANTIDAD'] ."</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <?php
    }


    public function imprimirTablaTarjetas(){
        ?>
        <h4 class="mb-4 pfgreen mt-5"><span class="font-weight-normal colorGris2">Tarjetas</span></h4>
        <div class="posiciones_table shadow-sm">
            <table class="">
                <tr class="fondoHeader2 text-white">
                    <th>Jugador</th><th>Equipo</th><th>Rojas</th><th>Amarillas</th>
                </tr>
                <?php
                foreach($this->getTablaTarjetas() as $goleador) {
                    echo "<tr><td class='nombre_tablaposiciones'>". $goleador['USU_NOMBRE'] . "</td>";
                    echo "<td class='nombre_tablaposiciones'>". $goleador['EQUI_NOMBRE']. "</td>";
                    echo "<td class='font-weight-bold'>" . $goleador['ROJAS'] ."</td>";
                    echo "<td class='font-weight-bold'>" . $goleador['AMARILLAS'] ."</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
        <?php
    }


    protected function getPartidosJugadosPorEquipo($equipoID){
        $param = [
            'torneo_id' => $this->torneo_id,
            'equipo_id' => $equipoID
        ];

        $query = "SELECT COUNT(*) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND :equipo_id IN (LOCAL_ID, VISITA_ID) AND JUGADO = 'Y' ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return ($datos['CANTIDAD']);
        } ELSE {
            return 0;
        }
    }

    protected function getPartidosGanadosPorEquipo($equipoID){
        $param = [
            'torneo_id' => $this->torneo_id,
            'equipo_id' => $equipoID
        ];

        $respuesta = 0;

        $query = "SELECT COUNT(*) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND JUGADO = 'Y' AND LOCAL_ID = :equipo_id AND PUNTOS_LOCAL > PUNTOS_VISITA ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta += ($datos['CANTIDAD']);
        }

        $query = "SELECT COUNT(*) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND JUGADO = 'Y' AND VISITA_ID = :equipo_id AND PUNTOS_VISITA > PUNTOS_LOCAL";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta += ($datos['CANTIDAD']);
        }

        return $respuesta;
    }

    protected function getPartidosEmpatadosPorEquipo($equipoID){
        $param = [
            'torneo_id' => $this->torneo_id,
            'equipo_id' => $equipoID
        ];

        $query = "SELECT COUNT(*) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND :equipo_id IN (LOCAL_ID, VISITA_ID) AND JUGADO = 'Y'  AND PUNTO_LOCAL = PUNTOS_VISITA ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return ($datos['CANTIDAD']);
        } ELSE {
            return 0;
        }
    }

    protected function getPartidosPerdidosPorEquipo($equipoID){
        $param = [
            'torneo_id' => $this->torneo_id,
            'equipo_id' => $equipoID
        ];

        $respuesta = 0;

        $query = "SELECT COUNT(*) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND JUGADO = 'Y' AND LOCAL_ID = :equipo_id AND PUNTOS_LOCAL < PUNTOS_VISITA ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta += ($datos['CANTIDAD']);
        }

        $query = "SELECT COUNT(*) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND JUGADO = 'Y' AND VISITA_ID = :equipo_id AND PUNTOS_VISITA < PUNTOS_LOCAL";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta += ($datos['CANTIDAD']);
        }

        return $respuesta;
    }


    protected function getGolesAFavorEquipo($equipoID){
        $param = [
            'torneo_id' => $this->torneo_id,
            'equipo_id' => $equipoID
        ];

        $respuesta = 0;

        $query = "SELECT SUM(PUNTOS_LOCAL) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND JUGADO = 'Y' AND LOCAL_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta += ($datos['CANTIDAD']);
        }

        $query = "SELECT SUM(PUNTOS_VISITA) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND JUGADO = 'Y' AND VISITA_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta += ($datos['CANTIDAD']);
        }

        return $respuesta;
    }


    protected function getGolesEnContraEquipo($equipoID){
        $param = [
            'torneo_id' => $this->torneo_id,
            'equipo_id' => $equipoID
        ];

        $respuesta = 0;

        $query = "SELECT SUM(PUNTOS_VISITA) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND JUGADO = 'Y' AND LOCAL_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta += ($datos['CANTIDAD']);
        }

        $query = "SELECT SUM(PUNTOS_LOCAL) CANTIDAD FROM PARTIDOS  WHERE TORNEO_ID = :torneo_id AND JUGADO = 'Y' AND VISITA_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta += ($datos['CANTIDAD']);
        }

        return $respuesta;
    }

    protected function getEquiposTablaPosiciones(){
        $param = [
            'torneo_id' => $this->torneo_id
        ];

        $respuesta = [];

        $query = "SELECT T.EQUIPO_ID EQUIPO_ID,  E.NOMBRE NOMBRE  , SUM(GANADOS * 3) + SUM(EMPATADOS) PUNTOS , SUM(JUGADOS) JUGADOS, SUM(GANADOS) GANADOS, SUM(EMPATADOS) EMPATADOS, SUM(PERDIDOS) PERDIDOS,SUM(GOLES_FAVOR - GOLES_CONTRA) DIFERENCIA, SUM(GOLES_FAVOR) GOLES_FAVOR, SUM(GOLES_CONTRA) GOLES_CONTRA FROM TABLA_POSICIONES T , EQUIPOS E WHERE T.EQUIPO_ID = E.EQUIPO_ID AND T.TORNEO_ID = :torneo_id GROUP BY T.EQUIPO_ID, E.NOMBRE ORDER BY 3 DESC, 8 DESC ,9  DESC";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta [] = [
                'EQUIPO_ID' => $datos['EQUIPO_ID'],
                'NOMBRE' => $datos['NOMBRE'],
                'PUNTOS' => $datos['PUNTOS'],
                'JUGADOS' => $datos['JUGADOS'],
                'GANADOS' => $datos['GANADOS'],
                'EMPATADOS' => $datos['EMPATADOS'],
                'PERDIDOS' => $datos['PERDIDOS'],
                'GOLES_FAVOR' => $datos['GOLES_FAVOR'],
                'GOLES_CONTRA' => $datos['GOLES_CONTRA'],
                'DIFERENCIA' => $datos['DIFERENCIA']
            ];
        }

        return $respuesta;
    }

    protected function getTablaGoleadores(){
        $param = [
            'torneo_id' => $this->torneo_id
        ];

        $respuesta = [];
        $query = "SELECT T.EQUIPO_ID EQUIPO_ID,  E.NOMBRE EQUI_NOMBRE  , U.USUARIO_ID USUARIO_ID , CONCAT(U.NOMBRE, ' ' , U.APELLIDO) USU_NOMBRE, count(*) CANTIDAD  FROM FICHA_PARTIDO T , EQUIPOS E , USUARIOS U WHERE T.EQUIPO_ID = E.EQUIPO_ID  AND T.JUGADOR_ID = U.USUARIO_ID AND T.TORNEO_ID = :torneo_id AND T.TIPO_ESTADISTICA_ID = 'G' GROUP BY T.EQUIPO_ID ,  E.NOMBRE , U.USUARIO_ID , U.NOMBRE, U.APELLIDO ORDER BY CANTIDAD DESC";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if (count($respuesta)<20){
                $respuesta [] = $datos;
            }
        }
        return $respuesta;
    }

    protected function getTablaTarjetas(){
        $param = [
            'torneo_id' => $this->torneo_id
        ];

        $respuesta = [];
        $query = "SELECT T.EQUIPO_ID EQUIPO_ID,  E.NOMBRE EQUI_NOMBRE  , U.USUARIO_ID USUARIO_ID , CONCAT(U.NOMBRE, ' ' , U.APELLIDO) USU_NOMBRE, SUM(CASE T.TIPO_ESTADISTICA_ID WHEN 'R' THEN 1 ELSE 0 END) ROJAS, SUM(CASE T.TIPO_ESTADISTICA_ID WHEN 'A' THEN 1 ELSE 0 END) AMARILLAS FROM FICHA_PARTIDO T , EQUIPOS E , USUARIOS U WHERE T.EQUIPO_ID = E.EQUIPO_ID  AND T.JUGADOR_ID = U.USUARIO_ID AND T.TORNEO_ID = :torneo_id AND T.TIPO_ESTADISTICA_ID  IN ('A','R') GROUP BY T.EQUIPO_ID ,  E.NOMBRE , U.USUARIO_ID , U.NOMBRE, U.APELLIDO ORDER BY ROJAS DESC, AMARILLAS DESC ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if (count($respuesta)<20){
                $respuesta [] = $datos;
            }

        }

        return $respuesta;
    }



    protected static function  InsertarDiasTorneo($inputs){


        $torneoID = $inputs['torneo_id'];

        $datos= [
            'torneo_id' => $torneoID
        ];
        $script = "DELETE FROM DIAS_TORNEO WHERE TORNEO_ID = :torneo_id";
        $stmt = DBConnection::getStatement($script );
        $stmt->execute($datos);

        if (isset($inputs['D'])){
            self::InsertarDiaEnTorneo($torneoID, 'D');
        }
        if (isset($inputs['L'])){
            self::InsertarDiaEnTorneo($torneoID, 'L');
        }
        if (isset($inputs['M'])){
            self::InsertarDiaEnTorneo($torneoID, 'M');
        }
        if (isset($inputs['X'])){
            self::InsertarDiaEnTorneo($torneoID, 'X');
        }
        if (isset($inputs['J'])){
            self::InsertarDiaEnTorneo($torneoID, 'J');
        }
        if (isset($inputs['V'])){
            self::InsertarDiaEnTorneo($torneoID, 'V');
        }
        if (isset($inputs['S'])){
            self::InsertarDiaEnTorneo($torneoID, 'S');
        }

    }

    protected static function  InsertarDiaEnTorneo($torneoID, $dia){

        $datos= [
            'torneo_id' => $torneoID,
            'dia_torneo'   =>  $dia
        ];
        $script = "INSERT INTO DIAS_TORNEO VALUES (:torneo_id, :dia_torneo)";
        $stmt = DBConnection::getStatement($script );
        $stmt->execute($datos);

    }


    public function getDiasTorneo(){
        return $this->diasTorneo;
    }

    public function setDiasTorneo(){
        $this->diasTorneo = [];
        $query = "SELECT DIA_ID FROM DIAS_TORNEO WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->diasTorneo [] = $datos ['DIA_ID'];
        };

    }

    public function getDiasTorneoEnString(){
        $respuesta = "";
        foreach( $this->diasTorneo as $dia){
            if (!empty($respuesta )){
                $respuesta .= " - ";
            }
            switch ($dia){
                case "D":
                    $respuesta .= "Domingo";
                    break;
                case "L":
                    $respuesta .= "Lunes";
                    break;
                case "M":
                    $respuesta .= "Martes";
                    break;
                case "X":
                    $respuesta .= "Miércoles";
                    break;
                case "J":
                    $respuesta .= "Jueves";
                    break;
                case "V":
                    $respuesta .= "Viernes";
                    break;
                case "S":
                    $respuesta .= "Sabado";
                    break;
            }
        }
        return $respuesta;
    }


    public function checkDia($dia) {
        foreach( $this->diasTorneo as $diaTorneo){
            if ($diaTorneo == $dia){
                return "checked";
            }
        };
        return "";
    }

    public static function esCopa($torneo)
    {
        $query = "SELECT 'X' FROM TORNEOS WHERE TORNEO_ID = :torneo_id AND TIPO_TORNEO_ID = 'C' ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $torneo]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function FinalizarTorneo ($torneo) {
        $query = "SELECT 'X' FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND JUGADO = 'N' ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $torneo]);
        if (!$stmt->fetch(\PDO::FETCH_ASSOC)){
            Torneo::actualizarEstadoTorneo($torneo, "F");

            $equipoCampeon = Torneo::getCampeon($torneo);
            $nombreCampeon = $equipoCampeon['NOMBRE'];
            $nombreTorneo = Torneo::getNombrePorID($torneo);
            foreach( Equipo::GetJugadoresDelEquipo($equipoCampeon['EQUIPO_ID']) as $jugador){
                $notificacion = ['usuario_id' => $jugador,
                    'torneo_id' => $torneo,
                    'mensaje' => "Tu equipo '" . $nombreCampeon . "' ha sido campeón del Torneo '" . $nombreTorneo ."'"];

                Notificacion::CrearNotificacion($notificacion);
            };

        }
    }


    public static function GetTorneosCreados ($dias) {
        $query = "SELECT COUNT(*) CANTIDAD FROM TORNEOS WHERE  DATEDIFF(CURDATE() , REGISTRADO_DT) <= :dias";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['dias' => $dias]);
        if ($respuesta = $stmt->fetch(\PDO::FETCH_ASSOC)){
            RETURN $respuesta['CANTIDAD'];
        } ELSE {
            RETURN 0;
        }
    }

    protected function mostrarPartidoCopa($partido , $usuario_ID){
        $htmlPartido = "<div class='equipo_container list-group ' >";

        if ($partido->getLocalNombre() != "" ) {
            $htmlPartido .= "<div class='torneo_equipo list-group-item'>" . $partido->getLocalNombre() . ": <span>" . $partido->getPuntosLocal() . "</span></div>";
        } else {
            $htmlPartido .= "<div class='torneo_equipo list-group-item'><span></span></div>";
        };

        if ($partido->getVisitaNombre() != "" ) {
            $htmlPartido .= "<div class='torneo_equipo list-group-item'>" . $partido->getVisitaNombre() . ": <span>" . $partido->getPuntosVisita() . "</span></div>";
        } else {
            $htmlPartido .= "<div class='torneo_equipo list-group-item'><span></span></div>";
        };

        if (($partido->getLocalNombre() != "" ) && ( $partido->getVisitaNombre()!= "") ){
            if (isset($usuario_ID) && $partido->esArbitro($usuario_ID) && (!$partido->fueJugado()) ){
                $label = "Actualizar Partido";
                $icon = "<i class='fas fa-edit'></i><span class='d-none'>editar</span>";
            } else {
                $label = "Ver Partido" ;
                $icon = "<i class='fas fa-eye'></i><span class='d-none'>ver</span>";
            }
            $htmlPartido .= "<div class='actualizar_ver'><a href='". $partido->getTorneoID() . "/" . $partido->getFaseID() . "/" . $partido->getPartidoID() . "' title=' $label '>$icon </a></div>";
        }

        $htmlPartido.= "</div>";
        return $htmlPartido;
    }

    public function imprimir($algo){
        echo "<pre>";
        print_r($algo);
        echo "</pre>";
    }


    public function mostrarFixtureCopa($fase_id, $usuario_ID){


        $fase = New Fase($this->torneo_id, $fase_id);
        $canPartidosEnFase = $fase->getCantidadPartidosFase() ;
        $htmlFinal ="";

        if ($canPartidosEnFase == 1) {
            $htmlFinal .= "<div class='item final'><span class='fase_torneo'>" .  $fase->getDescripcion() . "</span>";
            foreach ($fase->getPartidos() as $partido) {
                $htmlFinal .= $this->mostrarPartidoCopa($partido, $usuario_ID);
            };
            $htmlFinal .= "</div>";
            return $htmlFinal ;
        } else {
            $clase = "";
            switch ($canPartidosEnFase){
                case 2:
                    $clase = "semifinal";
                    break;
                case 4:
                    $clase = "cuartos";
                    break;
                case 8:
                    $clase = "octavos";
                    break;
                case 16:
                    $clase = "dieciseisavos";
                    break;
            }


            // Primero genero la llave original
            $resto = $canPartidosEnFase % 2;

            $canPartidosEnFase = $canPartidosEnFase- $resto ;
            $mitad = $canPartidosEnFase / 2 ;

            $partidosFase = $fase->getPartidos();
            $htmlFinal .= "<div class='item " . $clase . " llave_a'><span class='fase_torneo'> Llave A - " . $fase->getDescripcion() . "</span>";

            for ($i = 0 ; $i < $mitad ; $i++) {
                $partido = $partidosFase[$i];
                $htmlFinal .= $this->mostrarPartidoCopa($partido, $usuario_ID);
            };
            $htmlFinal .= "</div>";

            $htmlFinal .= $this->mostrarFixtureCopa($fase_id +1 , $usuario_ID);

            $htmlFinal .= "<div class='item " . $clase . " llave_b'><span class='fase_torneo'> Llave B - " . $fase->getDescripcion() . "</span>";
            for ($i = $mitad  ; $i < $canPartidosEnFase ; $i++){
                $partido = $partidosFase[$i];
                $htmlFinal .= $this->mostrarPartidoCopa($partido, $usuario_ID);
            }
            $htmlFinal .= "</div>";

        }

        return $htmlFinal;
    }


    public static function getCampeon($torneo){

        $param = [
            'torneo_id' => $torneo
        ];

        $respuesta = [];

        $query = "SELECT T.EQUIPO_ID EQUIPO_ID,  E.NOMBRE NOMBRE  , SUM(GANADOS * 3) + SUM(EMPATADOS) PUNTOS , SUM(JUGADOS) JUGADOS, SUM(GANADOS) GANADOS, SUM(EMPATADOS) EMPATADOS, SUM(PERDIDOS) PERDIDOS,SUM(GOLES_FAVOR - GOLES_CONTRA) DIFERENCIA, SUM(GOLES_FAVOR) GOLES_FAVOR, SUM(GOLES_CONTRA) GOLES_CONTRA FROM TABLA_POSICIONES T , EQUIPOS E WHERE T.EQUIPO_ID = E.EQUIPO_ID AND T.TORNEO_ID = :torneo_id GROUP BY T.EQUIPO_ID, E.NOMBRE ORDER BY 3 DESC, 8 DESC ,9  DESC";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param );
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $datos;
        }

        return $respuesta;


    }

    public static function getNombrePorID($id)
    {
        $datos = [
            'torneo_id' => $id
        ];
        $query = "SELECT NOMBRE FROM TORNEOS WHERE TORNEO_ID = :torneo_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        $nombre = "";
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $nombre = $datos['NOMBRE'];
        }
        return $nombre;
    }

    public static function InscribirEquipo($datos){

        $query = "INSERT INTO INSCRIPCIONES VALUE (:torneo_id, :equipo_id )";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos );
        $stmt->fetch(\PDO::FETCH_ASSOC);

        $nombreEquipo = Equipo::getNombrePorID($datos['equipo_id']);
        $nombreTorneo = Torneo::getNombrePorID($datos['torneo_id']);
        $organizadores = Torneo::GetOrganizadoresActivosDelTorneo($datos['torneo_id']);
        foreach( $organizadores  as $organizador) {
            $notificacion = ['usuario_id' => $organizador  ,
                'torneo_id' => $datos['torneo_id'],
                'mensaje' =>   "El equipo '". $nombreEquipo ."' ha solicitado inscribirse al torneo '" . $nombreTorneo . "'"];
            Notificacion::CrearNotificacion($notificacion );
        }

        foreach(Equipo::GetJugadoresDelEquipo($datos['equipo_id']) as $jugador) {
            $notificacion = ['usuario_id' => $jugador  ,
                'torneo_id' => $datos['torneo_id'],
                'mensaje' =>   "Tu equipo '". $nombreEquipo ."' ha solicitado inscribirse al torneo '" .  $nombreTorneo . "'"];
            Notificacion::CrearNotificacion($notificacion );
        }

    }


    public function getInscripciones()
    {
        $respuesta = [] ;
        $query = "SELECT A.EQUIPO_ID , A.NOMBRE FROM EQUIPOS A, INSCRIPCIONES B WHERE A.EQUIPO_ID = B.EQUIPO_ID AND B.TORNEO_ID = :torneo_id ORDER BY NOMBRE ";

        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta [] = $datos;
        };
        return $respuesta ;
    }



    public function printInscripcionesEnLi()
    {
        if (Session::has('logueado')) {
            $usuario = Session::get('usuario');
            if ($this->tieneOrganizador($usuario->getUsuarioID()) && $this->estado_torneo_id == "I") {
                $inscripciones = $this->getInscripciones();
                if (count($inscripciones) > 0) {
                    echo "<h4 class='pfgreen mt-4'>Inscripciones Pendientes </h4>";
                    echo "<ul class='list-group equipos_participan'>";

                    foreach ($inscripciones as $equipo) {
                        echo "<li class='list-group-item'><img src='" . App::$urlPath . "/img/equipos/" . $equipo['EQUIPO_ID'] . "_logo_200.jpg'><a href='" . App::$urlPath . "/equipos/" . $equipo['EQUIPO_ID'] . "' class='pfgreen hoverVerde' title='Ver Equipo'>" . $equipo['NOMBRE'] . "</a>";

                        // Insertar Equipo
                        echo "<form style='display:inline' action='agregar-inscripcion' method='POST'>";
                        echo "<input type='hidden' name='equipo_id' value='" . $equipo['EQUIPO_ID'] . "'/>";
                        echo "<input type='hidden' name='torneo_id' value='" . $this->torneo_id . "'/>";
                        echo "<button type='submit' class='eliminar-button float-right mt-2 d-inline-block'><i class='far fa-check-square'></i><span class='d-none'>Agregar</span></button></form>";

                        // Eliminar Inscripcion
                        echo "<form style='display:inline' action='eliminar-inscripcion' method='POST'>";
                        echo "<input type='hidden' name='equipo_id' value='" . $equipo['EQUIPO_ID'] . "'/>";
                        echo "<input type='hidden' name='torneo_id' value='" . $this->torneo_id . "'/>";
                        echo "<button type='submit' class='eliminar-button float-right mt-2 d-inline-block'><i class='far fa-trash-alt'></i><span class='d-none'>Eliminar</span></button></form>";
                        echo "</li>";
                    }
                    echo "</ul>";
                }
            }
        }
    }


    public static function EliminarInscripcion($torneo_id , $equipo_id){
        $datos = ['torneo_id' => $torneo_id,
            'equipo_id' => $equipo_id
        ];

        $query = "DELETE FROM INSCRIPCIONES WHERE TORNEO_ID = :torneo_id AND EQUIPO_ID  = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        IF (!$stmt->execute($datos )){
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        }
    }

}

