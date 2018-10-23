<?php

/**
 * Implementación de la clase Usuario
 */

namespace Proyecto\Model;
use Proyecto\DB\DBConnection;
use PDO;

class Usuario
{

    private $usuario_id;
    private $nombre;
    private $apellido;
    private $email;
    private $activo;
    private $telefono;
    private $ultimaVez;

    private $password;
    private $equipos;
    private $torneos;
    private $torneosPropios;

    /*
    protected $usuario_id;
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $activo;
    protected $telefono;
    protected $ultimaVez;

    protected $password;
    protected $equipos;
    protected $torneos;
    protected $torneosPropios;
    */

    /**
     * Usuario constructor.
     * @param string $usu
     * @param null $pwd
     */

    /*
    public function __construct($usu , $pwd = null)
    {
        $this->usuario_id = $usu;
        if(!is_null($pwd)) {
            $this->password= SHA1($pwd);
        }
        $this->setUsuario();
        $this->setEquipos();
        $this->setTorneos();
        $this->setTorneosPropios();
    }
    */


    /**
     * @param $data
     * @return null|Usuario
     *
     * AGREGADO por Gonzalo
     *
     */

    public static function buscarPorUsuario($data)
    {
        $query = "select * from usuarios where USUARIO = ? LIMIT 1";

        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);

        $exito = $stmt->execute([$data]);

        if($fila = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $usu = new Usuario;
            $usu->cargarDatos($fila);
            return $usu;
        }

