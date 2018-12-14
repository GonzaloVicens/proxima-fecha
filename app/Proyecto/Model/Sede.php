<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Exceptions\SedeNoGrabadaException;
use Proyecto\Session\Session;
use Proyecto\Model\Cancha;
use Proyecto\Core\App;


/**
 * Implementación de la clase Sede
 */
class Sede
{
    /**
     * @var integer
     */
    protected $sede_id;
    /**
     * @var string
     */
    protected $nombre;
    /**
     * @var string
     */
    protected $pais;

    /**
     * @var string
     */
    protected $provincia;

    /**
     * @var string
     */
    protected $codigo_postal;

    /**
     * @var string
     */
    protected $calle;

    /**
     * @var integer
     */
    protected $altura;

    /**
     * @var string
     */
    protected $telefono;

    /**
     * @var string
     */
    protected $detalles;


    /**
     * @var array of Canchas;
     */
    protected $canchas;

    /**
     * @var array of Canchas;
     */
    protected $duenos;



    /**
     * Usuario constructor.
     * @param null $equi
     */
    public function __construct($sede = null)
    {
        if(!is_null($sede)) {
            $this->setSede($sede);
            $this->setCanchas();
            $this->setDuenos();
        }
    }

    public static function CrearSede($inputs, $duenio){
        $sede= [
            'nombre' => $inputs['nombre'],
            'pais_id' => 'ARG',
            'provincia_id' => $inputs['provincia'],
            'codigo_postal'   =>  $inputs['postal'],
            'calle'   =>  $inputs['calle'],
            'altura' => $inputs['altura'],
            'telefono' => $inputs['telefono'],
            'detalles' => $inputs['detalles']
        ];

        $script = "INSERT INTO SEDES VALUES ( null, :nombre, :pais_id, :provincia_id, :codigo_postal, :calle, :altura, :telefono, :detalles)";
        $stmt = DBConnection::getStatement($script );
        if($stmt->execute($sede)) {
            $sede_id= DBConnection::getConnection()->lastInsertId();

            $dueno= [
                'sede_id' => $sede_id,
                'usuario_id'   =>  $duenio
            ];

            $script = "INSERT INTO DUENOS VALUES (:sede_id, :usuario_id, 1)";
            $stmt = DBConnection::getStatement($script );
            $stmt->execute($dueno);


            return $sede_id;
        } else {
            throw new SedeNoGrabadaException("Error al grabar la sede.");
        }
    }


