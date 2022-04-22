<?php namespace es\fdi\ucm\aw\gamersDen;
	require('includes/config.php');
	$tituloPagina = 'Calendario';
    if(isset($_SESSION['login'])){
        $contenidoPrincipal = <<<EOS
            <div class="cajaCalendario">
                <div id='calendar'></div>
            </div>
        EOS;
    }else{
        $contenidoPrincipal = <<<EOS
        <section class = "content">
            <p>No has iniciado sesión. Por favor, logueate para poder ver el calendario</p>
        </section>
        EOS;
    }
	include 'includes/vistas/plantillas/plantilla.php';
?>
