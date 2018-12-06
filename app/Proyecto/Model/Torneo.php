<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\TorneoNoGrabadoException;
use Proyecto\Session\Session;


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
     * @var array of Usuario;
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
     * @return int
     */
    public function getCantidadEquipos()
    {
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
        }
    }


    public static function existeTorneo($torneo_id){
        $query = "SELECT 'X' FROM TORNEOS WHERE TORNEO_ID = :torneo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $torneo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
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

        $torneo= [
            'nombre'           => $inputs['nombre'],
            'deporte_id'       =>  $inputs['deporte'],
            'tipo_torneo_id'   =>  $inputs['tipoTorneo'],
            'cantidad_equipos' =>  $inputs['cantidad'],
            'fecha_inicio'     =>  $inputs['fechaInicio'],
            'sede_id'          =>  $inputs['sede'],
            'estado_torneo_id'    =>  "I"
        ];


//        $script = "INSERT INTO TORNEOS VALUES (null, :nombre, :deporte_id, :tipo_torneo_id, :cantidad_equipos, STR_TO_DATE(:fecha_inicio, '%Y/%m/%d'), :sede_id, :estado_torneo_id)";
        $script = "INSERT INTO TORNEOS VALUES (null, :nombre, :deporte_id, :tipo_torneo_id, :cantidad_equipos, :fecha_inicio, :sede_id, :estado_torneo_id)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($torneo)) {
            $torneoID = DBConnection::getConnection()->lastInsertId();

            $organizador= [
                'torneo_id' => $torneoID,
                'organizador_id'   =>  $organizador_id
            ];
            $script = "INSERT INTO ORGANIZADORES VALUES (:torneo_id, :organizador_id, 1)";
            $stmt = DBConnection::getStatement($script );
            $stmt->execute($organizador);

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
        if(!$stmt->execute($torneo)) {
            throw new TorneoNoGrabadoException("Error al grabar el torneo.");
        };
    }


    protected function eliminarFixture() {
        $torneo= [
            'torneo_id' => $this->torneo_id
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
        $query = "SELECT EQUIPO_ID FROM EQUIPOS_TORNEO WHERE TORNEO_ID = :torneo_id ";

        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['torneo_id' => $this->torneo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->equipos[] = $datos['EQUIPO_ID'];
        };
    }

    public function setOrganizadores(){
        $this->organizadores= [];
        $query = "SELECT ORGANIZADOR_ID FROM ORGANIZADORES WHERE TORNEO_ID = :torneo_id ";
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
        if (!isset($this->estado_torneo_descr)) {

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
            echo "<li>" . $equipo->getNombre() ;
            if (Session::has('logueado')) {
                $usuario = Session::get('usuario');
                if ($this->tieneOrganizador($usuario->getUsuarioID()) && $this->estado_torneo_id == "I") {
                    echo "<form style='display:inline' action='eliminar-equipo' method='POST'>";
                    echo "<input type='hidden' name='equipo_id' value='" . $equipo->getEquipoId() ."'/>";
                    echo "<input type='hidden' name='origen' value='". $origen . "'/>";
                    echo "<input type='submit' value='Eliminar'/></form>";
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
    }

    public function eliminarEquipo($equipo_id){
        $datos = ['torneo_id' => $this->torneo_id,
            'equipo_id' => $equipo_id
        ];

        $query = "DELETE FROM EQUIPOS_TORNEO WHERE TORNEO_ID = :torneo_id AND EQUIPO_ID  = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos );
        $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function actualizar(){
        $this->setTorneo($this->torneo_id);
        $this->setEquipos();
        $this->setOrganizadores();
        $this->setFases();
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
    }

    public function existeFase($fase_id) {
        return Fase::ExisteFase($this->torneo_id, $fase_id);
    }

    public function crearFase($fase_id){
        if (! $this->existeFase($fase_id)){
            Fase::CrearFase($this->torneo_id, $fase_id, "Fecha " .$fase_id);
        }
    }

    public function yaOrganizaronPartido($local_ID, $visita_ID){
        return Partido::ExistePartidoEnTorneoEntre( $this->torneo_id, $local_ID, $visita_ID);
    }


    public function generarLiga(){
        $this->eliminarFixture();

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
                            $this->crearFase($iFase);
                        }
                        $fase = New Fase($this->torneo_id, $iFase);

                        if ($fase->tieneEquipo($equipoI)) {
                            $iFase++;
                        } else {
                            if ($fase->tieneEquipo($equipoJ)) {
                                $iFase++;
                            } else {
                                $organizadorRandom = mt_rand(0, count($this->organizadores) - 1);
                                $fase->insertarPartido($equipoI, $equipoJ, $this->organizadores[$organizadorRandom], $this->sede_id);
                                $partidoHecho = true;
                                $faseInicial =$iFase +1;
                            }
                        }
                    }



                }
            }
        }
        $this-> actualizar();
    }


    public function generarCopa(){

    }
    public function generarTorneoIdaYVuelta(){
    }




}