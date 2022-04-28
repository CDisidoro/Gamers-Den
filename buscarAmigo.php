<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = 'Buscar Amigo';

    // Gestionamos el formulario de búsqueda de mensajes
    $formBuscaMensajes = new FormularioBusquedaUsuario();
    $resultadoBuscaMensajes = $formBuscaMensajes->gestiona();
    $htmlFormBuscaMensajes = $resultadoBuscaMensajes->getHtmlFormulario();

    
    $contenidoPrincipal = '<h1 class="text-center">Buscar un Usuario por palabras clave </h1>';
    $contenidoPrincipal .= $htmlFormBuscaMensajes;
        

    include 'includes/vistas/plantillas/plantilla.php';
?>