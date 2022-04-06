<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = "Eliminar noticia";
    $formulario = new FormularioEliminarNoticia();
    $formHTML = $formulario->gestiona();
    $contenidoPrincipal = <<<EOS
        <h1>Eliminar Noticia</h1>
        $formHTML
    EOS;

    include 'includes/vistas/plantillas/plantilla.php';
?>