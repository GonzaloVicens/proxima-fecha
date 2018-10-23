var d = document;

var b = d.getElementsByTagName("body")[0];

/* Funciones para mostar cartelito informativo cuando se hace Hover en icono Subir Foto y Editar Perfil*/

var agregarFoto = d.getElementById('subirFotoPerfil');
var editarPerfil = d.getElementById('editarPerfil');

agregarFoto.onmouseover = function(){
		var spanOculto = d.getElementById('cartelOcultoSubirFoto');
		spanOculto.style.opacity = '1';
	/* 	spanOculto.style.top ='85%';
		spanOculto.style.left ='65%'; */
	}
	
agregarFoto.onmouseout = function(){
		var spanOculto = d.getElementById('cartelOcultoSubirFoto');
		spanOculto.style.opacity = '0';
	}
	

editarPerfil.onmouseover = function(){
		var spanOcultoEditar = d.getElementById('cartelOcultoEditarPerfil');
		spanOcultoEditar.style.opacity = '1';
	}
	
editarPerfil.onmouseout = function(){
		var spanOcultoEditar = d.getElementById('cartelOcultoEditarPerfil');
		spanOcultoEditar.style.opacity = '0';
	}
	
/* FIN DE Funciones para mostar cartelito >> Subir Foto y Editar Perfil */