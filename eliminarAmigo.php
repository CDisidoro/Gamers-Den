<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = "Eliminar amigo";
    $formulario = new FormularioEliminarAmigos();
    $formHTML = $formulario->gestiona();
    $contenidoPrincipal = <<<EOS
        <h1>Eliminar Amigos</h1>
        $formHTML
    EOS;

    include 'includes/vistas/plantillas/plantilla.php';
?>