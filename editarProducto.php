<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = 'Editar Producto';
	$formulario = new FormularioEditarProducto($_GET['id'],$_SESSION['ID']);
	$formHTML = $formulario->gestiona();

	$contenidoPrincipal = <<<EOS
	<div id="contenedor">	
		<main>
		<article>
				<h1>Edita la información de tu producto</h1>
				$formHTML
			</article>
		</main>
	</div>
	EOS;
    include 'includes/vistas/plantillas/plantilla.php';
?>