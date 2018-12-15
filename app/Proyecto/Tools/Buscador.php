<?php
namespace Proyecto\Tools;

use Proyecto\DB\DBConnection;

class Buscador
{
    public static function Buscar($criterio)
    {
        $param = ['criterio' => $criterio];
        $resultados = [];

        $query = "SELECT 'E' TIPO, EQUIPO_ID ID , NOMBRE FROM EQUIPOS  WHERE UPPER(NOMBRE) LIKE concat('%', UPPER(:criterio) , '%')  ORDER BY NOMBRE";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $resultados [] = $datos;
        }

        $query = "SELECT 'T' TIPO, TORNEO_ID ID , NOMBRE FROM TORNEOS WHERE UPPER(NOMBRE) LIKE concat('%', UPPER(:criterio) , '%')  ORDER BY NOMBRE";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $resultados [] = $datos;
        }

        $query = "SELECT 'S' TIPO, SEDE_ID ID , NOMBRE FROM SEDES WHERE UPPER(NOMBRE) LIKE concat('%', UPPER(:criterio) , '%')  ORDER BY NOMBRE";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $resultados [] = $datos;
        }

        $query = "SELECT 'U' TIPO, USUARIO_ID ID , CONCAT(NOMBRE, ' ', APELLIDO) NOMBRE FROM USUARIOS WHERE UPPER(NOMBRE) LIKE concat('%', UPPER(:criterio) , '%') OR UPPER(APELLIDO) LIKE concat('%', UPPER(:criterio) , '%')  OR UPPER(USUARIO_ID) LIKE concat('%', UPPER(:criterio) , '%')  ORDER BY NOMBRE";
        $stmt = DBConnection::getStatement($query);
        $stmt->execute($param);
        while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $resultados [] = $datos;
        }

        return $resultados;
    }
}