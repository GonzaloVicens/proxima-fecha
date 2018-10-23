<?php
include('../config.php');
$inputs = $_POST;

$equipo = $_POST['equipo'];
if (isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])){
    $archivo_tmp = $_FILES['foto']['tmp_name'];

    $original = imagecreatefromjpeg($archivo_tmp);
    $ancho = imagesx( $original );
    $alto = imagesy( $original );

	
	$alto_max= 675;
    $ancho_max = round( $ancho *  $alto_max / $alto );

	
    $copia = imagecreatetruecolor( $ancho_max, $alto_max );

    imagecopyresampled( $copia, $original,
        0,0, 0,0,
        $ancho_max,$alto_max,
        $ancho,$alto);

    $nombre_nuevo = "../images/equipos/$equipo"."_portada.jpg";
    imagejpeg( $copia , $nombre_nuevo);
}

header('Location: ../index.php?seccion=miequipo&equipo_id='.$equipo);


?>