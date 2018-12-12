<?php

/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/08/2018
 * Time: 02:47 AM
 */

use Proyecto\Core\App;
use Proyecto\Session\Session;
use Proyecto\Model\Equipo;
use Proyecto\Model\Usuario;
?>
<main class="py-4 mb-4">
    <div class="container">
        <div class="row">
              <div class="col-md-10">
                <div>
                    <h2 class="my-5 pfgreen">Listado de Equipos</h2>
                    <?php
                    Equipo::imprimirEquiposEnTabla();
                    ?>
                </div>
                <div>
                    <h2  class="my-5 pfgreen">Listado de Usuarios</h2>
                    <?php
                    Usuario::imprimirUsuariosEnTabla();
                    ?>
                </div>
            </div>
            <div class="col-md-2">
                <a href="<?= App::$urlPath . '/adminPF/desloguear'?>" class="btn btn-outline-secondary float-right"><i class="fas fa-door-open"></i> Cerrar Sesion</a>
            </div>
        </div>
    </div>
</main>
