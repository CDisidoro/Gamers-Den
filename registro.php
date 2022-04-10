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
	<div id="contenedor">	
		<main>
		<article>
				<h1>Registro de usuario</h1>
				$formHTML
			</article>
		</main>
	</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>