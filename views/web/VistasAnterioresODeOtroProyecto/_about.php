<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:22 PM
 */

use Proyecto\Core\App;

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
                    <!--li--><!--a href="<?= App::$urlPath;?>/ayuda" class="verde">Ayuda</a></li-->
                    <li><a href="<?= App::$urlPath;?>/contacto" class="verde">Contacto</a></li>
                    <!--li><a href="#" class="verde">Fixed top <span class="sr-only">(current)</span></a></li-->
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <div id="containerMain" class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <h2 class="verde marginVertical-40">
                    Acerca de CuántasKcal
                </h2>
                <div id="">
                    <p class="texto16px"><a href="default.php" class="textoBold verde comforta">CuántasKcal</a> es una web que ofrece información sobre alimentos de consumo cotidiano.
                         Cuenta con un <a class="textoBold verde" href="default.php">buscador</a>, donde el usuario podrá averiguar las calorías de un determinado alimento,
                        junto con su composición de hidratos de carbono, proteínas y grasas (macronutrientes).</p>
                    <!--p class="texto16px">Si tienes alguna duda sobre el funcionamiento o la información brindada por el buscador,
                        por favor <a class="textoBold verde" href="#">consulta la sección de ayuda</a>.</p-->
                    <p class="texto16px">También cuenta con un <a class="textoBold verde" href="#">blog</a>, donde se publican artículos de información general vinculados a la alimentación, nutrición, consumo de calorías, etc.,
                    redactados por comunicadores especializados.</p>
                    <p class="texto16px alert alert-success"><span class="textoBold">Aclaración:</span> CuántasKcal no intenta sugerir formas de alimentación ni tampoco dietas. En el caso que quieras modificar tus hábitos alimenticios
                    sea por la razón que fuera, te pedimos que consultes un nutricionista o especialista en alimentación a la hora de comenzar una dieta. Sólo un profesional
                    de la materia podrá darte consejos y diseñarte una dieta adecuada para tí, y acorde a tu organismo.</p>
                    <p class="texto16px">Muchas gracias por visitar nuestra web!</p>
                    <p class="texto16px">CuantasKcal.com</p>
                </div>
                <div id="resp">

                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <!--img src="<?= App::$urlPath;?>/img/300x250-Anuncio.png" /-->
                <aside class="altfix500 marginBottom-30">
                    <div class="fb-page" data-href="https://www.facebook.com/cuantaskcalorias/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/cuantaskcalorias/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/cuantaskcalorias/">CuantasKcal</a></blockquote></div>
                </aside>
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

