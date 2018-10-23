<?php

/**
 * Clase Alimento
 *
 */

namespace Proyecto\Model;

use Proyecto\DB\DBConnection;
use Proyecto\Core\App;

use \JsonSerializable;
/*use Exception;
use clases\ErrorEliminarException;
use clases\ErrorEdicionException;
use clases\ErrorIngresoException;
use clases\ErrorListarException;


use DaVinci\DB\DBConnection;
use Exception;*/
use Proyecto\Exceptions\ErrorListarException;
use Proyecto\Exceptions\ErrorEliminarException;
use Proyecto\Exceptions\ErrorIngresoException;
use Proyecto\Exceptions\ErrorEdicionException;


//require_once '../Autoload/autoload.php';

class Alimento implements JsonSerializable
{
    protected $idalimento;
    protected $nombre_alimento;
    protected $nombrelargo_alimento;
    protected $categoria_idcategoria;
    protected $nombre_categoria;
    protected $kcal_x_100gr;
    protected $gramos_cc_porcion;
    protected $porcion_idporcion;
    protected $nombre_porcion;
    protected $carbohidratos;
    protected $proteinas;
    protected $grasas;
    protected $mg_sodio;
    protected $azucares;
    protected $tamanio_chico;
    protected $tamanio_mediano;
    protected $tamanio_grande;
    protected $imagen;
    protected $fuente_kcalydemas;
    protected $fuente_porcion;
    protected $aclaraciones_publicas;
    protected $comentarios_internos;



    public static $atributosPermitidos = ['IDALIMENTO', 'NOMBRE_ALIMENTO','NOMBRELARGO_ALIMENTO','CATEGORIA_IDCATEGORIA','NOMBRE_CATEGORIA','GRAMOS_CC_PORCION','PORCION_IDPORCION','NOMBRE_PORCION','CARBOHIDRATOS','PROTEINAS','GRASAS','MG_SODIO','AZUCARES','TAMANIO_CHICO','TAMANIO_MEDIANO','TAMANIO_GRANDE','IMAGEN','FUENTE_KCALYDEMAS','IMAGEN','FUENTE_PORCION','ACLARACIONES_PUBLICAS','COMENTARIOS_INTERNOS'];

    public function jsonSerialize()
    {   return ['IDALIMENTO' => $this->getIdalimento(),
        'NOMBRE_ALIMENTO' => $this->getNombreAlimento(),
        'NOMBRELARGO_ALIMENTO' => $this->getNombrelargoAlimento(),
        'CATEGORIA_IDCATEGORIA' => $this->getCategoriaIdcategoria(),
        'NOMBRE_CATEGORIA' => $this->getNombreCategoria(),
        'KCAL_X_100GR' => $this->getKcalX100gr(),
        'GRAMOS_CC_PORCION' => $this->getGramosCcPorcion(),
        'PORCION_IDPORCION' => $this->getPorcionIdporcion(),
        'NOMBRE_PORCION' => $this->getNombrePorcion(),
        'CARBOHIDRATOS' => $this->getCarbohidratos(),
        'PROTEINAS' => $this->getProteinas(),
        'GRASAS' => $this->getGrasas(),
        'MG_SODIO' => $this->getMgSodio(),
        'AZUCARES' => $this->getAzucares(),
        'TAMANIO_CHICO' => $this->getTamanioChico(),
        'TAMANIO_MEDIANO' => $this->getTamanioMediano(),
        'TAMANIO_GRANDE' => $this->getTamanioGrande(),
        'IMAGEN' => $this->getImagen(),
        'FUENTE_KCALYDEMAS' => $this->getFuenteKcalydemas(),
        'FUENTE_PORCION' => $this->getFuentePorcion(),
        'ACLARACIONES_PUBLICAS' => $this->getAclaracionesPublicas(),
        'COMENTARIOS_INTERNOS' => $this->getComentariosInternos()
        ];
    }

