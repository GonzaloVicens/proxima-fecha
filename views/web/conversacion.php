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
<div id='home'>
	<main>
		<div class="col-md-3">
			<a href="<?= App::$urlPath . Session::get('origenChat') ?>" class="btn btn-outline-primary" style="float:right"><i class="fas fa-chevron-left"></i> volver</a>
		</div>

		<section id="conversacion">
			<?php
			echo "<h2> Conversación con <a href='../../usuarios/" .$contactoActual->getUsuarioId() ."' class='negrita'>"  . $contactoActual->getNombreCompleto() . "</a></h2>";
			echo "<ol>";
			foreach ($mensajes as $mensaje) {
				if ($mensaje->getEmisorID() == $contactoActual->getUsuarioID()) {
					$class = "mensajeImpar";
					$classLI = "mensajeLiImpar";
				} else {
					$class = "mensajePar";
					$classLI = "mensajeLiPar";
				}
				echo "<li class='$classLI' ><span class='$class'>" . $mensaje->getMensaje() . "</span></li>";
			};
			?>
			</ol>

			<form id='formChat' action= <?=App::$urlPath . '/usuarios/agregarMensaje' ?> method='post'>
				<input type='hidden' name='usuario_id' value='<?php echo $usuarioActual->getUsuarioId() ?>'/>
				<input type='hidden' name='contacto_id' value='<?php echo $contactoActual->getUsuarioId() ?>'/>
				<textarea name='mensaje' rows='3' cols='50' id='mensaje'></textarea>
				<input type='submit' class="LinkVerPosteos" value='Enviar'/>
			</form>
		</section>
	</main>
	<?php
} else {
	header("Location: ../../../public");
}