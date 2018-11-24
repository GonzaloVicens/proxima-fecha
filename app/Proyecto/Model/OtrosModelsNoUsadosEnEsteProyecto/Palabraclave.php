<?php

/**
 * Clase Categoria
 *
 */

namespace Proyecto\Model;

use Proyecto\DB\DBConnection;

class Palabraclave
{
    protected $idPalabraclave;
    protected $nombrePalabraclave;

    /**
     * @param $datosCate
     */
    public function cargarDatos($datosPalabra)
    {
        $this->setIdPalabraclave($datosPalabra['IDPALABRACLAVE']);
        $this->setNombrePalabraclave($datosPalabra['NOMBRE_PALABRACLAVE']);
    }

    /**
     * @return array
     */
    public static function listarTodo()
    {
        $query = "SELECT * FROM palabrasclave";

        $stmt = DBConnection::getStatement($query);

        $stmt->execute();

        $salida = [];

        while($datosPalabraclave = $stmt->fetch())
        {
            $palclave = new Palabraclave();

            $palclave->cargarDatos($datosPalabraclave);

            $salida[] = $palclave;

        }
        return $salida;
    }

    /**
     * @return mixed
     */

    public function getNombrePalabraclave()
    {
        return $this->nombrePalabraclave;
    }

    /**
     * @param mixed $nombrePalabraclave
     */
    public function setNombrePalabraclave($nombrePalabraclave)
    {
        $this->nombrePalabraclave = $nombrePalabraclave;
    }

    /**
     * @return mixed
     */
    public function getIdPalabraclave()
    {
        return $this->idPalabraclave;
    }

    /**
     * @param mixed $idPalabraclave
     */
    public function setIdPalabraclave($idPalabraclave)
    {
        $this->idPalabraclave = $idPalabraclave;
    }

}
