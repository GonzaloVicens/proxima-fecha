<?php
namespace Proyecto\Model;
use Proyecto\DB\DBConnection;
use PDO;

/**
 * Class Usuario
 * @package Proyecto\Model
 *
 * Modelo de la tabla usuarios.
 */
class Usuario
{
    // Propiedades
    private $id;
    private $usuario;
    private $password;
    private $mail;
    private $nombre;
    private $apellido;
    private $fecha_nac;
    private $sexo;
    private $pais;
    private $imagen;

    /**
     * Intenta loguear al usuario.
     *
     * @param $usuario
     * @param $password
     * @return bool|Usuario
     */
    public static function login($usuario, $password)
    {
       $query = "SELECT IDUSUARIO, USUARIO, PASSWORD FROM usuarios
                  WHERE USUARIO = ? LIMIT 1";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$usuario]);

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$userData) {
            return false;
        }

        // Si el usuario existe, entonces verificamos el password...
        if(!password_verify($password, $userData['password'])) {
            return false;
        }

        // Si está todo bien, creamos un objeto Usuario con los
        // datos y lo retornamos.
        $user = new Usuario;
        $user->cargarDatos($userData);
        return $user;
    }



    /**
     * @param $usuario
     * @return null|Usuario
     *
     * Busca usuario en la tabla Usuarios por medio del nombre.
     *
     * Si encuentra el nombre devuelve un objeto o instancia de la clase Usuario
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


    public static function buscarPorId($id)
    {
        $query = "select * from usuarios
                      where IDUSUARIO = ? LIMIT 1";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $exito = $stmt->execute([$id]);
        if($fila = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $usu = new Usuario;
            $usu->cargarDatos($fila);
            return $usu;
        }
        return null;
    }

    /*
     * Busca el nombre (usuario) del usuario con el parámetro del
     * id del usuario
     * * @param $idusuario
     * Devuelve el nombre (usuario) del usuario NO un objeto Usuario
     *
     * @return string
     */

    public static function devolverNombre($idusuario)
    {
        $query = "SELECT USUARIO FROM usuarios
                      WHERE IDUSUARIO = ?";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $stmt->execute([$idusuario]);
        $rta = $stmt->fetch();
        $salida = $rta['usuario'];
        return $salida;
    }

    /**
     * Carga los datos del array en el objeto.
     *
     * @param $data
     */
    protected function cargarDatos($data)
    {
        $this->setId($data['IDUSUARIO']);
        $this->setUsuario($data['USUARIO']);
        $this->setPassword($data['PASSWORD']);
        $this->setMail($data['NIVEL']);
        $this->setMail($data['ACTIVO']);
        //$this->setNombre($data['nombre']);
        //$this->setApellido($data['apellido']);
        //$this->setFechaNac($data['fecha_nac']);
        //$this->setSexo($data['sexo']);
        //$this->setPais($data['pais']);
    }


    public static function crear($data)
    {
        $query = "INSERT INTO usuarios (usuario, nombre, apellido, mail, fecha_nac, sexo, pais, password)
                  VALUES (:usuario, :nombre, :apellido, :mail, :fecha_nac, :sexo, :pais, :password)";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $exito = $stmt->execute($data);

        if(!$exito) {
            throw new \Exception("Error al crear el usuario.");
        }
    }


    public static function editar($data)
    {
        $query = "UPDATE usuarios SET usuario = :usuario, nombre = :nombre, apellido = :apellido, mail = :mail, fecha_nac = :fecha_nac, sexo = :sexo, pais = :pais, password = :password WHERE id = :id";
        $db = DBConnection::getConnection();
        $stmt = $db->prepare($query);
        $exito = $stmt->execute($data);
        if(!$exito) {
            throw new \Exception("Error al editar la informació del usuario.");
        }
    }

    /***** SETTERS & GETTERS *****/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * @return mixed
     */
    public function getFechaNac()
    {
        return $this->fecha_nac;
    }

    /**
     * @param mixed $fecha_nac
     */
    public function setFechaNac($fecha_nac)
    {
        $this->fecha_nac = $fecha_nac;
    }

    /**
     * @return mixed
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * @param mixed $sexo
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     */
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    /**
     * @return mixed
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * @param mixed $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }
}