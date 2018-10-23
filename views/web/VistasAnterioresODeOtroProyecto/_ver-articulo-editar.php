<?php
/**
 * Pantalla para insert de alimentos
 *
 * Si los inputs están completos va a Modelos/grabar.php
 *
 * En caso de no estar completos cuaqluiera de los 6 primeros inputs, aparece un mensaje de error
 *
 */

//require_once '../Autoload/autoload.php';

use Proyecto\Core\App;
use Proyecto\Model\Categoria;
use Proyecto\Model\Subcategoria;
use Proyecto\Model\Palabraclave;
use Proyecto\Auth\Autenticar;

if(!Autenticar::userLogged()) {
    header('Location: ' . App::$urlPath . '/login');
    exit;
}

$categorias = Categoria::listarTodo();
$subcategorias = Subcategoria::listarTodo();
$palabraclave = Palabraclave::listarTodo();


if(isset($_SESSION['datoartedit']))
{
    $input = $_SESSION['datoartedit'];
    unset($_SESSION['datoartedit']);
} else {
    $input = null;
}


$problema = false;
if(isset($_GET['PROBLEMA'])){
    if($_GET['PROBLEMA']){
        $problema = $_GET['PROBLEMA'];
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cuantas Calorías</title>
    <!--link rel="stylesheet" href="../CSS/estilo1.css">
    <link rel="stylesheet" href="../public/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/bootstrap/css/bootstrap-theme.css"-->
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= App::$urlPath;?>/css/estilo1.css">
    <meta charset="utf-8">
</head>
<body>
<div class="container">
    <div class="row">
        <header class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
            <h1>Editar Artículo</h1>
        </header>
    </div>
    <?php
    /*if($problema){
        echo "<div class='row'>";
        echo "    <div class='col-sm-8 col-lg-8 col-xs-12 col-md-8 marginVertical-20'>";
        echo "        <div class='alert alert-danger' role='alert'>";
        echo "            <span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>";
        echo "            <span class='sr-only'>Error:</span>";
        echo "             Es necesario completar los datos de los campos:";
        echo "             <div class='row'>";
        echo "                 <div class='col-sm-6 col-lg-6 col-xs-12 col-md-6'>";
        echo "                    <ul>";
        echo "                        <li>Nombre Alimento</li>";
        echo "                        <li>Nombre Largo Alimento</li>";
        echo "                        <li>Categoria</li>";
        echo "                    </ul>";
        echo "                 </div>";
        echo "                 <div class='col-sm-6 col-lg-6 col-xs-12 col-md-6'>";
        echo "                    <ul>";
        echo "                        <li>KCAL por 100 gramos</li>";
        echo "                        <li>Gramos por porción</li>";
        echo "                        <li>Porción</li>";
        echo "                    </ul>";
        echo "                 </div>";
        echo "             </div>";
        echo "        </div>";
        echo "    </div>";
        echo "    <div class='col-sm-4 col-lg-4 col-md-4'></div>";
        echo "</div>";
    }*/
    ?>
    <section class="row">
        <div class="col-sm-12 col-lg-12 col-xs-11 col-md-12 text-right marginVertical-20">
            <a href="<?= App::$urlPath;?>/abm/abm_articulos"><button type="button" class="btn btn-info">Volver</button></a>
        </div>
        <!--div class="col-sm-1 col-lg-1 col-md-1"></div-->
    </section>
    <main class="row">
        <div class="col-md-7">
            <div class="row">
                <form class="form-horizontal" action="<?= App::$urlPath;?>/abm/abm_articulos/previa-edit" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" value="<?php
                        if(isset($artic)){
                            echo $artic->getIdarticulo();
                        }?>" name="IDARTICULO"/>
                        <label for="TITULO" class="col-sm-3 col-md-3 control-label">Título: </label>
                        <div class="col-sm-9 col-md-9">
                            <input class="form-control" id="TITULO" type="text" name="TITULO" value="<?php
                                                                                                            if(isset($input)){
                                                                                                                echo $input->getTitulo();
                                                                                                            } elseif(isset($artic)){
                                                                                                                echo $artic->getTitulo();
                                                                                                            }?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="PRIMLINEAS" class="col-sm-3 control-label">Primeras líneas: </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="PRIMLINEAS" name="PRIMLINEAS" rows="10"><?php
                                if(isset($input)){
                                    echo $input->getPrimlineas();
                                } elseif(isset($artic)){
                                    echo $artic->getPrimlineas();
                                }?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="IMAGEN1" class="col-sm-3 control-label">Imagen 1: </label>
                        <div class="col-sm-9">
                            <!--input type='hidden' value='<?php
                            //if(isset($input)){
                              //  echo $input->getImagen1();
                            //} elseif(isset($artic)){
                              //  echo $artic->getImagen1();
                            //}
                            ?>' class='form-control' id='IMAGEN1' name='IMAGEN1'-->
                            <figure>
                                <img style="width: 100%;" src="<?= App::$urlPath;?><?php
                                         if(isset($input)){
                                             echo $input->getImagen1();
                                         } elseif(isset($artic)){
                                             echo $artic->getImagen1();
                                         }
                                            ?>" alt="<?php
                                if(isset($input)){
                                    echo $input->getTitulo();
                                } elseif(isset($artic)){
                                    echo $artic->getTitulo();
                                }
                                ?>" >

                            </figure>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="IMAGEN1" class="col-sm-3 control-label">Cambiar Imagen 1: </label>
                        <div class="col-sm-9">
                            <input class="form-control" id="IMAGEN1" type="file" name="IMAGEN1" value="" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="TEXTO" class="col-sm-3 control-label">Texto Completo: </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="TEXTO" name="TEXTO" rows="20"><?php
                                if(isset($input)){
                                    echo $input->getTexto();
                                } elseif(isset($artic)){
                                    echo $artic->getTexto();
                                }
                                ?></textarea>
                        </div>
                    </div>


                    <div class="form-group hidden">
                        <label for="IMAGEN2" class="col-sm-3 control-label">Imagen 2: </label>
                        <div class="col-sm-9">
                            <input class="form-control" id="IMAGEN2" type="file" name="IMAGEN2" value="" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="FIRMA" class="col-sm-3 control-label">Firma: </label>
                        <div class="col-sm-9">
                            <input class="form-control" id="FIRMA" type="text" name="FIRMA" value="<?php
                            if(isset($input)){
                                echo $input->getFirma();
                            } elseif(isset($artic)){
                                echo $artic->getFirma();
                            }?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="CATEGART_IDCATEGART"  class="col-sm-3 control-label">Categoría: </label>
                        <div class="col-sm-9">
                             <select name="CATEGART_IDCATEGART" class="form-control">
                                    <?php
                                    foreach($categorias as $cate)
                                    {
                                        if(isset($input)) {

                                            if($cate->getIdCategoria() == $input->getCategoria()) {

                                                echo "<option value='" . $cate->getIdCategoria() . "' selected>" . $cate->getNombreCategoria() . "</option>";

                                            } else {

                                                echo "<option value='" . $cate->getIdCategoria() ."'>" . $cate->getNombreCategoria() . "</option>";

                                            }

                                        } elseif(isset($artic)) {

                                            if($cate->getIdCategoria() == $artic->getCategoria()) {

                                                echo "<option value='" . $cate->getIdCategoria() . "' selected>" . $cate->getNombreCategoria() . "</option>";

                                            } else {

                                                echo "<option value='" . $cate->getIdCategoria() ."'>" . $cate->getNombreCategoria() . "</option>";

                                            }

                                        } else {

                                            echo "<option value='" . $cate->getIdCategoria() ."'>" . $cate->getNombreCategoria() . "</option>";

                                        }
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="SUBCATEGART_IDSUBCATEGART"  class="col-sm-3 control-label">Sub-Categoría: </label>
                        <div class="col-sm-9">
                            <select name="SUBCATEGART_IDSUBCATEGART" class="form-control">
                                <?php
                                foreach($subcategorias as $subcate)
                                {
                                    //echo "<option value='" . $subcate->getIdSubcategoria() ."'>" . $subcate->getNombreSubcategoria() . "</option>";
                                    if(isset($input)) {

                                        if($subcate->getIdSubcategoria() == $input->getSubcategoria()) {

                                            echo "<option value='" . $subcate->getIdSubcategoria() . "' selected>" . $subcate->getNombreSubcategoria() . "</option>";

                                        } else {

                                            echo "<option value='" . $subcate->getIdSubcategoria() ."'>" . $subcate->getNombreSubcategoria() . "</option>";

                                        }

                                    } elseif(isset($artic)) {

                                        if($subcate->getIdSubcategoria() == $artic->getSubcategoria()) {

                                            echo "<option value='" . $subcate->getIdSubcategoria() . "' selected>" . $subcate->getNombreSubcategoria() . "</option>";

                                        } else {

                                            echo "<option value='" . $subcate->getIdSubcategoria() ."'>" . $subcate->getNombreSubcategoria() . "</option>";

                                        }

                                    } else {

                                        echo "<option value='" . $subcate->getIdSubcategoria() ."'>" . $subcate->getNombreSubcategoria() . "</option>";

                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="PALABRACLAVE"  class="col-sm-3 control-label">Palabra Clave: </label>
                        <div class="col-sm-9">
                            <select name="PALABRACLAVE" class="form-control">
                                <?php
                                foreach($palabraclave as $palcla)
                                {
                                    if(isset($input)) {

                                        if($palcla->getIdPalabraclave() == $input->getPalabraclave()) {

                                            echo "<option value='" . $palcla->getIdPalabraclave() . "' selected>" . $palcla->getNombrePalabraclave() . "</option>";

                                        } else {

                                            echo "<option value='" . $palcla->getIdPalabraclave() ."'>" . $palcla->getNombrePalabraclave() . "</option>";

                                        }

                                    } elseif(isset($artic)) {

                                        if($palcla->getIdPalabraclave() == $artic->getPalabraclave()) {

                                            echo "<option value='" . $palcla->getIdPalabraclave() . "' selected>" . $palcla->getNombrePalabraclave() . "</option>";

                                        } else {

                                            echo "<option value='" . $palcla->getIdPalabraclave() ."'>" . $palcla->getNombrePalabraclave() . "</option>";

                                        }

                                    } else {

                                        echo "<option value='" . $palcla->getIdPalabraclave() ."'>" . $palcla->getNombrePalabraclave() . "</option>";

                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <input type="submit" class="btn btn-lg btn-success" value="ENVIAR" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-5">
        </div>
    </main>
</div>
</body>
</html>
