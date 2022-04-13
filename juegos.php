<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = 'Juegos';
    function generaJuegos(){
        $arrayJuegos = Videojuego::cargarVideojuegos();
        $juegos = '';
        foreach($arrayJuegos as $juego){
            $idJuego = $juego->getID();
            $nombreJuego = $juego->getNombre();
            $descJuego = $juego->getDescripcion();
            if(strlen($descJuego) > 260){
                $descJuego = substr($descJuego, 0, 260);
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
    if(isset($_SESSION['login'])){
        $listaJuegos = generaJuegos();
        $contenidoPrincipal = <<<EOS
            <section class="content">
                <div class="contenedorProductos">
                    <h1 class="tituloPagina">Descubre juegos nuevos</h1>
                </div>
                <div class="botonesProductos">
                    <div class ="cajaBusqueda">
                        <a href="buscarJuego.php"><img src="img/lupa.png" class="imagenBusqueda"/></a>
                    </div>
                </div>
                <div class="cuadroProductos">
                    $listaJuegos
                </div>
            </section>
        EOS;
    }else{
        $contenidoPrincipal = "<p>No has iniciado sesión. Por favor logeate para ver los juegos disponibles</p>";
    }
    include 'includes/vistas/plantillas/plantilla.php';
?>