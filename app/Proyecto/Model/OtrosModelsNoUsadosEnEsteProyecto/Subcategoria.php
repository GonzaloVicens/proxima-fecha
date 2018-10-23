<?php

/**
 * Clase Categoria
 *
 */

namespace Proyecto\Model;

use Proyecto\DB\DBConnection;

class Subcategoria
{
    protected $idSubcategoria;
    protected $nombreSubcategoria;

    /**
     * @param $datosCate
     */
    public function cargarDatos($datosSubcate)
    {
        $this->setIdSubcategoria($datosSubcate['IDSUBCATEGART']);
        $this->setNombreSubcategoria($datosSubcate['NOMBRE_SUBCATEGART']);
    }

    /**
     * @return array
     */
    public static function listarTodo()
    {
        $query = "SELECT * FROM subcategoriasart";

        $stmt = DBConnection::getStatement($query);

        $stmt->execute();

        $salida = [];

        while($datosSubcategoria = $stmt->fetch())
        {
            $subcateg = new Subcategoria();

            $subcateg->cargarDatos($datosSubcategoria);

            $salida[] = $subcateg;

        }
        return $salida;
    }

    /**
     * @return mixed
     */

    public function getNombreSubcategoria()
    {
        return $this->nombreSubcategoria;
    }

    /**
     * @param mixed $nombreSubcategoria
     */
    public function setNombreSubcategoria($nombreSubcategoria)
    {
        $this->nombreSubcategoria = $nombreSubcategoria;
    }

    /**
     * @return mixed
     */
    public function getIdSubcategoria()
    {
        return $this->idSubcategoria;
    }

    /**
     * @param mixed $idSubcategoria
     */
    public function setIdSubcategoria($idSubcategoria)
    {
        $this->idSubcategoria = $idSubcategoria;
    }

}
