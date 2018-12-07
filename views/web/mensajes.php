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
        <?php if ( $usuario->tieneContactos()) { ?>
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <h2 class="mt-5 mb-5 pfgreen"><i class="fas fa-comments"></i> Mensajes</h2>
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
            //Consulta: Acá qué iría como mensaje? "no tiene mensajes"
            //o esto quedó de una etapa de prueba y ahora hay que sacarlo?
            //echo "<h1> hubo un error </h1>";
        };?>
    </div>
</main>


