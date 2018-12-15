<?php
namespace Proyecto\Tools;

use Proyecto\Model\Equipo;
use Proyecto\Model\Sede;
use Proyecto\Model\Torneo;
use Proyecto\Model\Usuario;

class Estadisticas
{
    public static function GetEstadisticas($dias) {
        echo "<ul><li>Usuarios Registrados: " . Usuario::GetUsuariosCreados($dias);
        echo "</li><li>Equipos Creados: " . Equipo::GetEquiposCreados($dias);
        echo "</li><li>Sedes Creadas: ". Sede::GetSedesCreadas($dias);
        echo "</li><li>Torneos Creados: ". Torneo::GetTorneosCreados($dias);
        echo "</li></ul>";
    }



}