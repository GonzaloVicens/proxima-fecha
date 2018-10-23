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
<html lang="es">
<head>
    <title>CuantasKcal - Home</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!--link rel="icon" href="../../favicon.ico"-->

    <!--script src="<?= App::$urlPath;?>/js/listbox/highlight.pack.js"></script-->
    <!--script src="<?= App::$urlPath;?>/js/listbox/toolbar.js"></script-->


    <!-- Funcionaba a medias con estos archivos enlazados -->
    <script src="<?= App::$urlPath;?>/js/listbox/listbox.js"></script>
    <script src="<?= App::$urlPath;?>/js/listbox/main.js"></script>
    <script src="<?= App::$urlPath;?>/js/listbox/utils.js"></script>



    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= App::$urlPath;?>/css/estilo1.css">
    <!--link href="App::$urlPath/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet"-->

    <!-- Agregar el html shiv acá -->
</head>
<body>
<div id="fb-root"></div>
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
    <div id="containerMain" class="container paddingBottom-40">
        <div class="row">
            <div class="col-md-9 col-lg-9">
                <!--div>
                    <input type="text" name="nombre" value="" placeholder="Inserte texto" />
                </div-->
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-10">
                        <h2 class="verde marginVertical-40">
                            Busca Información Nutricional de Alimentos
                        </h2>
                        <div id="divForm" class="marginBottom-60">
                            <form action='' id="formAlimentos" method="post">
                                <div id="divCampos">
                                    <div class="form-group" id='formAlimento1'>
                                        <label for="NOMBRE_ALIMENTO" class="hidden">Buscar información de alimentos</label>

                                        <input class="form-control input-lg inputAlimento" role="combobox" autocomplete="off" id="alimento1" type="text" name="NOMBRE_ALIMENTO" placeholder="Averiguar calorías de...">
                                        <!--button class="btn btn-lg botonBuscar" id="botonForm" name="<?= App::$urlPath;?>/buscar-alimento">ENVIAR</button-->
                                        <input id="alimento2" type="hidden" name="<?= App::$urlPath;?>">
                                    </div>
                                    <div id="contpredicciones" class="displayNone">
                                        <div id="predicciones">
                                            <ul role='listbox' id='ss_imp_list' tabindex='0' aria-activedescendant=''> <!--aria-activedescendant='ss_opt1'-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <!--button class="btn btn-lg botonBuscar" id="botonForm" name="<?= App::$urlPath;?>/buscar-alimento">ENVIAR</button-->
                                </div>
                            </form>
                        </div>
                        <!--div id="resp" class="displayNone">
                         </div>
                         <div id="divBotonVolerBuscar" class='text-center displayNone'>
                            <button class='btn btn-lg botonBuscar' id='botonVolverAbuscar'>VOLVER A BUSCAR</button>
                        </div-->
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2">
                    </div>
                </div>
                <div class="row">
                    <!--div class="col-xs-12 col-sm-12 col-md-12"-->
                    <div id="resp" class="displayNone"  style='margin-bottom: 30px;padding:8px 30px 30px;'>
                    </div>
                    <!--/div-->
                    <!--div class="col-xs-12 col-sm-12 col-md-12"-->
                    <div id="divBotonVolerBuscar" class='text-center displayNone'>
                        <button class='btn btn-lg botonBuscar' id='botonVolverAbuscar'>VOLVER A BUSCAR</button>
                    </div>
                    <!--/div-->
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <h3 class="verde">Últimas publicaciones</h3>
                    </div>
                </div>
                <div class="row marginBottom-40">

                    <?php
                    foreach ($ultimaspub as $ultimapub) {
                    ?>


                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h4 style='overflow: hidden;height: 1.2em;'><a href="<?= App::$urlPath;?>/blog/articulo/<?php echo $ultimapub->getIdarticulo(); ?>" class="ultimaspub"><?php echo $ultimapub->getTitulo(); ?></a></h4>
                        <a href="<?= App::$urlPath;?>/blog/articulo/<?php echo $ultimapub->getIdarticulo(); ?>" class="ultimaspubimg"><img src="<?= App::$urlPath;?><?= $ultimapub->getImagen1(); ?>" alt="<?= $ultimapub->getTitulo(); ?>" class="ancho100porc" /></a>
                        </div>


                    <?php
                    }
                    ?>


                </div>
                </div>

         <!--/div>
        </div-->
        <div class="col-md-3 col-lg-3">
            <aside class='marginBottom-40 altfix200'>
                <div class="fb-page" data-href="https://www.facebook.com/cuantaskcalorias" data-tabs="timeline" data-height="200" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/cuantaskcalorias" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/cuantaskcalorias">CuantasKcal</a></blockquote></div>
                <!--img src="<?= App::$urlPath;?>/img/300x250-Anuncio.png" /-->
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
    </div>
    <!--/div-->
    </div>
    <footer class="footer">
        <div class="container">
            <p class="comforta text-center marginVertical-20">CuantasKcal - Todos los derechos reservados - 2017</p>
        </div>
    </footer>

</body>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--script-- src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script-->
<script>window.jQuery || document.write('<script src="<?= App::$urlPath;?>/js/jquery.min.js"><\/script>')</script>
<script src="<?= App::$urlPath;?>/bootstrap/js/bootstrap.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--script src="App::$urlPath/js/bootstrap/js/ie10-viewport-bug-workaround.js"></script-->
<!--script src="<?= App::$urlPath;?>/js/testAjax.js"></script-->
<script src="<?= App::$urlPath;?>/js/testAjax2.js"></script>
<!--script src="<?= App::$urlPath;?>/js/testSearch.js"></script-->
<script src="<?= App::$urlPath;?>/js/testSearch2.js"></script>
<script src="<?= App::$urlPath;?>/js/busquedaconclick.js"></script>
<script src="<?= App::$urlPath;?>/js/formarSalida.js"></script>
<script src="<?= App::$urlPath;?>/js/buscarDeNuevo.js"></script>



</html>

