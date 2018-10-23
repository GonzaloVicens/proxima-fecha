var d = document;

var header = d.getElementById('arriba');
var logo = d.getElementById('logoPrincipal');

/* var AgregarOrden = d.getElementById('AgregarReparacion');
 */
window.onscroll = function(e){
	header.style.height = '70px';
	logo.style.transform = 'scale(0.65,0.65)';
	logo.style.top = '-10px';
	logo.style.left = '-10px';
}

