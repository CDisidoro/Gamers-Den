<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Gamers Den';
	$contenidoPrincipal = <<<EOS
		<div class = "contenedor">
			<section class = "content">
				<article>
					<h1>Página principal</h1>
					<p> Aquí está el contenido público, visible para todos los usuarios. </p>
				</article>
			</section>
		</div>
	EOS;
	include 'includes/vistas/plantillas/plantilla.php';
?>
