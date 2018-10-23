<?php

/**
 * Clase Categoriaalimento
 *
 */

namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


class Categoriaalimento
{
    protected $idCategoria;
    protected $nombreCategoria;

    /**
     * @param $datosCate
     */
    public function cargarDatos($datosCate)
    {
        $this->setIdCategoria($datosCate['IDCATEGORIA']);
        $this->setNombreCategoria($datosCate['NOMBRE_CATEGORIA']);
    }

    /**
     * @return array
     */
    public static function listarTodo()
    {
        $query = "SELECT * FROM categorias";

        $stmt = DBConnection::getStatement($query);

        $stmt->execute();

        $salida = [];

        while($datosCategoria = $stmt->fetch())
        {
            $categ = new Categoriaalimento();

            $categ->cargarDatos($datosCategoria);

            $salida[] = $categ;

        }
        return $salida;
    }

    /**
     * @return mixed
     */

    public function getNombreCategoria()
    {
        return $this->nombreCategoria;
    }

    /**
     * @param mixed $nombreCategoria
     */
    public function setNombreCategoria($nombreCategoria)
    {
        $this->nombreCategoria = $nombreCategoria;
    }

    /**
     * @return mixed
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * @param mixed $idCategoria
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;
    }

}
