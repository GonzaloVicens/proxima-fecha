<?php
namespace Proyecto\Model;


use Proyecto\DB\DBConnection;
use Proyecto\Tools\Hash;
use Proyecto\Tools\Mail;
use Proyecto\Session\Session;
use Proyecto\Exceptions\UsuarioNoGrabadoException;
use Proyecto\Exceptions\AmigoNoGrabadoException;
use Proyecto\Exceptions\MensajesNoLeidosException;
use Proyecto\Model\Mensaje;
use Proyecto\Model\Equipo;
/**
 * Implementación de la clase Usuario
 */
class Usuario
{
    /**
     * @var string
     */
    protected $usuario_id;
    /**
     * @var string
     */
    protected $nombre;
    /**
     * @var string
     */
    protected $apellido;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $descripcion;
    /**
     * @var string
     */
    protected $activo;
    /**
     * @var string
     */
    protected $telefono;
    protected $ultimaVez;
    protected $password;

    /**
     * @var array of Equipo
     */
    protected $equipos;

    /**
     * @var array of Torneo
     */
    protected $torneos;

    /**
     * @var array of Torneo
     */
    protected $torneosPropios;


    /**
     * @var array of Usuario
     */
    protected $contactos;


    /**
     * Usuario constructor.
     * @param string $usu
     * @param null $pwd
     */
    public function __construct($usu , $pwd = null)
    {
        $this->usuario_id = $usu;
        if(!is_null($pwd)) {
            $this->password= $pwd;
        }
        $this->setUsuario();
        $this->setEquipos();
        $this->setTorneos();
        $this->setTorneosPropios();
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
        if($datos = $stmt->fetch(\PDO::FETCH_ASSOC)){
            if (Hash::verify($this->password,$datos['PASSWORD'] )){
                if ($datos['ACTIVO'] == '1'){
                    $rta = "";
                } else {
                    $rta = "El usuario no se encuentra activo";
                }
            } else {
                $rta = "La password es errónea" ;
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
                return  "El usuario ingresado no es admin";
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
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->equipos[] = New Equipo($datos['EQUIPO_ID']);

        };
    }

    public function setTorneos(){
        $this->torneos = [];
        $query = "SELECT DISTINCT A.TORNEO_ID FROM TORNEOS A, EQUIPOS_TORNEO B , JUGADORES C WHERE A.TORNEO_ID = B.TORNEO_ID AND B.EQUIPO_ID = C.EQUIPO_ID AND C.JUGADOR_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->torneos[] = New Torneo($datos['TORNEO_ID']);
        };
    }

