<?php
/**
 * Created by PhpStorm.
 * User: Gonzalo V
 * Date: 24/11/2018
 * Time: 06:39 PM
 */
use Proyecto\Core\App;
use Proyecto\Session\Session;

if (Session::has('logueado') && Session::get('logueado')=='S') {

?>

<main class="py-4 mb-4 notificaciones">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h2 class="mt-5 mb-5 pfgreen"><i class="fas fa-bell"></i> Notificaciones</h2>
                <ul class="list-group colorGris2">
                    <?php foreach($notificaciones as $notif) {
                        $boton ="";
                        IF (isset($notif['PARTIDO_ID']) && !empty($notif['PARTIDO_ID'])){
                            $boton .= "<a class='pfgreen' href='../torneos/" . $notif['TORNEO_ID'] . "/" . $notif['FASE_ID'] . "/" . $notif['PARTIDO_ID'] .  "' alt='ver partido'>ver partido </a>";
                        } else {
                            if (isset($notif['TORNEO_ID']) && !empty($notif['TORNEO_ID'])){
                                $boton .= "<a class='pfgreen' href='../torneos/" . $notif['TORNEO_ID'] . "' alt='ver torneo'> ver torneo </a>";
                            }
                        }


                        IF (isset($notif['EQUIPO_ID']) && !empty($notif['EQUIPO_ID'])){
                            $boton .= "<a class='pfgreen' href='../equipos/" . $notif['EQUIPO_ID'] . "' alt='ver equipo'> ver equipo </a>";
                        }

                        IF (isset($notif['SEDE_ID']) && !empty($notif['SEDE_ID'])){
                            $boton .= "<a class='pfgreen' href='../sedes/" .  $notif['SEDE_ID'] .  "' alt='ver sede'> ver sede </a>";
                        }
                        ?>
                        <li class="list-group-item">
                            <span class="fecha"><?= $notif['FECHA'] ?></span> <?= $notif['MENSAJE'] . $boton?>
                        </li>

                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-2">

            </div>
        </div>
    </div>
</main>

<?php } ?>