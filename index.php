<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="includes\layout\estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>
<div id="contenedor">

	<?php
		session_start();
		require ('includes/layout/cabecera.php');
		require ('includes/layout/sidebar.php');
		require('includes/layout/centro.php');
		require ('includes/layout/pie.php');
	?>

</div> <!-- Fin del contenedor -->

</body>
</html>