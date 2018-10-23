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
    <!--link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css"-->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#tabs" ).tabs();
        } );
    </script>

    <link href="<?= App::$urlPath;?>/css/estilo1.css" rel="stylesheet">
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
                <a class="navbar-brand comforta verde" href="#">CuántasKcal</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#" class="verde">Home</a></li>
                    <li><a href="#" class="verde">About</a></li>
                    <li><a href="#" class="verde">Blog</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" class="verde">Ayuda</a></li>
                    <li><a href="#" class="verde">Contacto</a></li>
                    <!--li><a href="#" class="verde">Fixed top <span class="sr-only">(current)</span></a></li-->
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <div id="containerMain" class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="tabs">
                <ul>
                    <li><a href="#tabs-1">Vista Previa Artículo</a></li>
                    <li><a href="#tabs-2">Vista Previa en Listado</a></li>
                </ul>
                <div id="tabs-1">
                <h2 class="verde marginVertical-40">
                    <?= $artic->getTitulo(); ?>
                </h2>
                <div class="divDeBlog">
                    <div class="row">
                        <!--div class="col-xs-12 col-sm-12 col-md-9 tituloBlog">
                            <h2><a href="#" class="text24px">Nuggets de Coliflor</a></h2>
                        </div-->
                        <div class="col-sm-10">
                            <figure class="contimagenart">
                                <!--img src="<--?= App::$urlPath;?--><!--?php-->
                                <img src="<?php

                                            $datoaux = $artic->getImagen1();

                                            if(isset($datoaux)) {
                                                //echo "<p>";
                                                echo $datoaux;
                                                //echo "</p>";
                                            }

                                            ?>" alt="<?= $artic->getTitulo(); ?>" >
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
                        <div class="col-sm-2">
                        </div>
                    </div>
                </div>
                </div>

                <div id="tabs-2">
                <div class="divDeBlog">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-9 tituloBlog">
                            <h2><a href="<?= App::$urlPath;?>/blog/1" class="text24px">Nuggets de Coliflor</a></h2>
                        </div>
                        <div class="col-sm-7">
                            <div class="texto16px"><h3 class="texto16px marginTop-0">Ingredientes(4 porciones):</h3><ul><li>500 gramos de coliflor</li><li>1 huevo</li><li>1 de taza de pan
                                        molido</li><li>100 gramos de queso manchego rallado</li><li>aceite vegetal</li><li>sal y pimienta al gusto <b class="verde">(...)</b></li></ul></div>
                            <span class="hidden-xs  seguirLeyendo">
                               <a href='#'> seguir leyendo</a>
                            </span>
                        </div>
                        <div class="col-sm-4 text-center">
                            <img src="<?= App::$urlPath;?>/img/articulos/nuggetsdecoliflor6x4.jpg" class="ancho100porc" alt="Nuggets de Coliflor" />
                        </div>
                        <div class="col-sm-1">
                        </div>
                    </div>
                </div>
                <div class="divDeBlog" style='border-right: red solid 5px;' id="previaarticulo">
                        <div class="row">
                            <div class="col-sm-12 tituloBlog">
                                <h3><a href="#" class="text24px"> <?= $artic->getTitulo(); ?> </a></h3>
                            </div>
                            <div class="col-sm-7">
                                <div class="texto16px">     <?php echo $artic->getPrimlineas(); ?>        </div><span class="hidden-xs seguirLeyendo"><a href='#'> seguir leyendo</a></span>
                            </div>
                            <div class="col-sm-4 text-center">
                                <img src="<?php

                                $datoaux = $artic->getImagen1();

                                if(isset($datoaux)) {
                                    //echo "<p>";
                                    echo $datoaux;
                                    //echo "</p>";
                                }

                                ?>" class="ancho100porc" alt="<?= $artic->getTitulo(); ?>" >

                                <!--img src="<?= App::$urlPath;?><?php echo $artic->getImagen1(); ?>" class="ancho100porc" alt="<?= $artic->getTitulo(); ?>" /-->
                            </div>
                            <div class="col-sm-1">
                            </div>
                        </div>
                </div>
                <div class="divDeBlog">
                    <div class="row">
                        <div class="col-sm-12 tituloBlog">
                            <h3><a href="#" class="text24px">Pollo a la Mostaza</a></h3>
                        </div>
                        <div class="col-sm-7">
                            <div class="texto16px"><h3 class="texto16px marginTop-0">Ingredientes:</h3><ul><li>1 diente de ajo pelado</li><li>60 gramos de mantequilla</li><li>60 gramos de nata</li><li>1 cucharada de mostaza Dijon (en bolitas)</li><li>Pizca de sal y pimienta</li><li>Pechugas de pollo <b class="verde">(...)</b></li></div><span class="hidden-xs seguirLeyendo"><a href='#'> seguir leyendo</a></span>
                        </div>
                        <div class="col-sm-4 text-center">
                            <img src="<?= App::$urlPath;?>/img/articulos/mustard6x4.jpg" class="ancho100porc" alt="Pollo a la mostaza" />
                        </div>
                        <div class="col-sm-1">
                        </div>
                    </div>
                </div>
                <div class="divDeBlog">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 tituloBlog">
                            <h3><a href="#" class="text24px">Batido de Mamey</a></h3>
                        </div>
                        <div class="col-sm-7">
                            <div class="texto16px"><p>El mamey es una fruta tropical común en centroamérica. Este batido típico es uno de los favoritos de lugareños y turistas por su cremosidad y frescura.</p><h3 class="texto16px marginTop-0">Preparación:</h3><p>Cortar la fruta en trozos, verter en la licuadora, agregarle 2 tazas llenas de agua... <b class="verde">(...)</b></p></div>
                            <span class="hidden-xs seguirLeyendo">
                                <a href='#'> seguir leyendo</a>
                            </span>
                        </div>
                        <div class="col-sm-4 text-center">
                            <img src="<?= App::$urlPath;?>/img/articulos/batidodemamey6x4.jpg" class="ancho100porc" alt="Batido de Mamey" />
                        </div>
                        <div class="col-sm-1">
                        </div>
                    </div>
                </div>
                </div>



            </div>
            <div class="col-md-3 col-lg-3">
                <!-- ACA van a ir los Botones para Insertar el artículo o volver para editarlo -->
                <div class="marginVertical-20">
                    <form method="post" enctype="multipart/form-data" action="<?= App::$urlPath;?>/abm/abm_articulos/insertar">
                        <input type="hidden" name="TITULO" value="<?= $artic->getTitulo(); ?>">
                        <input type="hidden" name="PRIMLINEAS" value="<?= $artic->getPrimlineas(); ?>">
                        <input type="hidden" name="TEXTO" value="<?= $artic->getTexto(); ?>">
                        <!--input type="file" class='hide' name="IMAGEN1" value="">
                        <input type="file" class='hide' name="IMAGEN2" value=""-->
                        <input type="hidden" name="IMAGEN1" value="<?php
                            $datoaux = $artic->getImagen1();
                            if(isset($datoaux)) {
                                echo $datoaux;
                            }
                            ?>">
                        <input type="hidden" name="IMAGEN2" value="">
                        <input type="hidden" name="FIRMA" value="<?= $artic->getFirma(); ?>">
                        <input type="hidden" name="CATEGART_IDCATEGART" value="<?= $artic->getCategoria(); ?>">
                        <input type="hidden" name="SUBCATEGART_IDSUBCATEGART" value="<?= $artic->getSubcategoria(); ?>">
                        <input type="hidden" name="PALABRACLAVE" value="<?= $artic->getPalabraclave(); ?>">
                        <input type="submit" class="btn btn-success btn-block btn-lg" value="CONFIRMAR">
                    </form>
                </div>
                <div class="marginVertical-20">
                    <!--a href="<?= App::$urlPath;?>/abm/abm_articulos" class='marginVertical-20' style='text-decoration: none;' ><button type="button" class="btn btn-info btn-block btn-lg">VOLVER para EDITAR</button></a-->
                    <form method="post" enctype="multipart/form-data" action="<?= App::$urlPath;?>/abm/abm_articulos">
                        <input type="hidden" name="TITULO" value="<?= $artic->getTitulo(); ?>">
                        <input type="hidden" name="PRIMLINEAS" value="<?= $artic->getPrimlineas(); ?>">
                        <input type="hidden" name="TEXTO" value="<?= $artic->getTexto(); ?>">
                        <input type="file" class='hide' name="IMAGEN1" value="">
                        <input type="file" class='hide' name="IMAGEN2" value="">
                        <input type="hidden" name="FIRMA" value="<?= $artic->getFirma(); ?>">
                        <input type="hidden" name="CATEGART_IDCATEGART" value="<?= $artic->getCategoria(); ?>">
                        <input type="hidden" name="SUBCATEGART_IDSUBCATEGART" value="<?= $artic->getSubcategoria(); ?>">
                        <input type="hidden" name="PALABRACLAVE" value="<?= $artic->getPalabraclave(); ?>">
                        <input type="submit" class="btn btn-info btn-block btn-lg" value="VOLVER para EDITAR">
                    </form>
                </div>
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
<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../JS/jquery.min.js"><\/script>')</script>
<script src="../public/bootstrap/js/bootstrap.js"></script-->
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--script src="../public/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
<script src="../JS/testAjax.js"></script>
<script src="../JS/buscarDeNuevo.js"></script>
<script-- src="../JS/agregarCampo.js"></script-->
<!--script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $('.dropdown-toggle').dropdown();
</script-->
<!--script>
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

</script-->
</body>
</html>

