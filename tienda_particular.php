<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');

	## Muestra el producto seleccionado en tienda 
	$producto = Producto::buscaProducto($_GET['id']);
	$tituloPagina = $producto->getNombre();

	$formCreaNegociacion = new FormularioCreaNegociacion($producto->getVendedor());
	$formulario = $formCreaNegociacion->gestiona();

	### ESPACIO DE LLAMADAS
	function generaBotones($idVendedor){
		$htmlBotones = '';
		$formBorrar = new FormularioEliminarProducto($_GET['id'],$_SESSION['ID']);
		$formHTML = $formBorrar->gestiona();
		if(isset($_SESSION['login']) && $_SESSION['ID'] == $idVendedor){
			$htmlBotones = <<<EOS
                <div class = "botonesNoticiaConcreta">
                    <div class = "botonIndividualNoticia">
                        <a href = "editarProducto.php?id={$_GET['id']}"> <img class = "botonModificarNoticia" src = "img/lapiz.png"> </a>
                    </div>
                    
                    $formHTML
                </div>
            EOS;
		}
		return $htmlBotones;
	}
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
	$nombreVendedor = Usuario::buscaPorId($vendedor);
	$botones = generaBotones($vendedor);

	if(isset($_SESSION['login'])){
		$contenidoPrincipal=<<<EOS
			<section class = "tiendaParticular">
				{$botones}
				<div class = "tituloProductoConcreto">
					<p> {$nombre} </p>
				</div>

				<div class = "fotoyDescripcionProductoConcreto">
					<div class = "cajaImagenNoticiaConcreta">
						<img class = "imagenNoticia"  src = " {$urlImagen} ">
					</div>

					<div class = "cajaDescProductoConcreto">
						<p class = "descripcionProducto" > Descripción del producto: {$descripcion} </p>
						<p class = "descripcionProducto" > {$precio} €</p>
						<p class = "descripcionProducto" > Vendido por: {$nombreVendedor->getUsername()} </p>
						<p class = "descripcionProducto" > {$fecha} </p>
						<div class = "cajaBotonNegociacion">
							$formulario
						</div>
					</div>
				</div>
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
?>