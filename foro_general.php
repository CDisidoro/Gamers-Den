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
					/*$foros.=<<<EOS
						<div class = "tarjetaProducto container">
						</div>
					EOS;*/
					$foros .=<<<EOS
						<div class="row tarjetaForo">
							<div class="mb-3">
								<div class="row g-0">
									<div class="col-4 votos">
										<div class="row">
											<div class="col-2">
												$formHTMLUpVote
												$formHTMLDownVote
											</div>
											<div class="col-1 nVotos">
												<p class = "autorForo">$upvotes</p>
												<p class = "fechaForo">$downvotes</p>
											</div>
										</div>
									</div>
									<div class="col-md-8">
										<div class="card-body">
											<div class="row">
												<div class="col-md-6">
													<a href = "foro_particular.php?id=$idForo" class="text-decoration-none">
														$contenido
													</a>
												</div>
												<div class="col">
													<p class = "autorForo">Autor: <a class="text-decoration-none" href="perfilExt.php?id=$nombreAutor"> $nombreAutor </a></p>
													<p class = "fechaForo">FECHA DE INICIO: $fecha</p>
													<p class = "fechaForo">ULTIMA PARTICIPACION: $ultimoCom</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
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
						<div class = "forosCuadro container">
							<div class = "botonesProductos row">
								$addForo
								<div class = "cajaBusqueda col">
									<a href = "buscarForo.php" class="btn btn-link" > <img src = "img/search.svg" class = "imagenBusqueda"> </a>
								</div>
							</div>
						<div class = "container">
							<div class="col">
								{$foros}
							</div>
						</div>
					</div>
				</div>
			</section>
		EOS;
	}
	else {
        $contenidoPrincipal = <<<EOS
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder acceder al foro</p>
            </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
