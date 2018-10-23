<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 21/08/2017
 * Time: 02:35 AM
 */

namespace Proyecto\Model;
use Proyecto\DB\DBConnection;
use Proyecto\Core\App;


class Articulo
{
    protected $idarticulo;
    protected $titulo;
    protected $primlineas;
    protected $texto;
    protected $imagen1;
    protected $imagen2;
    protected $firma;
    protected $categoria;
    protected $subcategoria;
    protected $palabraclave;


    /**
     * @param $datosAlim
     */
    public function cargarDatos($datosArt)
    {
        $this->setIdarticulo($datosArt['IDARTICULO']);
        $this->setTitulo($datosArt['TITULO']);
        $this->setPrimlineas($datosArt['PRIMLINEAS']);
        $this->setTexto($datosArt['TEXTO']);
        $this->setImagen1($datosArt['IMAGEN1']);
        $this->setImagen2($datosArt['IMAGEN2']);
        $this->setFirma($datosArt['FIRMA']);
        $this->setCategoria($datosArt['CATEGART_IDCATEGART']);
        $this->setSubcategoria($datosArt['SUBCATEGART_IDSUBCATEGART']);
        $this->setPalabraclave($datosArt['PALABRACLAVE']);
        //$this->setNombreCategoria($datosArt['NOMBRE_CATEGORIA']);
        //$this->setNombreCategoria();
        //$this->setNombrePorcion($datosArt['NOMBRE_PORCION']);
        //$this->setNombrePorcion();
    }


    public function cargarDatosPrevia($datosArt)
    {
        if(isset($datosArt['IDARTICULO'])){
            $this->setIdarticulo($datosArt['IDARTICULO']);
        }
        $this->setTitulo($datosArt['TITULO']);
        $this->setPrimlineas($datosArt['PRIMLINEAS']);
        $this->setTexto($datosArt['TEXTO']);

        //$artaux = self::traerUno($datosArt['IDARTICULO']);
        //echo "<pre>";
        //print_r($_FILES);
        //echo "</pre>";
        //die;
        //if(isset($_FILES['IMAGEN1'])){
        if(isset($_FILES['IMAGEN1']) && $_FILES['IMAGEN1']['error'] != '4'){
            $file = $_FILES['IMAGEN1'];
            $origen = $file['tmp_name'];
            $destino =  App::$publicPath . '/uploads/' . $file['name'];
            //print_r($destino);
            //die;
            move_uploaded_file($origen, $destino);

            $destinoparam = App::$urlPath . '/uploads/' . $file['name'];

            $this->setImagen1($destinoparam);

            $_SESSION['imagenedit'] = 'upload';
        } else {

            $artaux = new Articulo();
            $artaux2 = $artaux->traerUno($datosArt['IDARTICULO']);
            $artaux2 = $artaux2->getImagen1();
            if(isset($artaux2)){
                $this->setImagen1($artaux2);
            }

            $_SESSION['imagenedit'] = 'db';
        }
        //if(isset($datosArt['IMAGEN1'])){
          //  $this->setImagen1($datosArt['IMAGEN1']);
        //}
        if(isset($datosArt['IMAGEN2'])){
            $this->setImagen2($datosArt['IMAGEN2']);
        }
        $this->setFirma($datosArt['FIRMA']);
        $this->setCategoria($datosArt['CATEGART_IDCATEGART']);
        $this->setSubcategoria($datosArt['SUBCATEGART_IDSUBCATEGART']);
        $this->setPalabraclave($datosArt['PALABRACLAVE']);
        //$this->setNombreCategoria($datosArt['NOMBRE_CATEGORIA']);
        //$this->setNombreCategoria();
        //$this->setNombrePorcion($datosArt['NOMBRE_PORCION']);
        //$this->setNombrePorcion();
    }


    /**
     * @param $data
     * @return bool
     * @throws ErrorIngresoException
     */
    public static function insertarDatos($data)
    {
        $query = "insert into articulos (TITULO, PRIMLINEAS, TEXTO, IMAGEN1, IMAGEN2, FIRMA, CATEGART_IDCATEGART, SUBCATEGART_IDSUBCATEGART, 
                  PALABRACLAVE) values (:titulo, :primlineas, :texto, :imagen1, :imagen2, :firma, :categoria, 
                  :subcategoria, :palabraclave)";

        $stmt = DBConnection::getStatement($query);

