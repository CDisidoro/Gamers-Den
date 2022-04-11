<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');

    $idNoticia = filter_var($_GET['id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
	$tituloPagina = 'Editar noticia';
	$formulario = new FormularioEditarNoticia($idNoticia);
	$formHTML = $formulario->gestiona();

	$contenidoPrincipal = <<<EOS
	<div id="contenedor">	
		<main>
		<article>
				<h1>Edita aquí la noticia</h1>
				$formHTML
			</article>
		</main>
	</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>