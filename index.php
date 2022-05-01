<?php namespace es\fdi\ucm\aw\gamersDen;

use function es\fdi\ucm\aw\gamersDen\generaProductos as GamersDenGeneraProductos;

	require('includes/config.php');
	require('Bienvenido.php');
	/*
	*   Función que genera el html de la noticia que se muestra en el cuadro de noticias destacadas en noticias_principal
	*/
	function generarHTMLdestacado(){
		$htmlNoticiaDestacada = '';
		$noticias = Noticia::mostrarPorCar(4);
		if(!$noticias){
			$htmlNoticiaDestacada =<<<EOS
			<p> ¡Aún no hay noticia destacada! Pero nuestros escritores están en ello :) </p>
			EOS;
		}
		else{
			$htmlNoticiaDestacada =<<<EOS
			<div class = "noticia container">
				<div class="row">
					<div class = "cajaTitulo col">
						<a href ="noticias_concreta.php?id= {$noticias[0]->getID()}">
							<img class = "imagenNoticia" src = "{$noticias[0]->getImagen()}">
						</a>
					</div>
					<div class = "cajaTitulo col">
						<p class = "tituloNoticia fs-4 text-center"> {$noticias[0]->getTitulo()}</p>
					</div>
					<div class = "cajaTitulo col">
						<p class = "descripcionNoticia fs-4">{$noticias[0]->getDescripcion()}</p>
					</div>
				</div>
			</div>
			EOS;
		}
	
		return $htmlNoticiaDestacada;
	}

	function generaPorCat($idCat){
        $arrayJuegos = Videojuego::cargarPorCat($idCat);
        $juegos = '';
        if(!$arrayJuegos || sizeof($arrayJuegos) == 0){
            return 'No se han encontrado juegos con esta categoría';
        }
        foreach($arrayJuegos as $juego){
            $idJuego = $juego->getID();
            $nombreJuego = $juego->getNombre();
            $descJuego = $juego->getDescripcion();
            $textCap = 128;
            if(strlen($descJuego) > $textCap){
                $descJuego = substr($descJuego, 0, $textCap);
                $descJuego .= '...';
            }
            $imgJuego = $juego->getUrlImagen();
            $redir = 'juego_particular.php?id='.$idJuego;
            $juegos .= <<<EOS
                <div class="tarjetaProducto">
                    <a href="$redir">
                        <img src=$imgJuego class="imagenTajetaProducto"/>
                        <p class="nombreProductoTarjeta">$nombreJuego</p>
                    </a>
                    <p class="descripcionProductoTarjeta">$descJuego</p>
                </div>
            EOS;
        }
        return $juegos;
    }

	function generaProductos(){
		## Cogemos todos nuestros productos (básicamente videojuegos) en un array
		$arrayProductos = Producto::mostrarPorCar("Destacado");

		$productos = '';
		## Cargamos todos los videojuegos disponibles con su nombre e imagen asociada
		if($arrayProductos != -1){
			foreach ($arrayProductos as $producto) {
				$idProducto = $producto->getID();
				$nomProducto = $producto->getNombre();
				$descProducto = $producto->getDescripcion();
				$urlImagen = $producto->getImagen();
				## URL del producto junto con el id
				$id = 'Productos.php?id='.$producto->getID();
				$productos.=<<<EOS
					<div class = "tarjetaProducto">
						<a href=$id rel="nofollow" target="_blank">
						<a href = "tienda_particular.php?id=$idProducto">
							<img src=$urlImagen class = "imagenTajetaProducto" />
							<p class = "nombreProductoTarjeta">$nomProducto</p>
						</a>
						<p class = "descripcionProductoTarjeta">$descProducto</p>
						</a>
					</div>
				EOS;
			}
		}	
		return $productos;
	}
	
	$tituloPagina = 'Gamers Den';
	$noticiaDestacada = generarHTMLdestacado();
	$nuevosJuegos = generaPorCat(1);
	$juegosSegunda = generaProductos();
	$contenidoPrincipal = <<<EOS
		<div class="contenedor">
			<section class = "content">
				<article class="container">
					<h1 class="text-center">Página principal</h1>
					<p class="text-center"> Te damos la bienvenida a Gamers Den, tu página social y tienda de juegos de segunda mano favorita! </p>
				</article>
				<article class="container">
					<h2 class="text-center">Noticia Destacada</h2>
					<div class = "noticiaDestacada">
						$noticiaDestacada
					</div>
				</article>
				<article class="container">
					<h2 class="text-center">Top Juegos de segunda mano</h2>
					<div class = "cuadrotodosProductos">
						$juegosSegunda
					</div>
				</article>
				<article class="container">
					<h2 class="text-center">Últimos Lanzamientos de la Industria</h2>
					<div class="cuadroProductos container">
						$nuevosJuegos
					</div>
				</article>
			</section>
		</div>
	EOS;
	include 'includes/vistas/plantillas/plantilla.php';
?>
