<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:22 PM
 */

use Proyecto\Core\App;
use Proyecto\Auth\Autenticar;
//use Proyecto\Model\Alimento;

//if(!Autenticar::userLogged()) {
  //  header('Location: ' . App::$urlPath . '/login');
    //exit;
//}

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
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.11';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
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

                    <li><a href="<?= App::$urlPath;?>/contacto" class="verde">Contacto</a></li>

                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <div id="containerMain" class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <h2 class="verde marginVertical-40">
                    <?= $artic->getTitulo(); ?>
                </h2>
                <div class="divDeBlog">
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                            <figure class="contimagenart">
                                <img src="<?= App::$urlPath;?><?= $artic->getImagen1(); ?>" alt="<?= $artic->getTitulo(); ?>" >
                            </figure>
                            <div class="texto16px">
                                <?= $artic->getTexto(); ?>
                            </div>
                            <?php
                                $datoAuxiliar = $artic->getFirma();
                                if(isset($datoAuxiliar)) {

                                        echo "<p>";
                                        echo $datoAuxiliar;
                                        echo "</p>";
                                }
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <aside class='marginBottom-40 altfix200'>
                    <div class="fb-page" data-href="https://www.facebook.com/cuantaskcalorias" data-tabs="timeline" data-height="200" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/cuantaskcalorias" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/cuantaskcalorias">CuantasKcal</a></blockquote></div>
                </aside>
                <section class="bs-callout bs-callout-info">
                    <ul class='list-unstyled'>
                        <li class='text18px verde lipanel'><a href='<?= App::$urlPath;?>/about' class='text18px paddingVertical-15 verde lipanel_a'>¿Qué es CuantasKcal?</a></li>
                        <li class='text18px verde lipanel'><a href='<?= App::$urlPath;?>/contacto' class='text18px paddingVertical-15 verde lipanel_a'>Envianos un mensaje</a></li>
                        <li class='text18px verde lipanel'><a href='<?= App::$urlPath;?>/blog' class='text18px  paddingVertical-15 verde lipanel_a'>Artículos de Interés</a></li>
                    </ul>
                </section>
            </div>
        </div>
    </div> <!-- /container -->
    <footer class="footer">
        <div class="container">
            <p class="comforta text-center marginVertical-20">CuantasKcal - Todos los derechos reservados - 2017</p>
        </div>
    </footer>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?= App::$urlPath;?>/js/jquery.min.js"><\/script>')</script>
<script src="<?= App::$urlPath;?>/bootstrap/js/bootstrap.js"></script>

</body>
</html>

