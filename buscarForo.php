<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = 'Buscar Foro';

    // Gestionamos el formulario de búsqueda de mensajes
    $formBuscaForos = new FormularioBusquedaForo();
    $resultadoBuscaForos = $formBuscaForos->gestiona();
    $htmlFormBuscaForos = $resultadoBuscaForos->getHtmlFormulario();

    
    $contenidoPrincipal = '<h1 class="text-center">Buscar un foro por palabras clave </h1>';
    $contenidoPrincipal .= $htmlFormBuscaForos;
        

    include 'includes/vistas/plantillas/plantilla.php';
?>