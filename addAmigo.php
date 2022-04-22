<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = "Añadir amigo";
    $formulario = new FormularioAmigos();
    $formHTML = $formulario->gestiona();
    $contenidoPrincipal = <<<EOS
        <h1 class="text-center">Añadir amigos</h1>
        $formHTML
    EOS;

    include 'includes/vistas/plantillas/plantilla.php';
?>