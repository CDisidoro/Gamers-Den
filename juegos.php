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
    function generaBotones(){
        $addJuego = '';
        if(isset($_SESSION['login'])){
            $usuario = Usuario::buscaPorId($_SESSION['ID']);
            if($usuario->hasRole(3) || $usuario->hasRole(1)){
                $addJuego = <<<EOS
                    <div class="cajaBotonProducto col-1">
                        <a href="crearJuego.php">Añadir Juego</a>
                    </div>
                    <div class="cajaBotonProducto col-1">
                        <a href="creaCategoria.php">Añadir Categoría</a>
                    </div>
                EOS;
            }
        }
        return $addJuego;
    }

    function generaBotonEditar($idCat){
        $html = '';
        if(isset($_SESSION['login']) && ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3)){
            $botonBorrar = new FormularioEliminarCategoria($_GET['categoria']);
            $formBoton = $botonBorrar->gestiona();
            $html .= <<<EOS
                <div class="botonesNoticiaConcreta container">
                    <div class="botonIndividualNoticia">
                        <a href="editarCategoria.php?id=$idCat" class="btn btn-link"><img class = "botonModificarNoticia" src = "img/pencil.svg"></a>
                    </div>
                    <div class="botonIndividualNoticia">
                        $formBoton
                    </div>
                </div>
            EOS;
        }
        return $html;
    }

    function generaCategorias(){
        $html = '';
        $categorias = Categoria::cargaCategorias();
        foreach($categorias as $categoria){
            $idCat = $categoria->getID();
            $nombreCat = $categoria->getNombre();
            $redir = 'juegos.php?categoria='.$idCat;
            $html .= <<<EOS
                <div class="cajaBotonProducto col">
                    <a href="$redir">$nombreCat</a>
                </div>
            EOS;
        }
        return $html;
    }

    function generaTextoCategoria($idCat){
        $cat = Categoria::buscaPorId($idCat);
        if($cat){
            return $cat->getDescripcion();
        }else{
            return '';
        }
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

    $botones = generaBotones();
    $categorias = generaCategorias();
    if(!isset($_GET['categoria'])){
        $listaJuegos = generaJuegos();
        $textoCat = '';
        $editCat = '';
    }else{
        $listaJuegos = generaPorCat($_GET['categoria']);
        $textoCat = generaTextoCategoria($_GET['categoria']);
        $editCat = generaBotonEditar($_GET['categoria']);
    }
    $contenidoPrincipal = <<<EOS
        <section class="content container">
            <div class="container">
                <h1 class="tituloPagina text-center">Descubre juegos nuevos</h1>
                <h3>$textoCat</h3>
                $editCat
            </div>
            <div class="botonesProductos row">
                $categorias
                <div class ="cajaBusqueda col">
                    <a href="buscarJuego.php" class="btn btn-link"><img src="img/search.svg" class="imagenBusqueda"/></a>
                </div>
            </div>
            <div class="botonesProductos row">
                $botones
            </div>
            <div class="cuadroProductos container">
                $listaJuegos
            </div>
        </section>
    EOS;
    include 'includes/vistas/plantillas/plantilla.php';
?>