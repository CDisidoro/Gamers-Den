<?php namespace es\fdi\ucm\aw\gamersDen;
    //Inicio del procesamiento
    require ('includes/config.php');

    $tituloPagina = 'Login';
    $formulario = new FormularioLogin();
    $formHTML = $formulario->gestiona();

    $contenidoPrincipal = <<<EOS
    <h1>Acceso a Gamers Den</h1>
    $formHTML
    EOS;

    include 'includes/vistas/plantillas/plantilla.php';
?>