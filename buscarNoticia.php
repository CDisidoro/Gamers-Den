<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = 'Buscar Noticia';

    // Gestionamos el formulario de búsqueda de mensajes
    $formBuscaMensajes = new FormularioBusquedaNoticia();
    $resultadoBuscaMensajes = $formBuscaMensajes->gestiona();
    $htmlFormBuscaMensajes = $resultadoBuscaMensajes->getHtmlFormulario();

    
    $contenidoPrincipal = '<h1 class="text-center">Buscar una noticia por palabras clave </h1>';
    $contenidoPrincipal .= $htmlFormBuscaMensajes;
        

    include 'includes/vistas/plantillas/plantilla.php';
?>