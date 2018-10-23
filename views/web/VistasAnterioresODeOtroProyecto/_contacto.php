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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!--link rel="icon" href="../../favicon.ico"-->

    <title>CuantasKcal - Contacto</title>

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
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="verde marginVertical-40">
                            Contacto - CuántasKcal
                        </h2>
                        <p class="lead">
                            Dejanos tu consulta, duda o sugerencia. Te responderemos a la brevedad.
                        </p>
                    </div>
                </div>
                <div id="divFormContacto">
                    <form class="form-horizontal" role="form" method="post" action="" enctype="multipart/form-data">
                        <!--div class="container"-->
                        <div class="row" style="margin:0 6px;">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label verde texto16px">Nombre</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="nombre" value="">
                                </div>
                                <div class="col-sm-1">
                                </div>
                            </div>
                        </div>
                        <!--/div-->
                        <!--div class="container"-->
                        <div class="row" style="margin:0 6px;">
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label verde texto16px">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@dominio.com" value="">
                                </div>
                                <div class="col-sm-1">
                                </div>
                            </div>
                        </div>
                        <!--/div-->
                        <!--div class="container"-->
                        <div class="row" style="margin:0 6px;">
                            <div class="form-group">
                                <label for="message" class="col-sm-2 control-label verde texto16px">Mensaje</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="4" name="message"></textarea>
                                </div>
                                <div class="col-sm-1">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin:0 6px;">
                            <div class="form-group">
                                 <div class="col-sm-12 col-sm-offset-2">
                                    <button class="btn btn-lg botonBuscar" id="botonForm">ENVIAR</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 col-sm-offset-2">
                            </div>
                        </div>
                    </form>
                </div>
                <div id="resp">

                </div>

            </div>
            <div class=" col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <aside class="altfix500 marginBottom-30">
                    <div class="fb-page" data-href="https://www.facebook.com/cuantaskcalorias/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/cuantaskcalorias/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/cuantaskcalorias/">CuantasKcal</a></blockquote></div>
                </aside>
            </div>
        </div>
    </div> <!-- /container -->

    <div class="modal fade" id="ventanaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="form-control-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


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
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script type="text/javascript">
   $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

   /* $('.dropdown-toggle').dropdown();*/
</script>
<script type="text/javascript" src="<?= App::$urlPath;?>/js/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= App::$urlPath;?>/js/sweetalert/sweetalert.css">




<?php if(isset($msgrta)) {
    if ($msgrta == 'ok') { ?>
        <script type="text/javascript">
            swal({
                title: "Éxito!",
                text: "Su mensaje fue enviado éxitosamente. Le responderemos a la brevedad. Muchas gracias!",
                type: "success",
                confirmButtonText: "Entendido",
                confirmButtonColor: "#5BD274"
            });
        </script>
    <?php } else if ($msgrta == 'problema'){ ?>
        <script type="text/javascript">
            swal({
                title: "Hubo un problema...",
                text: "Su mensaje no se pudo enviar, disculpe las molestias. Por favor vuelva a intentar más tarde",
                type: "error",
                confirmButtonText: "Entendido",
                confirmButtonColor: "#5BD274"
            });
        </script>
    <?php  $msgrta = '';}


}
?>

</body>
</html>

