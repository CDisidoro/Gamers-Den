<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');

	## Muestra el producto seleccionado en tienda 
	$tituloPagina = '';
	$producto = Producto::buscaProducto($_GET['id']);

	### ESPACIO DE LLAMADAS
	## Recogemos todos los atributos de los productos, falta imagen
	$descripcion = $producto->getDescripcion();
	$nombre = $producto->getNombre();
	$fecha = $producto->getFecha();
	$vendedor = $producto->getVendedor(); ## Esto es para establecer el chat
	$precio = $producto->getPrecio();
	$caracteristicas = $producto->getCaracteristica(); ## Las características supongo que es para los tags y filtros
	$urlImagen = 'img/';
	$urlImagen .= $producto->getImagen();
	$urlImagen .= '.jpg';
	###

	if(isset($_SESSION['login'])){
		$contenidoPrincipal=<<<EOS
		<section class = "content">
			<article class = "avatarydatos">
				<div class = "cajagrid">
					<div class = "cajagrid">
						<img src=$urlImagen width="150" height="200" alt="movil" />
					</div>
				<div class = "cajagrid">
					<div class = "flexcolumn">
						<div class = "cajaflex">
							<p class = "nombreusuario">{$nombre}</p>           
						</div>
						<div class = "cajaflex">
							<p class = "descripcion">{$descripcion}</p>
							<p> {$fecha} </p>
							<p> {$vendedor} </p>
							<p class = "precio">{$precio}</p>
						</div>
					</div>
				</div> 
				<div class = "flexcolumn">
					<div class = "cajaflex">
						<p class = "precio">{$precio}</p>
					</div>
				</div>
			</article>        
		</section>
	EOS;
	}
	else{

		$contenidoPrincipal=<<<EOS
		<div>
			<p> Ha ocurrido un error al cargar la información debido a que no ha iniciado sesión </p>
		</div>
	EOS;
	}
	

include 'includes/vistas/plantillas/plantilla.php';
