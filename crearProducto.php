<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');
	$tituloPagina = 'Crear Producto';
	$formulario = new FormularioCrearProducto($_SESSION['ID']);
	$formHTML = $formulario->gestiona();

	$contenidoPrincipal = <<<EOS
	<div id="contenedor">	
		<main>
		<article>
				<h1>Agrega tu producto a la tienda</h1>
				$formHTML
			</article>
		</main>
	</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>