    public function setTorneosPropios(){
        $this->torneosPropios = [];
        $query = "SELECT DISTINCT TORNEO_ID FROM ORGANIZADORES  WHERE ACTIVO = 1 AND ORGANIZADOR_ID =  :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->torneosPropios[] = New Torneo($datos['TORNEO_ID']);

        };
    }

    /**
     * Trae los datos de la base de datos del usuario asigando y lo guarda en la instancia
     */
    public function setUsuario()
    {
        $query = "SELECT NOMBRE, APELLIDO, EMAIL, ACTIVO, TELEFONO, ULTIMA_VEZ_ONLINE FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->apellido= $datos['APELLIDO'];
            $this->email = $datos['EMAIL'];
            $this->activo = $datos['ACTIVO'];
            $this->telefono = $datos['TELEFONO'];
            $this->ultimaVez = $datos['ULTIMA_VEZ_ONLINE'];
        };
    }

    public function tieneEquipo() {
        return !empty($this->equipos[0]);
    }

    public function tieneTorneo() {
        return !empty($this->torneos[0]);
    }

    public function tieneTorneosPropios() {
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

    /**
     * @return string
     */
    public function getUsuarioID(){
        return $this->usuario_id;
    }

    /**
     * @return string
     */
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getApellido(){
        return $this->apellido;
    }

    /**
     * Devuelve el nombre y el apellido concatenados
     * @return string
     */
    public function getNombreCompleto(){
        return $this->nombre . " " . $this->apellido;
    }

    /**
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }


    /**
     * Inserta los datos del usuario en la base de datos en base al parámetro vUsuario recibido
     * Si sale bien, devuelve el ID del usaurio creado
     * @param $vUsuario Array of String
     * @return mixed
     * @throws UsuarioNoGrabadoException
     */
    public static function CrearUsuario($vUsuario){
        $usuario= [
            'usuario_id'  => $vUsuario['usuario'],
            'password'    =>  Hash::encrypt($vUsuario['clave']),
            'nombre'      => ucfirst($vUsuario['nombre']),
            'apellido'    => ucfirst($vUsuario['apellido']),
            'email'       => $vUsuario['email'],
            'activo'      => '1',
            'telefono'   => null,
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

    /** Actualiza cuando e usuario inisio sesion
     *  Si sale bien, devuelve el ID del usaurio actualizado
     * @param $vUsuario
     * @return mixed
     * @throws UsuarioNoGrabadoException
     */
    public function inicioSesion(){
        $usuario= [
            'usuario_id'  => $this->usuario_id,
            'ultima_vez' => date("Y-m-d")
        ];

        $script = "UPDATE USUARIOS  SET ULTIMA_VEZ_ONLINE = :ultima_vez WHERE USUARIO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($usuario)) {
            return $this->usuario_id;
        } else {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
            throw new UsuarioNoGrabadoException("Error al grabar el usuario.");
        }
    }


    /**
     * @param $usuario_id
     * Método que envia un correo electronico al mail del usuario pasado por parámetro con los datos para poder iniciar sesión.
     * Además actualiza la contraseña del usuario con una temporal hasta que el usuario decida cambiarla
     */

    public static function EnviarPassword ($usuario_id){
        $usuarioOlvidado = new Usuario($usuario_id);

        $destinoMail = $usuarioOlvidado->getEmail();
        $destinoNombre = $usuarioOlvidado->getNombreCompleto();
        //genero una nueva clave de 8 digitos;
        $clave = "PF";
        for ($i = 0; $i <= 8 ; $i++) {
            $clave .= mt_rand(0, 9);
        };

        $usuario = [
            'usuario_id' => $usuario_id,
            'password' => Hash::encrypt($clave )
        ];

        $script = "UPDATE USUARIOS  SET PASSWORD = :password WHERE USUARIO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($script);
        if ($stmt->execute($usuario)) {
            Mail::enviarNuevoPassword($destinoNombre,$destinoMail,  $clave);

        }else{
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
            throw new UsuarioNoGrabadoException("Error al grabar el usuario.");
        }
    }




    /** Actualiza los datos del usuario en la base de datos en base al parámetro vUsuario recibido
     *  Si sale bien, devuelve el ID del usaurio actualizado
     * @param $vUsuario
     * @throws UsuarioNoGrabadoException
     */
    public function actualizarUsuario($vUsuario){

        $usuario= [
            'usuario_id'  => $this->usuario_id,
            'nombre'      => ucfirst($vUsuario['nombre']),
            'apellido'    => ucfirst($vUsuario['apellido']),
            'email'       => $vUsuario['email']
        ];

        $script = "UPDATE USUARIOS  SET NOMBRE = :nombre, APELLIDO = :apellido , EMAIL = :email WHERE USUARIO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($usuario)) {
            if (isset($vUsuario['clave']) && !empty($vUsuario['clave'])) {
                $usuario = [
                    'usuario_id' => $this->usuario_id,
                    'password' => Hash::encrypt($vUsuario['clave'])
                ];

                $script = "UPDATE USUARIOS  SET PASSWORD = :password WHERE USUARIO_ID = :usuario_id";
                $stmt = DBConnection::getStatement($script);
                if (!$stmt->execute($usuario)) {
                    echo "<pre>";
                    print_r($stmt->errorInfo());
                    echo "</pre>";
                    throw new UsuarioNoGrabadoException("Error al grabar el usuario.");
                }
            }
        } else {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
            throw new UsuarioNoGrabadoException("Error al grabar el usuario.");
        }
    }

    /**
     * Verifica en la base de datos si existe el usuario pasado por parámetro
     * @param $usuario_id
     * @return mixed
     */
    public static function existeUsuario ($usuario_id){
        $query = "SELECT 'X' FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    /**
     * Verifica en la base de datos si el usuario tiene algún amigo
     * @param $usuario_id
     * @return mixed
     */
    public function tieneAmigos (){
        $query = "SELECT 'X' FROM AMIGOS WHERE USUARIO_ID = :usuario_id OR AMIGO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' =>  $this->usuario_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }



    /**
     * Verifica en la base de datos si el usuario tiene como amigo al pasado por parámetro
     * @param $amigo_id
     * @return mixed
     */
        public function esAmigoDe ($amigo_id){
        $query = "SELECT 'X' FROM AMIGOS WHERE (USUARIO_ID = :usuario_id AND AMIGO_ID = :amigo_id) OR (USUARIO_ID = :amigo_id AND AMIGO_ID = :usuario_id)";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id, 'amigo_id' => $amigo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    /**
     * Agrega al amigo pasado por parámetro
     * @param $amigo_id
     * @return mixed
     * @throws AmigoNoGrabadoException
     */
    public function agregarAmigo ($amigo_id){
        $script = "INSERT INTO AMIGOS VALUES (:usuario_id, :amigo_id)";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute(['usuario_id' => $this->usuario_id, 'amigo_id' => $amigo_id])) {
            throw new AmigoNoGrabadoException("Error al grabar el amigo.");
        };
    }

    /**
     * Elimina al amigo pasado por parámetro
     * @param $amigo_id
     * @return mixed
     */
    public function eliminarAmigo ($amigo_id){
        $query = "DELETE FROM AMIGOS WHERE (USUARIO_ID = :usuario_id AND AMIGO_ID = :amigo_id) OR (USUARIO_ID = :amigo_id AND AMIGO_ID = :usuario_id)";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id, 'amigo_id' => $amigo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    /**
     * Devuelve un array con todos los Usuarios con los que el usuario haya compartido mensajes
     * @param $posteo
     * @return array
     */
    public function getConversaciones ()
    {
        $query = "SELECT AMIGO_ID FROM AMIGOS WHERE USUARIO_ID = :usuario_id UNION SELECT USUARIO_ID AS AMIGO_ID FROM AMIGOS WHERE  AMIGO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        $amigos = [];

        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $amigos [] = New Usuario( $datos['AMIGO_ID'] );
        }
        return $amigos ;
    }

    /**
     * Devuelve un array con todos los Mensajes entre el usuario y su contacto pasado por parámetro
     * @param $contacto_id
     * @return array
     */
    public function getMensajesCon ($contacto_id)
    {
        return Mensaje::GetConversacion($this->usuario_id , $contacto_id) ;
    }

    /**
     * Actualiza los mensajes marcando que ya ha leído los suyos.
     * @param $amigo_id
     * @throws MensajesNoLeidosException
     */

    public function leerMensajes ($amigo_id)
    {
        return Mensaje::leerMensajes($this->usuario_id , $amigo_id) ;
    }

    /**
     * Verifica si tiene Chts sin haberse leído del usuario parasado por parámetro
     * @param $amigo_id
     * @return boolean
     */
    public function tieneMensajesSinLeerDe ($contacto_id)
    {
        return Mensaje::HayMensajesSinLeer($this->usuario_id , $contacto_id) ;
    }

    public static function BuscarUsuarios($dato )
    {
        $query = "SELECT USUARIO_ID FROM USUARIOS WHERE UPPER(NOMBRE) LIKE concat('%', UPPER(:dato) , '%')  OR UPPER(APELLIDO) LIKE concat('%', UPPER(:dato) , '%') ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['dato' => $dato]);
        $resultados = [];
        while($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $resultados [] = New Usuario( $datos['USUARIO_ID'] );
        }
        return $resultados ;
    }


    /**
     * Verifica si tiene Chts sin haberse leído
     * @return boolean
     */
    public function tieneMensajesSinLeer ()
    {
        return Mensaje::HayMensajesSinLeer($this->usuario_id , $this->usuario_id ) ;
    }



    public static function imprimirUsuariosEnTabla()
    {
        echo"<table  class='table table-condensed'>";
        echo "<tr><th>USUARIO</th><th>NOMBRE</th><th>EMAIL</th><th>ESTADO</th><th>ACCIONES</th></tr>";
        $query = "SELECT USUARIO_ID, NOMBRE, APELLIDO, EMAIL, ACTIVO, CASE ACTIVO WHEN 1  THEN 'Activo' ELSE 'Inactivo' END AS ACTIVOSTRING FROM USUARIOS ORDER BY USUARIO_ID";
        $stmt = DBConnection::getStatement($query);

        $stmt->execute();
        while ($a = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            echo "<tr><td>$a[USUARIO_ID]</td><td>$a[NOMBRE] $a[APELLIDO]</td><td>$a[EMAIL]</td><td>$a[ACTIVOSTRING]</td>";
            if ($a['ACTIVO'] == 1) {
                echo "<td><a class='fa fa-trash fa-2x' title='Inactivar $a[USUARIO_ID]' href='desactivar-usuario/$a[USUARIO_ID]'>Inactivar</a></td>";
            } else {
                echo "<td><a class='fa fa-pencil fa-2x' title='Activar $a[USUARIO_ID]' href='activar-usuario/$a[USUARIO_ID]'>Activar</a></td>";
            }
            echo "</tr>";
        };

        echo "</table>";

    }



    public static function ActualizarEstado($usuario_id, $activo){
        $query = "UPDATE USUARIOS SET ACTIVO = :activo WHERE USUARIO_ID = :usuario_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['activo' => $activo, 'usuario_id' => $usuario_id]);
        $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public static function imprimir($aImprimir)
    {
        echo "<pre>";
        print_r($aImprimir);
        echo "</pre>";
    }



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



    public function tieneContactos(){
        Return Mensaje::HayMensajesDeUsuario($this->getUsuarioID());
    }


    public function getContactos(){
        return Mensaje::GetContactosDeMensajesDeUsuario ($this->usuario_id);
    }

    public function esCapitanDeEquipo(){
        $query = "SELECT 'Y' FROM EQUIPOS WHERE CAPITAN_ID= :usuario_id AND ACTIVO = '1' ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function esOrganizadorDeTorneo($torneo_id){
        $query = "SELECT 'Y' FROM ORGANIZADORES WHERE TORNEO_ID = :torneo_id AND ORGANIZADOR_ID = :usuario_id AND ACTIVO = 1 ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id, 'torneo_id' => $torneo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function puedeAgregarEquiposEnTorneo($torneo_id){
        $query = "SELECT 'Y' FROM TORNEOS A, ORGANIZADORES B WHERE A.TORNEO_ID = B.TORNEO_ID AND A.TORNEO_ID = :torneo_id AND B.ORGANIZADOR_ID = :usuario_id AND A.ESTADO_TORNEO_ID = 'I' AND B.ACTIVO = 1 ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $this->usuario_id, 'torneo_id' => $torneo_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function actualizar(){
        $this->setUsuario();
        $this->setEquipos();
        $this->setTorneos();
        $this->setTorneosPropios();
    }

    public static function getNombreDeUsuario ($usuario_id){
        $query = "SELECT NOMBRE , APELLIDO FROM USUARIOS WHERE USUARIO_ID = :usuario_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id]);
        if ($a = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $a['APELLIDO'] . ', ' . $a['NOMBRE'];
        } else {
            throw new UsuarioNoEncontradoException ("No existe el usuario.");
        }

    }



}

