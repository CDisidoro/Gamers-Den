<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Foro';

	function generaForos(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayForos = Foro::getForos();
		$foros = '';
		## Cargamos todos los videojuegos disponibles con su nombre e imagen asociada
		if($arrayForos != -1){
			if(isset($_SESSION['login'])){
				foreach ($arrayForos as $foro) {
					$idForo = $foro->getId();
					$redireccion = 'foro_general.php';
					$formUpvote = new FormularioUpvoteForo($idForo,$_SESSION['ID'], $redireccion);
					$formHTMLUpVote = $formUpvote->gestiona();
					$formDownvote = new FormularioDownvoteForo($idForo,$_SESSION['ID'], $redireccion);
					$formHTMLDownVote = $formDownvote->gestiona();
					$contenido = $foro->getContenido();
					$autor = $foro->getAutor();
					$usuario = Usuario::buscaPorId($autor);
					$nombreAutor = $usuario->getUsername();
					$fecha = $foro->getFecha();
					$upvotes = $foro->getUpvotes();
					$downvotes = $foro->getDownvotes();
					$ultimoCom = $foro->getUltimoComentario();
					$foros.=<<<EOS
						<div class = "tarjetaProducto">
							<a href = "foro_particular.php?id=$idForo">
								<p class = "contenidoForo">$contenido</p>
							</a>
							<p class = "autorForo">Autor: $nombreAutor</p>
							<p class = "autorForo">LIKES: $upvotes</p>
							$formHTMLUpVote
							<p class = "fechaForo">DISLIKES: $downvotes</p>
							$formHTMLDownVote
							<p class = "fechaForo">FECHA DE INICIO: $fecha</p>
							<p class = "fechaForo">ULTIMA PARTICIPACION: $ultimoCom</p>
						</div>
					EOS;
				}
			}
		}	
		return $foros;
	}

	function generaAgregarForos(){
		$addForo = '';
		if(isset($_SESSION['login'])){
			$addForo = <<<EOS
				<div class = "cajaBotonProducto col">
					<a href = "crearForo.php"> Añadir Foro </a>
				</div>
			EOS;
		}
		return $addForo;
	}

	$foros = generaForos();
	$addForo = generaAgregarForos();
	if(isset($_SESSION['login'])){
		$contenidoPrincipal=<<<EOS
			<section class = "foroPrincipal container">
				<div class = "container">
					<div class = "cajaTituloForo">
						<h1 class = "tituloPagina text-center"> Todos los foros </h1>
					</div>

					<div class = "container">

						<div class = "productosCuadro container">
							<div class = "botonesProductos row">
								$addForo
								<div class = "cajaBusqueda col">
									<a href = "buscarForo.php" class="btn btn-link" > <img src = "img/search.svg" class = "imagenBusqueda"> </a>
								</div>

							</div>

						<div class = "cuadroProductos container">
							{$foros}                   
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
