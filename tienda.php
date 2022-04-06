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
		if($arrayProductos != -1){
			foreach ($arrayProductos as $producto) {
				$idProducto = $producto->getID();
				$nomProducto = $producto->getNombre();
				$descProducto = $producto->getDescripcion();
				$urlImagen = 'img/';
				$urlImagen .= $producto->getImagen();
				$urlImagen .= '.jpg';
				## URL del producto junto con el id
				$id = 'Productos.php?id='.$producto->getID();
				$productos.=<<<EOS
				<li>
					<a href=$id rel="nofollow" target="_blank">
					<a href = "tienda_particular.php?id=$idProducto">
						<img src=$urlImagen width="150" height="200" alt="movil" />
						<h3>$nomProducto</h3>
					</a>
					<p>$descProducto</p>
					</a>
				</li>	
				EOS;
			}
		}	
		return $productos;
	}

	$productos = generaProductos();
	if(isset($_SESSION['login'])){	
		$contenidoPrincipal=<<<EOS
			<section class = "tiendaPrincipal">
				<div class = "contenedorProductos">
					<div class = "productoDestacadp">
						{}
					</div>
				</div>

				<div  class = "contenedorProductos">

					<div class = "productosCuadro">
						<div class = "botones">
							
							<div class = "cajaBoton">
								<a href = "tienda.php?caracteristica=Destacado"> Destacado </a>
							</div>
							
							<div class = "cajaBoton">
								<a href = "tienda.php?caracteristica=Nuevo"> Nuevo </a>
							</div>

							<div class = "cajaBoton">
								<a href = "tienda.php?caracteristica=Popular"> Popular </a>
							</div>

							<div class = "cajaBusqueda">                               
								<a href = "buscarProducto.php" > <img src = "img/lupa.png" class = "imagenBusqueda"> </a>
							</div>

						</div>

						<div class = "cuadroProductos">
							{$productos}                       
						</div>                            
					</div>

				</div>
			</section>
		EOS;
	}
	else {
        $contenidoPrincipal = <<<EOS
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
            </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
