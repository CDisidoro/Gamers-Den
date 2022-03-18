<?php namespace es\fdi\ucm\aw\gamersDen;?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="<?='css/estilo.css'?>" />
		<title><?= $tituloPagina ?></title>
	</head>
	<body>
		<div id="contenedor">
			<?php
				require('includes/vistas/comun/cabecera.php');
				require('includes/vistas/comun/sidebar.php');
			?>
			<main>
				<article>
					<?= $contenidoPrincipal ?>
				</article>
			</main>
			<?php require('includes/vistas/comun/pie.php');?>
		</div>
	</body>
</html>