<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\EquipoNoGrabadoException;
use Proyecto\Session\Session;
use Proyecto\Core\App;
use Proyecto\Model\TipoEstadistica;
/**
 * Implementación de la clase Equipo
 */
class Equipo
{
    /**
     * @var integer
     */
    protected $equipo_id;
    /**
     * @var string
     */
    protected $nombre;
    /**
     * @var string
     */
    protected $capitan_id;

    /**
     * @var array of Usuario;
     */
    protected $jugadores;

    protected $activo;

    protected $activoString;



    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($equi = null)
    {
        if (!is_null($equi)) {
            $this->setEquipo($equi);
        }
    }


    public static function CrearEquipo($nombre, $capitan)
    {
        $equipo = [
            'nombre' => $nombre,
            'capitan_id' => $capitan
        ];

        $script = "INSERT INTO EQUIPOS VALUES (null, :nombre, :capitan_id, 1, CURDATE())";
        $stmt = DBConnection::getStatement($script);
        if ($stmt->execute($equipo)) {
            $idEquipo = DBConnection::getConnection()->lastInsertId();
            $jugador = [
                'equipo_id' => $idEquipo,
                'jugador_id' => $capitan
            ];


            $script = "INSERT INTO JUGADORES VALUES (:equipo_id, :jugador_id)";
            $stmt = DBConnection::getStatement($script);
            if ($stmt->execute($jugador)) {
                $notificacion = ['usuario_id' => $capitan,
                        'equipo_id' => $idEquipo,
                        'mensaje' => "Se ha creado el equipo <span class='verde3 font-regular-bold'>" .  $nombre . "</span>"  ];
                Notificacion::CrearNotificacion($notificacion);
                return $idEquipo;
            } else {
                throw new EquipoNoGrabadoException( "Error al insertar un jugador en el equipo");
            }

        } else {
            throw new EquipoNoGrabadoException("Error al grabar el equipo.");
        }
    }


    public static function existeEquipo($equipo_id)
    {
        $query = "SELECT 'X' FROM EQUIPOS WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $equipo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function existeJugador($jugador_id)
    {
        $datos = ['equipo_id' => $this->equipo_id,
            'jugador_id' => $jugador_id
        ];

        $query = "SELECT 'X' FROM JUGADORES WHERE EQUIPO_ID = :equipo_id AND JUGADOR_ID = :jugador_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function insertarJugador($jugador_id)
    {
        $datos = ['equipo_id' => $this->equipo_id,
            'jugador_id' => $jugador_id
        ];
        $query = "INSERT INTO JUGADORES VALUE (:equipo_id , :jugador_id)";
        $stmt = DBConnection::getStatement($query);
        if ( $stmt->execute($datos)) {
            $notificacion = ['usuario_id' => $jugador_id,
                'equipo_id' => $this->equipo_id,
                'mensaje' => "Has sido agregado al equipo <span class='verde3 font-regular-bold'>" . $this->nombre . "</span>"];
            Notificacion::CrearNotificacion($notificacion);

            foreach($this->jugadores as $jugador) {
                $notificacion = ['usuario_id' => $jugador,
                    'equipo_id' => $this->equipo_id,
                    'mensaje' => "Se ha agregado al jugador  <span class='verde3 font-regular-bold'>" . $jugador_id . "</span> al equipo  <span class='verde3 font-regular-bold'>" . $this->nombre . "</span>"];
                Notificacion::CrearNotificacion($notificacion);
            }
        } else {
            throw new EquipoNoGrabadoException( "Error al insertar un jugador en el equipo");
        }

    }


    public function setEquipo($equi)
    {
        $this->equipo_id = $equi;

        $query = "SELECT NOMBRE, CAPITAN_ID , ACTIVO, CASE ACTIVO WHEN 1  THEN 'Activo' ELSE 'Inactivo' END AS ACTIVOSTRING FROM EQUIPOS WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->capitan_id = $datos['CAPITAN_ID'];
            $this->activo = $datos['ACTIVO'];
            $this->activoString = $datos['ACTIVOSTRING'];
        };
        $this->setJugadores();
    }


    public function setJugadores()
    {
        $this->jugadores = [];
        $query = "SELECT JUGADOR_ID FROM JUGADORES WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->jugadores[] = $datos['JUGADOR_ID'];
        };
    }

