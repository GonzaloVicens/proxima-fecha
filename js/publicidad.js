var d = document;


var publicidad = d.getElementById('publicidad');
publicidad.onmouseover = function(){
	this.getElementsByTagName('img')[0].src = "images/publicidad_2.png";
	this.style.height = "220px";	
};

publicidad.onmouseout = function(){
	this.getElementsByTagName('img')[0].src = "images/publicidad_1.png";
	this.style.height = "60px";	
};


publicidad.getElementsByTagName('a')[0].addEventListener('click', function(ev) {
	ev.preventDefault();
	var publicidad = 	d.getElementById("publicidad");
	var padre = publicidad.parentNode;
	padre.removeChild(publicidad);
});

publicidad.getElementsByTagName('img')[0].addEventListener('click', function(ev) {
	window.open("http://www.canal13.com.ar", "_blank"); 
});