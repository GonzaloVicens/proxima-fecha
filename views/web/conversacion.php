<?php
use Proyecto\Core\App;
use Proyecto\Session\Session;
use Proyecto\Model\Usuario;
use Proyecto\Model\Mensaje;


/**
 * @var Usuario $usuarioActual
 * @var Usuario $contactoActual
 * @var array $chats
 */
if (Session::has("usuario") && Session::get("usuario")->getUsuarioId() == $usuarioActual->getUsuarioId()) {


	?>
	<body>
<main class="py-4 mb-4 mensaje">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                 <div class="btn-volver-derecha">
                    <a href="<?= App::$urlPath . Session::get('origenChat') ?>" class="btn btn-outline-secondary btn-volver-derecha"><i class="fas fa-chevron-left"></i> volver</a>
                 </div>
                <section id="conversacion">
                    <?php
                    echo "<h2 class='h4 colorGris2'><span class='font-weight-normal'>Conversación con</span> <br>";
                    //Conversación con <img src='.$contactoActual->getUsuarioID().'><a href='../../usuarios/" .$contactoActual->getUsuarioId() ."' class='verde3 hoverVerde'>"  . $contactoActual->getNombreCompleto() . "</a></h2>";
                    //Conversación con <img src='" . App::$urlPath . "/img/usuarios/".$contactoActual->getUsuarioId() . ".jpg'><a href='../../usuarios/" .$contactoActual->getUsuarioId() ."' class='verde3 hoverVerde'>"  . $contactoActual->getNombreCompleto() . "</a></h2>";
                    if(isset($contactoActual) and file_exists('img/usuarios/'.$contactoActual->getUsuarioId() . '.jpg')){

                        echo "<img class='redondo' src='" . App::$urlPath . "/img/usuarios/".$contactoActual->getUsuarioId() . ".jpg'><a href='../../usuarios/" .$contactoActual->getUsuarioId() ."' class='h3 verde3 hoverVerde'>"  . $contactoActual->getNombreCompleto() . "</a></h2>";
                    }else {
                        echo "<img class='redondo' src='" . App::$urlPath . "/img/usuarios/UserJugador.jpg'><a href='../../usuarios/" .$contactoActual->getUsuarioId() ."' class='verde3 hoverVerde'>"  . $contactoActual->getNombreCompleto() . "</a></h2>";
                    }
                    echo "<ol class='dialogo'>";
                    foreach ($mensajes as $mensaje) {
                        if ($mensaje->getEmisorID() == $contactoActual->getUsuarioID()) {
                            $class = "mensajeImpar";
                            $classLI = "mensajeLiImpar";

                            echo "<li class='$classLI'>";
                            ////echo "    <span class='$class'>" . $mensaje->getMensaje() . "</span>";
                            if(isset($contactoActual) and file_exists('img/usuarios/'.$contactoActual->getUsuarioId() . '.jpg')){
                                echo "<span class='$class'><img class='redondo' src='" . App::$urlPath . "/img/usuarios/".$contactoActual->getUsuarioId() . ".jpg'><p class='unMensaje'>" . $mensaje->getMensaje() . "</p></span>";
                            }else {
                                echo "<span class='$class'><img class='redondo' src='" . App::$urlPath . "/img/usuarios/UserJugador.jpg'><p class='unMensaje'>" . $mensaje->getMensaje() . "</p></span>";
                            }
                            echo "</li>";

                        } else {
                            $class = "mensajePar";
                            $classLI = "mensajeLiPar";

                            echo "<li class='$classLI'>";
                            echo "    <span class='$class'>" . $mensaje->getMensaje() . "</span>";
                            echo "</li>";

                        }
                        //echo "<li class='$classLI' ><span class='$class'>" . $mensaje->getMensaje() . "</span></li>";
                    };
                    ?>
                    </ol>

                    <form id='formChat' action= <?=App::$urlPath . '/usuarios/agregarMensaje' ?> method='post'>
                        <input type='hidden' name='usuario_id' value='<?php echo $usuarioActual->getUsuarioId() ?>'/>
                        <input type='hidden' name='contacto_id' value='<?php echo $contactoActual->getUsuarioId() ?>'/>
                        <textarea name='mensaje' rows='3' cols='50' id='nuevoMensaje' class="mr-3"></textarea>
                        <input type='submit' class="LinkVerPosteos btn btn-outline-success" value='Enviar'/>
                    </form>
                </section>
                </div>
                <div class="col-md-2">
                </div>
            </div>
        </div>
	</main>
	<?php
} else {
	header("Location: ../../../public");
}