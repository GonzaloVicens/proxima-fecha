<?php
use Proyecto\Model\Equipo;
use Proyecto\Session\Session;


if (Equipo::existeEquipo($equipo_id)) {
	$equipo = new Equipo($equipo_id);
	$equipo->setJugadores();
	Session::set("equipo_idActual",$equipo->getEquipoId());
	?>


	<main>
		<?php
		echo "<div style='background-image: url(../img/equipos/" . $equipo_id . "_portada.jpg)'>";
		echo "<div>";
		echo "<img src='../img/equipos/" . $equipo_id . "_logo_200.jpg' alt='Logo del Equipo'/>";
		echo "<h2 class='mayusculas negrita'>" . $equipo->getNombre() . "</h2>";
		echo "</div>";
		if ( $equipo->getCapitanID() == Session::get("usuario")->getUsuarioID()) {
			echo "<div><a href='#registroEquipo' title='actualizar portada'>Actualizar Portada</a></div>";
		};
		echo "</div>";
	?>

		<div id="registro">
			<div>
				<div id="registroEquipo">
					<div>
						<div id='cabeceraRegistroEquipo'>
							<h2 class='mayusculas'>Actualizá la Portada</h2>
							<a href='#' title='Volver' id='cruzCerrar'><span class='oculto'>Volver</span></a>
						</div>
						<div id='cuerpoRegistroEquipo'>
							<form id='formRegistro' action="php/actualizarPortada.php" method="post" enctype="multipart/form-data">
								<input type="hidden" name="equipo" value="<?php echo $equipo_id?>"/>
								<label>Portada<input id="archivo" type="file" name="foto" accept="image/jpeg" /></label>
								<input type="hidden" name="ajax" />
								<div class='btnIngresar'>
									<input  type="submit" value="Actualizar Portada" />
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>



		<?php
		if ($equipo->participaEnTorneo()) {
			$torneo = $equipo->getTorneo();
			?>
			<div>
				<?php echo "<h3 class='mayusculas'>Está participando en la liga <span class='negrita'>" . $torneo->getNombre() . "</span></h3>"; ?>
				<div>
					<div class="tresColx2">
						<?php
						$torneo->printTabla($equipo_id);
						?>

					</div>
					<div class="tresCol">
						<h3> FALTA CAMBIAR ESTO Proximo Partido - Fecha 6 </h3>
						<img src="../img/equipos/1_logo_100.jpg" alt="Logo del Equipo"/>
						<p>VS</p>
						<img src="../img/equipos/9_logo_100.jpg" alt="Logo del Equipo"/>
						<p>PHP Futbol Club</p>
						<p>Array de 1 Indice</p>
						<p>Fecha y Hora: 12/11/2016 - 21:00hs</p>
						<p>Sede: Club Da Vinci</p>
						<img src="images/mapa.jpg" alt="Ubicación del lugar"/>
					</div>
				</div>
			</div>
		<?php } ?>
		<div>
			<div>
				<div class="dosCol" id="companeros">
					<h3 class="mayusculas">Integrantes del Equipo</h3>
					<?php
					$equipo->printJugadoresEnUL();
					if (! $equipo->participaEnTorneo() && $equipo->getCapitanID() == Session::get("usuario")->getUsuarioID()) {
						echo "<div><a href='#AgregarCompanero' title='Agregar Compañero'>Agregar Compañero</a></div>";
					}	?>

					<div>
						<div id="mensajeModal">
							<div>
								<div>
									<h2> Enviar Mensaje </h2>
									<a href='#' title='Volver'> Volver</a>
								</div>
								<div>
									<form action="index.php?seccion=miequipo&equipo_id=<?php echo $equipo->getEquipoId()?>" method="post">
										<textarea rows='10' cols='30' name="mensaje"></textarea>
										<input type="submit" value="Enviar"/>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="dosCol">
					<?php if ($equipo->participaEnTorneo()) {
					?>
					<div>
						<div>
							<h3> HAY QUE CAMBIAR ESTO Último Partido - Fecha 5 </h3>
							<img src="../img/equipos/1_logo_100.jpg" alt="Logo del Equipo"/>
							<p>4 - 2</p>
							<img src="../img/equipos/6_logo_100.jpg" alt="Logo del Equipo"/>
							<p>PHP Futbol Club</p>
							<p>Puerto 7</p>
							<a href="#" title="Ver Todos">Ver Resultados de Todos los Partidos Jugados</a>
						</div>
					</div>
					<?php } ?>
					<div id="Fravega">
						<a href="#" title="Fravega"><img style="margin: 0px" src="../img/fravega.png" alt="Fravega"/></a>
					</div>
				</div>
			</div>
		</div>
	</main>

	<?php
	if (! $equipo->participaEnTorneo() && $equipo->getCapitanID() == Session::get("usuario")->getUsuarioID()) {
		?>
		<div id="registroAgregar">
			<div>
				<div id="AgregarCompanero">
					<div>
						<div id='cabeceraAgregarCompanero'>
							<h2 class='mayusculas'>Elige un usuario</h2>
							<a href='#' title='Volver' id='cruzCerrarAgregar'><span class='oculto'>Volver</span></a>
						</div>
						<div id='cuerpoAgregarCompanero'>
							<form class='formRegistro' action="php/agregarJugador.php" method="post">
								<input type="hidden" name="equipo" value="<?php echo $equipo_id?>"/>
								<label>Jugador<input id="jugador" type="text" name="jugador"/></label>
								<input type="hidden" name="ajax" />
								<div class='btnIngresar'>
									<input  type="submit" value="Agregar Compañero" />
								</div>
							</form>
							<?php
							if(Session::has("errorAgregarJugador")){
								echo("<div class='DivErrores'>");
								echo("<h2 style='color:#F00'>" . Session::get("errorAgregarJugador") . "</h2>");
								echo("</div>");
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php };
} else {
	header("Location: /error404");
}
?>
