<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = "Buscar noticias";
    $formulario = new FormularioBusquedaNoticia();
    $formHTML = $formulario->gestiona();
    $contenidoPrincipal = <<<EOS
        <h1>Buscar noticias </h1>
        <p> Busca noticias por palabras clave separadas por un espacio </p>
        $formHTML
    EOS;

    include 'includes/vistas/plantillas/plantilla.php';
?>