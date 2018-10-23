<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 29/06/2017
 * Time: 05:23 PM
 */

namespace Proyecto\Model;

namespace Proyecto\Model;
use Proyecto\DB\DBConnection;


class Sexo
{
    protected $idsexo;
    protected $nombre_sexo;

    /**
     * @param $datosCate
     */
    public function cargarDatos($datosSexo)
    {
        $this->setIdsexo($datosSexo['idsexo']);
        $this->setNombreSexo($datosSexo['nombre_sexo']);
    }

    /**
     * @return array
     */
    public static function listarTodo()
    {
        $query = "SELECT * FROM sexos";

        $stmt = DBConnection::getStatement($query);

        $stmt->execute();

        $salida = [];

        while($datosSexos = $stmt->fetch())
        {
            $sex = new Sexo();

            $sex->cargarDatos($datosSexos);

            $salida[] = $sex;

        }
        return $salida;
    }


    /***** SETTERS & GETTERS *****/

    /**
     * @return mixed
     */

    public function getNombreSexo()
    {
        return $this->nombre_sexo;
    }

    /**
     * @param mixed $nombreCategoria
     */
    public function setNombreSexo($nombreSexo)
    {
        $this->nombre_sexo = $nombreSexo;
    }

    /**
     * @return mixed
     */
    public function getIdsexo()
    {
        return $this->idsexo;
    }

    /**
     * @param mixed $idCategoria
     */
    public function setIdsexo($idSexo)
    {
        $this->idsexo = $idSexo;
    }
}