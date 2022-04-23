<?php namespace es\fdi\ucm\aw\gamersDen;
    require ('includes/config.php');

    $idNoticia = filter_var($_GET['id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
	$tituloPagina = 'Editar noticia';
	$formulario = new FormularioEditarNoticia($idNoticia, $_SESSION['ID']);
	$formHTML = $formulario->gestiona();

	$contenidoPrincipal = <<<EOS
	<div class="container">
				<h1 class="text-center">Edita aquí la noticia</h1>
				$formHTML
			</article>
		</main>
	</div>
	EOS;

	include 'includes/vistas/plantillas/plantilla.php';
?>