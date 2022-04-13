<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $juego = Videojuego::buscaVideojuego($_GET['id']);
    if(!$juego){
            $tituloPagina = "No encontrado";
            $contenidoPrincipal = "<p>Lo sentimos, el juego al que has intentado acceder no existe</p>";
    }else{
        $nombreJuego = $juego->getNombre();
        $descJuego = $juego->getDescripcion();
        $lanzamiento = $juego->getLanzamiento();
        $desarrollador = $juego->getDesarrollador();
        $imagen = $juego->getUrlImagen();
        $precio = $juego->getPrecio();
        $tituloPagina = $nombreJuego;
        $contenidoPrincipal = <<<EOS
            <section>
                <div class="tituloProductoConcreto">
                    <h1>$nombreJuego</h1>
                </div>
                <div class="fotoyDescripcionProductoConcreto">
                    <div class="cajaImagenNoticiaConcreta">
                        <img class="imagenNoticia" src="$imagen"/>
                        <p class="descripcionProducto">Desarrollado por: $desarrollador</p>
                        <p class="descripcionProducto">Fecha de lanzamiento: $lanzamiento</p>
                    </div>
                    <div class ="cajaDescProductoConcreto">
                        <p class="descripcionProducto">$descJuego</p>
                        <p class="descripcionProducto">Precio: $precio €</p>
                    </div>
                </div>
            </section>
        EOS;
    }
    include 'includes/vistas/plantillas/plantilla.php';
?>