<?php
/**
 * Tabla principal de ABM
 *
 */

//require_once '../Autoload/autoload.php';

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
    <div class="row marginVertical-20">
        <div class="col-sm-8 col-lg-8 col-xs-12 col-md-8 text-left marginVertical-20">
            <h1>Insertar Alimento</h1>
        </div>
        <div class="col-sm-4 col-lg-4 col-md-4"></div>
    </div>
    <section class="row">
        <div class="col-sm-8 col-lg-8 col-xs-12 col-md-8 text-right marginVertical-20">
            <a href="<?= App::$urlPath;?>/abm/abm_alimentos"><button type="button" class="btn btn-info">Volver</button></a>
        </div>
        <div class="col-sm-4 col-lg-4 col-md-4"></div>
    </section>
    <section class="row">
        <form class="form-horizontal" action="<?= App::$urlPath;?>/abm/abm_alimentos/insertar-alimento" method="post">
            <!--input id="IDALIMENTO" type="hidden" name="IDALIMENTO" value='' /-->
            <div class="form-group">
                <label for="NOMBRE_ALIMENTO" class="col-sm-2 control-label">Nombre Alimento: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="NOMBRE_ALIMENTO" type="text" name="NOMBRE_ALIMENTO" value='' />
                </div>
            </div>
            <div class="form-group">
                <label for="NOMBRELARGO_ALIMENTO" class="col-sm-2 control-label">Nombre Largo Alimento: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="NOMBRELARGO_ALIMENTO" type="text" name="NOMBRELARGO_ALIMENTO" value='' />
                </div>
            </div>
            <div class="form-group">
                <label for="CATEGORIA_IDCATEGORIA"  class="col-sm-2 control-label">Categoria: </label>
                <div class="col-sm-6">
                    <select name="CATEGORIA_IDCATEGORIA" id="CATEGORIA_IDCATEGORIA" class="form-control">
                        <?php
                        foreach($categorias as $cate)
                        {
                            //if($cate->getIdCategoria()== $ali->getCategoriaIdcategoria()) {
                              //  echo "<option selected value='" . $cate->getIdCategoria() ."'>" . $cate->getNombreCategoria() . "</option>";
                            //} else {
                                echo "<option value='" . $cate->getIdCategoria() ."'>" . $cate->getNombreCategoria() . "</option>";
                            //}
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="KCAL_X_100GR"  class="col-sm-2 control-label">KCAL por 100 gramos: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="KCAL_X_100GR"  type="text" name="KCAL_X_100GR" value='' />
                </div>
            </div>
            <div class="form-group">
                <label for="GRAMOS_CC_PORCION" class="col-sm-2 control-label">Gramos por porción: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="GRAMOS_CC_PORCION" type="text" name="GRAMOS_CC_PORCION" value='' />
                </div>
            </div>
            <div class="form-group">
                <label for="PORCION_IDPORCION"  class="col-sm-2 control-label">Porción: </label>
                <div class="col-sm-6">
                    <select name="PORCION_IDPORCION" id="PORCION_IDPORCION" class="form-control">
                        <?php
                        foreach($porciones as $porcion)
                        {
                            //if($porcion->getIdPorcion()== $ali->getPorcionIdporcion()){
                              //  echo "<option selected value='" . $porcion->getIdPorcion() ."'>" . $porcion->getNombrePorcion() . "</option>";
                            //} else {
                                echo "<option value='" . $porcion->getIdPorcion() ."'>" . $porcion->getNombrePorcion() . "</option>";
                            //}
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="CARBOHIDRATOS" class="col-sm-2 control-label">Carbohidratos: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="CARBOHIDRATOS" type="text" name="CARBOHIDRATOS" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="PROTEINAS" class="col-sm-2 control-label">Proteínas: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="PROTEINAS" type="text" name="PROTEINAS" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="GRASAS"  class="col-sm-2 control-label">Grasas: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="GRASAS" type="text" name="GRASAS" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="MG_SODIO"  class="col-sm-2 control-label">Mg Sodio: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="MG_SODIO" type="text" name="MG_SODIO" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="AZUCARES"  class="col-sm-2 control-label">Azúcares: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="AZUCARES" type="text" name="AZUCARES" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="TAMANIO_CHICO"  class="col-sm-2 control-label">Tamaño Chico: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="TAMANIO_CHICO" type="text" name="TAMANIO_CHICO" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="TAMANIO_MEDIANO"  class="col-sm-2 control-label">Tamaño Mediano: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="TAMANIO_MEDIANO" type="text" name="TAMANIO_MEDIANO" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="TAMANIO_GRANDE"  class="col-sm-2 control-label">Tamaño Grande: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="TAMANIO_GRANDE" type="text" name="TAMANIO_GRANDE" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="IMAGEN"  class="col-sm-2 control-label">Imagen: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="IMAGEN" type="text" name="IMAGEN" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="FUENTE_KCALYDEMAS"  class="col-sm-2 control-label">Fuente Kcal y demás: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="FUENTE_KCALYDEMAS" type="text" name="FUENTE_KCALYDEMAS" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="FUENTE_PORCION"  class="col-sm-2 control-label">Fuente Porción: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="FUENTE_PORCION" type="text" name="FUENTE_PORCION" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="ACLARACIONES_PUBLICAS" class="col-sm-2 control-label">Aclaraciones Públicas: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="ACLARACIONES_PUBLICAS" type="text" name="ACLARACIONES_PUBLICAS" value="" />
                </div>
            </div>
            <div class="form-group">
                <label for="COMENTARIOS_INTERNOS"  class="col-sm-2 control-label">Comentarios Internos: </label>
                <div class="col-sm-6">
                    <input class="form-control" id="COMENTARIOS_INTERNOS" type="text" name="COMENTARIOS_INTERNOS" value="" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-6">
                    <input type="submit" class="btn btn-lg btn-success" value="ENVIAR" />
                </div>
            </div>
        </form>
    </section>
</div>
<script type="text/javascript" src="<?= App::$urlPath;?>/js/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= App::$urlPath;?>/js/sweetalert/sweetalert.css">
<script type="text/javascript" src="<?= App::$urlPath;?>/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="<?= App::$urlPath;?>/bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?= App::$urlPath;?>/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
