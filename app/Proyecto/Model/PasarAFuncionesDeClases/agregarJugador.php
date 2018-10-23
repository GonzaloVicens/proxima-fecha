<?php
include('../config.php');
$inputs = $_POST;
Session::start();
if (isset($_POST["equipo"]) && !empty($_POST["equipo"]) ){
    $equipo_id = $_POST['equipo'];
    $equipo = new Equipo($equipo_id);

    if (isset($_POST["jugador"]) && !empty($_POST["jugador"])) {

        $jugador_id = $_POST['jugador'];

        if ($equipo->existeJugador($jugador_id)) {
            Session::set("errorAgregarJugador", $jugador_id . " ya es un jugador del equipo");
        } else {
            if (Usuario::existeUsuario($jugador_id)) {
                $equipo->insertarJugador($jugador_id);
                Session::clear("errorAgregarJugador");
            } else {
                Session::set("errorAgregarJugador", $jugador_id . " no existe en el sistema");
            }
        };
    } else {
        Session::set("errorAgregarJugador",  " Ingrese un jugador");
    }

    header('Location: ../index.php?seccion=miequipo&equipo_id='.$equipo_id.'#AgregarCompanero');
} else {
    header('Location: ../index.php?seccion=miequipo');
}


?>