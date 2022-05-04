<?php namespace es\fdi\ucm\aw\gamersDen;

	require('includes/config.php');

	/*
	* Procesando la petición
	*/

	// Gestionamos si se ha enviado formulario para buscar Mensajes
	$formBuscaForos = new FormularioBusquedaForo();
	$resultadoBuscaForos = $formBuscaForos->gestiona();

	// Generamos la vista si no se está enviando el formulario de crear, editar o borrar mensaje

	$cabecera = "<h1 class='text-center'>Resultado Búsqueda</h1>";
	$resultado = $resultadoBuscaForos->getResultado();
	$foros = $resultado['foros'];
	$extraUrlParams = $resultado['extraUrlParams'];
	$htmlFormBuscaForos = $resultadoBuscaForos->getHtmlFormulario();

	$htmlForos = '';
	$htmlForos .= '<section class = "mostrarNoticias container">';
	foreach($foros as $foro){
		$idForo = $foro->getId();
		$contenido = $foro->getContenido();
		$autor = $foro->getAutor();
		$usuario = Usuario::buscaPorId($autor);
		$nombreAutor = $usuario->getUsername();
		$fecha = $foro->getFecha();
		$upvotes = $foro->getUpvotes();
		$downvotes = $foro->getDownvotes();
		$ultimoCom = $foro->getUltimoComentario();
		$htmlForos.=<<<EOS
		<div class="row tarjetaForo">
			<div class="mb-3">
				<div class="row g-0">
					<div class="col-4 votos">
						<div class="row">
							<div class="col-1 nVotos">
								<p class = "autorForo">+$upvotes</p>
								<p class = "fechaForo">-$downvotes</p>
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
	$htmlForos .= '</section>';

	$tituloPagina = 'Foros';
	$contenidoPrincipal=<<<EOF
		$cabecera
		$htmlFormBuscaForos
		$htmlForos
	EOF;

	include 'includes/vistas/plantillas/plantilla.php';
?>