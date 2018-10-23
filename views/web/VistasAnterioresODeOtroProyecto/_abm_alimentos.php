<?php
/**
 * Tabla principal de ABM
 *
 */

//require_once '../Autoload/autoload.php';

use Proyecto\Core\App;
use Proyecto\Auth\Autenticar;
use Proyecto\Model\Alimento;
use Proyecto\Model\Usuario;

if(!Autenticar::userLogged()) {
    header('Location: ' . App::$urlPath . '/login');
    exit;
}


/*
try{
    $alimentos = Alimento::listarTodo();
} catch (ErrorListarException $e){
    echo $e->getMessage();
} */

$usuario = $_SESSION['user']->getUsuario();

if(isset($_SESSION['rtausuario']))
{
    $msg = $_SESSION['rtausuario'];
    unset($_SESSION['rtausuario']);
} else {
    $msg = null;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cuantas Calorías</title>
    <!--link rel="stylesheet" href="../Bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../Bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" href="../CSS/estilo1.css"-->
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= App::$urlPath;?>/css/estilo1.css">
    <meta charset="utf-8">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <header class="col-md-12 col-lg-12 col-sm-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <h1 style="font-size: 19px;">Listado de Alimentos</h1>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"> </span><?php echo " " . $usuario . " "; ?><span class="caret"> </span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?= App::$urlPath;?>/abm/salir">cerrar sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            </header>
        </div>
    </div>
    <div class="container">
        <section class="row">
            <div class="col-sm-12 col-lg-12 col-xs-11 col-md-12 text-right marginVertical-20">
                <a href="<?= App::$urlPath;?>/abm"><button type="button" class="btn btn-info">Volver</button></a>
            </div>
        </section>
        <div class="row marginVertical-20">
            <nav class="col-md-12 col-lg-12 col-sm-12">
                <a href="<?= App::$urlPath;?>/abm/abm_alimentos/insertar-alimento"><button type="button" class="btn btn-primary">Nuevo Alimento <span class='glyphicon glyphicon-info-sign' data-toggle="tooltip" data-placement="top" title="Agregar un nuevo alimento a la base de datos"></span></button></a>
            </nav>
        </div>
        <div class="row">
            <main class="col-md-12 col-lg-12 col-sm-12">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoria</th>
                        <th>Porcion</th>
                        <th>Gramos o cc por porción</th>
                        <th>Calorías por porción</th>
                        <th>Carbohidratos</th>
                        <th>Proteínas</th>
                        <th>Grasas</th>
                        <th>Mg Sodio</th>
                        <th>Fuente info</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($alimentos as $ali)
                        {
                            echo "<tr>";
                                echo "<td>" . $ali->getNombreAlimento() . "</td>";
                                echo "<td>" . $ali->getNombreCategoria() . "</td>";
                                echo "<td>" . $ali->getNombrePorcion() . "</td>";
                                echo "<td>" . $ali->getGramosCcPorcion() . "</td>";
                                echo "<td>" . (($ali->getKcalX100gr() * $ali->getGramosCcPorcion()) / 100) . "</td>";
                                echo "<td>" . $ali->getCarbohidratos() . "</td>";
                                echo "<td>" . $ali->getProteinas() . "</td>";
                                echo "<td>" . $ali->getGrasas() . "</td>";
                                echo "<td>" . $ali->getMgSodio() . "</td>";
                                echo "<td class='text-center'><div data-toggle='tooltip' data-placement='top' title='" . $ali->getFuenteKcalydemas() . "'><span class='glyphicon glyphicon-info-sign'></span></div></td>";

                                //echo "<td class='text-center'><a href='editAlimento.php?IDALIMENTO=" .  $ali->getIdalimento() . "'><span class='glyphicon glyphicon-pencil'></span></a></td>";

                                echo "<td class='text-center'><form action='" . App::$urlPath . "/abm/abm_alimentos/ver-editar' method='post'><input type='hidden' name='IDALIMENTO' value='" . $ali->getIdalimento() . "' id='" . $ali->getIdalimento() . "'><button type='submit' class='sinBordeNiFondo'><i class='glyphicon glyphicon-pencil text-primary'></i></button></form></td>";

                                echo "<td class='text-center'><form action='" . App::$urlPath . "/abm/abm_alimentos/ver-eliminar' method='post'><input type='hidden' name='IDALIMENTO' value='" . $ali->getIdalimento() . "' id='" . $ali->getIdalimento() . "'><button type='submit' class='sinBordeNiFondo'><i class='glyphicon glyphicon-remove text-danger'></i></button></form></td>";

                                //echo "<td class='text-center'><a href='../Modelos/eliminar.php?IDALIMENTO=" .  $ali->getIdalimento() . "'><span class='glyphicon glyphicon-remove'></span></a></td>";
                            echo "</tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <script type="text/javascript" src="<?= App::$urlPath;?>/JS/sweetalert/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= App::$urlPath;?>/JS/sweetalert/sweetalert.css">
    <script type="text/javascript" src="<?= App::$urlPath;?>/JS/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="<?= App::$urlPath;?>/Bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?= App::$urlPath;?>/Bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('.dropdown-toggle').dropdown();
    </script>
    <?php if(isset($msg)) {
        if ($msg =='insertOk') { ?>
            <script type="text/javascript">
                swal({
                    title: "Exito!",
                    text: "El nuevo registró se ingresó correctamente",
                    type: "success",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#5BD274"
                });
            </script>
        <?php } else if ($msg == 'eliminarOk'){ ?>
            <script type="text/javascript">
                swal({
                    title: "Exito!",
                    text: "El registro se eliminó correctamente",
                    type: "success",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#5BD274"
                });
            </script>
        <?php } else if ($msg == 'editarOk'){ ?>
            <script type="text/javascript">
                swal({
                    title: "Exito!",
                    text: "El registro se editó correctamente",
                    type: "success",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#5BD274"
                });
            </script>
        <?php }
        }?>
</body>
</html>
    