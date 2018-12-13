<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


/**
 * Implementación de la clase Provincia
 */
class Provincia
{


    public static function getDescripcion( $pais_id, $provincia_id){

        $param= [
            'pais_id' => $pais_id,
            'provincia_id' => $provincia_id
        ];

        $query = "SELECT PROVINCIA FROM PROVINCIAS WHERE PAIS_ID = :pais_id AND PROVINCIA_ID = :provincia_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param);
        IF ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $datos['PROVINCIA'];
        }  ;
        return "";
    }
}