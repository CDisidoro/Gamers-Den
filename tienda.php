<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Nuestra tienda';
	
	
	function generaProductos(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayProductos = Producto::enseñarPorCar($_GET['caracteristica']);

		$productos = '';
		$productos.=<<<EOS
			<div="contenedor">
		EOS;
		## Cargamos todos los videojuegos disponibles con su nombre e imagen asociada
		foreach ($arrayProductos as $producto) {
			$idProducto = $producto->getID();
			$nomProducto = $producto->getNombre();
			$descProducto = $producto->getDescripcion();
			$urlImagen = 'img/';
			$urlImagen .= $usuarioAmigo->getAvatar();
			$urlImagen .= '.jpg';
			## URL del producto junto con el id
			$id = 'Productos.php?id='.$producto->getID();
			$productos.=<<<EOS
			<li>
				<a href=$id rel="nofollow" target="_blank">
				<a href = "TiendaParticular.php?id=$idProducto">
					<img src=$urlImagen width="150" height="200" alt="movil" />
					<h3>$nomProducto</h3>
				</a>
				<p>$descProducto</p>
				</a>
			</li>	
			EOS;
		}
		return $productos;
	}

	$productos = generaProductos();


	$contenidoPrincipal=<<<EOS
		$productos
		</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>
