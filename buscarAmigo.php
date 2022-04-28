<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = 'Buscar Usuario';

    // Gestionamos el formulario de búsqueda de usuarios
    $formBuscaMensajes = new FormularioBusquedaUsuario();
    $resultadoBuscaMensajes = $formBuscaMensajes->gestiona();
    $htmlFormBuscaMensajes = $resultadoBuscaMensajes->getHtmlFormulario();

    
    $contenidoPrincipal = '<h1 class="text-center">Buscar un usuario </h1>';
    $contenidoPrincipal .= $htmlFormBuscaMensajes;
        

    include 'includes/vistas/plantillas/plantilla.php';
?>