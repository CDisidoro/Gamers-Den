<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Mis Productos';

	function generaProductosVenta(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayProductos = Producto::getVendiendo($_SESSION['ID']);

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

	function generaProductosComprados(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayProductos = Producto::getCompra($_SESSION['ID']);

		$productos = '';
		## Cargamos todos los videojuegos disponibles con su nombre e imagen asociada
		if($arrayProductos != -1){
			foreach ($arrayProductos as $producto) {
				$idProducto = $producto->getID();
				$nomProducto = $producto->getNombre();
				$descProducto = $producto->getDescripcion();
				$urlImagen = $producto->getImagen();
				$formCancelar = new FormularioCancelarCompra($idProducto);
				$formHTML = $formCancelar->gestiona();
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
						{$formHTML}
					</div>
				EOS;
			}
		}	
		return $productos;
	}

	function generaProductosPorConfirmar(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayProductos = Producto::getConfirmados($_SESSION['ID']);

		$productos = '';
		## Cargamos todos los videojuegos disponibles con su nombre e imagen asociada
		if($arrayProductos != -1){
			foreach ($arrayProductos as $producto) {
				$idProducto = $producto->getID();
				$nomProducto = $producto->getNombre();
				$descProducto = $producto->getDescripcion();
				$urlImagen = $producto->getImagen();
				$formCancelar = new FormularioCancelarCompra($idProducto);
				$formHTMLCancelar = $formCancelar->gestiona();
				$formConfirmar = new FormularioConfirmarCompra($idProducto);
				$formHTMLConfirmar = $formConfirmar->gestiona();
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
						{$formHTMLCancelar}
						{$formHTMLConfirmar}
					</div>
				EOS;
			}
		}	
		return $productos;
	}

	function generaProductosEnviados(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayProductos = Producto::getEnviados($_SESSION['ID']);

		$productos = '';
		## Cargamos todos los videojuegos disponibles con su nombre e imagen asociada
		if($arrayProductos != -1){
			foreach ($arrayProductos as $producto) {
				$idProducto = $producto->getID();
				$nomProducto = $producto->getNombre();
				$descProducto = $producto->getDescripcion();
				$urlImagen = $producto->getImagen();
				$formFinalizar= new FormularioFinalizarCompra($idProducto);
				$formHTML= $formFinalizar->gestiona();
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
						{$formHTML}
					</div>
				EOS;
			}
		}	
		return $productos;
	}

	if(isset($_SESSION['login'])){
		$productosVenta = generaProductosVenta();
		$productosCompra = generaProductosComprados();
		$productosPorConfirmar = generaProductosPorConfirmar();
		$productosPorFinalizar = generaProductosEnviados();
		$usuario = Usuario::buscaPorId($_SESSION['ID']);
		$contenidoPrincipal=<<<EOS
		<section class = "tiendaPrincipal">
			<div class = "container">
				<div class = "cajaTituloTienda">
					<h1 class = "tituloPagina"> MIS PRODUCTOS </h1>
				</div>
				<div class = "contenedorTienda">
					<h2 class = "tituloPagina"> MIS PRODUCTOS EN VENTA </h2>
					<div class = "cuadroProductos">
						{$productosVenta}                     
					</div>                
				</div>
				<div class = "contenedorTienda">
					<h2 class = "tituloPagina"> MIS PRODUCTOS COMPRADOS </h2>
					<div class = "cuadroProductos">
						{$productosCompra}                     
					</div>                
				</div>
				<div class = "contenedorTienda">
					<h2 class = "tituloPagina"> MIS PRODUCTOS POR CONFIRMAR </h2>
					<div class = "cuadroProductos">
						{$productosPorConfirmar}                     
					</div>                
				</div>

				<div class = "contenedorTienda">
					<h2 class = "tituloPagina"> PRODUCTOS QUE SE LE HAN ENVIADO Y QUE UNA VEZ LOS RECIBA PODRA FINALIZAR LA COMPRA </h2>
					<div class = "cuadroProductos">
						{$productosPorFinalizar}                     
					</div>                
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
