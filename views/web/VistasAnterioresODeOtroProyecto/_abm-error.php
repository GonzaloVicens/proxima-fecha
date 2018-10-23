<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 03/12/2017
 * Time: 09:31 PM
 */

use Proyecto\Core\App;
use Proyecto\Auth\Autenticar;
use Proyecto\Model\Alimento;
use Proyecto\Model\Porcion;
use Proyecto\Model\Categoria;
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
}*/

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
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-4">
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
            <Header>
                <h1>Hubo un problema</h1>
            </Header>
            <section>
                <div class="marginVertical-20 text-center">
                    <img src="<?= App::$urlPath;?>/img/icons/deadfaceerror.png" alt="cara con lengua afuera y ojos en cruz" width="280">
                </div>
                <p class="lead"><?php echo $msg; ?></p>
                <a href="<?= App::$urlPath;?>/abm"><button type="button" class="btn btn-primary btn-block btn-lg">Volver</button></a>
            </section>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-4">
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?= App::$urlPath;?>/JS/sweetalert/sweetalert.css">
<script type="text/javascript" src="<?= App::$urlPath;?>/JS/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= App::$urlPath;?>/Bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?= App::$urlPath;?>/Bootstrap/js/bootstrap.min.js"></script>
</body>
</html>