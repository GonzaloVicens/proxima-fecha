<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 21/10/2018
 * Time: 15:49 AM
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
<header class="navbar navbar-expand flex-row shadow_bottom fondoHeader2">
    <div class="flexbox">
        <a class="navbar-brand mr-0 mr-3" href="<?= App::$urlPath;?>/" aria-label="Bootstrap">
            <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader3 mr-3">
        </a>
    </div>
    <div class="navbar-nav ml-auto text-light">
        <a class="btn btn-outline-light d-inline-block ml-3" href="<?= App::$urlPath . '/adminPF/desloguear'?>">Salir</a>
    </div>
</header>