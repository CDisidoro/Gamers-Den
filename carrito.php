<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Mi Carrito';

	function generaProductos(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayProductos = Producto::getCarrito($_SESSION['ID']);

		$productos = '';
		## Cargamos todos los videojuegos disponibles con su nombre e imagen asociada
		if($arrayProductos != -1){
			foreach ($arrayProductos as $producto) {
				$idProducto = $producto->getID();
				$nomProducto = $producto->getNombre();
				$descProducto = $producto->getDescripcion();
				$urlImagen = $producto->getImagen();
				## URL del producto junto con el id
				$id = 'Productos.php?id='.$producto->getID();
				$productos.=<<<EOS
					<div class = "tarjetaProducto">
						<a href=$id rel="nofollow" target="_blank">
						<a href = "tienda_particular.php?id=$idProducto">
							<img src=$urlImagen class = "imagenTajetaProducto" />
							<p class = "nombreProductoTarjeta">$nomProducto</p>
						</a>
						<p class = "descripcionProductoTarjeta">$descProducto</p>
						</a>
					</div>
				EOS;
			}
		}	
		return $productos;
	}

	$productos = generaProductos();
	if(isset($_SESSION['login'])){
		$formCompra = new FormularioComprarCarrito($_SESSION['ID']);
		$formHTML = $formCompra->gestiona();
		$usuario = Usuario::buscaPorId($_SESSION['ID']);
		$precioTotal = $usuario->precioCarrito();
		$contenidoPrincipal=<<<EOS
		<section class = "tiendaPrincipal">
			<div class = "container">
				<div class = "cajaTituloTienda">
					<h1 class = "tituloPagina"> MI CARRITO </h1>
				</div>
				<div class = "contenedorTienda">
					<div class = "cuadroProductos">
						{$productos}                     
					</div>
					<h1 class = "PrecioCarrito text-center">PRECIO TOTAL: $precioTotal €</h1>
					{$formHTML}                      
				</div>

			</div>		
		</section>
		EOS;
	}
	else {
		$contenidoPrincipal = <<<EOS
			<section class = "content">
				<p>No has iniciado sesión. Por favor, logueate para poder acceder a la tienda</p>
			</section>
		EOS;
	}
	include 'includes/vistas/plantillas/plantilla.php';
?>
