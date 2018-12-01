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
    $usuarioLogueado = true;
}else{
    $usuarioLogueado = false;
}
?>

<main class="py-4 mb-4 notificaciones">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h2 class="mt-5 mb-5 pfgreen"><i class="fas fa-bell"></i> Notificaciones</h2>
                <ul class="list-group colorGris2">

                    <li class="list-group-item"><span class="fecha">11/12/18</span> Has sido invitado al equipo Los Paisanos Enfermos</li>
                    <li class="list-group-item"><span class="fecha">21/11/18</span> Lorem ipsum dolor, upstea git upstream pre-prod. No por mucho madrugar se amanece mas temprano amaicha del valle, añola kit kat dos por uno</li>
                    <li class="list-group-item"><span class="fecha">03/08/18</span> Mensaje de Carlitos Cepeda: bartoleo quinoa cecha</li>
                </ul>
            </div>
            <div class="col-md-2">

            </div>
        </div>
        <?php if ( $usuario->tieneContactos()) { ?>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h2 class="mt-5 mb-5 pfgreen"><i class="fas fa-bell"></i> Conversaciones</h2>
                <ul id='listaAmigos'>
                <?php
                foreach( $usuario->getContactos() as $contacto) {
                    echo "<li>";

                    if(file_exists('img/usuarios/'.$contacto->getUsuarioId()  . '.jpg')){
                        echo "<img class='fotoChica' src='../img/usuarios/".$contacto->getUsuarioId() . ".jpg' alt='foto perfil' />";
                    }else {
                        echo "<img class='fotoChica' src='../img/usuarios/UserJugador.jpg' alt='foto perfil' />";
                    }

                    echo "<a href='" .$contacto->getUsuarioId() ."' class='negrita'>" . $contacto->getNombreCompleto() ."</a><a href='../mensajes/" . Session::get("usuario")->getUsuarioId() . "/". $contacto->getUsuarioId() ."' title='Ver Chat'>Ver Chat</a>";
                    if ( $usuario->tieneMensajesSinLeerDe($contacto->getUsuarioId())){
                        echo("<span> Tiene Mensajes Nuevos </span>");
                    }
                    echo "</li>";
                }
                ?>
                </ul>
            </div>
            <div class="col-md-2">

            </div>
        </div>

        <?php
            } else {
                echo "<h1> hubo un error </h1>";
        };?>
    </div>
</main>


