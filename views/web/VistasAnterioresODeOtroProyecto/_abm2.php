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

try{
    $alimentos = Alimento::listarTodo();
} catch (ErrorListarException $e){
    echo $e->getMessage();
}

$usuario = $_SESSION['user']->getUsuario();


?>
<!DOCTYPE html>
<html>
<head>
    <title>Cuantas Calorías</title>

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
                        <h1 style="font-size: 19px;">ABM Cuantas Calorías</h1>
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
        <nav class="row marginVertical-20">
            <div class="col-md-6 col-lg-6 col-sm-12 marginVertical-20">
               <a href="<?= App::$urlPath;?>/abm/abm_articulos" style='text-decoration: none;' ><button type="button" class="btn btn-success btn-block btn-lg">ABM ARTICULOS</button></a>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 marginVertical-20">
                <a href="<?= App::$urlPath;?>/abm/abm_alimentos" style='text-decoration: none;' ><button type="button" class="btn btn-info btn-block btn-lg">ABM ALIMENTOS</button></a>
            </div>
        </nav>
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
    <?php if(isset($_GET['msg'])) {
        if ($_GET['msg'] == 'insertOk') { ?>
            <script type="text/javascript">
                swal({
                    title: "Exito!",
                    text: "El nuevo producto se ingresó correctamente",
                    type: "success",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#5BD274"
                });
            </script>
        <?php } else if ($_GET['msg'] == 'eliminarOk'){ ?>
            <script type="text/javascript">
                swal({
                    title: "Exito!",
                    text: "El producto se eliminó correctamente",
                    type: "success",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#5BD274"
                });
            </script>
        <?php } else if ($_GET['msg'] == 'editarOk'){ ?>
            <script type="text/javascript">
                swal({
                    title: "Exito!",
                    text: "El producto se editó correctamente",
                    type: "success",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#5BD274"
                });
            </script>
        <?php }
        }?>
</body>
</html>
    