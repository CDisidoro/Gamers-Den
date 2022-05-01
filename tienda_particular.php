<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	### ESPACIO DE LLAMADAS
	function generaBotones($idVendedor){
		$htmlBotones = '';
		$formBorrar = new FormularioEliminarProducto($_GET['id'],$_SESSION['ID']);
		$formHTML = $formBorrar->gestiona();
		if(isset($_SESSION['login']) && $_SESSION['ID'] == $idVendedor){
			$htmlBotones = <<<EOS
				<div class = "botonesNoticiaConcreta container">
					<div class = "botonIndividualNoticia">
						<a href = "editarProducto.php?id={$_GET['id']}" class="btn btn-link"> <img class = "botonModificarNoticia" src = "img/pencil.svg"> </a>
					</div>
					<div class="botonIndividualNoticia">
						$formHTML
					</div>
				</div>
			EOS;
		}
		return $htmlBotones;
	}
	if(isset($_SESSION['login'])){
		## Muestra el producto seleccionado en tienda 
		$producto = Producto::buscaProducto($_GET['id']);
		if(!$producto){
			$tituloPagina = "No encontrado";
			$contenidoPrincipal = "<p>Lo sentimos, el artículo al que ha intentado acceder no existe</p>";
		}else{
			$tituloPagina = $producto->getNombre();
			$formCarrito = new FormularioManejaCarrito($_GET['id'],$_SESSION['ID']);
			$formHTML = $formCarrito->gestiona();
			$formCreaNegociacion = new FormularioCreaNegociacion($producto->getVendedor());
			$formulario = $formCreaNegociacion->gestiona();
			$descripcion = $producto->getDescripcion();
			$nombre = $producto->getNombre();
			$fecha = $producto->getFecha();
			$vendedor = $producto->getVendedor(); ## Esto es para establecer el chat
			$precio = $producto->getPrecio();
			$caracteristicas = $producto->getCaracteristica(); ## Las características supongo que es para los tags y filtros
			$urlImagen = $producto->getImagen();
			###
			$nombreVendedor = Usuario::buscaPorId($vendedor);
			$botones = generaBotones($vendedor);
			$contenidoPrincipal=<<<EOS
				<section class = "tiendaParticular container">
					{$botones}
					<div class = "tituloProductoConcreto">
						<p> {$nombre} </p>
					</div>

					<div class = "fotoyDescripcionProductoConcreto">
						<div class = "cajaImagenNoticiaConcreta">
							<img class = "imagenNoticia"  src = " {$urlImagen} ">
							$formHTML
						</div>

						<div class = "container">
							<p class = "descripcionProducto" > Descripción del producto: {$descripcion} </p>
							<p class = "descripcionProducto" >Precio:  {$precio} €</p>
							<p class = "descripcionProducto" > Vendido por: {$nombreVendedor->getUsername()} </p>
							<p class = "descripcionProducto" >Fecha de publicación: {$fecha} </p>
							$formulario
						</div>
					</div>
				</section>
			EOS;
		}
	}
	else{
		$contenidoPrincipal=<<<EOS
			<div>
				<p> Tienes que iniciar sesión para acceder a esta parte de la página! </p>
			</div>
		EOS;
	}
	include 'includes/vistas/plantillas/plantilla.php';
?>