<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:22 PM
 */

use Proyecto\Core\App;
use Proyecto\Auth\Autenticar;

if(!Autenticar::userLogged()) {
    header('Location: ' . App::$urlPath . '/login');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!--link rel="icon" href="../../favicon.ico"-->

    <title>CuantasKcal - Home</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap-theme.css">
    <link href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/estilo1.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?= App::$urlPath;?>/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--link href="navbar-fixed-top.css" rel="stylesheet"-->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><!--script src='../../assets/js/ie8-responsive-file-warning.js'></--script><![endif]-->

    <!-- Dice que es para evitar falsos positivos de bug en IE por lo tanto el de abajo lo comento
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <!--script src='<?= App::$urlPath;?>/bootstrap/js/html5shiv.min.js'></script-->
    <!--script src='<?= App::$urlPath;?>/bootstrap/js/respond.min.js'></script-->
    <!--[endif]-->
</head>
<body>
<div class="contenedorGral">
    <header>
        <h1 class="hidden">Cuántas Kcal</h1>
    </header>
    <!-- Fixed navbar -->
    <nav id="navbar_principal" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand comforta verde" href="<?= App::$urlPath;?>/">CuántasKcal</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?= App::$urlPath;?>/" class="verde">Home</a></li>
                    <li><a href="<?= App::$urlPath;?>/about" class="verde">About</a></li>
                    <li><a href="<?= App::$urlPath;?>/blog" class="verde">Blog</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?= App::$urlPath;?>/ayuda" class="verde">Ayuda</a></li>
                    <li><a href="<?= App::$urlPath;?>/contacto" class="verde">Contacto</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <div id="containerMain" class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="verde marginVertical-40">
                            Busca Alimentos
                        </h2>
                        <table class='table table-striped table-bordered table-hover table-condensed'>
                            <thead class='verde backgroundVerdeClaro'>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Tipo Porción</th>
                                <th>Gramos Porción</th>
                                <th>Calorías por Porción</th>
                                <th>Carbohidratos</th>
                                <th>Proteínas</th>
                                <th>Grasas</th>
                                <th>Mg Sodio</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class='textoBold'> <?= $alim->getNombreAlimento(); ?></td>
                                    <td> <?= $alim->getNombreCategoria(); ?> </td>
                                    <td> <?= $alim->getNombrePorcion(); ?> </td>
                                    <td> <?= $alim->getGramosCcPorcion(); ?> </td>
                                    <td class='textoBold'> <?php

                                        $resultado = ($alim->getGramosCcPorcion() * $alim->getKcalX100gr()) / 100;

                                        echo $resultado;

                                        ?> </td>
                                    <td> <?= $alim->getCarbohidratos(); ?> </td>
                                    <td> <?= $alim->getProteinas(); ?></td>
                                    <td> <?= $alim->getGrasas(); ?></td>
                                    <td> <?= $alim->getMgSodio(); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="resp">
                        </div>
                        <div id="divBotonVolerBuscar" class='text-center'>
                            <a href="<?= App::$urlPath;?>/"><button class='btn btn-lg botonBuscar' id='botonVolverAbuscar'>VOLVER A BUSCAR</button></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        Últimos artículos publicados
                    </div>
                    <div class="col-xs-4">
                        <h3>La sal no sala y el azucar</h3>
                    </div>
                    <div class="col-xs-4">
                        <h3>La sal no sala y el azucar</h3>
                    </div>
                    <div class="col-xs-4">
                        <h3>La sal no sala y el azucar</h3>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <img src="<?= App::$urlPath;?>/img/300x250-Anuncio.png" />
        </div>

    <footer class="footer">
        <div class="container">
            <p class="comforta text-center marginVertical-20">CuantasKcal - Todos los derechos reservados - 2017</p>
        </div>
    </footer>
</div>
</body>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?= App::$urlPath;?>/js/jquery.min.js"><\/script>')</script>
<script src="<?= App::$urlPath;?>/js/bootstrap/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= App::$urlPath;?>/js/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<script src="<?= App::$urlPath;?>/js/testAjax.js"></script>
<script src="<?= App::$urlPath;?>/js/buscarDeNuevo.js"></script>
<script src="<?= App::$urlPath;?>/js/agregarCampo.js"></script>
<!--script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('.dropdown-toggle').dropdown();
</script-->
<script>
    $(document).ready(function(){
        $("#agregarCampo").tooltip({title: "Agregar un nuevo campo para buscar más de un alimento", delay: 1500});
        $("#agregarCampo").click(function(){
            $("[data-toggle='tooltip']").tooltip('destroy');
        });

        /*$('#agregar').tooltip({title: "Agregar un nuevo campo para buscar más de un alimento", delay: {show: 2000, hide: 500}});*/
    });
    $(document).ready(function(){
        cargarAjax();
    })
</script>
</html>

