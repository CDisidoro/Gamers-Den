<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = 'Buscar Videojuego';

    // Gestionamos el formulario de búsqueda de videojuegos
    $formBuscaJuegos = new FormularioBusquedaJuegos();
    $resultadoBuscaJuegos = $formBuscaJuegos->gestiona();
    $htmlFormBuscaJuegos = $resultadoBuscaJuegos->getHtmlFormulario();

    
    $contenidoPrincipal = '<h1 class="text-center">Buscar un videojuego por palabras clave </h1>';
    $contenidoPrincipal .= $htmlFormBuscaJuegos;
        

    include 'includes/vistas/plantillas/plantilla.php';
?>