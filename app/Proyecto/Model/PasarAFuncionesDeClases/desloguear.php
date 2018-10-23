<?php
    include('../config.php');
    Session::set('logueado','N');
    Session::set('usuario',null);
    header("Location: ../index.php");
?>