<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 21/10/2018
 * Time: 03:54 PM
 */

use Proyecto\Core\App;

?>
<!DOCTYPE html>
<html>
<head>
    <title>proximafecha</title>
    <meta charset="utf-8">
    <link href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/estilo.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/fontawesome/css/all.css" rel="stylesheet">
</head>
<body>
<header class="navbar navbar-expand flex-column flex-md-row pl-5 pr-5 shadow_bottom fondoHeader2">
    <div class="flexbox">
        <a class="navbar-brand mr-0 mr-md-2" href="<?= App::$urlPath;?>/" aria-label="Bootstrap">
            <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader2 mr-3">
        </a>
    </div>
    <div class="navbar-nav ml-md-auto text-light">
        <a class="btn btn-outline-light btn-bd-download d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="<?= App::$urlPath;?>/">Cerrar Sesión</a>
    </div>
</header>
