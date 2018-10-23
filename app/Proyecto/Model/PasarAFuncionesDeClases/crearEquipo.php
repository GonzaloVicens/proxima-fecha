<?php
include('../config.php');
$inputs = $_POST;

$nombre = $_POST['nombre'];
$capitan = $_POST['capitan'];



$equipo_id = Equipo::CrearEquipo($nombre, $capitan);

if (isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])){
    $archivo_tmp = $_FILES['foto']['tmp_name'];


    $original = imagecreatefromjpeg($archivo_tmp);
    $ancho = imagesx( $original );
    $alto = imagesy( $original );

    // Copia 200 px
    $alto_max= 200;
    $ancho_max = round( $ancho *  $alto_max / $alto );

    $copia = imagecreatetruecolor( $ancho_max, $alto_max );

    imagecopyresampled( $copia, $original,
        0,0, 0,0,
        $ancho_max,$alto_max,
        $ancho,$alto);

    $nombre_nuevo = "../images/equipos/$equipo_id"."_logo_200.jpg";
    imagejpeg( $copia , $nombre_nuevo);


    // Copia 100 px
    $alto_max= 100;
    $ancho_max = round( $ancho *  $alto_max / $alto );

    $copia = imagecreatetruecolor( $ancho_max, $alto_max );

    imagecopyresampled( $copia, $original,
        0,0, 0,0,
        $ancho_max,$alto_max,
        $ancho,$alto);

    $nombre_nuevo = "../images/equipos/$equipo_id"."_logo_100.jpg";
    imagejpeg( $copia , $nombre_nuevo);

}

header('Location: ../index.php?seccion=miequipo&equipo_id='.$equipo_id);


?>