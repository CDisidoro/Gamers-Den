<?php namespace es\fdi\ucm\aw\gamersDen;
    //Inicio del procesamiento
    require ('includes/config.php');

    $tituloPagina = 'Login';
    $formulario = new FormularioLogin();
    $formHTML = $formulario->gestiona();

    $contenidoPrincipal = <<<EOS
    <div class="container">
        <h1 class="text-center">Acceso a Gamers Den</h1>
        $formHTML
    </div>
    EOS;

    include 'includes/vistas/plantillas/plantilla.php';
?>