<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');

	$tituloPagina = 'Cambiar Biografia';
	$formulario = new FormularioCambiarBio($_SESSION['ID']);
	$formHTML = $formulario->gestiona();

	$contenidoPrincipal = <<<EOS
	<div id="contenedor">	
		<main>
		<article>
				<h1 class="text-center">Cambia aquí tu biografía</h1>
				$formHTML
			</article>
		</main>
	</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>