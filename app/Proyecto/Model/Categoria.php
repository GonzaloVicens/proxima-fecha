<?php

/**
 * Clase Categoria
 *
 */

namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


class Categoria
{
    protected $idCategoria;
    protected $nombreCategoria;

    /**
     * @param $datosCate
     */
    public function cargarDatos($datosCate)
    {
        $this->setIdCategoria($datosCate['IDCATEGART']);
        $this->setNombreCategoria($datosCate['NOMBRE_CATEGART']);
    }

    /**
     * @return array
     */
    public static function listarTodo()
    {
        $query = "SELECT * FROM categoriasart";

        $stmt = DBConnection::getStatement($query);

        $stmt->execute();

        $salida = [];

        while($datosCategoria = $stmt->fetch())
        {
            $categ = new Categoria();

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
