<?php

/**
 * Clase Porcion
 *
 */

namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


//require_once '../Autoload/autoload.php';

class Porcion
{
    protected $idPorcion;
    protected $nombrePorcion;

    public function cargarDatos($datosPor)
    {
        $this->setIdPorcion($datosPor['IDPORCION']);
        $this->setNombrePorcion($datosPor['NOMBRE_PORCION']);
    }

    /**
     * @return array
     */
    public static function listarTodo()
    {
        $query = "SELECT * FROM porciones";

        $stmt = DBConnection::getStatement($query);

        $stmt->execute();

        $salida = [];

        while($datosPorciones = $stmt->fetch())
        {
            $porcion = new Porcion();

            $porcion->cargarDatos($datosPorciones);

            $salida[] = $porcion;

        }

        return $salida;
    }


    /**
     * @return mixed
     */
    public function getIdPorcion()
    {
        return $this->idPorcion;
    }

    /**
     * @param mixed $idPorcion
     */
    public function setIdPorcion($idPorcion)
    {
        $this->idPorcion = $idPorcion;
    }

    /**
     * @return mixed
     */
    public function getNombrePorcion()
    {
        return $this->nombrePorcion;
    }

    /**
     * @param mixed $nombrePorcion
     */
    public function setNombrePorcion($nombrePorcion)
    {
        $this->nombrePorcion = $nombrePorcion;
    }


}