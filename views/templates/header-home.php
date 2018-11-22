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
    <link href="<?= App::$urlPath;?>/css/contact.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/estilo.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/fontawesome/css/all.css" rel="stylesheet">
</head>
<body>
<header class="navbar navbar-expand flex-column flex-md-row fondoHeader pl-5 pr-5">
    <div class="flexbox">
        <a class="navbar-brand mr-0 mr-md-2" href="<?= App::$urlPath;?>/" aria-label="Bootstrap">
            <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader mr-3">
        </a>
    </div>
    <div class="flexbox navbar-nav ml-md-auto">
        <form class="d-none d-md-block d-lg-block">
            <div class="input-group">
                <div class="input-group-prepend justify-content-center">
                    <span class="input-group-text" id="inputGroupPrepend2"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control" id="validationDefaultUsername" placeholder="Buscar..." aria-describedby="inputGroupPrepend2" required>
            </div>
        </form>
    </div>
    <div class="navbar-nav ml-md-auto text-light">
        <a class="btn btn-outline-warning btn-bd-download d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="<?= App::$urlPath;?>/registrarse">REGISTRARSE</a>
    </div>
</header>