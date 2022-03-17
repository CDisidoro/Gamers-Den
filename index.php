<?php namespace es\fdi\ucm\aw\gamersDen;?>
<!DOCTYPE html>
<html>
<<<<<<< HEAD
<head>
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>
<div class ="contenedor">
	<?php 
		session_start();
        require ('includes/vistas/comun/cabecera.php');
    ?>
          
	<div class = "clearfix"> </div>
         
    <?php 
        require ('includes/vistas/comun/sidebar.php');
    ?>   

    <div class = "clearfix"></div>
	
	<section>
		<?php
			require ('includes/vistas/comun/centro.php');
		?>
	</section>

	<?php
		require ('includes/vistas/comun/pie.php');
	?>

</div> <!-- Fin del contenedor -->

</body>
=======
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="<?='css/estilo.css'?>" />
		<title><?= $tituloPagina ?></title>
	</head>
	<body>
		<div id="contenedor">
			<?php
				require('includes/vistas/comun/cabecera.php');
				require('includes/vistas/comun//sidebar.php');
			?>
			<main>
				<article>
					<?= $contenidoPrincipal ?>
				</article>
			</main>
			<?php require('includes/vistas/comun//pie.php');?>
		</div>
	</body>
>>>>>>> 4cc71657c5c02472d98cbaaa5a259c50c4f27f46
</html>