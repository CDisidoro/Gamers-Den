<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');
	$tituloPagina = 'Crear Producto';
	$formulario = new FormularioCrearProducto($_SESSION['ID']);
	$formHTML = $formulario->gestiona();

	$contenidoPrincipal = <<<EOS
	<div class="container">
		<h1 class="text-center">Agrega tu producto a la tienda</h1>
		$formHTML
	</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>