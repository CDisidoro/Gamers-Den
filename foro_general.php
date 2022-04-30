<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Foro';

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

	$foros = "Cargando temas de discusión...";
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
							<div class="col" id="cajaForos">
								{$foros}
							</div>
						</div>
					</div>
				</div>
			</section>
			<script>
				$(document).ready(function(){
					//Actualizacion Periodica de temas del foro
					//Fuente: https://es.stackoverflow.com/questions/55668/actualizar-div-autom%C3%A1ticamente
					var refresh = setInterval(function(){
						$("#cajaForos").load("cargaForos.php");
					}, 1000);
				})
			</script>
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
