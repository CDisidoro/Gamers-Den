<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = 'Buscar Producto';

    // Gestionamos el formulario de búsqueda de productos
    $formBuscaProducto = new FormularioBuscarProducto();
    $htmlBuscaProducto = $formBuscaProducto->gestiona();

    
    $contenidoPrincipal = '<h1>Buscar una noticia por palabras clave </h1>';
    $contenidoPrincipal .= $htmlBuscaProducto->getHtmlFormulario();
        

    include 'includes/vistas/plantillas/plantilla.php';
?>