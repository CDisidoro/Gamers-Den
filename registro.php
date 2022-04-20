<?php namespace es\fdi\ucm\aw\gamersDen;
	//Inicio del procesamiento
    require ('includes/config.php');

	## Mostramos el registro con un formulario en el que se nos pide: Nombre, email y contraseña
	$tituloPagina = 'Registro';
	$formulario = new FormularioRegistro();
	$formHTML = $formulario->gestiona();

    ## Capturamos todo el html mediante el operador multilinea <<<
    ## Código del formulario: https://www.php.net/manual/es/tutorial.forms.php
    ## Términos de la página: https://www.htmlquick.com/es/reference/tags/input-checkbox.html

	$contenidoPrincipal = <<<EOS
	<div id="contenedor" class="container">
		<h1 class="text-center">Registro de usuario</h1>
		$formHTML
	</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>