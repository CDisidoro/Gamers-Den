<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');
	$tituloPagina = 'Crear noticia';
	$formulario = new FormularioCrearNoticia($_SESSION['ID']);
	$formHTML = $formulario->gestiona();

	$contenidoPrincipal = <<<EOS
	<div class="container">
		<h1 class="text-center">Crear noticia</h1>
		$formHTML
	</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>