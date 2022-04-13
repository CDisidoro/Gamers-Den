<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = 'Juegos';

    $contenidoPrincipal = <<<EOS
        <section class="content">
            <article>
                <h2>Descubre juegos nuevos</h2>
            </article>
            <p>Aqui va a estar toda la funcionalidad de los juegos</p>
        </section>
    EOS;
    include 'includes/vistas/plantillas/plantilla.php';
?>