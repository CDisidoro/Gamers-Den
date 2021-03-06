<?php namespace es\fdi\ucm\aw\gamersDen;
    require('includes/config.php');
    $tituloPagina = "Buscar Producto";
    // Gestionamos el formulario de búsqueda de productos
    $formBuscaProducto = new FormularioBuscarProducto();
    $htmlBuscaProducto = $formBuscaProducto->gestiona();
    $htmlForm = $htmlBuscaProducto->getHtmlFormulario();
    //Generacion de la vista
    $cabecera = "<h1 class='text-center'>Resultados de búsqueda</h1>";
    $resultado = $htmlBuscaProducto->getResultado();
    $productos = $resultado['juegos'];
    $htmlProductos = '<section class="row">';
    foreach($productos as $producto){
        $idProducto = $producto->getID();
        $nomProducto = $producto->getNombre();
        $descProducto = $producto->getDescripcion();
        $urlImagen = $producto->getImagen();
        ## URL del producto junto con el id
        $id = 'Productos.php?id='.$producto->getID();
        $htmlProductos.=<<<EOS
            <div class = "col-1 tarjetaProducto">
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
    $htmlProductos .= '</section>';

    $contenidoPrincipal = <<<EOS
        $cabecera
        $htmlForm
        <div class="container">
            $htmlProductos
        </div>
        
    EOS;
    include 'includes/vistas/plantillas/plantilla.php';
?>