        return null;
    }



    /**
     * Valida el usuario instanciado existe en la base de datos y está activo;
     * @return string
     */
    public function validarUsuario(){
        $rta = "";
        $query = "SELECT PASSWORD, ACTIVO FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id'=> $this->usuario_id  ]);
        if($datos = $stmt->fetch(PDO::FETCH_ASSOC)){
            if ($datos['PASSWORD'] == $this->password){
                if ($datos['ACTIVO'] == '1'){
                    $rta = "";
                } else {
                    $rta = "El usuario no se encuentra activo";
                }
            } else {
                $rta = "La password es errónea";
            }

        } else {
            $rta = "El usuario no existe";
        }

        return $rta;
    }

    public function validarAdmin(){
        if($this->validarUsuario()){
            return "Error en el usuario y/o contraseña";
        } else {
            if($this->usuario_id !== "pf_admin"){
                return  "Error en el usuario y/o contraseña";
            }else {
                return "";
            }
        }
    }


    public function setEquipo($equipo)
    {
        $this->equipos[] = New Equipo($equipo);
    }

    public function setEquipos(){
        $this->equipos = [];
        $query = "SELECT EQUIPO_ID FROM JUGADORES WHERE JUGADOR_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->equipos[] = New Equipo($datos['EQUIPO_ID']);

        };
    }

    public function setTorneos(){
        $this->torneos = [];
        $query = "SELECT DISTINCT A.TORNEO_ID FROM TORNEOS A, EQUIPOS_TORNEO B , JUGADORES C WHERE A.TORNEO_ID = B.TORNEO_ID AND B.EQUIPO_ID = C.EQUIPO_ID AND C.JUGADOR_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->torneos[] = New Torneo($datos['TORNEO_ID']);
        };
    }

    public function setTorneosPropios(){
        $this->torneosPropios = [];
        $query = "SELECT DISTINCT A.TORNEO_ID FROM TORNEOS A, ORGANIZADORES B WHERE A.TORNEO_ID = B.TORNEO_ID AND B.ACTIVO = 1 AND B.ORGANIZADOR_ID =  :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->torneosPropios[] = New Torneo($datos['TORNEO_ID']);

        };
    }


    public function setUsuario()
    {
        $query = "SELECT NOMBRE, APELLIDO, EMAIL, ACTIVO, TELEFONO, ULTIMA_VEZ_ONLINE FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        if ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->apellido= $datos['APELLIDO'];
            $this->email = $datos['EMAIL'];
            $this->activo = $datos['ACTIVO'];
            $this->telefono = $datos['TELEFONO'];
            $this->ultimaVez = $datos['ULTIMA_VEZ_ONLINE'];
        };
    }



    public static function CrearUsuario($vUsuario){
        $usuario= [
            'usuario_id' => $vUsuario['usuario'],
            'password'   =>  SHA1($vUsuario['clave']),
            'nombre'     => ucfirst($vUsuario['nombre']),
            'apellido'   => ucfirst($vUsuario['apellido']),
            'email'      => ucfirst($vUsuario['email']),
            'activo'     => '1',
            'telefono'   => $vUsuario['telefono'],
            'ultima_vez' => date("Y-m-d")
        ];

        $script = "INSERT INTO USUARIOS  VALUES (:usuario_id, :password, :nombre , :apellido, :email, :activo, :telefono, :ultima_vez)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($usuario)) {
            return $vUsuario['usuario'];
        } else {
            throw new UsuarioNoGrabadoException("Error al grabar el usuario.");
        }
    }

    public static function existeUsuario ($usuario_id){
        $query = "SELECT 'X' FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return ($stmt->fetch(PDO::FETCH_ASSOC)) ;
    }


    public static function imprimirUsuariosEnTabla()
    {
        echo"<table  class='table table-condensed'>";
        echo "<tr><th>USUARIO</th><th>NOMBRE</th><th>EMAIL</th><th>ESTADO</th><th>ACCIONES</th></tr>";


        $query = "SELECT USUARIO_ID, NOMBRE, APELLIDO, EMAIL, ACTIVO, CASE ACTIVO WHEN 1  THEN 'Activo' ELSE 'Inactivo' END AS ACTIVOSTRING FROM USUARIOS ORDER BY USUARIO_ID";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($a = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>$a[USUARIO_ID]</td><td>$a[NOMBRE] $a[APELLIDO]</td><td>$a[EMAIL]</td><td>$a[ACTIVOSTRING]</td>";
            if ($a['ACTIVO'] == 1) {
                echo "<td><a class='fa fa-trash fa-2x' title='Inactivar $a[USUARIO_ID]' href='php/usuario.desactivar.php?id=$a[USUARIO_ID]'>Inactivar</a></td>";
            } else {
                echo "<td><a class='fa fa-pencil fa-2x' title='Activar $a[USUARIO_ID]' href='php/usuario.activar.php?id=$a[USUARIO_ID]'>Activar</a></td>";
            }
            echo "</tr>";
        };
        echo "</table>";

    }

    public static function ActualizarEstado($usuario_id, $activo){
        $query = "UPDATE USUARIOS SET ACTIVO = :activo WHERE USUARIO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['activo' => $activo, 'usuario_id' => $usuario_id]);
        $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public static function imprimir($aImprimir)
    {
        echo "<pre>";
        print_r($aImprimir);
        echo "</pre>";
    }



    /**
     * Carga los datos del array en el objeto.
     *
     * @param $data
     */
    protected function cargarDatos($data)
    {
        $this->setId($data['id']);
        $this->setUsuario($data['usuario']);
        $this->setPassword($data['password']);
        $this->setMail($data['mail']);
        $this->setNombre($data['nombre']);
        $this->setApellido($data['apellido']);
        $this->setFechaNac($data['fecha_nac']);
        $this->setSexo($data['sexo']);
        $this->setPais($data['pais']);

    }

    /**** SETTERS AND GETTERS *****/



    public function tieneEquipo() {
        return !empty($this->equipos[0]);
    }

    public function tieneTorneo() {
        return !empty($this->torneos[0]);
    }

    public function tieneTorneoPropio() {
        return !empty($this->torneosPropios[0]);
    }

    public function getEquipos(){
        return $this->equipos;
    }

    public function getTorneos(){
        return $this->torneos;
    }

    public function getTorneosPropios(){
        return $this->torneosPropios;
    }

    public function getUsuarioID(){
        return $this->usuario_id;
    }


    public function getNombre(){
        return $this->nombre;
    }


    public function getApellido(){
        return $this->apellido;
    }

    public function getNombreCompleto(){
        return $this->nombre . " " . $this->apellido;
    }



}


