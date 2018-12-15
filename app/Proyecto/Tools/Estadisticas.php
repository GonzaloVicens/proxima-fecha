<?php
namespace Proyecto\Tools;

use Proyecto\Model\Equipo;
use Proyecto\Model\Sede;
use Proyecto\Model\Torneo;
use Proyecto\Model\Usuario;

class Estadisticas
{
    public static function GetEstadisticas($dias) {
        echo "<ul class='list-group'><li class='list-group-item w-sm-100 w-50 text-secondary'><span class='font-regular-bold'><i class='fas fa-user'></i> Usuarios Registrados</span>: " . Usuario::GetUsuariosCreados($dias);
        echo "</li><li class='list-group-item w-sm-100 w-50 text-secondary'><span class='font-regular-bold'><i class='fas fa-shield-alt'></i> Equipos Creados</span>: " . Equipo::GetEquiposCreados($dias);
        echo "</li><li class='list-group-item w-sm-100 w-50 text-secondary'><span class='font-regular-bold'><i class='fas fa-map-marker-alt'></i> Sedes Creadas</span>: ". Sede::GetSedesCreadas($dias);
        echo "</li><li class='list-group-item w-sm-100 w-50 text-secondary'><span class='font-regular-bold'><i class='fas fa-trophy'></i> Torneos Creados</span>: ". Torneo::GetTorneosCreados($dias);
        echo "</li></ul>";
    }



}