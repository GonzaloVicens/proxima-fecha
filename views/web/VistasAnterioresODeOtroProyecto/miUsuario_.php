<?php



$usuario_id = null;
if (isset($_GET['usuario_id'])){
	$usuario_id = $_GET['usuario_id'];
	if (Usuario::existeusuario($usuario_id)) {
		$usuario = new usuario($usuario_id);
	} else{
		header("Location: index.php?seccion=error404");
	};

} else {
	if (Session::has("usuario")){
		$usuario = Session::get('usuario');
	} else{
	header("Location: index.php?seccion=error404");
	}
} ;
?>
<main class='container'>
	<div id='primerafilamiusuario' class='row'>
		<div class='col-md-4'>
			<?php
			if(file_exists('images/usuarios/'.$usuario->getUsuarioId() . '.jpg')){
				echo "<img src='images/usuarios/".$usuario->getUsuarioId() . ".jpg' alt='foto perfil' />";
			}else {
				echo "<img src='images/icons/UserJugador.png' alt='foto perfil' />";
			}
			if (Session::has("usuario") && Session::get("usuario")->getUsuarioId() == $usuario_id){
				echo "<span id='cartelOcultoSubirFoto'>Subir Foto</span><a id='subirFotoPerfil'><span class='oculto'>Subir Foto</span></a>";
			}
			?>
		</div>
		<div class='col-md-7' id='datosusuario'>
			<ul>
				<li class='nombreUser'><?php echo $usuario->getNombreCompleto()?></li>
				<li><span class='negrita'>Equipos:</span>
					<ul>
						<?php
						if($usuario->tieneEquipo()){
							foreach ($usuario->getEquipos() as $equipo) {
								/* echo "<li>" . $equipo->getNombre() ." <a style='padding-left:40px' href='index.php?seccion=miequipo&equipo_id=".$equipo->getEquipoID()."' title=''Ver Equipo'>Ver Equipo</a></li>"; */
								echo "<li><a class='negrita' href='index.php?seccion=miequipo&equipo_id=".$equipo->getEquipoID()."' title='Ver Equipo'>" . $equipo->getNombre() ."</a></li>";
							}
						}else{
							echo "<li>Todavía no sos parte de ningún equipo.</li>";
						}?>
					</ul>
				</li>
				<li><span class='negrita'>Torneos en los que participa:</span>
					<ul>
						<?php if($usuario->tieneTorneo()){
							foreach ($usuario->getTorneos() as $torneo) {
								echo "<li>" . $torneo->getNombre() ." </li>";
							}
						}else{
							echo "<li>No participa en ningún torneo</li>";
						}?>
					</ul>
				</li>
				<li><span class='negrita'>Torneos creados:</span>
					<ul>
						<?php if($usuario->tieneTorneoPropio()){
							foreach ($usuario->getTorneosPropios() as $torneo) {
								echo "<li>" . $torneo->getNombre() ." </li>";
							}
						}else{
							echo "<li>No ha creado ningún torneo</li>";
						}?>
					</ul>
				</li>
			</ul>
		</div>
		<div id='divContieneEditar' class='col-md-1'>
			<?php
			if (Session::has("usuario") && Session::get("usuario")->getUsuarioId() == $usuario_id){
				echo"<span id='cartelOcultoEditarPerfil'>Editar Perfil</span><a id='editarPerfil'><span class='oculto'>Editar Perfil</span></a>";  
		 	} else{
		 		if(Session::has("equipo_idActual")){
					$equipo_idActual = Session::get("equipo_idActual");
					echo "<a href='index.php?seccion=miequipo&equipo_id=" . $equipo_idActual . "' title='Volver'>Volver al Equipo</a>";
				}
			}
			?>
		</div>
	</div>
	<?php
	if (Session::has("usuario") && Session::get("usuario")->getUsuarioId() == $usuario_id){
?>
		<div class='row' id='accionesEquipo'>
		<div class='col-md-3'>
			<h3 class="mayusculas negrita">Acciones - Equipo</h3>
		</div>
		<div class='col-md-3'>
			<a id='crearEquipo' href="#registroEquipo">
				Crear Un Equipo
				<img src='images/crearEquipo-200px.png' alt='icono crear equipo' />
			</a>
		</div>
		<div class='col-md-3'>
			<a id='buscarEquipo' href="#">
				Buscar un Equipo
				<img src='images/buscarEquipo2-200px.png' alt='icono buscar equipo' />
			</a>
		</div>
		<div class='col-md-3'>
			<a id='verEquipos' href="index.php?seccion=equipos">Ver Equipos<img src='images/verEquipo-200px.png' alt='icono ver equipos' /></a>
		</div>
	</div>
	<div id="registro">
		<div>
			<div id="registroEquipo">
				<div>
					<div id='cabeceraRegistroEquipo'>
						<h2 class='mayusculas'>Crear tu equipo</h2>
						<a href='#' title='Volver' id='cruzCerrar'><span class='oculto'>Volver</span></a>
						<!--a href='#' title='Volver' id='cruzCerrar'><span class='oculto'>Volver</span></a-->
					</div>
					<div id='cuerpoRegistroEquipo'>
						<form id='formRegistro' action="php/crearEquipo.php" method="post" enctype="multipart/form-data">
							<label>Nombre<input type="text" name="nombre"/></label>
							<!--<label>Capitán<input type="text" name="capitan"/></label>-->
							<input type="hidden" name="capitan" value="<?php echo $usuario->getUsuarioID()?>"/>
							<label>Escudo<input id="archivo" type="file" name="foto" accept="image/jpeg" /></label>
							<input type="hidden" name="ajax" />
							<div class='btnIngresar'>
								<input  type="submit" value="Crear Equipo" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</main>



