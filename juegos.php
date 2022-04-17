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
    function generaAddJuego(){
        $addJuego = '';
        if(isset($_SESSION['login'])){
            $usuario = Usuario::buscaPorId($_SESSION['ID']);
            if($usuario->hasRole(3)){
                $addJuego = <<<EOS
                    <div class="cajaBotonProducto">
                        <a href="crearJuego.php">Añadir Juego</a>
                    </div>
                EOS;
            }
        }
        return $addJuego;
    }

    function generaCategorias(){
        $html = '';
        $categorias = Categoria::cargaCategorias();
        foreach($categorias as $categoria){
            $idCat = $categoria->getID();
            $nombreCat = $categoria->getNombre();
            $redir = 'juegos.php?categoria='.$idCat;
            $html .= <<<EOS
                <div class="cajaBotonProducto">
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

    $addJuego = generaAddJuego();
    $categorias = generaCategorias();
    if(!isset($_GET['categoria'])){
        $listaJuegos = generaJuegos();
        $textoCat = '';
    }else{
        $listaJuegos = generaPorCat($_GET['categoria']);
        $textoCat = generaTextoCategoria($_GET['categoria']);
    }
    $contenidoPrincipal = <<<EOS
        <section class="content">
            <div class="contenedorProductos">
                <h1 class="tituloPagina">Descubre juegos nuevos</h1>
                <h3>$textoCat</h3>
            </div>
            <div class="botonesProductos">
                $categorias
                <div class ="cajaBusqueda">
                    <a href="buscarJuego.php"><img src="img/lupa.png" class="imagenBusqueda"/></a>
                </div>
                $addJuego
            </div>
            <div class="cuadroProductos">
                $listaJuegos
            </div>
        </section>
    EOS;
    include 'includes/vistas/plantillas/plantilla.php';
?>