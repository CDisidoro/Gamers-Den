<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Gamers Den';
	$contenidoPrincipal = <<<EOS
		<main>
		<article>
			<h1>Página principal</h1>
			<p> Aquí está el contenido público, visible para todos los usuarios. </p>
		</article>
		</main>
	EOS;
	include 'includes/vistas/plantillas/plantilla.php';
?>