    public function getEquipoId()
    {
        return $this->equipo_id;
    }

    public function getJugadores()
    {
        return $this->jugadores;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getCapitanID()
    {
        return $this->capitan_id;
    }

    public function estaActivo(){
        return ($this->activo == 1);
    }

    public function getActivoString(){
        return $this->activoString;
    }

    /**
     * @return null|Torneo
     */
    public function getTorneos($whereAdicional = null)
    {
        $torneos = [];
        $query = "SELECT A.TORNEO_ID FROM TORNEOS A, EQUIPOS_TORNEO B WHERE A.TORNEO_ID = B.TORNEO_ID AND A.ESTADO_TORNEO_ID = 'C' AND B.EQUIPO_ID = :equipo_id ";

        if ($whereAdicional ){
            $query .= $whereAdicional;
        }
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $torneos [] = new Torneo($datos['TORNEO_ID']);
        };
        return $torneos ;
    }

    public function participaEnTorneo()
    {
        $query = "SELECT 'X' FROM TORNEOS A, EQUIPOS_TORNEO B WHERE A.TORNEO_ID = B.TORNEO_ID AND B.EQUIPO_ID = :equipo_id AND A.ESTADO_TORNEO_ID != 'F' ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function printJugadoresEnUL()
    {
        echo "<ul class='lista_jugadores list-group'>";

        if (Session::has("usuario")) {
            $usuario = Session::get("usuario");
            $usuario_id = $usuario->getUsuarioID();
        } else {
            $usuario_id = "";
        }
        $query = "SELECT A.JUGADOR_ID, B.NOMBRE , B.APELLIDO FROM JUGADORES A, USUARIOS B WHERE A.JUGADOR_ID = B.USUARIO_ID AND A.EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);

        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $idCapitan = "";
            $iconCapitan = "";
            $boton = "";
            $jugadorID = $datos['JUGADOR_ID'];
            IF ($datos['JUGADOR_ID'] == $this->capitan_id) {
                $idCapitan = "id='capitan'";
                $iconCapitan = "<i class='fas fa-copyright' data-toggle='tooltip' data-placement='top' title='Capitán del Equipo'></i>";
            }

            if (Session::has('logueado')) {
                if ($usuario_id == $this->capitan_id) {
                    IF (($jugadorID != $this->capitan_id)) {
                        // Configuro el origen del chat para el botón "Volver" de la conversacion;
                        Session::set('origenChat', '/equipos/' . $this->equipo_id);
                        $boton = "<a href='../mensajes/" . $usuario_id . "/" . $jugadorID . "' class='enviar-mensaje'>Enviar Mensaje</a>";
                    }
                } else {
                    IF (($jugadorID == $this->capitan_id)) {
                        // Configuro el origen del chat para el botón "Volver" de la conversacion;
                        Session::set('origenChat', '/equipos/' . $this->equipo_id);
                        $boton = "<a href='../mensajes/" . $usuario_id . "/" . $jugadorID . "' class='enviar-mensaje'>Enviar Mensaje</a>";
                        //    $boton = "<a href='#mensajeModal' class='mayuscula'>Enviar Mensaje</a>";
                    }
                }
            }

            if (file_exists('img/usuarios/' . $datos['JUGADOR_ID'] . '.jpg')) {
                $rutaImagen = "../img/usuarios/" . $datos['JUGADOR_ID'] . ".jpg";
            } else {
                $rutaImagen = "../img/usuarios/UserJugador.jpg";
            }


            echo "<li class='li-listado-jugadores-img list-group-item'><a href='../usuarios/" . $datos['JUGADOR_ID'] . "' title='Ver'><img src='$rutaImagen' alt='Foto del Jugador " . $datos['NOMBRE'] . " " . $datos['APELLIDO'] . "'/></a><a class='li-listado-jugadores-a pfgreen hoverVerde' href='../usuarios/" . $datos['JUGADOR_ID'] . "' title='Ver'><span class='nombre_apellido_jugador'>" . $datos['NOMBRE'] . " " . $datos['APELLIDO'] . "</span><span class='ml-3 font-italic colorGris2 hoverVerde'> " . $datos['JUGADOR_ID'] . "</span></a><span " . $idCapitan . "> ". $iconCapitan ."</span>" . $boton . "</li>";
        }
        echo "</ul>";
    }


