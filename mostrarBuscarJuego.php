<?php namespace es\fdi\ucm\aw\gamersDen;
    require('includes/config.php');
    $tituloPagina = "Buscar Videojuego";
    // Gestionamos el formulario de búsqueda de videojuegos
    $formBuscaJuegos = new FormularioBusquedaJuegos();
    $resultadoBuscaJuegos = $formBuscaJuegos->gestiona();
    $cabecera = '<h1 class="text-center">Resultado de búsqueda</h1>';
    $resultado = $resultadoBuscaJuegos->getResultado();
    $juegos = $resultado['juegos'];
    $extraParams = $resultado['extraUrlParams'];
    $htmlFormBuscaJuegos = $resultadoBuscaJuegos->getHtmlFormulario();

    $htmlJuegos = '<section>';
    foreach($juegos as $juego){
        $idJuego = $juego->getID();
        $nombre = $juego->getNombre();
        $desc = $juego->getDescripcion();
        $imagen = $juego->getUrlImagen();
        $redir = 'juego_particular.php?id='.$idJuego;
        $htmlJuegos .= <<<EOS
            <div class ="tarjetaProducto">
                <a href=$redir>
                    <img src=$imagen class="imagenTajetaProducto"/>
                    <p class="nombreProductoTarjeta">$nombre</p>
                </a>
                <p class="descripcionProductoTarjeta">$desc</p>
            </div>
        EOS;
    }
    $htmlJuegos .= '</section>';

    $contenidoPrincipal = <<<EOS
        $cabecera
        $htmlFormBuscaJuegos
        <div class="cuadroProductos">
            $htmlJuegos
        </div>
    EOS;
    include 'includes/vistas/plantillas/plantilla.php';
?>