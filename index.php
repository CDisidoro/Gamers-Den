<?php
	require_once __DIR__.'/includes/config.php';
	$tituloPagina = 'Gamers Den';
	$contenidoPrincipal=<<<EOS
		<h1>Bienvenido a la página principal de Gamers Den!!!</h1>
		<p>Aquí está el contenido público, visible para todos los usuarios con o sin registro.</p>
		<p>Usa la barra de menú para navegar.</p>
	EOS;
	require __DIR__.'/includes/vistas/comun/plantilla.php';
?>