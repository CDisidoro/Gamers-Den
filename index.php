<?php namespace es\fdi\ucm\aw\gamersDen;?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="<?=RUTA_CSS.'/estilo.css'?>" />
		<title><?= $tituloPagina ?></title>
	</head>
	<body>
		<div id="contenedor">
			<?php
				require(_DIR_.'/cabecera.php');
				require(_DIR_.'/sidebar.php');
			?>
			<main>
				<article>
					<?= $contenidoPrincipal ?>
				</article>
			</main>
			<?php require(_DIR_.'/pie.php');?>
		</div>
	</body>
</html>