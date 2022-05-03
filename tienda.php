<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Nuestra tienda';

	function generaProductos(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayProductos = Producto::mostrarPorCar($_GET['caracteristica']);

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

	function generaTodosProductos(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayProductos = Producto::getAllProductos();

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

	function generaAgregarProducto(){
		$addProducto = '';
		if(isset($_SESSION['login'])){
			$addProducto = <<<EOS
				<div class = "cajaBotonProducto col">
					<a href = "crearProducto.php"> Añadir Producto </a>
				</div>
			EOS;
		}
		return $addProducto;
	}

	$productos = generaProductos();
	$todosproductos = generaTodosProductos();
	$addProducto = generaAgregarProducto();
	if(isset($_SESSION['login'])){
		$usuario = Usuario::buscaPorId($_SESSION['ID']);
		$textCarrito = 'Mi Carrito ('.$usuario->longCarrito() .')';
		$contenidoPrincipal=<<<EOS
		<section class = "tiendaPrincipal container">
			<div class = "container">
				<div class = "cajaTituloTienda">
					<h1 class = "tituloPagina text-center"> Todos los productos </h1>
				</div>
				<div class = "miCarrito row">
					<div class = "cajaBotonCarrito col">
						<a href = "carrito.php">$textCarrito</a>
					</div>
					<div class = "cajaBotonCarrito col">
						<a href = "misProductos.php">Mis Productos</a>
					</div>
				</div>
				<div class = "cuadrotodosProductos">
					{$productos}
				</div>
				<div class = "container">

					<div class = "productosCuadro container">
						<div class = "botonesProductos row">
							<div class = "cajaBotonProducto col">
								<a href = "tienda.php?caracteristica=Destacado"> Destacado </a>
							</div>

							<div class = "cajaBotonProducto col">
								<a href = "tienda.php?caracteristica=Nuevo"> Nuevo </a>
							</div>

							<div class = "cajaBotonProducto col">
								<a href = "tienda.php?caracteristica=Popular"> Popular </a>
							</div>

							$addProducto
							
							<div class = "cajaBusqueda col">
								<a href = "buscarProducto.php" class="btn btn-link" > <img src = "img/search.svg" class = "imagenBusqueda"> </a>
							</div>

						</div>

					<div class = "cuadroProductos container">
						{$todosproductos}                     
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
