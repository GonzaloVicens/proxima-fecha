<?php	
	include('../config.php');
	$inputs = $_POST;
	
	$error =0;
	$errorActual = "";
	
	Session::start();

    $formValidator = new FormValidator( $inputs);


	// Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
	if ( !empty($formValidator->getCamposError()) ){
        Session::set("camposError",$formValidator->getCamposError());
        Session::set("campos",$formValidator->getCampos());
		header("Location: ../index.php?error=1#registroModal");
	} else {
        Session::set("campos",$formValidator->getCampos());
		$usuario_id = Usuario::CrearUsuario($inputs);
        $usuario = New Usuario($usuario_id);
        Session::set('usuario',$usuario);
        Session::set('logueado','S');
        header("Location: ../index.php?seccion=miusuario&usuario_id=$usuario_id");
	}

?>