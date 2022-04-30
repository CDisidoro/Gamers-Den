<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $juego = Videojuego::buscaVideojuego($_GET['id']);
    function generarBotones(){
        $botones = '';
        if(isset($_SESSION['login']) && ($_SESSION['rol'] == 3 || $_SESSION['rol'] == 1)){
            $botonBorrar = new FormularioEliminarJuego($_GET['id']);
            $formBoton = $botonBorrar->gestiona();
            $botones = <<<EOS
                <div class="botonesNoticiaConcreta container">
                    <div class="botonIndividualNoticia">
                        <a href="editarJuego.php?id={$_GET['id']}" class="btn btn-link"><img class="botonModificarNoticia" src="img/pencil.svg"/></a>
                    </div>
                    <div class="botonIndividualNoticia">
                        $formBoton
                    </div>
                </div>
            EOS;
        }
        return $botones;
    }
    function generarListaDeseos(){
        $boton = '';
        if(isset($_SESSION['login'])){
            $formWish = new FormularioAddListaDeseos($_GET['id'],$_SESSION['ID']);
            $formBoton = $formWish->gestiona();
            $boton = <<<EOS
                <div class="cajaBotonNegociacion container">
                    $formBoton
                </div>
            EOS;
        }
        return $boton;
    }
    function generarCategorias($juego){
        $html = '';
        $arrayCat = $juego->getCategorias();
        foreach($arrayCat as $cat){
            $nombreCat = $cat->getNombre();
            $html .= $nombreCat.', ';
        }
        $html = substr($html, 0, strlen($html)-2);
        return $html;
    }

    function procesarDescripcion($desc){
        $descripcion = '';
        $parrafos = explode("\n", $desc);
        foreach($parrafos as $parrafo){
            $descripcion .= <<<EOS
                <p class="fw-bold">$parrafo</p>
            EOS;
        }
        return $descripcion;
    }
    if(!$juego){
            $tituloPagina = "No encontrado";
            $contenidoPrincipal = "<p>Lo sentimos, el juego al que has intentado acceder no existe</p>";
    }else{
        $nombreJuego = $juego->getNombre();
        $descJuego = procesarDescripcion($juego->getDescripcion());
        $lanzamiento = $juego->getLanzamiento();
        $desarrollador = $juego->getDesarrollador();
        $imagen = $juego->getUrlImagen();
        $precio = $juego->getPrecio();
        $tituloPagina = $nombreJuego;
        $botones = generarBotones();
        $wishlist = generarListaDeseos();
        $categorias = generarCategorias($juego);
        $contenidoPrincipal = <<<EOS
            <section class="container">
                <div class="tituloProductoConcreto">
                    <h1>$nombreJuego</h1>
                </div>
                $botones
                <div class="fotoyDescripcionProductoConcreto">
                    <div class="cajaImagenNoticiaConcreta">
                        <img class="imagenNoticia" src="$imagen"/>
                        <p class="descripcionProducto">Desarrollado por: $desarrollador</p>
                        <p class="descripcionProducto">Fecha de lanzamiento: $lanzamiento</p>
                        <p class="descripcionProducto">Categorías: $categorias</p>
                    </div>
                    <div class ="cajaDescProductoConcreto">
                        $descJuego
                        <p class="descripcionProducto">Precio: $precio €</p>
                    </div>
                </div>
                $wishlist
            </section>
        EOS;
    }
    include 'includes/vistas/plantillas/plantilla.php';
?>