    /**
     * @return mixed
     */
    public static function listarTodo()
    {
        $query = "SELECT * FROM alimentos, categorias, porciones 
        WHERE IDCATEGORIA = CATEGORIA_IDCATEGORIA 
        AND IDPORCION = PORCION_IDPORCION";

        if($stmt = DBConnection::getStatement($query)) {

        $stmt->execute();

        $salida = [];

        while($datosAlimento = $stmt->fetch())
           {
                $alim = new Alimento();

                $alim->cargarDatos($datosAlimento);

                $salida[] = $alim;

           }
            return $salida;
        } else {
            throw new ErrorListarException('Hubo un problema, no se pudo listar los elementos.');
        }
    }

    /**
     * @param $datosAlim
     */
    public function cargarDatos($datosAlim)
    {
        $this->setIdalimento($datosAlim['IDALIMENTO']);
        $this->setNombreAlimento($datosAlim['NOMBRE_ALIMENTO']);
        $this->setNombrelargoAlimento($datosAlim['NOMBRELARGO_ALIMENTO']);
        $this->setCategoriaIdcategoria($datosAlim['CATEGORIA_IDCATEGORIA']);
        //$this->setNombreCategoria($datosAlim['NOMBRE_CATEGORIA']);
        $this->setNombreCategoria();
        $this->setKcalX100gr($datosAlim['KCAL_X_100GR']);
        $this->setGramosCcPorcion($datosAlim['GRAMOS_CC_PORCION']);
        $this->setPorcionIdporcion($datosAlim['PORCION_IDPORCION']);
        //$this->setNombrePorcion($datosAlim['NOMBRE_PORCION']);
        $this->setNombrePorcion();
        $this->setCarbohidratos($datosAlim['CARBOHIDRATOS']);
        $this->setProteinas($datosAlim['PROTEINAS']);
        $this->setGrasas($datosAlim['GRASAS']);
        $this->setMgSodio($datosAlim['MG_SODIO']);
        $this->setAzucares($datosAlim['AZUCARES']);
        $this->setTamanioChico($datosAlim['TAMANIO_CHICO']);
        $this->setTamanioMediano($datosAlim['TAMANIO_MEDIANO']);
        $this->setTamanioGrande($datosAlim['TAMANIO_GRANDE']);
        $this->setImagen($datosAlim['IMAGEN']);
        $this->setFuenteKcalydemas($datosAlim['FUENTE_KCALYDEMAS']);
        $this->setFuentePorcion($datosAlim['FUENTE_PORCION']);
        $this->setAclaracionesPublicas($datosAlim['ACLARACIONES_PUBLICAS']);
        $this->setComentariosInternos($datosAlim['COMENTARIOS_INTERNOS']);
    }

    /**
     * @param $data
     * @return bool
     * @throws ErrorEliminarException
     */
    /*
    public static function eliminarDatos($data)
    {
        $query = "delete from alimentos where IDALIMENTO = :idalimento";

        $stmt = DBConnection::getStatement($query);

        if($stmt->execute(['idalimento' => $data['IDALIMENTO']]))
        {
            return true;
        } else {
            throw new ErrorEliminarException("Hubo un error, no se pudo eliminar el registro. Por favor vuelva a intentarlo más tarde.");
        }
    } */

    public static function eliminarDatos($id)
    {
        $query = "DELETE FROM alimentos
                  WHERE IDALIMENTO = ?";
        //echo $query . "<br>";
        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);
        $exito = $stmt->execute([$id]);

