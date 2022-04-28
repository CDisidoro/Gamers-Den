<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Foro';

	function generaForos(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayForos = Foro::getForos();
		$foros = '';
		## Cargamos todos los videojuegos disponibles con su nombre e imagen asociada
		if($arrayForos != -1){
			foreach ($arrayForos as $foro) {
				$idForo = $foro->getId();
				$formUpvote = new FormularioUpvoteForo($idForo,$_SESSION['ID']);
				$formHTMLUpVote = $formUpvote->gestiona();
				$formDownvote = new FormularioDownvoteForo($idForo,$_SESSION['ID']);
				$formHTMLDownVote = $formDownvote->gestiona();
				$contenido = $foro->getContenido();
				$autor = $foro->getAutor();
				$usuario = Usuario::buscaPorId($autor);
				$nombreAutor = $usuario->getUsername();
				$fecha = $foro->getFecha();
                $upvotes = $foro->getUpvotes();
                $downvotes = $foro->getDownvotes();
				$foros.=<<<EOS
					<div class = "tarjetaProducto">
						<a href = "foro_particular.php?id=$idForo">
							<p class = "contenidoForo">$contenido</p>
						</a>
						<p class = "autorForo">$nombreAutor</p>
						<p class = "autorForo">$upvotes</p>
						$formHTMLUpVote
						<p class = "fechaForo">$downvotes</p>
						$formHTMLDownVote
						<p class = "fechaForo">$fecha</p>
					</div>
				EOS;
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
	include 'includes/vistas/plantillas/plantilla.php';
?>
