<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 07/07/2017
 * Time: 12:22 PM
 */

use Proyecto\Core\App;

$num = '0';
foreach ($paginacion as $pagina) {

    $num += 1;

    if($pagina['0'] == $recetas['0']->getIdarticulo()){

        $pagina_actual = $num;


        if($num == 1) {
             $pagina_anterior = $num;
        } else {
            $pagina_anterior = $num-1;
        }

        if($num == count($paginacion)){
            $pagina_posterior = $num;
        } else {
            $pagina_posterior = $num+1;

        }

    }

}

    $cont= '0';

    foreach ($paginacion as $pagina){
        $cont += 1;

        if($cont == $pagina_anterior) {
            $indpaganterior = $pagina['0'];
        }

        if($cont == $pagina_posterior) {
            $indpagposterior = $pagina['0'];
        }
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
                    Artículos y recetas
                </h2>

                <?php
                foreach ($recetas as $receta) {
                ?>

                <div class="divDeBlog">
                    <div class="row">
                        <!--div class="col-xs-12 col-sm-12 col-md-9 tituloBlog"-->
                        <div class="col-xs-12 col-sm-12 col-md-12 tituloBlog">
                            <h2><a href="<?= App::$urlPath;?>/blog/articulo/<?php echo $receta->getIdarticulo(); ?>" class="text24px"><?php echo $receta->getTitulo(); ?></a></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="texto16px"><?php echo $receta->getPrimlineas(); ?></div>
                            <span class="hidden-xs seguirLeyendo">
                                <a href="<?= App::$urlPath;?>/blog/articulo/<?php echo $receta->getIdarticulo(); ?>">seguir leyendo</a>
                            </span>
                        </div>
                        <div class="col-sm-4 text-center">
                            <img src="<?= App::$urlPath;?><?php echo $receta->getImagen1(); ?>" class="ancho100porc" alt="<?php echo $receta->getTitulo(); ?>" />
                        </div>
                        <div class="col-sm-1">
                        </div>
                    </div>
                </div>
            <!--/div-->

                <?php
                }
                ?>

                <!--div-->

                     <nav aria-label="Page navigation">
                         <ul class="pagination">

                             <?php
                                 echo "<li><a href='" . App::$urlPath . "/blog/" . $indpaganterior . "'> &lt; </a></li>";

                                 $cont = '0';
                                 $numero = '0';

                                 foreach ($paginacion as $pagina) {

                                     $numero += 1;

                                    if($numero == $pagina_actual){
                                        echo "<li style='background-color: blue;'><a href='" . App::$urlPath . "/blog/" . $pagina[$cont] . "' style='color: white;background-color: #84ba89;'>" . $numero . "</a></li>";
                                    } else {
                                        echo "<li><a href='" . App::$urlPath . "/blog/" . $pagina[$cont] . "'>" . $numero . "</a></li>";
                                    }
                                 }

                                echo "<li><a href='" . App::$urlPath . "/blog/" . $indpagposterior . "'> &gt; </a></li>";
                             ?>

                         </ul>
                     </nav>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <!--img src="<?= App::$urlPath;?>/img/300x250-Anuncio.png" /-->
                <div class="fb-page" data-href="https://www.facebook.com/cuantaskcalorias/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/cuantaskcalorias/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/cuantaskcalorias/">CuantasKcal</a></blockquote></div>
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