    public static function imprimirEquiposEnUl()
    {
        echo "<ul id='ulTotalBusqueda'>";
        $query = "SELECT A.EQUIPO_ID, A.NOMBRE  , SUBSTR(GROUP_CONCAT(C.NOMBRE ,' ', C.APELLIDO , ' ') ,1,50)AS JUGADORES FROM EQUIPOS A, JUGADORES B , USUARIOS C WHERE A.EQUIPO_ID = B.EQUIPO_ID  AND B.JUGADOR_ID = C.USUARIO_ID AND A.ACTIVO = 1 AND C.ACTIVO = 1 GROUP BY A.EQUIPO_ID , A.NOMBRE";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            echo "<li class='liresultadobusqueda' >";
            echo "<div class='marcoEscudo' ><div><img src = 'images/equipos/" . $datos['EQUIPO_ID'] . "_logo_100.jpg' alt = 'Logo Equipo " . $datos['EQUIPO_ID'] . "' /></div ></div>";
            echo "<div class='agruparDivs' ><div class='tituloResBusq' > " . $datos['NOMBRE'] . "</div >";
            echo "<div class='italicaResBusq' > Jugadores: " . $datos['JUGADORES'] . "...</div ></div >";
            echo "<div class='divflechaCirculo'>";
            echo "<a href='index.php?seccion=miequipo&equipo_id=" . $datos['EQUIPO_ID'] . "' title='Ver Equipo' ><img  class='flechaDerechaCirculo' src = 'images/icons/flechaderecha.png' alt = 'Ver Equipo' /></a >";
            echo "</div></li>";
        };
        echo "</ul>";
    }

    public static function imprimirEquiposEnTabla()
    {
        echo "<table  class='table table-condensed'>";
        echo "<tr><th>ID</th><th>NOMBRE</th><th>CAPITAN</th><th>ESTADO</th><th>ACCIONES</th></tr>";
        $query = "SELECT EQUIPO_ID, NOMBRE, CAPITAN_ID, ACTIVO, CASE ACTIVO WHEN 1  THEN 'Activo' ELSE 'Inactivo' END AS ACTIVOSTRING FROM EQUIPOS ORDER BY EQUIPO_ID";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($a = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            echo "<tr><td>$a[EQUIPO_ID]</td><td>$a[NOMBRE]</td><td>$a[CAPITAN_ID]</td><td>$a[ACTIVOSTRING]</td>";
            if ($a['ACTIVO'] == 1) {
                echo "<td><a class='text-danger' title='Inactivar $a[EQUIPO_ID]' href='desactivar-equipo/$a[EQUIPO_ID]'><i class='fas fa-times-circle'></i> Inactivar</a></td>";
            } else {
                echo "<td><a class='text-success' title='Activar $a[EQUIPO_ID]' href='activar-equipo/$a[EQUIPO_ID]'><i class='fas fa-check'></i> Activar</a></td>";
            }
            echo "</tr>";
        };
        echo "</table>";
    }

    public static function imprimirEquiposPorArray($array)
    {
        echo "<table  class='table table-condensed'>";
        echo "<tr><th>ID</th><th>NOMBRE</th><th>CAPITAN</th><th>ESTADO</th><th>ACCIONES</th></tr>";

        foreach($array as $a){
            echo "<tr><td>" . $a->getEquipoID() ."</td><td>". $a->getNombre()."</td><td>". $a->getCapitanID(). "</td><td>" . $a->getActivoString() . "</td>";
            if ($a->estaActivo()) {
                echo "<td><a class='text-danger' title='Inactivar ". $a->getEquipoID() . "' href='desactivar-equipo/". $a->getEquipoID() ."'><i class='fas fa-times-circle'></i> Inactivar</a></td>";
            } else {
                echo "<td><a class='text-danger' title='Activar ". $a->getEquipoID() . "' href='activar-equipo/". $a->getEquipoID() ."'><i class='fas fa-check'></i> Activar</a></td>";
            }
            echo "</tr>";
        };
        echo "</table>";
    }


    public static function ActualizarEstado($equipo_id, $activo)
    {
        $query = "UPDATE EQUIPOS SET ACTIVO = :activo WHERE EQUIPO_ID = :equipo_id";
        $stmt = DBConnection::getStatement($query);
        $param = ['activo' => $activo,
            'equipo_id' => $equipo_id];
        if ($stmt->execute($param)){
            $nombre = Equipo::getNombrePorID($equipo_id);
            if ($activo == "1") {
                $mensaje = "Se ha activado el equipo <span class='verde3 font-regular-bold'>". $nombre  . "</span>";
            } else {
                $mensaje = "Se ha desactivado el equipo <span class='verde3 font-regular-bold'>". $nombre . "</span>";
            }
            foreach(Equipo::GetJugadoresDelEquipo($equipo_id) as $jugador) {
                $notificacion = ['usuario_id' => $jugador,
                    'equipo_id' => $equipo_id,
                    'mensaje' => $mensaje];
                Notificacion::CrearNotificacion($notificacion);
            }
        } else {
            throw new EquipoNoGrabadoException("Error al actualizar el estado del equipo");
        }

    }

    public static function GetJugadoresDelEquipo($equipo) {
        $jugadores = [];

        $query = "SELECT JUGADOR_ID FROM JUGADORES WHERE EQUIPO_ID = :equipo_id  ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $equipo]);

        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $jugadores[] = $datos['JUGADOR_ID'];
        }
        return $jugadores;
    }


    public function estaJugandoTorneo()
    {
        $query = "SELECT 'X' FROM TORNEOS A, EQUIPOS_TORNEO B WHERE A.TORNEO_ID = B.TORNEO_ID AND B.EQUIPO_ID = :equipo_id  AND A.ESTADO_TORNEO_ID = 'C' ";

        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public static function BuscarEquipos($inputs, $activo = null)
    {

        $where = "WHERE 1 = 1 ";

        if ($activo) {
            $where .= $activo;
        }

        $datos = [];
        if ($inputs['id']) {
            $where .= " AND EQUIPO_ID = :id";
            $datos['id'] = $inputs['id'];
        }

        if ($inputs['nombre']) {
            $where .= " AND UPPER(NOMBRE) LIKE concat('%', UPPER(:nombre) , '%')  ";
            $datos['nombre'] = $inputs['nombre'];
        }

        $order = " ORDER BY NOMBRE";
        $query = "SELECT EQUIPO_ID FROM EQUIPOS " . $where . $order;

        $stmt = DBConnection::getStatement($query);
        $resultados = [];
        $stmt->execute($datos);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $resultados [] = New Equipo ($datos['EQUIPO_ID']);
        }
        return $resultados;
    }


    public static function getNombrePorID($id)
    {
        $datos = [
            'equipo_id' => $id
        ];
        $query = "SELECT NOMBRE FROM EQUIPOS WHERE EQUIPO_ID = :equipo_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        $nombre = "";
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $nombre = $datos['NOMBRE'];
        }
        return $nombre;
    }

    public function actualizar()
    {
        $this->setJugadores();
        Session::set('equipo', $this);
    }

    public function printOptionsJugadores($elegido = null)
    {

        $query = "SELECT A.JUGADOR_ID, B.APELLIDO, B.NOMBRE FROM JUGADORES A, USUARIOS B WHERE A.EQUIPO_ID = :equipo_id AND A.JUGADOR_ID = B.USUARIO_ID ORDER BY APELLIDO ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if ($elegido == $datos['JUGADOR_ID']) {
                $selected = " selected ";
            } else {
                $selected = "  ";
            }
            echo "<option value='" . $datos['JUGADOR_ID'] . "' " . $selected . ">" . $datos['APELLIDO'] . ", " . $datos['NOMBRE'] . "</option>";
        };
    }

    public function printJugadoresEnPartido($fichas, $esLocal)
    {
        echo "<div class='container_lista_jugadores'>";
        echo "<ul class='lista_jugadores list-group'>";

        $query = "SELECT A.JUGADOR_ID, B.NOMBRE , B.APELLIDO FROM JUGADORES A, USUARIOS B WHERE A.JUGADOR_ID = B.USUARIO_ID AND A.EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);

        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $ulFichas = "<ul>";
            $jugadorID = $datos['JUGADOR_ID'];

            IF ($jugadorID  == $this->capitan_id) {
                $ulFichas .= "<li>C</li>";
            }

            foreach ($fichas as $ficha) {
                if ($ficha->getJugadorID() == $jugadorID) {
                    $ulFichas .= "<li>". $ficha->getTipoEstadisticaID()."</li>";
                }
            }
            $ulFichas .= "</ul>";

            if ($esLocal) {
            //    echo "<li class='li-listado-jugadores-img list-group-item'>" . $ulFichas . "<a class='li-listado-jugadores-a pfgreen hoverVerde' href='../usuarios/" . $jugadorID . "' title='Ver'><span class='nombre_apellido_jugador'>" . $datos['APELLIDO'] . ", " . $datos['NOMBRE'] . "</span></a></li>";
                echo "<li class='li-listado-jugadores-img list-group-item'><a class='li-listado-jugadores-a pfgreen hoverVerde' href='". App::$urlPath . "/usuarios/" . $jugadorID . "' title='Ver'><span class='nombre_apellido_jugador'>" . $datos['APELLIDO'] . ", " . $datos['NOMBRE'] . "</span></a></li>";
            } else {
              //  echo "<li class='li-listado-jugadores-img list-group-item'><a class='li-listado-jugadores-a pfgreen hoverVerde' href='../usuarios/" . $jugadorID . "' title='Ver'><span class='nombre_apellido_jugador'>" . $datos['APELLIDO'] . ", " . $datos['NOMBRE'] . "</span></a>" . $ulFichas . "</li>";
                echo "<li class='li-listado-jugadores-img list-group-item'><a class='li-listado-jugadores-a pfgreen hoverVerde' href='". App::$urlPath . "/usuarios/" . $jugadorID . "' title='Ver'><span class='nombre_apellido_jugador'>" . $datos['APELLIDO'] . ", " . $datos['NOMBRE'] . "</span></a></li>";
            }
        }
        echo "</ul>";
        echo "</div>";
    }

    public function printFormularioPartido($partido)
    {
        if (Torneo::GetEstadoIdPorTorneo($partido->getTorneoID()) == 'C'){
            if (Session::has('logueado')) {
                $usuario = Session::get('usuario');
                if ($usuario->getUsuarioID() == $partido->getArbitroID()) {
                    ?>
                    <div class="form-container-cargar-datos">
                        <form action='agregar-ficha-partido' method='POST'>
                            <h4 class='mt-5 mb-4 pfgreen encabezado-cargar-datos'>Agregar Ficha al Equipo</h4>
                            <div class='form-group'>
                                <select name='tipo' class='form-control'>
                                    <?= TipoEstadistica::printOptions() ?>
                                </select>
                            </div>
                            <div class='form-group'>
                                <select name='jugador' class='form-control'>
                                    <?= $this->printOptionsJugadores() ?>
                                </select>
                            </div>
                            <input type="hidden" name="torneo" value="<?= $partido->getTorneoID() ?>">
                            <input type="hidden" name="fase" value="<?= $partido->getFaseID() ?>">
                            <input type="hidden" name="partido" value="<?= $partido->getPartidoID() ?>">
                            <input type="hidden" name="equipo" value="<?= $this->equipo_id ?>">
                            <button type='submit' class='btn btn-light'>Agregar</button>
                        </form>
                    </div>
                    <?php
                }
            }
        }
    }

    public function printEstadisticasEnPartido($fichas, $esLocal)
    {
        echo "<div class='container_datos_partido'>";
        echo "<ul class='lista_datos_partido list-unstyled'>";

        $query = "SELECT A.JUGADOR_ID, B.NOMBRE , B.APELLIDO FROM JUGADORES A, USUARIOS B WHERE A.JUGADOR_ID = B.USUARIO_ID AND A.EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);

        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $liFichas = "";
            $jugadorID = $datos['JUGADOR_ID'];

            IF ($jugadorID  == $this->capitan_id) {
                if ($esLocal){
                    $liFichas  .= "<li class='li_dato_capitan'><span class='dato_capitan'></span><span>Capitán: </span>". $datos['NOMBRE'] . " " . $datos['APELLIDO']."</li>";
                } else {
                    $liFichas  .= "<li class='li_dato_capitan'><span class='dato_capitan'></span><span>Capitán: </span>". $datos['NOMBRE'] . " " . $datos['APELLIDO']."</li>";
                }
            }

            foreach ($fichas as $ficha) {
                if ($ficha->getJugadorID() == $jugadorID) {
                    switch ($ficha) {
                    }
                    if ($esLocal){
                        $liFichas  .= "<li class='".$ficha->getTipoEstadisticaID() . "_dato'><span class='".$ficha->getTipoEstadisticaID()."'></span><span>".$ficha->getTipoEstadisticaDescr().": </span>". $datos['NOMBRE'] . " " . $datos['APELLIDO']."</li>";
                    } else {
                        $liFichas  .= "<li class='".$ficha->getTipoEstadisticaID() . "_dato'><span class='".$ficha->getTipoEstadisticaID()."'></span><span>".$ficha->getTipoEstadisticaDescr().": </span>". $datos['NOMBRE'] . " " . $datos['APELLIDO']."</li>";
                    }
                }
            }
            echo $liFichas ;
        }
        echo "</ul>";
        echo "</div>";
    }



    public function getProximosPartidos(){
        $partidos= [];

        $query = "SELECT A.TORNEO_ID TORNEO_ID, MIN(A.FASE_ID) FASE_ID FROM PARTIDOS  A , TORNEOS B WHERE A.TORNEO_ID = B.TORNEO_ID AND B.ESTADO_TORNEO_ID = 'C' AND :equipo_id IN (A.LOCAL_ID, A.VISITA_ID) AND A.JUGADO = 'N' GROUP BY A.TORNEO_ID";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);

        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $param = [
                'torneo_id' => $datos['TORNEO_ID'],
                'fase_id' => $datos['FASE_ID'],
                'equipo_id' => $this->equipo_id
            ];

            $query2 = "SELECT PARTIDO_ID FROM PARTIDOS WHERE TORNEO_ID = :torneo_id AND FASE_ID = :fase_id AND :equipo_id IN (LOCAL_ID, VISITA_ID) ";
            $stmt2 = DBConnection::getStatement($query2);
            $stmt2->execute($param);

            while ($datos2 = $stmt2->fetch(\PDO::FETCH_ASSOC)) {
                $partidos[] = New Partido( $datos['TORNEO_ID'], $datos['FASE_ID'], $datos2['PARTIDO_ID']);
            }
        }
        return $partidos;
    }

    public function getUltimaFecha()
    {

        $query = "SELECT A.TORNEO_ID TORNEO_ID , C.NOMBRE NOMBRE, A.FASE_ID FASE_ID , D.DESCRIPCION FASE_DESCR, A.PARTIDO_ID PARTIDO_ID FROM PARTIDOS  A, TORNEOS C , FASES D WHERE A.TORNEO_ID = C.TORNEO_ID AND :equipo_id IN (A.LOCAL_ID, A.VISITA_ID) AND D.TORNEO_ID = A.TORNEO_ID AND D.FASE_ID = A.FASE_ID AND A.FECHA = (SELECT MAX(B.FECHA) FROM PARTIDOS B WHERE A.TORNEO_ID = B.TORNEO_ID AND :equipo_id IN (A.LOCAL_ID, A.VISITA_ID) AND B.JUGADO = 'Y' )";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public static function GetEquiposCreados ($dias) {
        $query = "SELECT COUNT(*) CANTIDAD FROM EQUIPOS WHERE  DATEDIFF(CURDATE() , REGISTRADO_DT) <= :dias";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['dias' => $dias]);
        if ($respuesta = $stmt->fetch(\PDO::FETCH_ASSOC)){
            RETURN $respuesta['CANTIDAD'];
        } ELSE {
            RETURN 0;
        }
    }



}


