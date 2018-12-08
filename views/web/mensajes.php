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
$usuario->actualizar();
// Cionfiguro el origen del chat para el botón "Volver" de la conversacion;
Session::set('origenChat','/usuarios/mensajes');

?>

<main class="py-4 mb-4 mensajes">
    <div class="container">
        <?php if ( $usuario->tieneContactos()) { ?>
            <div class="row">
                <div class="col-md-2">
                </div>
                <div class="col-md-8">
                    <h2 class="mt-5 mb-5 pfgreen"><i class="fas fa-comments"></i> Mensajes</h2>
                    <ul class='lista-contacto-mensaje list-group'>
                        <?php
                        foreach( $usuario->getContactos() as $contacto) {
                            echo "<li class='li-contacto-mensaje list-group-item'>";

                                echo "<a href='../usuarios/".$contacto->getUsuarioId() . "' title='Ver Datos Usuario'>";
                            if(file_exists('img/usuarios/'.$contacto->getUsuarioId()  . '.jpg')){
                                echo "    <img src='../img/usuarios/".$contacto->getUsuarioId() . ".jpg' alt='Foto del Contacto ".$contacto->getNombreCompleto(). "'>";
                            }else {
                                echo "<img class='fotoChica' src='../img/usuarios/UserJugador.jpg' alt='foto perfil' />";
                            }
                                echo "</a>";
                                echo "<a class='li-listado-jugadores-a pfgreen hoverVerde' href='../mensajes/" . Session::get("usuario")->getUsuarioId() . "/". $contacto->getUsuarioId() ."' title='Ver Chat'>";
                                echo "    <span class='nombre_apellido_jugador'>". $contacto->getNombreCompleto() . "</span>";
                                echo "    <span class='ml-3 font-italic colorGris2 hoverVerde'> ". $contacto->getUsuarioId() . "</span>";
                                echo "</a>";
                                echo "<a href='../mensajes/" . Session::get("usuario")->getUsuarioId() . "/". $contacto->getUsuarioId() ."' class='verchat' title='Ver Chat'><i class='fas fa-comment'></i> Ver Chat</a>";


                            if ( $usuario->tieneMensajesSinLeerDe($contacto->getUsuarioId())){
                                echo("<span class='aviso-mensajes-nuevos'> <i class='fas fa-exclamation-circle'></i> Mensajes Nuevos </span>");
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
    </div>|
</main>


