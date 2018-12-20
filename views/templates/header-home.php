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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= App::$urlPath;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/css/estilo.css" rel="stylesheet">
    <link href="<?= App::$urlPath;?>/fontawesome/css/all.css" rel="stylesheet">
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-9226700858522421",
            enable_page_level_ads: true
        });
    </script>

</head>
<body>
<header class="navbar navbar-expand flex-column flex-md-row fondoHeader pl-5 pr-5">
    <h1 class="d-none fontsizecero">Proximafecha.com - Gestión Online de Torneos de Fútbol</h1>
    <div class="flexbox">
        <a class="navbar-brand mr-0 mr-md-2" href="<?= App::$urlPath;?>/" aria-label="Bootstrap">
            <img src="<?= App::$urlPath;?>/img/LOGOPF-Sin-Fondo.png" class="logoHeader mr-3">
        </a>
    </div>
    <div class="flexbox navbar-nav ml-md-auto">
        <form method="post" action="buscar" class="d-none d-md-block d-lg-block">
            <div class="input-group">
                <div class="input-group-prepend justify-content-center">
                    <span class="input-group-text" id="inputGroupPrepend2"><i class="fas fa-search"></i></span>
                </div>
                <input name="criterio" type="text" class="form-control" placeholder="Buscar..." aria-describedby="inputGroupPrepend2" required>
            </div>
        </form>
    </div>
    <div class="navbar-nav ml-md-auto text-light">
        <a class="btn btn-outline-warning btn-bd-download d-lg-inline-block mb-3 mb-md-0 ml-md-3" href="<?= App::$urlPath;?>/registrarse">REGISTRARSE</a>
    </div>
</header>