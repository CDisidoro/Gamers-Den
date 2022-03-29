<?php namespace es\fdi\ucm\aw\gamersDen;
	//require_once __DIR__.'/includes/config.php';
	//require __DIR__.'/includes/Videojuegos.php'; // Habrá que meter los videojuegos 

	## Cogemos todos nuestros videojuegos en un array
	$arrayProductos = Videojuegos::cargarVideojuegos();
	
	## Mostrar los productos
	$tituloPagina = 'Nuestra tienda';
	$productos = '';
	$productos.=<<<EOS
		<div="contenedor">
	EOS;
	
	## Cargo todos los videojuegos disponibles con su nombre e imagen asociada, tengo que preguntar lo de la imagen
	for ($i = 0; $i < sizeof($arrayProductos); $i++) {
		$nombreVideojuego=strval($arrayProductos[$i]->muestraNombre());
		$urlImagen=strval($arrayProductos[$i]->muestraImagen());
		## URL del producto junto con el id
		$id = 'Videojuegos.php?id='.$arrayProductos[$i]->muestraID();
		$productos.=<<<EOS
		<li>
			<a href=$id rel="nofollow" target="_blank">
				<img src=$urlImagen width="150" height="200" alt="movil" />
				<h3>$nombreJuego</h3>
			</a>
		</li>	
		EOS;
	}

	## COSAS QUE TODAVÍA NO ESTAN IMPLEMENTADAS:
	## La función muestraImagen todavía no está pq no tenemos puestas las imágenes, 
	## a su vez tampoco está hecho que ponga la descripción del producto, etc....

	$contenidoPrincipal=<<<EOS
		$productos
		</div>
	EOS;

include 'includes/vistas/plantillas/plantilla.php';
