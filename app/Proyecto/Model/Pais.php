<?php
namespace Proyecto\Model;

use Proyecto\DB\DBConnection;


/**
 * Implementación de la clase Pais
 */
class Pais
{


    public static function getDescripcion( $pais_id){

        $param= [
            'pais_id' => $pais_id
        ];

        $query = "SELECT PAIS FROM PAISES WHERE PAIS_ID = :pais_id";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param);
        IF ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return $datos['PAIS'];
        }  ;
        return "";
    }
}