    public static function ActualizarSede($inputs){

        $sede= [
            'sede_id' => $inputs['sede_id'],
            'nombre' => $inputs['nombre'],
            'pais_id' => 'ARG',
            'provincia_id' => $inputs['provincia'],
            'codigo_postal'   =>  $inputs['postal'],
            'calle'   =>  $inputs['calle'],
            'altura' => $inputs['altura'],
            'telefono' => $inputs['telefono'],
            'detalles' => $inputs['detalles']
        ];

        $script = "UPDATE SEDES SET NOMBRE = :nombre, PAIS_ID = :pais_id, PROVINCIA_ID = :provincia_id, CODIGO_POSTAL= :codigo_postal, CALLE= :calle , ALTURA = :altura, TELEFONO= :telefono, DETALLES= :detalles WHERE SEDE_ID = :sede_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($sede)) {
            throw new SedeNoGrabadaException("Error al grabar la sede.");
        };
    }


    public static function existeSede($sede_id){
        $query = "SELECT 'X' FROM SEDES WHERE SEDE_ID = :sede_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['sede_id' => $sede_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function eliminarSede(){

        $sede= [
            'sede_id' => $this->sede_id
        ];

        $script = "DELETE FROM CANCHAS WHERE SEDE_ID = :sede_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($sede)) {
            throw new SedeNoGrabadaException("Error al grabar la sede.");
        };

        $script = "DELETE FROM DUENOS WHERE SEDE_ID = :sede_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($sede)) {
            throw new SedeNoGrabadaException("Error al grabar la sede.");
        };

        $script = "DELETE FROM SEDES WHERE SEDE_ID = :sede_id";
        $stmt = DBConnection::getStatement($script );
        if(!$stmt->execute($sede)) {
            throw new SedeNoGrabadaException("Error al grabar la sede.");
        };

    }



    public function setSede($sede)
    {
        $this->sede_id = $sede;

        $query = "SELECT NOMBRE, PAIS_ID, PROVINCIA_ID, CODIGO_POSTAL, CALLE, ALTURA, TELEFONO, DETALLES FROM SEDES WHERE SEDE_ID = :sede_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['sede_id' => $this->sede_id]);
        if ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->nombre = $datos['NOMBRE'];
            $this->pais_id = $datos['PAIS_ID'];
            $this->provincia_id= $datos['PROVINCIA_ID'];
            $this->codigo_postal= $datos['CODIGO_POSTAL'];
            $this->calle = $datos['CALLE'];
            $this->altura= $datos['ALTURA'];
            $this->telefono = $datos['TELEFONO'];
            $this->detalles = $datos['DETALLES'];
        };

    }


    public function setCanchas()
    {
        $this->canchas = [];
        $query = "SELECT CANCHA_ID FROM CANCHAS WHERE SEDE_ID = :sede_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['sede_id' => $this->sede_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->canchas[] = New Cancha($this->sede_id, $datos['CANCHA_ID']);
        };
    }

    public function setDuenos(){
        $this->duenos= [];
        $query = "SELECT USUARIO_ID FROM DUENOS WHERE SEDE_ID = :sede_id  AND ACTIVO = '1'  ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['sede_id' => $this->sede_id]);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $this->duenos[] = $datos['USUARIO_ID'];
        };
    }

    public function getSedeId(){
        return $this->sede_id;
    }
    public function getCanchas(){
        return $this->canchas;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function existeCancha($cancha_id){
        $datos = ['sede_id' => $this->sede_id,
                    'cancha_id' => $cancha_id
        ];

        $query = "SELECT 'X' FROM CANCHAS WHERE SEDE_ID = :sede_id AND CANCHA_ID = :cancha_id ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function insertarCancha($decripcion , $deporte, $precio){
        Cancha::CrearCancha($this->sede_id, $decripcion , $deporte, $precio);
    }


    public static function printOptionsSedes($elegida = null){


        $query = "SELECT SEDE_ID , NOMBRE FROM SEDES ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            if ($datos['SEDE_ID'] == $elegida) {
                $selected = " selected ";
            } else {
                $selected = " ";
            }
            echo "<option value='" . $datos['SEDE_ID'] . "' ". $selected. ">" . $datos['NOMBRE']  . "</option>";
        }       ;
    }

    public static function printOptionsProvincias($elegida = null){
        $query = "SELECT PROVINCIA_ID , PROVINCIA FROM PROVINCIAS WHERE PAIS_ID = 'ARG'";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute();
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            if ($datos['PROVINCIA_ID'] == $elegida) {
                $selected = " selected ";
            } else {
                $selected = " ";
            }
            echo "<option value='" . $datos['PROVINCIA_ID'] . "' ". $selected. ">" . $datos['PROVINCIA']  . "</option>";
        }       ;
    }

    public function getDuenos() {
        return $this->duenos;
    }

    public function getDuenosActivos(){
        return $this->getTodosLosDuenos(" AND B.ACTIVO = '1' ");
    }


    public function getTodosLosDuenos($where = null){
        $respuesta= [];
        $query = "SELECT B.USUARIO_ID, A.NOMBRE, A.APELLIDO, B.ACTIVO FROM USUARIOS A, DUENOS B WHERE A.USUARIO_ID = B.USUARIO_ID AND B.SEDE_ID = :sede_id ";

        if (isset($where)){
            $query .= $where ;
        }

        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['sede_id' => $this->sede_id]);

        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $respuesta[] = $datos;
        };

        return $respuesta;
    }

    public function actualizar(){
        $this->setSede($this->sede_id);
        $this->setCanchas();
        $this->setDuenos();
        Session::clearValue('sede');
        Session::set('sede',$this);
    }

    public function getPais() {
        return $this->pais;
    }


    public function getPaisDescr() {
        return Pais::getDescripcion($this->pais);
    }

    public function getProvincia() {
        return $this->provincia;
    }

    public function getProvinciaDescr() {
        return Provincia::getDescripcion($this->pais, $this->provincia);
    }

    public function getCalle() {
        return $this->calle ;
    }

    public function getAltura() {
        return $this->altura ;
    }

    public function getDireccion() {
        return $this->calle . " " . $this->altura ;
    }

    public function getCodigoPostal() {
        return $this->codigo_postal;
    }


    public function getTelefono(){
        return $this->telefono;
    }

    public function getDetalles() {
        return $this->detalles;
    }

    public function tieneCanchas(){
        return !empty($this->canchas[0]);
    }

    public function tieneDueno($usuario_id){
        $query = "SELECT 'Y' FROM DUENOS WHERE SEDE_ID = :sede_id AND USUARIO_ID = :usuario_id AND ACTIVO = 1 ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['usuario_id' => $usuario_id, 'sede_id' => $this->sede_id]);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public  function printCanchasEnLi($origen){
        foreach ($this->canchas as $canchaAMostrar) {

            echo "<li class='list-group-item'>" . $canchaAMostrar->getNombre() ;
            echo "<ul><li>Deporte: ".  $canchaAMostrar->getDeporteDescr() ."</li><li> Precio: $" . $canchaAMostrar->getPrecio() . "</li></ul>";
            if (Session::has('usuario')) {
                $usuario = Session::get('usuario');
                if ($this->tieneDueno($usuario->getUsuarioID()) ) {
                    echo "<form style='display:inline' action='eliminar-cancha' method='POST'>";
                    echo "<input type='hidden' name='sede_id' value='" . $this->getSedeId() ."'/>";
                    echo "<input type='hidden' name='cancha_id' value='" . $canchaAMostrar->getCanchaId() ."'/>";
                    echo "<input type='submit' value='Eliminar'/></form>";
                }
            }
            echo "</li>";
        }
    }


    public function existeDueno($dueno_id){
        $datos = ['sede_id' => $this->sede_id,
            'dueno_id' => $dueno_id
        ];

        $query = "SELECT 'X' FROM DUENOS WHERE SEDE_ID = :sede_id AND USUARIO_ID = :dueno_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }


    public function tieneOtrosDuenos($dueno_id){
        $datos = ['sede_id' => $this->sede_id,
            'dueno_id' => $dueno_id
        ];

        $query = "SELECT 'X' FROM DUENOS WHERE SEDE_ID = :sede_id AND USUARIO_ID != :dueno_id AND ACTIVO = '1' ";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function tieneDuenoActivo($dueno_id){
        $datos = ['sede_id' => $this->sede_id,
            'dueno_id' => $dueno_id
        ];

        $query = "SELECT 'X' FROM DUENOS WHERE SEDE_ID = :sede_id AND USUARIO_ID = :dueno_id AND ACTIVO = '1'";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos);
        return ($stmt->fetch(\PDO::FETCH_ASSOC)) ;
    }

    public function editarDueno($dueno_id, $activo)
    {

        if ($activo) {
            $activo = '0';
        } else {
            $activo = '1';
        }

        $datos = ['sede_id' => $this->sede_id,
            'dueno_id'  => $dueno_id,
            'activo'          => $activo
        ];
        $query = "UPDATE DUENOS SET ACTIVO = :activo WHERE SEDE_ID = :sede_id AND USUARIO_ID =  :dueno_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos );
        $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insertarDueno($dueno_id){
        $datos = ['sede_id' => $this->sede_id,
            'dueno_id' => $dueno_id
        ];
        $query = "INSERT INTO DUENOS VALUE (:sede_id , :dueno_id, '1')";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($datos );
        $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function agregarCancha($inputs){
        Cancha::CrearCancha($inputs);
    }

    public function eliminarCancha($inputs){
        Cancha::EliminarCancha($inputs);
    }

}