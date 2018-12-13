<?php
namespace Proyecto\Tools;

use Proyecto\Model\Usuario;

class FormValidator
{
    /**
     * Campos que se mandan a validar
     * @var array
     */
    protected $campos= [];

    /**
     * Campos que están en error luego de validar
     * @var array
     */
    protected $camposError = [];

    /**
     * Atributo privado donde se guarda la clave para luego ver si coincide con su confirmación.
     * @var string
     */
    private  $confClave;


    /**
     * Atributo privado donde se guarda si el validador es para el Registrarse o el Editar
     */
    private $formEditar;

    /**
     * Al instanciar la clase con un formulario como parámetro, ya se hace la validación del mismo
     * FormValidator constructor.
     * @param $formulario
     */
    public function __construct($formulario, $formEditar =null)
    {
        $this->campos = $formulario;
        $this->formEditar= $formEditar;
        $this->validarFormulario();
    }

    /**
     * Recorre uno a uno los campos del formulario y valida el mismo;
     */
    public function validarFormulario(){
        // Valido los inputs;
        $firmoTerminos = false;

        if ( $this->formEditar) {
            $firmoTerminos = true;
        }
        foreach( $this->campos as $nombreCampo => $valor){


            if ($nombreCampo == 'terminos'){
                $firmoTerminos = true;
            }
            $errorActual = $this->validarCampo($nombreCampo, $valor);
            if ($errorActual){
                $this->camposError[$nombreCampo] = $errorActual;
            }
        }
        if (!$firmoTerminos){
            $this->camposError['terminos'] = "No ha aceptado  los términos";
        }
    }


    /**
     * Funcion que valida el  valor pasado en $campo en base al $nombre del campo
     * @param $nombre
     * @param $campo
     * @return string
     */
    public function validarCampo($nombre, $campo){

        switch($nombre){
            case 'nombre':
            case 'apellido':
                    $buscar = array( '/á/i', '/é/i', '/í/i', '/ó/i', '/ú/i', '/ñ/i' );
                    $poner = array( 'a', 'e', 'i', 'o', 'u', 'n' );
                    $texto2 = preg_replace( $buscar, $poner, $campo );
                    return $this->validarCampoEspecifico($texto2 , '/^[a-z\s]+$/i', "El campo solo puede ser texto o espacios");
                break;
            case 'clave':
                $this->confClave = $campo;
                if ( !$this->formEditar ) {
                    return $this->validarCampoEspecifico($campo, '/^.+$/i', "El campo es requerido");
                }
                break;
            case 'usuario':
                $rta = $this->validarCampoEspecifico($campo, '/^[a-z\d]+$/i', "El campo solo puede ser texto o números");
                if (!$rta) {
                    return $this->validarUsuarioExistente($campo);
                } else{
                    return $rta ;
                }
                break;
            case 'confClave':
                return $this->validarConfClave($campo, $this->confClave );
                break;

            case 'telefono':
                return $this->validarCampoEspecifico($campo, '/^\d{8,}$/', "El campo solo admite números (Mínimo 8)");
                break;


            case 'email':
                $rta =  $this->validarCampoEspecifico($campo, '/^([\w\.]{3,}@[a-z0-9\-]{3,}(\.[a-z]{2,4})+)?$/i', "El campo no es un correo válido");
                if (!$rta) {
                    return $this->validarEMailExistente($campo);
                } else{
                    return $rta ;
                }

                break;

            case 'fechaInicio':
            case 'deporte':
            case 'tipoTorneo':
                if ($campo == "" ){
                    return "El campo es requerido";
                }else{
                    return "";
                }
                break;

            default:
                return "";
        };
    }



    /**
     * Función que valida que el campo parámetro en base a la expresión del segundo parámetro;
     * Si no es válido devuelve el texto del tercer parámetro o el de requerido cuando corresponda;
     * @param $campo
     * @param $expReg
     * @param $texto
     * @return string
     */
    public function validarCampoEspecifico($campo, $expReg, $texto){
        $rta = "";
        if ($campo == "" ){
            $rta = "El campo es requerido";
        }else{
            $valido = preg_match( $expReg, $campo );
            if ( !$valido ) {
                $rta = $texto;
            }
        }
        return $rta;
    }

    /**
     * Método que confirma si las claves ingresadas en el formulario coinciden
     * @param $clave
     * @param $confClave
     * @return string
     */
    public function validarConfClave($clave, $confClave){
        $rta = "";
        if ( $clave != $confClave ) {
            $rta = "Las claves no coinciden";
        }
        return $rta;
    }



    /**
     * Informa si la validación fue exitosa.
     *
     * @return bool
     */
    public function esValido()
    {
        return count($this->camposError) == 0;
    }



    /**
     * @return array
     */
    public function getCamposError()
    {
        return $this->camposError;
    }

    /**
     * @return array
     */
    public function getCampos()
    {
        return $this->campos;
    }

    /**
     * Valida si el usuario que se pasa por parámetro existe en la base de datos.
     * @param $usuario
     * @return string
     */
    public function validarUsuarioExistente($usuario){
        $rta = "";
        if (Usuario::existeUsuario($usuario)){
            $rta = "El usuario elegido ya existe en la base de datos";
        }
        return $rta;
    }

    /**
     * Valida si el mail que se pasa por parámetro existe en la base de datos.
     * @param $usuario
     * @return string
     */
    public function validarEMailExistente($eMail){
        $rta = "";
        if (Usuario::existeMail($eMail)){
            $rta = "El correo elegido ya existe en la base de datos";
        }
        return $rta;
    }

}