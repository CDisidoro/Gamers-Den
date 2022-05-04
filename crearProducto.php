<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');
	$tituloPagina = 'Crear Producto';
	if(isset($_GET['id'])){
		$formulario = new FormularioCrearProducto($_SESSION['ID'], $_GET['id']);
	}else{
		$formulario = new FormularioCrearProducto($_SESSION['ID'], null);
	}
	$formHTML = $formulario->gestiona();

	$contenidoPrincipal = <<<EOS
	<div class="container">
		<h1 class="text-center">Agrega tu producto a la tienda</h1>
		$formHTML
	</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>