        if($exito){
            $_SESSION['rtausuario'] = 'eliminarOk';
            return $exito;
        } else {
            throw new ErrorEliminarException('Hubo un error, no se pudo eliminar el registro de la Base. Por favor vuelve a intentarlo más tarde.');
        }
    }

    /**
     * @param $data
     * @return bool
     * @throws ErrorEdicionException
     */
    public static function updateDatos($data)
    {
        $query = "update alimentos set NOMBRE_ALIMENTO = :nombre, NOMBRELARGO_ALIMENTO = :nombrelargo, CATEGORIA_IDCATEGORIA = :categoria,
                  KCAL_X_100GR = :kcal, GRAMOS_CC_PORCION = :grporcion, PORCION_IDPORCION = :porcion, CARBOHIDRATOS = :carbo, 
                  PROTEINAS = :prote, GRASAS = :gras, MG_SODIO = :sodio, AZUCARES = :azucar, TAMANIO_CHICO = :tamChico, TAMANIO_MEDIANO = :tamMediano,
                  TAMANIO_GRANDE = :tamGrande, IMAGEN = :imag, FUENTE_KCALYDEMAS = :fuenteKcal, FUENTE_PORCION = :fuentePorcion,
                  ACLARACIONES_PUBLICAS = :aclaraciones, COMENTARIOS_INTERNOS = :comentarios where IDALIMENTO = :idalimento";

        $stmt = DBConnection::getStatement($query);

        $exito = $stmt->execute(['idalimento' => $data['IDALIMENTO'],
            'nombre' => $data['NOMBRE_ALIMENTO'],
            'nombrelargo' => $data['NOMBRELARGO_ALIMENTO'],
            'categoria' => $data['CATEGORIA_IDCATEGORIA'],
            'kcal' => $data['KCAL_X_100GR'],
            'grporcion' => $data['GRAMOS_CC_PORCION'],
            'porcion' => $data['PORCION_IDPORCION'],
            'carbo' => $data['CARBOHIDRATOS'],
            'prote' => $data['PROTEINAS'],
            'gras' => $data['GRASAS'],
            'sodio' => $data['MG_SODIO'],
            'azucar' => $data['AZUCARES'],
            'tamChico' => $data['TAMANIO_CHICO'],
            'tamMediano' => $data['TAMANIO_MEDIANO'],
            'tamGrande' => $data['TAMANIO_GRANDE'],
            'imag' => $data['IMAGEN'],
            'fuenteKcal' => $data['FUENTE_KCALYDEMAS'],
            'fuentePorcion' => $data['FUENTE_PORCION'],
            'aclaraciones' => $data['ACLARACIONES_PUBLICAS'],
            'comentarios' => $data['COMENTARIOS_INTERNOS'],]);

        if($exito)
        {   $_SESSION['rtausuario'] = 'editarOk';
            return true;
        } else {
            throw new ErrorEdicionException("Hubo un error, no se pudo editar el registro en la base. Por favor vuelva a intentarlo más tarde.");
        }

    }

    /**
     * @param $data
     * @return bool
     * @throws ErrorIngresoException
     */
    public static function insertarDatos($data)
    {
        $query = "insert into alimentos (NOMBRE_ALIMENTO, NOMBRELARGO_ALIMENTO, CATEGORIA_IDCATEGORIA, 
                  KCAL_X_100GR, GRAMOS_CC_PORCION, PORCION_IDPORCION, CARBOHIDRATOS, PROTEINAS, GRASAS, MG_SODIO, 
                  AZUCARES, TAMANIO_CHICO, TAMANIO_MEDIANO, TAMANIO_GRANDE, IMAGEN, FUENTE_KCALYDEMAS, FUENTE_PORCION, 
                  ACLARACIONES_PUBLICAS, COMENTARIOS_INTERNOS) values (:nombre, :nombrelargo, :categoria, :kcal, 
                  :grporcion, :porcion, :carbo, :prote, :gras, :sodio, :azucar, :tamChico, :tamMediano, :tamGrande, 
                  :imag, :fuenteKcal, :fuentePorcion, :aclaraciones, :comentarios)";

        $stmt = DBConnection::getStatement($query);

        $exito = $stmt->execute(['nombre' => $data['NOMBRE_ALIMENTO'],
                        'nombrelargo' => $data['NOMBRELARGO_ALIMENTO'],
                        'categoria' => $data['CATEGORIA_IDCATEGORIA'],
                        'kcal' => $data['KCAL_X_100GR'],
                        'grporcion' => $data['GRAMOS_CC_PORCION'],
                        'porcion' => $data['PORCION_IDPORCION'],
                        'carbo' => $data['CARBOHIDRATOS'],
                        'prote' => $data['PROTEINAS'],
                        'gras' => $data['GRASAS'],
                        'sodio' => $data['MG_SODIO'],
                        'azucar' => $data['AZUCARES'],
                        'tamChico' => $data['TAMANIO_CHICO'],
                        'tamMediano' => $data['TAMANIO_MEDIANO'],
                        'tamGrande' => $data['TAMANIO_GRANDE'],
                        'imag' => $data['IMAGEN'],
                        'fuenteKcal' => $data['FUENTE_KCALYDEMAS'],
                        'fuentePorcion' => $data['FUENTE_PORCION'],
                        'aclaraciones' => $data['ACLARACIONES_PUBLICAS'],
                        'comentarios' => $data['COMENTARIOS_INTERNOS'],]);

        if($exito) {
            $_SESSION['rtausuario'] = 'insertOk';
            return true;
        } else {
            throw new ErrorIngresoException("Hubo un error, no se pudo ingresar el nuevo registro en la base. Por favor vuelva a intentarlo más tarde.");
        }

    }

    /**
     * @param $data
     * @return Alimento
     */
    public static function traerUno($data)
    {
        $query = "select * from alimentos, categorias, porciones where IDCATEGORIA = CATEGORIA_IDCATEGORIA 
        and IDPORCION = PORCION_IDPORCION and IDALIMENTO = :idalimento";

        $stmt = DBConnection::getStatement($query);

        //$stmt->execute(['idalimento' => $data['IDALIMENTO']]);
        $stmt->execute(['idalimento' => $data]);

        $datosAlimento = $stmt->fetch();

        $alim = new Alimento();

        $alim->cargarDatos($datosAlimento);

        $salida = $alim;

        return $salida;

    }


    public static function traerPorNombre($data)
    {
        $query = "select * from alimentos where NOMBRE_ALIMENTO = :nombre";

        $stmt = DBConnection::getStatement($query);

        $stmt->execute(['nombre' => $data['NOMBRE_ALIMENTO']]);
        //$stmt->execute(['nombre' => $data]);

        //echo '<pre> data:';
        //print_r($data);
        //echo '</pre>';

        //echo '<pre> $stmt';
        //print_r($stmt);
        //echo '</pre>';

        $datosAlimento = $stmt->fetch();

        //echo '<pre> $datosAlimento';
        //print_r($datosAlimento);
        //echo '</pre>';
        //die;

        $alim = new Alimento();

        $alim->cargarDatos($datosAlimento);

        $alim->jsonSerialize();

        //sleep(4);
        //$hoy = date("YmdHis");

        //echo $hoy;

        //die;

        return json_encode($alim);
        //die;
        //$salida = $alim->cargarDatos($datosAlimento);

        //echo '<pre>';
        //print_r($alim);
        //echo '</pre>';

        //$testJson = json_encode($alim);

        //echo '<pre>$testJson';
        //print_r($testJson);
        //echo '</pre>';
        //die;

        //$alim['NOMBRE_CATEGORIA'] = $alim::traerNombreCategoria($alim['CATEGORIA_IDCATEGORIA']);

        //$salida = json_encode($alim); ATENCION >>> esto estaba descomentado cuando funcionaba con JSON
        //$salida['IDALIMENTO'] = $alim->getIdalimento();
        //$salida['NOMBRE_ALIMENTO'] = $alim->getNombreAlimento();
        //$salida['NOMBRELARGO_ALIMENTO'] = $alim->getNombrelargoAlimento();
        //$salida['GRAMOS_CC_PORCION'] = $alim->getGramosCcPorcion();

        //json_encode($jsondata, JSON_FORCE_OBJECT);


        //return $testJson;

    }

    public static function traerOpciones($data)
    {
        $query = "select * from alimentos where NOMBRE_ALIMENTO LIKE :nombre";

        $stmt = DBConnection::getStatement($query);

        $stmt->execute(['nombre' => '%' . $data['NOMBRE_ALIMENTO'] . '%']);

        //SEGUIR A PARTIR DE ACA - VER QUE HAY QUE HACER UN BUtraerPorNombreCLE

        $salida = [];

        while($fila = $stmt->fetch()) {

            $alim = new Alimento();

            $alim->cargarDatos($fila);

            $alim->jsonSerialize();

            //json_encode($alim);

            $salida[] = $alim;
        }

        //$salida = 'que onda?';

        return json_encode($salida);

        //return $salida;


        /*
        $datosAlimento = $stmt->fetch();

        $alim = new Alimento();

        $alim->cargarDatos($datosAlimento);

        $alim->jsonSerialize();


        return json_encode($alim);
        */

    }

    public static function traerNombreCategoria($data)
    {
        $query = "select NOMBRE_CATEGORIA from categorias where IDCATEGORIA = :categoria";

        $stmt = DBConnection::getStatement($query);

        //$stmt->execute(['categoria' => $data['CATEGORIA_IDCATEGORIA']]);
        //$stmt->execute(['categoria' => $data]);

        $stmt->execute(['categoria' => $data]);

        $nombreCategoria = $stmt->fetch();

        //$alim = new Alimento();

        //$alim->cargarDatos($datosAlimento);

        //$salida = json_encode($nombreCategoria);
        $salida = $nombreCategoria[0];

        return $salida;
        //return $nombreCategoria;

    }

    public static function traerNombrePorcion($data)
    {
        $query = "select NOMBRE_PORCION from porciones where IDPORCION = :porcion";

        $stmt = DBConnection::getStatement($query);

        $stmt->execute(['porcion' => $data]);

        $nombrePorcion = $stmt->fetch();

        $salida = $nombrePorcion[0];

        return $salida;

    }

    /*
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if(in_array($key, self::$atributosPermitidos)){
                $this->{$key} = $value;
            }
        }
    }
    */


    /**
     * @return mixed
     */
    public function getIdalimento()
    {
        return $this->idalimento;
    }

    /**
     * @param mixed $idalimento
     */
    public function setIdalimento($idalimento)
    {
        $this->idalimento = $idalimento;
    }

    /**
     * @return mixed
     */
    public function getNombreAlimento()
    {
        return $this->nombre_alimento;
    }

    /**
     * @param mixed $nombre_alimento
     */
    public function setNombreAlimento($nombre_alimento)
    {
        $this->nombre_alimento = $nombre_alimento;
    }

    /**
     * @return mixed
     */
    public function getNombrelargoAlimento()
    {
        return $this->nombrelargo_alimento;
    }

    /**
     * @param mixed $nombrelargo_alimento
     */
    public function setNombrelargoAlimento($nombrelargo_alimento)
    {
        $this->nombrelargo_alimento = $nombrelargo_alimento;
    }

    /**
     * @return mixed
     */
    public function getCategoriaIdcategoria()
    {
        return $this->categoria_idcategoria;
    }

    /**
     * @param mixed $categoria_idcategoria
     */
    public function setCategoriaIdcategoria($categoria_idcategoria)
    {
        $this->categoria_idcategoria = $categoria_idcategoria;
    }

    /**
     * @return mixed
     */
    public function getKcalX100gr()
    {
        return $this->kcal_x_100gr;
    }

    /**
     * @param mixed $kcal_x_100gr
     */
    public function setKcalX100gr($kcal_x_100gr)
    {
        $this->kcal_x_100gr = $kcal_x_100gr;
    }

    /**
     * @return mixed
     */
    public function getGramosCcPorcion()
    {
        return $this->gramos_cc_porcion;
    }

    /**
     * @param mixed $gramos_cc_porcion
     */
    public function setGramosCcPorcion($gramos_cc_porcion)
    {
        $this->gramos_cc_porcion = $gramos_cc_porcion;
    }

    /**
     * @return mixed
     */
    public function getPorcionIdporcion()
    {
        return $this->porcion_idporcion;
    }

    /**
     * @param mixed $porcion_idporcion
     */
    public function setPorcionIdporcion($porcion_idporcion)
    {
        $this->porcion_idporcion = $porcion_idporcion;
    }

    /**
     * @return mixed
     */
    public function getCarbohidratos()
    {
        return $this->carbohidratos;
    }

    /**
     * @param mixed $carbohidratos
     */
    public function setCarbohidratos($carbohidratos)
    {
        $this->carbohidratos = $carbohidratos;
    }

    /**
     * @return mixed
     */
    public function getProteinas()
    {
        return $this->proteinas;
    }

    /**
     * @param mixed $proteinas
     */
    public function setProteinas($proteinas)
    {
        $this->proteinas = $proteinas;
    }


    /**
     * @return mixed
     */
    public function getGrasas()
    {
        return $this->grasas;
    }

    /**
     * @param mixed $grasas
     */
    public function setGrasas($grasas)
    {
        $this->grasas = $grasas;
    }


    /**
     * @return mixed
     */
    public function getMgSodio()
    {
        return $this->mg_sodio;
    }

    /**
     * @param mixed $mg_sodio
     */
    public function setMgSodio($mg_sodio)
    {
        $this->mg_sodio = $mg_sodio;
    }

    /**
     * @return mixed
     */
    public function getAzucares()
    {
        return $this->azucares;
    }

    /**
     * @param mixed $azucares
     */
    public function setAzucares($azucares)
    {
        $this->azucares = $azucares;
    }

    /**
     * @return mixed
     */
    public function getTamanioChico()
    {
        return $this->tamanio_chico;
    }

    /**
     * @param mixed $tamanio_chico
     */
    public function setTamanioChico($tamanio_chico)
    {
        $this->tamanio_chico = $tamanio_chico;
    }

    /**
     * @return mixed
     */
    public function getTamanioMediano()
    {
        return $this->tamanio_mediano;
    }

    /**
     * @param mixed $tamanio_mediano
     */
    public function setTamanioMediano($tamanio_mediano)
    {
        $this->tamanio_mediano = $tamanio_mediano;
    }

    /**
     * @return mixed
     */
    public function getTamanioGrande()
    {
        return $this->tamanio_grande;
    }

    /**
     * @param mixed $tamanio_grande
     */
    public function setTamanioGrande($tamanio_grande)
    {
        $this->tamanio_grande = $tamanio_grande;
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

    /**
     * @return mixed
     */
    public function getFuenteKcalydemas()
    {
        return $this->fuente_kcalydemas;
    }

    /**
     * @param mixed $fuente_kcalydemas
     */
    public function setFuenteKcalydemas($fuente_kcalydemas)
    {
        $this->fuente_kcalydemas = $fuente_kcalydemas;
    }

    /**
     * @return mixed
     */
    public function getFuentePorcion()
    {
        return $this->fuente_porcion;
    }

    /**
     * @param mixed $fuente_porcion
     */
    public function setFuentePorcion($fuente_porcion)
    {
        $this->fuente_porcion = $fuente_porcion;
    }

    /**
     * @return mixed
     */
    public function getAclaracionesPublicas()
    {
        return $this->aclaraciones_publicas;
    }

    /**
     * @param mixed $aclaraciones_publicas
     */
    public function setAclaracionesPublicas($aclaraciones_publicas)
    {
        $this->aclaraciones_publicas = $aclaraciones_publicas;
    }

    /**
     * @return mixed
     */
    public function getComentariosInternos()
    {
        return $this->comentarios_internos;
    }

    /**
     * @param mixed $comentarios_internos
     */
    public function setComentariosInternos($comentarios_internos)
    {
        $this->comentarios_internos = $comentarios_internos;
    }

    /**
     * @return mixed
     */
    public function getNombreCategoria()
    {
        return $this->nombre_categoria;
    }

    /**
     * @param mixed $nombre_categoria
     */
    public function setNombreCategoria()
    {
        $nombre_categoria = $this->traerNombreCategoria($this->getCategoriaIdcategoria());
        $this->nombre_categoria = $nombre_categoria;
    }

    /**
     * @return mixed
     */
    public function getNombrePorcion()
    {
        return $this->nombre_porcion;
    }

    /**
     * @param mixed $nombre_porcion
     */
    public function setNombrePorcion()
    {
        $nombre_porcion = $this->traerNombrePorcion($this->getPorcionIdporcion());
        $this->nombre_porcion = $nombre_porcion;
    }
}