        $exito = $stmt->execute(['titulo' => $data['TITULO'],
            'primlineas' => $data['PRIMLINEAS'],
            'texto' => $data['TEXTO'],
            'imagen1' => $data['IMAGEN1'],
            'imagen2' => $data['IMAGEN2'],
            'firma' => $data['FIRMA'],
            'categoria' => $data['CATEGART_IDCATEGART'],
            'subcategoria' => $data['SUBCATEGART_IDSUBCATEGART'],
            'palabraclave' => $data['PALABRACLAVE'],]
        );

        if($exito) {
            $_SESSION['rtausuario'] = 'insertOk';
            return true;
        } else {
            throw new ErrorIngresoArticulo("Hubo un error, no se pudo ingresar el nuevo registro en la base. Por favor vuelva a intentarlo más tarde.");
        }

    }


    public static function editarDatos($data)
    {
        $query = "update articulos set TITULO = :titulo, PRIMLINEAS = :primlineas, TEXTO = :texto,
                  IMAGEN1 = :imagen1, IMAGEN2 = :imagen2, FIRMA = :firma, CATEGART_IDCATEGART = :categoria, 
                  SUBCATEGART_IDSUBCATEGART = :subcategoria, PALABRACLAVE = :palabraclave where IDARTICULO = :idarticulo";

        $stmt = DBConnection::getStatement($query);

        //echo '<pre>';
        //print_r($data);
        //echo '</pre>';

        //die;

        $exito = $stmt->execute(['idarticulo' => $data['IDARTICULO'],
            'titulo' => $data['TITULO'],
            'primlineas' => $data['PRIMLINEAS'],
            'texto' => $data['TEXTO'],
            'imagen1' => $data['IMAGEN1'],
            'imagen2' => $data['IMAGEN2'],
            'firma' => $data['FIRMA'],
            'categoria' => $data['CATEGART_IDCATEGART'],
            'subcategoria' => $data['SUBCATEGART_IDSUBCATEGART'],
            'palabraclave' => $data['PALABRACLAVE']]);

        if($exito)
        {
            $_SESSION['rtausuario'] = 'editarOk';
            return true;
        } else {

            //echo '<pre>';
            //print_r($exito);
            //echo '</pre>';

            //die;


            throw new ErrorEdicionException("Hubo un error, no se pudo editar el registro en la base. Por favor vuelva a intentarlo más tarde.");
        }

    }




    /**
     * Elimina un Artículo en la base de datos.
     *
     * @param array $data
     * @return bool
     * @throws ErrorEliminarException
     */

    public static function eliminarDatos($id)
    {
        $query = "DELETE FROM articulos
                  WHERE IDARTICULO = ?";
        //echo $query . "<br>";
        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);
        $exito = $stmt->execute([$id]);

        if($exito){
            $_SESSION['rtausuario'] = 'eliminarOk';
            return $exito;
        } else {
            throw new ErrorEliminarException('Hubo un error, no se pudo eliminar el artículo. Por favor vuelve a intentarlo más tarde.');
        }
    }

    /**
     * @param $data
     * @return Alimento
     */
    public static function traerUno($id)
    {
        $query = "select * from articulos where IDARTICULO = :idarticulo";

        $stmt = DBConnection::getStatement($query);
        $stmt->execute(['idarticulo' => $id]);

        //$stmt->execute(['idarticulo' => $data['IDARTICULO']]);
        //$stmt->execute(['idarticulo' => $data]);

        $datosArticulo = $stmt->fetch();

        $art = new Articulo();

        $art->cargarDatos($datosArticulo);

        $salida = $art;

        return $salida;

    }


    /**
     * @param $datos
     * @return Alimento
     */
    public static function armarPrevia($datos)
    {
        $datosArticulo = $datos;

        $art = new Articulo();

        $art->cargarDatosPrevia($datosArticulo);

        $salida = $art;

        $_SESSION['datoart'] = $salida;

        return $salida;

    }

    /**
     * @param $datos
     * @return Alimento
     */
    public static function armarPreviaEdit($datos)
    {
        $datosArticulo = $datos;

        $art = new Articulo();

        $art->cargarDatosPrevia($datosArticulo);

        $salida = $art;

        $_SESSION['datoartedit'] = $salida;

        return $salida;

    }


    public static function traerUltimosTres()
    {

        $query = "select * from articulos ORDER BY IDARTICULO DESC limit 3";

        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);

        $stmt->execute();

        $salida = [];

        while($fila = $stmt->fetch()) {

            $artic = new Articulo();

            $artic->cargarDatos($fila);

            $salida[] = $artic;
        }

        return $salida;

    }


    public static function traerUltCinco()
    {
        $query = "select * from articulos ORDER BY IDARTICULO DESC limit 5";

        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);

        $stmt->execute();

        $salida = [];

        while($fila = $stmt->fetch()) {

            $artic = new Articulo();

            $artic->cargarDatos($fila);

            $salida[] = $artic;
        }

        return $salida;

    }


    public static function traerTodos()
    {
        $query = "select * from articulos ORDER BY IDARTICULO DESC";

        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);

        $stmt->execute();

        $salida = [];

        while($fila = $stmt->fetch()) {

            $artic = new Articulo();

            $artic->cargarDatos($fila);

            $salida[] = $artic;
        }

        return $salida;

    }


    public static function traerCincoPaginacion($idreferencia)
    {
        $query = "select * from articulos where IDARTICULO <= :idreferencia ORDER BY IDARTICULO DESC limit 5";

        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);

        $stmt->execute(['idreferencia' => $idreferencia]);

        $salida = [];

        while($fila = $stmt->fetch()) {

            $artic = new Articulo();

            $artic->cargarDatos($fila);

            $salida[] = $artic;
        }

        return $salida;

    }







    /*public static function traerPaginaActual($idreferencia)
    {



        while($fila = $stmt->fetch()) {

            $artic = new Articulo();

            $artic->cargarDatos($fila);

            $salida[] = $artic;
        }

        return $salida;

    } */


    public static function traerUltimoID()
    {
        $query = "select MAX(IDARTICULO) from articulos";

        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);

        $stmt->execute();

        $dato = $stmt->fetch();

        $salida = $dato['0'];

        return $salida;

    }



    public static function traerIDsreferencia()
    {
        $query = "select IDARTICULO from articulos ORDER BY IDARTICULO desc";

        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);

        $stmt->execute();

        $listado = [];

        while($fila = $stmt->fetch()) {

            $listado[] = $fila;
        }

        $cantidad = ceil(count($listado) / 5);

        $salida = [];

        $var = 0;

        while($cantidad) {

            $salida[] = $listado[$var];

            $var += 5;

            $cantidad -= 1;
        }

        return $salida;

        //echo '<pre>';
        //print_r($salida);
        //echo '</pre>';
        //die;

    }


    public static function contarTodos()
    {
        $query = "select count(IDARTICULO) FROM articulos";

        $db = DBConnection::getConnection();

        $stmt = $db->prepare($query);

        $stmt->execute();

        $dato = $stmt->fetch();

        $total = $dato['0'];

        $total = ceil($total / 5);

        return $total;

    }




    //public static function arrayPaginacion()
    //{

        //$ids_referencia = self::traerIDreferencia();

        //$salida = [];

        //$salida['0'] = $ultimo;

        //$dato1 = self::traerUltCinco();

        //$dato1 = $dato1['4']['IDARTICULO'];

        //echo $dato1;

        //die;

    //}




    /**
     * @return mixed
     */
    public function getIdarticulo()
    {
        return $this->idarticulo;
    }

    /**
     * @param mixed $idarticulo
     */
    public function setIdarticulo($idarticulo)
    {
        $this->idarticulo = $idarticulo;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getPrimlineas()
    {
        return $this->primlineas;
    }

    /**
     * @param mixed $primlineas
     */
    public function setPrimlineas($primlineas)
    {
        $this->primlineas = $primlineas;
    }


    /**
     * @return mixed
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param mixed $texto
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;
    }

    /**
     * @return mixed
     */
    public function getImagen1()
    {
        return $this->imagen1;
    }

    /**
     * @param mixed $imagen1
     */
    public function setImagen1($imagen1)
    {
        $this->imagen1 = $imagen1;
    }

    /**
     * @return mixed
     */
    public function getImagen2()
    {
        return $this->imagen2;
    }

    /**
     * @param mixed $imagen2
     */
    public function setImagen2($imagen2)
    {
        $this->imagen2 = $imagen2;
    }

    /**
     * @return mixed
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * @param mixed $firma
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getSubcategoria()
    {
        return $this->subcategoria;
    }

    /**
     * @param mixed $subcategoria
     */
    public function setSubcategoria($subcategoria)
    {
        $this->subcategoria = $subcategoria;
    }

    /**
     * @return mixed
     */
    public function getPalabraclave()
    {
        return $this->palabraclave;
    }

    /**
     * @param mixed $palabraclave
     */
    public function setPalabraclave($palabraclave)
    {
        $this->palabraclave = $palabraclave;
    }
}