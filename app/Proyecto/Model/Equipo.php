<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\EquipoNoGrabadoException;

/**
 * Implementación de la clase Equipo
 */
class Equipo
{
    /**
     * @var string
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

    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($equi = null)
    {
        if(!is_null($equi)) {
            $this->setEquipo($equi);
        }
    }


    public static function CrearEquipo($nombre , $capitan){
        $equipo= [
            'nombre' => $nombre,
            'capitan_id'   =>  $capitan
        ];

        $script = "INSERT INTO EQUIPOS VALUES (null, :nombre, :capitan_id, 1)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($equipo)) {
            $idEquipo = DBConnection::getConnection()->lastInsertId();
            $jugador= [
                'equipo_id' => $idEquipo,
                'jugador_id'   =>  $capitan
            ];


            $script = "INSERT INTO JUGADORES VALUES (:equipo_id, :jugador_id)";
            $stmt = DBConnection::getStatement($script );
            $stmt->execute($jugador);
            return $idEquipo;
        } else {
            throw new EquipoNoGrabadoException("Error al grabar el equipo.");
        }
    }


    public static function existeEquipo($equipo_id){
        $query = "SELECT 'X' FROM EQUIPOS WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $equipo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function existeJugador($jugador_id){
        $datos = ['equipo_id' => $this->equipo_id,
            'jugador_id' => $jugador_id
        ];

        $query = "SELECT 'X' FROM JUGADORES WHERE EQUIPO_ID = :equipo_id AND JUGADOR_ID = :jugador_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function insertarJugador($jugador_id){
        $datos = ['equipo_id' => $this->equipo_id,
            'jugador_id' => $jugador_id
        ];
        $query = "INSERT INTO JUGADORES VALUE (:equipo_id , :jugador_id)";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos );
        $stmt->fetch(\PDO::FETCH_ASSOC);
    }




    public function setEquipo($equi)
    {
        $this->equipo_id = $equi;

        $query = "SELECT NOMBRE, CAPITAN_ID FROM EQUIPOS WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->capitan_id = $datos['CAPITAN_ID'];
        };
        $this->jugadores = [];
    }


    public function setJugadores()
    {
        $this->jugadores = [];
        $query = "SELECT JUGADOR_ID FROM JUGADORES WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->jugadores[] = New Usuario($datos['JUGADOR_ID']);
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


    /**
     * @return null|Torneo
     */
    public function getTorneo()
    {
        $query = "SELECT TORNEO_ID FROM EQUIPOS_TORNEO WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return new Torneo($datos['TORNEO_ID']);
        };
        return null;
    }

    public function participaEnTorneo()
    {
        $query = "SELECT 'X' FROM EQUIPOS_TORNEO WHERE EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function printJugadoresEnUL()
    {
        echo"<ul>";
        $query = "SELECT A.JUGADOR_ID, B.NOMBRE , B.APELLIDO FROM JUGADORES A, USUARIOS B WHERE A.JUGADOR_ID = B.USUARIO_ID AND A.EQUIPO_ID = :equipo_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['equipo_id' => $this->equipo_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            IF (($datos['JUGADOR_ID'] == $this->capitan_id) &&  (Session::has("usuario"))){
                $idCapitan = "id='capitan'";
                $boton = "<a href='#mensajeModal' class='mayuscula'>Enviar Mensaje</a>";
            } else {
                $idCapitan = "";
                $boton = "";
            }

            if(file_exists('img/usuarios/'.$datos['JUGADOR_ID'] . '.jpg')){
                $rutaImagen = "../img/usuarios/".$datos['JUGADOR_ID']. ".jpg";
            }else {
                $rutaImagen = "../img/usuarios/UserJugador.jpg";
            }


            echo "<li><a href='../usuarios/".$datos['JUGADOR_ID']."' title='Ver'><img src='$rutaImagen' alt='Foto del Jugador " . $datos['NOMBRE'] . " " . $datos['APELLIDO'] . "'/></a><a href='../usuarios/".$datos['JUGADOR_ID']."' title='Ver'><span ".$idCapitan.">" . $datos['NOMBRE'] . " " . $datos['APELLIDO'] . "</span></a>".$boton ."</li>";
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
            echo "<div class='marcoEscudo' ><div><img src = 'images/equipos/". $datos['EQUIPO_ID']."_logo_100.jpg' alt = 'Logo Equipo ".$datos['EQUIPO_ID']."' /></div ></div>";
            echo "<div class='agruparDivs' ><div class='tituloResBusq' > ". $datos['NOMBRE'] ."</div >";
            echo "<div class='italicaResBusq' > Jugadores: ". $datos['JUGADORES'] . "...</div ></div >";
            echo "<div class='divflechaCirculo'>";
            echo "<a href='index.php?seccion=miequipo&equipo_id=".$datos['EQUIPO_ID']."' title='Ver Equipo' ><img  class='flechaDerechaCirculo' src = 'images/icons/flechaderecha.png' alt = 'Ver Equipo' /></a >";
            echo "</div></li>";
        };
        echo "</ul>";
    }

    public static function imprimirEquiposEnTabla()
    {
        echo"<table  class='table table-condensed'>";
        echo "<tr><th>ID</th><th>NOMBRE</th><th>CAPITAN</th><th>ESTADO</th><th>ACCIONES</th></tr>";
        $query = "SELECT EQUIPO_ID, NOMBRE, CAPITAN_ID, ACTIVO, CASE ACTIVO WHEN 1  THEN 'Activo' ELSE 'Inactivo' END AS ACTIVOSTRING FROM EQUIPOS ORDER BY EQUIPO_ID";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($a = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            echo "<tr><td>$a[EQUIPO_ID]</td><td>$a[NOMBRE]</td><td>$a[CAPITAN_ID]</td><td>$a[ACTIVOSTRING]</td>";
            if ($a['ACTIVO'] == 1) {
                echo "<td><a title='Inactivar $a[EQUIPO_ID]' href='php/equipo.desactivar.php?id=$a[EQUIPO_ID]'>Inactivar</a></td>";
            } else {
                echo "<td><a title='Activar $a[EQUIPO_ID]' href='php/equipo.activar.php?id=$a[EQUIPO_ID]'>Activar</a></td>";
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
        $stmt->execute($param);
        $stmt->fetch(\PDO::FETCH_ASSOC);
    }



}
