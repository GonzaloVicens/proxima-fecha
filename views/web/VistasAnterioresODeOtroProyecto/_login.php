<?php
/**
 * Pantalla de login
 *
 * Si el login es correcto deriva a index.php (el panel de ABM)
 *
 * Si es incorrecto devuelve mensaje de error
 *
 * Usuario: gvicens || mbardella
 * Pass: 123
 *
 * Usuario: mmargineda Pass:losnocheros
 *
 * Usuario: mvicens Pass:vereda
 *
 * Usuario: ovicens Pass:pescar
 *
 */

use Proyecto\Core\App;


if(isset($_SESSION['_input']))
{
    $input = $_SESSION['_input'];
    unset($_SESSION{'_input'});
} else {
    $input = null;
}

if(isset($_SESSION['_error']))
{
    $error = $_SESSION['_error'];
    unset($_SESSION['_error']);
} else {
    $error = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cuantas Calorías</title>
    <link rel="stylesheet" href="<?= App::$urlPath;?>/css/estilo1.css">
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= App::$urlPath;?>/bootstrap/css/bootstrap-theme.css">

    <meta charset="utf-8">
</head>
<body>
<div class="container">
    <header class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <h1>Login</h1>
            <p id="resp"></p>
        </div>
    </header>
    <div class="row">
        <main class="col-md-12 col-lg-12 col-sm-12">
            <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
            <div id="login-overlay" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="myModalLabel">Login CuantasKcal</h2>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <div class="well">
                                    <!--form id="loginForm" action="../Modelos_login.php.php" method="POST" novalidate="novalidate"-->
                                    <form id="loginForm" action="<?= App::$urlPath;?>/login" method="POST">
                                        <div class="form-group">
                                            <label for="NOMBRE" class="control-label">Usuario</label>
                                            <input type="text" class="form-control" id="USUARIO" name="USUARIO" value="<?php if($input){ echo $input['USUARIO']; } ?>" required="" title="Please enter you username" placeholder="ejemplo@gmail.com">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="PASSWORD" class="control-label">Password</label>
                                            <input type="password" class="form-control" id="PASSWORD" name="PASSWORD" value="" required="" title="Please enter your password">
                                            <?php if($error){
                                                echo "<span class='help-block alert alert-danger'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> "
                                                    . $error
                                                    . "</span>"; }
                                            ?>
                                        </div>
                                        <!--div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" id="remember"> Remember login
                                            </label>
                                        </div-->
                                        <button id="btn-ingresar" type="submit" class="btn btn-success btn-block">Login</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script>window.jQuery || document.write('<script src="<?= App::$urlPath;?>/js/jquery.min.js"><\/script>')</script>
<script src="<?= App::$urlPath;?>/bootstrap/js/bootstrap.js"></script>
</body>
</html>
