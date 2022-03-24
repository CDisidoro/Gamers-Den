<?php namespace es\fdi\ucm\aw\gamersDen;

    require('includes/config.php');
    $tituloPagina = "Añadir amigo";
    $formulario = new FormularioAmigos();
    $formHTML = $formulario->gestiona();
    $contenidoPrincipal = <<<EOS
        <section class = "content>
            <article>
                <h1>Añadir amigos</h1>
                $formHTML
            </article>
        </section>
    EOS;

    include 'includes/vistas/plantillas/plantilla.php';
?>