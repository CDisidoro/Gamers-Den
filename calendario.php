<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
    $tituloPagina = 'Mi calendario';

    if(isset($_SESSION['login'])){
        function generaProductos(){


    }
    else{
        $contenidoPrincipal = <<<EOS
            <section class = "content">
                <p>No has iniciado sesión. Por favor, logueate para poder ver tu perfil</p>
            </section>
            EOS;
        return $contenidoPrincipal;
    }

	include 'includes/vistas/plantillas/plantilla.php';
?>